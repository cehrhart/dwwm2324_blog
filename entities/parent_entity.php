<?php

	class Entity {
		
		protected string $_strPrefixe;		
		
		/**
		* Méthode d'hydratation de l'objet à partir d'un tableau
		* @param $arrData array Tableau des attributs à hydrater
		*/
		public function hydrate($arrData){
			foreach($arrData as $key=>$value){
				$strSetterName	= "set".ucfirst(str_replace($this->_strPrefixe, "", $key));
				// Si le setter existe dans la classe 
				if (method_exists($this, $strSetterName)){
					$this->$strSetterName($value);
				}
			}
		}		
		
	}