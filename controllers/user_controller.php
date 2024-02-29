<?php
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require 'libs/PHPMailer/Exception.php';
	require 'libs/PHPMailer/PHPMailer.php';
	require 'libs/PHPMailer/SMTP.php';

	/** 
	* Controller des utilisateurs
	* @author Christel
	*/
	include_once("models/user_model.php");
	include_once("entities/user_entity.php"); // inclure la classe

	class UserCtrl extends Ctrl{
		
		/**
		* Méthode permettant de créer un compte 
		*/
		public function create_account(){
			$arrErrors = array();
			//var_dump($_POST);
			$objUser = new User();
			if (count($_POST) > 0){
				$objUser->hydrate($_POST);
				// Vérification des données de l'utilisateur
				$arrErrors = $this->_verifInfos($objUser);
				
				// Vérifications du mot de passe
				$arrErrors = array_merge($arrErrors, $this->_verifPwd($objUser->getPwd()));
				
				if(count($arrErrors) == 0){
					//$objUser->setPwd(password_hash($objUser->getPwd(), PASSWORD_DEFAULT));
					$objUserModel	= new UserModel;
					if ($objUserModel->insert($objUser)){
						header("Location:".parent::BASE_URL."article/home");
					}else{
						$arrErrors[] = "L'insertion s'est mal passée";
					}
				}
				
			}else{ // Formulaire non envoyé
				$objUser->setName("");
				$objUser->setFirstname("");
				$objUser->setMail("");
			}
			
			// Afficher
			$this->_arrData["strPage"] 		= "create_account";
			$this->_arrData["strTitle"] 	= "Créer un compte";
			$this->_arrData["strDesc"] 		= "Page permettant de créer un compte";
			$this->_arrData["arrErrors"] 	= $arrErrors;
			$this->_arrData["objUser"]		= $objUser;
			$this->afficheTpl("create_account");
		}
		
		/**
		* Méthode de connection d'un utilisateur
		*/
		public function login(){
			$arrErrors = array();
			
			/* 2. Rechercher l'utilisateur dans la BDD */
			$strEmail 	= $_POST['email']??"";
			$strPwd 	= $_POST['password']??"";
			if (count($_POST) > 0){ // si le formulaire est envoyé
				$objUserModel	= new UserModel;
				$arrUser 		= $objUserModel->searchUser($strEmail, $strPwd);

				if ($arrUser === false){
					/* 3. Si pas ok => Afficher un message d'erreur */
					$arrErrors[] = "Erreur de connexion";
				}else{
					/* 3. Si ok => Session */
					$_SESSION['user'] = $arrUser;
				}
			}
			/* 1. Afficher le formulaire */
			$this->_arrData["strPage"] 	= "login";
			$this->_arrData["strTitle"] = "Se connecter";
			$this->_arrData["strDesc"] 	= "Page permettant de se connecter";
			$this->_arrData["arrErrors"]= $arrErrors;
			$this->_arrData["email"]	= $strEmail;
			$this->_arrData['csrf']		= $this->_generateCsrfToken();
			$this->afficheTpl("login");
		}
		
		/**
		* Méthode permettant de se déconnecter
		*/
		public function logout(){
			session_destroy();
			header("Location:".parent::BASE_URL);
		}
	
		/**
		* Méthode permettant de modifier son profil
		*/
		public function edit_profile(){
			// Est-ce que l'utilisateur est connecté ?
			if (!isset($_SESSION['user']['user_id']) || $_SESSION['user']['user_id'] == ''){
				header('Location:'.parent::BASE_URL.'error/show403');
			}
			
			$arrErrors	= array();
			$objUser 	= new User;
			// Objet à partir de la BDD - à l'affichage du formulaire
			$objUserModel	= new UserModel;
			$arrUser		= $objUserModel->get($_SESSION['user']['user_id']);
			$objUser->hydrate($arrUser);
			
			// Récupère les valeurs actuelles pour vérification
			$strActualMail 	= $objUser->getMail();			
			$strOldPwd 		= $objUser->getPwd();			
			
			// Objet à partir du formulaire - à l'envoi du formulaire
			if (count($_POST) > 0){
				// Mettre à jour l'objet
				$objUser->hydrate($_POST);

				// Vérifier 
				$boolVerifMail = ($strActualMail != $objUser->getMail());
				$arrErrors = $this->_verifInfos($objUser, $boolVerifMail);

				if ($objUser->getPwd() != ''){
					if (password_verify($_POST['oldpwd'], $strOldPwd)){
						$arrErrors = array_merge($arrErrors, $this->_verifPwd($objUser->getPwd()));
					}else{
						$arrErrors['pwd']	= "Erreur de mdp";
					}
				}
			
				// Mise à jour en BDD
				if(count($arrErrors) == 0){
					if ($objUserModel->update($objUser)){
						// Traitement du pseudo en cookie
						$strPseudo	= trim($_POST['pseudo']);
						if($strPseudo != ''){
							$strPseudo	= filter_var($strPseudo, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
							setcookie('pseudo', $strPseudo, $this->_arrCookieOptions);
						}else{
							setcookie('pseudo', '', array(	'expires'=>time()-1,
															'path' 		=> '/', 
															'domain' 	=> '', 
													));
						}

						// Attention si informations de session modifiées => modifier la session
						$_SESSION['user']['user_firstname'] = $objUser->getFirstname();
						$_SESSION['user']['user_name'] 		= $objUser->getName();
						
						header("Location:".parent::BASE_URL."article/home");
					}else{
						$arrErrors[] = "L'insertion s'est mal passée";
					}
				}
				
			}
			
			// Afficher
			$this->_arrData["strPage"] 		= "edit_profile";
			$this->_arrData["strTitle"] 	= "Modifier mon compte";
			$this->_arrData["strDesc"] 		= "Page permettant de modifier mon compte";
			$this->_arrData["arrErrors"] 	= $arrErrors;
			$this->_arrData["objUser"]		= $objUser;
			$this->afficheTpl("edit_profile");
		}
		
		
		/**
		* Méthode privée de vérification des informations de l'utilisateur
		* @param object $objUser Objet à vérifier
		* @return array les erreurs générées
		*/
		private function _verifInfos(object $objUser, $boolVerifMail = true){
			$arrErrors = array();
			if ($objUser->getName() == ""){
				$arrErrors['name'] = "Le nom est obligatoire";
			}elseif (strlen($objUser->getName()) < 2){
				$arrErrors['name'] = "Le nom est trop court";
			}
			
			if ($objUser->getFirstname() == ""){
				$arrErrors['firstname'] = "Le prénom est obligatoire";
			}
			
			if ($objUser->getMail() == ""){
				$arrErrors['mail'] = "Le mail est obligatoire";
			}elseif (!filter_var($objUser->getMail(), FILTER_VALIDATE_EMAIL)) {
				$arrErrors['mail'] = "Le mail n'est pas correct";
			}elseif ($boolVerifMail){
				$objUserModel	= new UserModel;
				// Test si le mail existe déjà
				$boolMailExists	= $objUserModel->verifMail($objUser->getMail());
				
				if ($boolMailExists === true){
					$arrErrors['mail'] = "Le mail est déjà utilisé";
				}
			}
			return $arrErrors;
		}
		
		
		/**
		* Méthode privée de vérification du mot de passe de l'utilisateur
		* @param string $strPassword Mot de passe à vérifier
		* @return array les erreurs générées
		*/
		private function _verifPwd(string $strPassword){
			$arrErrors	= array();
			$password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{16,}$/"; 
				
			if ($strPassword == ""){
				$arrErrors['pwd'] = "Le mot de passe est obligatoire";
			}elseif(!preg_match($password_regex, $strPassword)){
				$arrErrors['pwd'] = "Le mot de passe doit faire minimum 16 caractères 
									et contenir une minuscule, une majuscule, un chiffre et un caractère";
			}elseif ($strPassword != $_POST['passwd_confirm']){
				$arrErrors['pwd'] = "Le mot de passe et sa confirmation doivent être identiques";
			}
			return $arrErrors;
		}
		
		/**
		* Methode permettant de demander la réinitialisation du mot de passe
		* @TODO : Afficher le formulaire + envoyer le mail si adresse mail ok
		*/
		public function forgetPwd(){
			
			$arrErrors = array();
			$arrSuccess = array();
			if (count($_POST) > 0){
				if ($_POST['email'] == ''){
					$arrErrors['email'] = "Vous devez renseigner un mail";
				}else{
					$arrSuccess['email'] = "Si vous êtes inscrit vous allez recevoir un mail ....";
					$objUserModel	= new UserModel;
					$intUserId		= $objUserModel->getByMail($_POST['email']);
					if ($intUserId !== false){ 
						$strRecoCode 	= bin2hex(random_bytes(12));
						
						if ($objUserModel->updateReco($strRecoCode, $intUserId)){
							$strDestMail 	= $_POST['email'];
							$strSubject		= 'Récupération du mot de passe';
							
							$this->_arrData["code"] 	= $strRecoCode;
							$strBody		= $this->afficheTpl("mails/contact", false);
							
							$this->_sendMail($strDestMail, $strSubject, $strBody);
						}
					}
				}
			}
			
			$this->_arrData["strPage"] 	= "forgetPwd";
			$this->_arrData["strTitle"] = "Mot de passe oublié";
			$this->_arrData["strDesc"] 	= "Page permettant de régénérer son mot de passe";
			$this->_arrData["arrErrors"]= $arrErrors;
			$this->_arrData["arrSuccess"]= $arrSuccess;
			$this->afficheTpl("forget");

		}
		
		public function resetPwd(){
			$strCode		= $_GET['code'];
			$objUserModel	= new UserModel;
			$arrUser		= $objUserModel->searchByCode($strCode);
			
			$arrErrors		= array();
			if ($arrUser === false){
				$arrErrors['url']			= "La demande est expirée";
			}else{
				$_SESSION['user_recovery'] 	= $arrUser['user_id'];
				Header("Location:".parent::BASE_URL."user/doResetPwd");
			}
			
			$this->_arrData["strPage"] 	= "resetPwd";
			$this->_arrData["strTitle"] = "Réinitialisation du mot de passe";
			$this->_arrData["strDesc"] 	= "Page permettant de réinitialisation son mot de passe";
			$this->_arrData["arrErrors"]= $arrErrors;
			$this->afficheTpl("reset");
		}
		
		public function doResetPwd(){
			$arrErrors	= array();
			if (count($_POST) >0){
				// vérifier les mots de passe
				$arrErrors = $this->_verifPwd($_POST['pwd']);
				if (count($arrErrors) == 0){
					// mettre à jour la bdd
					$objUserModel	= new UserModel;
					if ($objUserModel->updatePwd($_POST['pwd'])){
						session_destroy();
						Header("Location:".parent::BASE_URL."user/login");
					}else{
						$arrErrors['mdp'] = "erreur de modification du mot de passe";
					}
				}
			}			
			
			$this->_arrData["strPage"] 	= "resetPwd";
			$this->_arrData["strTitle"] = "Réinitialisation du mot de passe";
			$this->_arrData["strDesc"] 	= "Page permettant de réinitialisation son mot de passe";
			$this->_arrData["arrErrors"]= $arrErrors;
			//$this->_arrData["arrSuccess"]= $arrSuccess;
			$this->afficheTpl("doreset");
		}		
		
		
		
		private function _sendMail($strDestMail, $strSubject, $strBody){
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->Mailer = "smtp";

			$mail->SMTPDebug  	= 0;  
			$mail->SMTPAuth   	= TRUE;
			$mail->SMTPSecure 	= "tls";
			$mail->Port       	= 587;
			$mail->Host       	= "smtp.gmail.com";
			$mail->Username 	= 'ceformation68@gmail.com';
			$mail->Password 	= 'lkpy yuoc ftuu qksu';
			$mail->CharSet		= PHPMailer::CHARSET_UTF8;
			$mail->IsHTML(true);
			$mail->setFrom('mon_blog@gmail.com', 'Exercice BLOG');
			$mail->addAddress($strDestMail);
			$mail->Subject 	= $strSubject;
			$mail->Body 	= $strBody;
			//$mail->addAttachment('test.txt');

			return $mail->send();
		}
	}