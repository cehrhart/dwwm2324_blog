<?php
	class UserCtrl extends Ctrl{
		
		public function create_account(){
			$this->_arrData["strPage"] 	= "create_account";
			$this->_arrData["strTitle"] = "Créer un compte";
			$this->_arrData["strDesc"] 	= "Page permettant de créer un compte";
			$this->afficheTpl("create_account");
		}
		
		public function login(){
			$this->_arrData["strPage"] 	= "login";
			$this->_arrData["strTitle"] = "Se connecter";
			$this->_arrData["strDesc"] 	= "Page permettant de se connecter";
			$this->afficheTpl("login");
		}
		
		
		
	}