<?php
	/** 
	* Controller des erreurs
	* @author Christel
	*/
	class ErrorCtrl extends Ctrl{
		
		/**
		* Méthode permettant d'afficher l'erreur 404
		*/
		public function show404(){
			$this->_arrData["strPage"] 	= "404";
			$this->_arrData["strTitle"] = "Page non trouvée";
			$this->_arrData["strDesc"] 	= "Page affichant le fait que la page demandée n'a pas été trouvée";
			$this->afficheTpl("show404");
		}
		
		/**
		* Méthode permettant d'afficher l'erreur 403
		*/
		public function show403(){
			$this->_arrData["strPage"] 	= "403";
			$this->_arrData["strTitle"] = "Vous n'êtes pas autorisé";
			$this->_arrData["strDesc"] 	= "Page affichant le fait que l'utilisateur n'a pas les droits suffisants";
			$this->afficheTpl("show403");
		}
		
	}