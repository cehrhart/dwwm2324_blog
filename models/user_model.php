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
			$strQuery 	= "SELECT user_firstname 
							FROM users
							WHERE user_id = ".$id;
			return $this->_db->query($strQuery)->fetch();
		}
		
		/**
		* Méthode de récupération d'un utilisateur en fonction de son mail et son pwd
		* @param string $strEmail Adresse mail de l'utilisateur
		* @param string $strPwd Mot de passe de l'utilisateur
		* @return 
		*/
		public function searchUser(string $strEmail, string $strPwd){
			$strQuery 	= "SELECT user_id, user_firstname, user_name
							FROM users
							WHERE user_mail = :mail
								AND user_pwd = :pwd ;";
			
			$rqPrep	= $this->_db->prepare($strQuery);			
			
			$rqPrep->bindValue(":mail", $strEmail, PDO::PARAM_STR);
			$rqPrep->bindValue(":pwd", $strPwd, PDO::PARAM_STR);
			
			$rqPrep->execute();
			return $rqPrep->fetch();
		}
		
		
	}