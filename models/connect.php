<?php
	class Model{
		protected $_db;		
		
		public function __construct(){
			try{
				// Connexion à la BDD
				$this->_db = new PDO(
										"mysql:host=localhost;dbname=blog_php", // Serveur et BDD
										"root", //utilisateur - même que phpmyadmin
										"", 	//mot de passe - même que phpmyadmin
										array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC) // Mode de renvoi
									);
				// Encodage
				$this->_db->exec("SET CHARACTER SET utf8");
				// Exceptions
				$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(PDOException $erreurs){
				echo("Erreurs de connexion : ".$erreurs->getMessage());
			}
		}
	}