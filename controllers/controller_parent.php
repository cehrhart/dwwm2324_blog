<?php
	/**
	* Controller mère
	* @author Christel
	*/
	class Ctrl{
		// Tableau des données à utiliser dans le template
		protected array $_arrData = array(); 
		
		/**
		* Méthode d'affichage des templates
		* @param $strTpl Nom du template à afficher
		*/
		public function afficheTpl($strTpl){
			include("libs/smarty/Smarty.class.php");
			$smarty = new Smarty();

			foreach($this->_arrData as $key=>$value){
				$smarty->assign($key, $value);
			}
			$smarty->display("views/".$strTpl.".tpl");
		}
		
		
		
	}