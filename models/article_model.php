<?php
	/* Récupérer les articles dans la BDD */
	include_once("connect.php");
	
	class ArticleModel extends Model {
		
		public function __construct(){
			parent::__construct();
		}
	
		public function findAll(int $intLimit = 0, $arrSearch = array()){
		
			$strQuery 	= "	SELECT article_title, article_img, article_content, article_createdate, 
								user_firstname AS 'article_creator'
							FROM articles
								INNER JOIN users ON article_creator = user_id";
			
			$strWhere	= " WHERE ";
			
			// Recherche par mot clé
			$strKeywords = $arrSearch['keywords']??"";
			if ($strKeywords != ''){
				$strQuery 	.= $strWhere." (article_title LIKE :keywords
									OR article_content LIKE :keywords) ";
				$strWhere	= " AND ";
			}				
			
			// Recherche par date exacte
			$intPeriod		= $arrSearch['period']??0;
			$strDate		= $arrSearch['date']??"";
			if ($intPeriod == 0 && $strDate != ''){
				$strQuery 	.= $strWhere." article_createdate = :date ";
				$strWhere	= " AND ";
			}
			
			// Recherche par période
			$strStartDate	= $arrSearch['startdate']??"";
			$strEndDate		= $arrSearch['enddate']??"";
			if ($intPeriod == 1 && $strStartDate != '' && $strEndDate != '' ){
				$strQuery 	.= $strWhere." article_createdate BETWEEN :begin AND :end ";
				$strWhere	= " AND ";
			}

			// Recherche par auteur
			$intAuthor		= $arrSearch['author']??"";
			if ($intAuthor != ''){
				$strQuery 	.= $strWhere." user_id = :author ";
				$strWhere	= " AND ";
			}

			// Tri par ordre décroissant
			$strQuery 	.= " ORDER BY article_createdate DESC";
			
			if ($intLimit > 0){
				$strQuery 	.= " LIMIT :limit";
			}
			
			// On prépare la requête
			$rqPrep	= $this->_db->prepare($strQuery);
			// On complète les variables de la requête, selon le contexte
			if ($strKeywords != ''){
				$rqPrep->bindValue(":keywords", "%".$strKeywords."%", PDO::PARAM_STR);
			}
			if ($intPeriod == 0 && $strDate != ''){
				$rqPrep->bindValue(":date", $strDate, PDO::PARAM_STR);
			}
			if ($intPeriod == 1 && $strStartDate != '' && $strEndDate != '' ){
				$rqPrep->bindValue(":begin", $strStartDate, PDO::PARAM_STR);
				$rqPrep->bindValue(":end", $strEndDate, PDO::PARAM_STR);
			}			
			if ($intAuthor != ''){
				$rqPrep->bindValue(":author", $intAuthor, PDO::PARAM_INT);
			}
			if ($intLimit > 0){
				$rqPrep->bindValue(":limit", $intLimit, PDO::PARAM_INT);
			}			
			$rqPrep->execute();
			return $rqPrep->fetchAll();
			//return $this->_db->query($strQuery)->fetchAll();
		}
		
		/* Requêtes simples
		public function findAll(int $intLimit = 0, $arrSearch = array()){
			$strQuery 	= "	SELECT article_title, article_img, article_content, article_createdate, 
								user_firstname AS 'article_creator'
							FROM articles
								INNER JOIN users ON article_creator = user_id";
			
			$strWhere	= " WHERE ";
			// Recherche par mot clé
			$strKeywords = $arrSearch['keywords']??"";
			if ($strKeywords != ''){
				$strQuery 	.= $strWhere." (article_title LIKE '%".$strKeywords."%'
									OR article_content LIKE '%".$strKeywords."%') ";
				$strWhere	= " AND ";
			}				
			// Recherche par date exacte
			$intPeriod		= $arrSearch['period']??0;
			$strDate		= $arrSearch['date']??"";
			if ($intPeriod == 0 && $strDate != ''){
				$strQuery 	.= $strWhere." article_createdate = '".$strDate."' ";
				$strWhere	= " AND ";
			}
			// Recherche par période
			$strStartDate	= $arrSearch['startdate']??"";
			$strEndDate		= $arrSearch['enddate']??"";
			if ($intPeriod == 1 && $strStartDate != '' && $strEndDate != '' ){
				$strQuery 	.= $strWhere." article_createdate BETWEEN '".$strStartDate."' AND '".$strEndDate."' ";
				$strWhere	= " AND ";
			}

			// Tri par ordre décroissant
			$strQuery 	.= " ORDER BY article_createdate DESC";
			
			if ($intLimit > 0){
				$strQuery 	.= " LIMIT ".$intLimit;
			}
			
			//var_dump($strQuery);
			

			return $this->_db->query($strQuery)->fetchAll();
		}	*/	
	
		/**
		* Méthode permettant d'ajouter un article en BDD 
		* @param $objArticle object Objet Article à insérer
		*/
		public function insert(object $objArticle){
			$strQuery	= "	INSERT INTO articles (
									article_title, article_img, article_content, 
									article_createdate, article_creator)
							VALUES (:titre, :image, :contenu, NOW(), 1);
							";
			// On prépare la requête
			$rqPrep	= $this->_db->prepare($strQuery);
			$rqPrep->bindValue(":titre", $objArticle->getTitle(), PDO::PARAM_STR);
			$rqPrep->bindValue(":image", $objArticle->getImg(), PDO::PARAM_STR);
			$rqPrep->bindValue(":contenu", $objArticle->getContent(), PDO::PARAM_STR);
			
			$rqPrep->execute();
		}
	}