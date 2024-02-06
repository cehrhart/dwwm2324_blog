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
		
	}