<?php

	/**
	* Controller mère
	* @author Christel
	* @TODO Opimisation : Remonter la gestion et l'affichage des erreurs
	*/
	class Ctrl{
		
		const BASE_URL = "http://localhost/blog/";
		
		// Tableau d'erreur 
		protected array $_arrErrors = array();
		
		// Tableau des données à utiliser dans le template
		protected array $_arrData	= array(); 
		
		// Tableau pour les types Mimes
		protected array $_arrMimesType	= array("image/jpeg", "image/png");
		
		// Tableau de configuration des cookies
		protected array $_arrCookieOptions 	= array ();
		
		// Tableau de sécurisation des pages => uniquement pour l'admin
		protected array $_arrAdminPages = array();
		
		public function __construct(){
			
			$this->_arrCookieOptions = array (
									'expires' 	=> time() + (365*24*60*60), // nbjours*nbheures*nbminutes*nbsecondes
									'path' 		=> '/', 
									'domain' 	=> '', // domaine !!!!!! A préciser pour Firefox !!!!!!
									'secure' 	=> false,     // HTTPS
									'httponly' 	=> true,    // accessible uniquement en http, pas en js par exemple
									'samesite' 	=> 'Strict' // None || Lax  || Strict
									);
			
			
			
			// Pages admin uniquement
			if (count($_GET) > 0){
				$strPage	= $_GET['ctrl'].'/'.$_GET['action'];
				
				if (in_array($strPage, $this->_arrAdminPages) && $_SESSION['user']['user_role'] != "admin"){
					header("Location:".self::BASE_URL."error/show403");
				}
			}
			
			// Vérification du token CSRF => Ajouter les input name=csrf
			/*if (count($_POST) > 0 && isset($_SESSION['csrf_token']) && !$this->_verifyCsrfToken($_POST['csrf'])){
				header("Location:".self::BASE_URL."error/show403");
			}*/
		}
		
		/**
		* Méthode d'affichage des templates
		* @param $strTpl Nom du template à afficher
		*/
		public function afficheTpl($strTpl, $boolDisplay = true){
			include_once("libs/smarty/Smarty.class.php");
			$smarty = new Smarty();

			foreach($this->_arrData as $key=>$value){
				$smarty->assign($key, $value);
			}
			// L'utilisateur en session
			$smarty->assign("user", $_SESSION['user']??array());
			$smarty->assign("base_url", self::BASE_URL);
			
			if ($boolDisplay){
				$smarty->display("views/".$strTpl.".tpl");
			}else{
				return $smarty->fetch("views/".$strTpl.".tpl");
			}
		}
		
		
		/** 
		* Fonction permettant de générer et stocker le token CSRF dans la session
		* @return string Le token généré
		*/
		protected function _generateCsrfToken():string {
			$strCSRFToken = bin2hex(random_bytes(32)); // Génère un token aléatoire
			return $_SESSION['csrf_token'] = $strCSRFToken;
		}
		
		/**
		* Méthode permettant de vérifier le token CSRF
		* @param string $strCSRFToken Le token à vérifier
		* @return boolean le résultat de la vérification
		*/
		// Vérifier le token CSRF
		protected function _verifyCsrfToken(string $strCSRFToken):bool {
			return isset($_SESSION['csrf_token']) && $_SESSION['csrf_token'] === $strCSRFToken;
		}

		
	}