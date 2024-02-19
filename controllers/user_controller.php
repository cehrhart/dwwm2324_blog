<?php
	/** 
	* Controller des utilisateurs
	* @author Christel
	*/
	include_once("models/user_model.php");
	include_once("entities/user_entity.php"); // inclure la classe

	class UserCtrl extends Ctrl{
		
		public function create_account(){
			$this->_arrData["strPage"] 	= "create_account";
			$this->_arrData["strTitle"] = "Créer un compte";
			$this->_arrData["strDesc"] 	= "Page permettant de créer un compte";
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
	}