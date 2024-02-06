<?php
	class PageCtrl extends Ctrl{
		
		public function about(){
			$this->_arrData["strPage"] 	= "about";
			$this->_arrData["strTitle"] = "A propos";
			$this->_arrData["strDesc"] 	= "Page de contenu";
			$this->afficheTpl("about");
			
			/*$strPage	= "about";
			$strTitle 	= "A propos";
			$strDesc	= "Page de contenu";
			include("views/_partial/header.php");			
			include("views/about.php");			
			include("views/_partial/footer.php");*/
		}
		
		public function contact(){
			$this->_arrData["strPage"] 	= "contact";
			$this->_arrData["strTitle"] = "Contact";
			$this->_arrData["strDesc"] 	= "Page de contact";
			$this->afficheTpl("contact");
			
			/*$strPage	= "contact";
			$strTitle 	= "Contact";
			$strDesc	= "Page de contact";
			include("views/_partial/header.php");
			include("views/contact.php");			
			include("views/_partial/footer.php");	*/
		}
		
		public function mentions(){
			$this->_arrData["strPage"] 	= "mentions";
			$this->_arrData["strTitle"] = "Mentions légales";
			$this->_arrData["strDesc"] 	= "Page de contenu";
			$this->afficheTpl("mentions");

			/*$strPage	= "mentions";
			$strTitle 	= "Mentions légales";
			$strDesc	= "Page de contenu";
			include("views/_partial/header.php");
			include("views/mentions.php");			
			include("views/_partial/footer.php");*/
		}
		
		
		
		
	}