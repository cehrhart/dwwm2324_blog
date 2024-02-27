<?php
	/** 
	* Controller des pages
	* @author Christel
	*/
	class PageCtrl extends Ctrl{
		/**
		* Méthode d'affichage de la page about
		*/		
		public function about(){
			$this->_arrData["strPage"] 	= "about";
			$this->_arrData["strTitle"] = "A propos";
			$this->_arrData["strDesc"] 	= "Page de contenu";
			$this->afficheTpl("about");
		}
		
		/**
		* Méthode d'affichage de la page contact
		*/		
		public function contact(){
			$this->_arrData["strPage"] 	= "contact";
			$this->_arrData["strTitle"] = "Contact";
			$this->_arrData["strDesc"] 	= "Page de contact";
			$this->afficheTpl("contact");
		}
		
		/**
		* Méthode d'affichage de la page des Mentions légales
		*/			
		public function mentions(){
			$this->_arrData["strPage"] 	= "mentions";
			$this->_arrData["strTitle"] = "Mentions légales";
			$this->_arrData["strDesc"] 	= "Page de contenu";
			$this->afficheTpl("mentions");
		}
	}