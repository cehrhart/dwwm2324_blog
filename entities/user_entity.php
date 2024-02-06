<?php
	include_once("parent_entity.php");
	/**
	* Classe entité de l'objet utilisateur
	* @author Christel Ehrhart
	* @version 2024
	*/
	class User extends Entity{
		// Propriétés
		protected string $_strPrefixe = "user_";		
		
		private int $_id;
		private string $_name;		
		private string $_firstname;
		private string $_mail;		
		private string $_pwd;		
		
		// ################### Méthodes ######################## //

		/**
		* Getter de récupération de la valeur de l'id
		* @return identifiant de l'objet
		*/
		public function getId():int{ 
			return $this->_id;
		}
		// setter de modification de la valeur de l'id
		public function setId(int $intId){ 
			$this->_id = $intId;
		}
		
		// getter et setter de firstname
		public function getFirstname():string{ 
			return $this->_firstname;
		}
		public function setFirstname(string $strFirstname){ 
			$this->_firstname = $strFirstname;
		}	
	}		