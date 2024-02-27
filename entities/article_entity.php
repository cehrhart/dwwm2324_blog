<?php
	include_once("parent_entity.php");
	/**
	* Classe entité de l'objet article
	* @author Christel Ehrhart
	* @version 2024
	*/
	class Article extends Entity{
		// Propriétés
		protected string $_strPrefixe = "article_";
		
		private int $_id;		
		private string $_title;
		private string $_img;
		private string $_content;
		private string $_createdate;
		private string $_creator;	
		private int $_creator_id;
		private int $_valid;
		private string $_comment;
		
		// ################### Méthodes ######################## //
	
		/**
		* Getter de récupération de la valeur de l'id
		* @return int identifiant de l'objet
		*/
		public function getId():int{ 
			return $this->_id;
		}
		/**
		* Setter de modification de la valeur de l'id
		* @param int identifiant de l'objet
		*/		
		public function setId(int $intId){ 
			$this->_id = $intId;
		}
		
		/**
		* Getter de récupération de la valeur du titre
		* @return string titre 
		*/
		public function getTitle():string{ 
			return $this->_title;
		}
		/**
		* Setter de modification du titre
		* @param string Titre de l'objet
		*/	
		public function setTitle(string $strTitle){ 
			$this->_title = trim($strTitle);
		}
		
		/**
		* Getter de récupération de l'image
		* @return string nom de l'image
		*/
		public function getImg():string{ 
			return $this->_img;
		}
		/**
		* Setter de modification de l'image
		* @param string Nom de l'image
		*/	
		public function setImg(string $strImg){ 
			$this->_img = $strImg;
		}
		
		/**
		* Getter de récupération du contenu
		* @return string contenu 
		*/
		public function getContent():string{ 
			return $this->_content;
		}
		/**
		* Setter de modification du contenu
		* @param string contenu 
		*/
		public function setContent(string $strContent){ 
			$this->_content = trim($strContent); // Enlève les espaces avant et après
			$this->_content = filter_var($this->_content, FILTER_SANITIZE_FULL_SPECIAL_CHARS); // nettoyage
		}		
		/**
		* Getter de récupération d'une partie du contenu
		* @param int $max nombre de caractères à afficher
		* @return string contenu 
		*/
		public function getContentSummary(int $max){
			$strContent		= $this->_content;
			if(strlen($strContent) > $max){
				$strContent	= substr($strContent, 0, $max)."...";
			}
			return $strContent;
		}
		
		/**
		* Getter de récupération de la date de création
		* @return string date de création
		*/
		public function getCreatedate():string{ 
			return $this->_createdate;
		}
		/**
		* Setter de modification de la date de création
		* @param string date de création 
		*/
		public function setCreatedate(string $strCreatedate){ 
			$this->_createdate = $strCreatedate;
		}	
		/**
		* Getter de récupération de la date de création format français
		* @return string date de création
		*/		
		public function getCreatedateFr(){
			// Traitement de la date
			$objDate		= new DateTime($this->_createdate);
			return $objDate->format("d/m/Y");
		}
		/**
		* Getter de récupération du créateur 
		* @return string créateur
		*/
		public function getCreator():string{ 
			return $this->_creator;
		}
		/**
		* Setter de modification du créateur 
		* @param string créateur 
		*/
		public function setCreator(string $strCreator){ 
			$this->_creator = $strCreator;
		}		
		
		/**
		* Getter de récupération de l'identifiant du créateur 
		* @return int identifiant du créateur
		*/
		public function getCreator_id():int{ 
			return $this->_creator_id;
		}
		/**
		* Setter de modification de l'identifiant du créateur 
		* @param int identifiant du créateur
		*/
		public function setCreator_id(int $intCreatorId){ 
			$this->_creator_id = $intCreatorId;
		}		
		
		/**
		* Getter de récupération de l'état de validation
		* @return int état de validation
		*/
		public function getValid():int{ 
			return $this->_valid;
		}
		/**
		* Setter de modification de l'état de validation
		* @param int état de validation
		*/
		public function setValid(int $intValid){ 
			$this->_valid = $intValid;
		}		
		
		/**
		* Getter de récupération du commentaire de validation
		* @return string commentaire de validation
		*/
		public function getComment():string{ 
			return $this->_comment;
		}
		/**
		* Setter de modification du commentaire de validation
		* @param string commentaire de validation
		*/
		public function setComment(string $strComment){ 
			$this->_comment = trim($strComment); // Enlève les espaces avant et après
			$this->_comment = filter_var($this->_comment, FILTER_SANITIZE_FULL_SPECIAL_CHARS); // nettoyage
		}		
	}