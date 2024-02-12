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
		
		// getter et setter de title
		public function getTitle():string{ 
			return $this->_title;
		}
		public function setTitle(string $strTitle){ 
			$this->_title = trim($strTitle);
		}
		
		// getter et setter de img
		public function getImg():string{ 
			return $this->_img;
		}
		public function setImg(string $strImg){ 
			$this->_img = $strImg;
		}
		
		// getter et setter de content
		public function getContent():string{ 
			return $this->_content;
		}
		public function setContent(string $strContent){ 
			$this->_content = trim($strContent);
		}		
		public function getContentSummary(int $max){
			$strContent		= $this->_content;
			if(strlen($strContent) > $max){
				$strContent	= substr($strContent, 0, $max)."...";
			}
			return $strContent;
		}
		
		// getter et setter de createdate
		public function getCreatedate():string{ 
			return $this->_createdate;
		}
		public function setCreatedate(string $strCreatedate){ 
			$this->_createdate = $strCreatedate;
		}		
		public function getCreatedateFr(){
			// Traitement de la date
			$objDate		= new DateTime($this->_createdate);
			return $objDate->format("d/m/Y");
		}
		// getter et setter de creator
		public function getCreator():string{ 
			return $this->_creator;
		}
		public function setCreator(string $strCreator){ 
			$this->_creator = $strCreator;
		}		
		
		
	}