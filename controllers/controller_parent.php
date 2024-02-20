<?php
	/**
	* Controller mère
	* @author Christel
	*/
	class Ctrl{
		// Tableau des données à utiliser dans le template
		protected array $_arrData = array(); 
		protected array $_arrMimesType = array("image/jpeg", "image/png");
		
		public function __construct(){
			var_dump($_GET, $_SESSION);
		}
		
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
			// L'utilisateur en session
			$smarty->assign("user", $_SESSION['user']??array());
			
			$smarty->display("views/".$strTpl.".tpl");
		}
		
		
		
	}