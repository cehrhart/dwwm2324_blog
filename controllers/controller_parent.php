<?php
	class Ctrl{
		
		protected array $_arrData = array();
		
		public function afficheTpl($strTpl){
			include("libs/smarty/Smarty.class.php");
			$smarty = new Smarty();

			foreach($this->_arrData as $key=>$value){
				$smarty->assign($key, $value);
			}
			$smarty->display("views/".$strTpl.".tpl");
		}
		
		
		
	}