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
		/** 
		* Setter de modification de la valeur de l'id
		* @param int $intId Identifiant de l'objet
		*/
		public function setId(int $intId){ 
			$this->_id = $intId;
		}
		
		/**
		* Getter de récupération de la valeur du nom
		* @return nom de l'objet
		*/
		public function getName():string{ 
			return $this->_name;
		}
		/** 
		* Setter de modification de la valeur du nom
		* @param string $strName nom de l'objet
		*/		
		public function setName(string $strName){ 
			$this->_name = trim($strName); // Enlève les espaces avant et après
			$this->_name = filter_var($this->_name, FILTER_SANITIZE_FULL_SPECIAL_CHARS); // nettoyage
		}	

		/**
		* Getter de récupération de la valeur du prénom
		* @return prénom de l'objet
		*/
		public function getFirstname():string{ 
			return $this->_firstname;
		}
		/** 
		* Setter de modification de la valeur du prénom
		* @param string $strFirstname prénom de l'objet
		*/		
		public function setFirstname(string $strFirstname){ 
			$this->_firstname = trim($strFirstname); // Enlève les espaces avant et après
			$this->_firstname = filter_var($this->_firstname, FILTER_SANITIZE_FULL_SPECIAL_CHARS); // nettoyage
		}	

		/**
		* Getter de récupération de la valeur du mail
		* @return mail de l'objet
		*/
		public function getMail():string{ 
			return $this->_mail;
		}
		/** 
		* Setter de modification de la valeur du mail
		* @param string $strMail mail de l'objet
		*/		
		public function setMail(string $strMail){ 
			$this->_mail = $strMail;
		}	

		/**
		* Getter de récupération de la valeur du mot de passe
		* @return mot de passe de l'objet
		*/
		public function getPwd():string{ 
			return $this->_pwd;
		}
		/** 
		* Setter de modification de la valeur du mot de passe
		* @param string $strPwd mot de passe de l'objet
		*/		
		public function setPwd(string $strPwd){ 
			$this->_pwd = $strPwd;
		}	
		/**
		* Getter de récupération du mot de passe haché
		* @return mot de passe haché
		*/
		public function getPwdHash():string{ 
			return password_hash($this->_pwd, PASSWORD_DEFAULT);
		}

		



	}		