<?php
	/** 
	* Controller des articles
	* @author Christel
	*/
	include_once("models/article_model.php");
	include_once("entities/article_entity.php"); // inclure la classe

	class ArticleCtrl extends Ctrl{
		
		const MAX_CONTENT = 50;
		
		/**
		* Méthode qui permet d'afficher la page d'accueil contenant les 4 derniers articles
		*/
		public function home(){

			/* Utilisation de la classe model */
			$objArticleModel	= new ArticleModel;
			$arrArticles		= $objArticleModel->findAll(4);

			// Parcourir les articles pour créer des objets
			// -----  TODO Optimisation => déplacer dans modèle ------- //
			$arrArticlesToDisplay	= array();
			foreach($arrArticles as $arrDetailArticle){	
				$objArticle = new Article();		// instancie un objet Article
				$objArticle->hydrate($arrDetailArticle);
				$arrArticlesToDisplay[] = $objArticle;
			}
			// ------------ //

			$this->_arrData["strPage"] 	= "index";
			$this->_arrData["strTitle"] = "Accueil";
			$this->_arrData["strDesc"] 	= "Page affichant les 4 derniers articles";
			$this->_arrData["arrArticlesToDisplay"] = $arrArticlesToDisplay;

			$this->afficheTpl("home");			
		}	
		
		/**
		* Méthode qui permet d'afficher la page de blog contenant tous les articles avec une recherche
		*/
		public function blog(){
			// Récupère l'information dans $_POST => car form est en methode post
			$strKeywords 	= $_POST['keywords']??"";
			//$strKeywords 	= trim($strKeywords);
			$intPeriod		= $_POST['period']??0;
			$strDate		= $_POST['date']??"";
			$strStartDate	= $_POST['startdate']??"";
			$strEndDate		= $_POST['enddate']??"";
			$intAuthor		= $_POST['author']??"";

			$arrSearch 		= array('keywords' 	=> $strKeywords,
									'period' 	=> $intPeriod,
									'date' 		=> $strDate,
									'startdate' => $strStartDate,
									'enddate' 	=> $strEndDate,
									'author'	=> $intAuthor
									);

			/* Utilisation de la classe model */
			$objArticleModel	= new ArticleModel;
			$arrArticles		= $objArticleModel->findAll(0, $arrSearch );

			// Parcourir les articles pour créer des objets
			$arrArticlesToDisplay	= array();
			foreach($arrArticles as $arrDetailArticle){	
				$objArticle = new Article();		// instancie un objet Article
				$objArticle->hydrate($arrDetailArticle);
				$arrArticlesToDisplay[] = $objArticle;
			}

			$this->_arrData["strKeywords"] 	= $strKeywords;
			$this->_arrData["intPeriod"] 	= $intPeriod;
			$this->_arrData["strDate"] 		= $strDate;
			$this->_arrData["strStartDate"] = $strStartDate;
			$this->_arrData["strEndDate"] 	= $strEndDate;
			$this->_arrData["intAuthor"] 	= $intAuthor;

			$this->_arrData["strPage"] 	= "blog";
			$this->_arrData["strTitle"] = "Blog";
			$this->_arrData["strDesc"] 	= "Page affichant tous les articles, avec une zone de recherche sur les articles";
			$this->_arrData["arrArticlesToDisplay"] = $arrArticlesToDisplay;

			// Récupérer les utilisateurs pour la recherche
			include_once("models/user_model.php");
			include_once("entities/user_entity.php");
			
			$objUserModel	= new UserModel;
			$arrUsers		= $objUserModel->findAll();
			
			// On parcours les utilisateurs pour créer les objets users
			$arrUsersToDisplay	= array();
			foreach($arrUsers as $arrDetailUser){	
				$objUser = new User();		// instancie un objet User
				$objUser->hydrate($arrDetailUser);
				$arrUsersToDisplay[] = $objUser;
			}			
			
			$this->_arrData["arrUsersToDisplay"] = $arrUsersToDisplay;

			$this->afficheTpl("blog");			
			
		}
		
		/**
		* Méthode qui permet d'ajouter / modifier un Article
		*/
		public function addedit(){
			/* 2. Récupérer les informations du formulaire */
			$arrErrors = array();
			$objArticle = new Article();	// instancie un objet Article
			if (count($_POST) > 0 && count($_FILES) > 0){
				/* 3. Créer un objet article */
				$objArticle->hydrate($_POST);	// hydrate (setters) avec les données du formulaire
				
				if ($objArticle->getTitle() == ""){
					$arrErrors['title'] = "Le titre est obligatoire";
				}
				if (strlen($objArticle->getTitle()) < 10){
					$arrErrors['title'] = "Le titre doit faire au minimum 10 caractères";
				}
				if ($objArticle->getContent() == ""){
					$arrErrors['content'] = "Le contenu est obligatoire";
				}
				
				/* 4. Enregistrer l'image */
				$strImgName	= $_FILES['image']['name'];
				if ($strImgName != ""){
					// Si le type d'image est autorisé
					if (in_array($_FILES['image']['type'], $this->_arrMimesType)){ 
						$strSource 	= $_FILES['image']['tmp_name'];
						switch ($_FILES['image']['type']){
							case "image/jpeg": 
								$strImgName	= bin2hex(random_bytes(5)).".jpg"; // texte aléatoire
								break;
							case "image/png": 
								$strImgName	= bin2hex(random_bytes(5)).".png"; // texte aléatoire
								break;
						}
						$strDest	= "uploads/".$strImgName;
						// Si la copie de l'image s'est bien passée
						if (move_uploaded_file($strSource, $strDest)){
							$objArticle->setImg($strImgName);
						}else{
							$arrErrors['img'] = "Erreur lors de l'enregistrement de l'image";
						}
					}else{
						$arrErrors['img'] = "Le type d'image n'est pas autorisé";
					}
				}else{
					$arrErrors['img'] = "L'image est obligatoire";
				}
				/* 5. Enregistrer l'objet en BDD */
				if (count($arrErrors) == 0){
					$objArticleModel	= new ArticleModel;
					if ($objArticleModel->insert($objArticle)){
						header("Location:index.php?ctrl=article&action=blog");
					}else{
						$arrErrors[] = "L'insertion s'est mal passée";
					}
				}
			}else{
				$objArticle->setTitle("");
				$objArticle->setContent("");
			}
			$this->_arrData["objArticle"] 	= $objArticle;
			
			$this->_arrData["strPage"] 		= "add_article";
			$this->_arrData["strTitle"] 	= "Ajouter un article";
			$this->_arrData["strDesc"] 		= "Page permettant d'ajouter un article";
			$this->_arrData["arrErrors"] 	= $arrErrors;
			/* 1. Afficher le formulaire */
			$this->afficheTpl("article_addedit");		
		}
		
		
	}