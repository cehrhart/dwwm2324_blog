<?php
	/***
	* Récupérer les utilisateurs dans la BDD 
	* @author Christel
	*/
	include_once("connect.php");
	
	class UserModel extends Model {
		
		/**
		* Constructeur de la classe 
		*/
		public function __construct(){
			parent::__construct();
		}
		
		/**
		* Méthode de récupération de tous les utilisateurs
		* @return Tableau des utilisateurs
		*/
		public function findAll(){
			$strQuery 	= "SELECT user_id, user_firstname 
							FROM users";
			return $this->_db->query($strQuery)->fetchAll();
		}

		/**
		* Méthode de récupération d'un utilisateur
		* @return Tableau de l'utilisateur
		*/
		public function get(int $id){
			$strQuery 	= "SELECT user_id, user_firstname, user_name, user_mail, user_pwd
							FROM users
							WHERE user_id = ".$id;
			return $this->_db->query($strQuery)->fetch();
		}
		
		/**
		* Méthode de récupération d'un utilisateur en fonction de son mail et son pwd
		* @param string $strEmail Adresse mail de l'utilisateur
		* @param string $strPwd Mot de passe de l'utilisateur 	hky67?3gKpE?AGa$
		* @return 
		*/
		public function searchUser(string $strEmail, string $strPwd){
			/*$strQuery 	= "SELECT user_id, user_firstname, user_name
							FROM users
							WHERE user_mail = :mail
								AND user_pwd = :pwd ;";*/
			$strQuery 	= "SELECT user_id, user_firstname, user_name, user_pwd
							FROM users
							WHERE user_mail = :mail;";
							
			$rqPrep	= $this->_db->prepare($strQuery);			
			
			$rqPrep->bindValue(":mail", $strEmail, PDO::PARAM_STR);
			//$rqPrep->bindValue(":pwd", $strPwd, PDO::PARAM_STR);
			
			$rqPrep->execute();
			//return $rqPrep->fetch();
			$arrUser = $rqPrep->fetch();

			if(is_array($arrUser) && password_verify($strPwd, $arrUser['user_pwd'])){
				unset($arrUser['user_pwd']); // on enlève le mot de passe du tableau
				return $arrUser;
			}
			
			return false;
			
		}
		
		/**
		* Méthode qui vérifie la présence du mail dans la BDD
		* @param string $strEmail Email à chercher dans la table user
		* @return bool L'adresse existe ou non dans la table
		*/
		public function verifMail(string $strEmail):bool{
			$strQuery 	= "SELECT user_mail
							FROM users
							WHERE user_mail = :mail;";
			
			$rqPrep	= $this->_db->prepare($strQuery);			
			
			$rqPrep->bindValue(":mail", $strEmail, PDO::PARAM_STR);
			
			$rqPrep->execute();
			return is_array($rqPrep->fetch());
		}
		
		/**
		* Méthode d'insertion d'un utilisateur en bdd
		* param object $objUser Objet utilisateur
		*/
		public function insert(object $objUser){
			$strQuery 	= "INSERT INTO users (user_name, user_firstname, user_mail, user_pwd)
							VALUES (:name, :firstname, :mail, :pwd);";
			$rqPrep	= $this->_db->prepare($strQuery);
			$rqPrep->bindValue(":name", $objUser->getName(), PDO::PARAM_STR);
			$rqPrep->bindValue(":firstname", $objUser->getFirstname(), PDO::PARAM_STR);
			$rqPrep->bindValue(":mail", $objUser->getMail(), PDO::PARAM_STR);
			$rqPrep->bindValue(":pwd", $objUser->getPwdHash(), PDO::PARAM_STR);
			return $rqPrep->execute();
		}

		/**
		* Méthode de modification d'un utilisateur en bdd
		* param object $objUser Objet utilisateur
		*/
		public function update(object $objUser){
			$strQuery 	= "UPDATE users 
							SET user_name = :name, 
								user_firstname = :firstname, 
								user_mail = :mail";
			if ($objUser->getPwd() != ''){
				$strQuery 	.= ", user_pwd = :pwd";
			}
			$strQuery 	.= " WHERE user_id = :id	;";
			$rqPrep	= $this->_db->prepare($strQuery);
			
			$rqPrep->bindValue(":name", $objUser->getName(), PDO::PARAM_STR);
			$rqPrep->bindValue(":firstname", $objUser->getFirstname(), PDO::PARAM_STR);
			$rqPrep->bindValue(":mail", $objUser->getMail(), PDO::PARAM_STR);
			$rqPrep->bindValue(":id", $objUser->getId(), PDO::PARAM_INT);
			if ($objUser->getPwd() != ''){
				$rqPrep->bindValue(":pwd", $objUser->getPwdHash(), PDO::PARAM_STR);
			}
			return $rqPrep->execute();
		}
		
	}