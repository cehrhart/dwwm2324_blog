<?php
	class ErrorCtrl extends Ctrl{
		
		public function show404(){
			$this->_arrData["strPage"] 	= "404";
			$this->_arrData["strTitle"] = "Page non trouvée";
			$this->_arrData["strDesc"] 	= "Page affichant le fait que la page demandée n'a pas été trouvée";
			$this->afficheTpl("show404");
		}
		
		public function show403(){
			echo("erreur 403");
		}
		
	}