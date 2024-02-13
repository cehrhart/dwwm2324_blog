<?php
	use PHPUnit\Framework\TestCase;
	
	class user_modelTest extends TestCase{
		private $_user_model;
		
		public function setUp():void{
			require_once("C:/wamp64/www/blog/models/user_model.php");
			$this->_user_model		= new UserModel;
		}
		
		public function test_get(){
			// Résultats attendus
			$arrUsersTest	= array('user_firstname'=> "Christel");
								
			// Résultat de la méthode
			$arrUsersResult = $this->_user_model->get(1);
			
			$this->assertSame($arrUsersTest, $arrUsersResult);
		}
		
		public function test_findAll(){
			// Résultats attendus
			$arrUsersTest	= array(
								0=> array('user_id' => 1, 'user_firstname'=> "Christel"),
								1=> array('user_id' => 2, 'user_firstname'=> "Utilisateur")
								);
								
			// Résultat de la méthode
			$arrUsersResult = $this->_user_model->findAll();
			
			$this->assertSame($arrUsersTest, $arrUsersResult);
		}
		
		
		
		
		
	}

