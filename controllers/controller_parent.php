<?php
	/**
	* Controller mère
	* @author Christel
	*/
	class Ctrl{
		// Tableau des données à utiliser dans le template
		protected array $_arrData = array(); 
		protected array $_arrMimesType = array("image/jpeg", "image/png");
		
		// Tableau de sécurisation des pages => uniquement pour l'admin
		protected array $_arrAdminPages = array("page/about", "page/mentions");
		
		public function __construct(){
			// Pages admin uniquement
			if (count($_GET) > 0){
				$strPage	= $_GET['ctrl'].'/'.$_GET['action'];
				
				if (in_array($strPage, $this->_arrAdminPages) && $_SESSION['user']['user_role'] != "admin"){
					header("Location:http://localhost/blog/error/show403");
				}
			}
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