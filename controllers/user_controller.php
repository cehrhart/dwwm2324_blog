<?php
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
				
				/*if ($objUser->getName() == ""){
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
				}else{
					$objUserModel	= new UserModel;
					// Test si le mail existe déjà
					$boolMailExists	= $objUserModel->verifMail($objUser->getMail());
					if ($boolMailExists === true){
						$arrErrors['mail'] = "Le mail est déjà utilisé";
					}
				}*/
				// Vérifications du mot de passe
				$arrErrors = $this->_verifPwd($objUser->getPwd());

				/*$password_regex = "/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{16,}$/"; 
				
				if ($objUser->getPwd() == ""){
					$arrErrors['pwd'] = "Le mot de passe est obligatoire";
				}elseif(!preg_match($password_regex, $objUser->getPwd())){
					$arrErrors['pwd'] = "Le mot de passe doit faire minimum 16 caractères 
										et contenir une minuscule, une majuscule, un chiffre et un caractère";
				}elseif ($objUser->getPwd() != $_POST['passwd_confirm']){
					$arrErrors['pwd'] = "Le mot de passe et sa confirmation doivent être identiques";
				}*/
				
				if(count($arrErrors) == 0){
					//$objUser->setPwd(password_hash($objUser->getPwd(), PASSWORD_DEFAULT));
					if ($objUserModel->insert($objUser)){
						header("Location:index.php?ctrl=article&action=home");
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
			$this->afficheTpl("login");
		}
		
		/**
		* Méthode permettant de se déconnecter
		*/
		public function logout(){
			session_destroy();
			header("Location:http://localhost/blog/index.php");
		}
	
		/**
		* Méthode permettant de modifier son profil
		*/
		public function edit_profile(){
			// Est-ce que l'utilisateur est connecté ?
			if (!isset($_SESSION['user']['user_id']) || $_SESSION['user']['user_id'] == ''){
				header('Location:http://localhost/blog/error/show403');
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
						$arrErrors = $this->_verifPwd($objUser->getPwd());
					}else{
						$arrErrors['pwd']	= "Erreur de mdp";
					}
				}

				// Mise à jour en BDD
				if(count($arrErrors) == 0){
					if ($objUserModel->update($objUser)){
						header("Location:index.php?ctrl=article&action=home");
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
			$this->_arrData["objUser"]	= $objUser;
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
	}