<?php

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\ControllerDon;
use app\controllers\ControllerDonnation;
use app\models\Don;
use app\models\Donnation;
/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

	//Get
	$router->get('/', function() use ($app) {
		$app->render('welcome');
	});

	$router->get('/welcome', function() use ($app) {
		$app->render('welcome');
	});

	$router->get('/donsAffichage', function() use ($app) {
		// Instanciation des controllers
		$controllerDon = new ControllerDon();
		$dons = $controllerDon->getAllDons();
		
		$controllerDonnation = new ControllerDonnation();
		$donnations = $controllerDonnation->getAllDonnation();
		
		// Rendu de la vue avec les données
		$app->render('donsAffichage', ['dons' => $dons, 'donnations' => $donnations]);
	});

	// Route GET pour afficher le formulaire d'insertion
	$router->get('/donInsert', function() use ($app) {
		// Récupérer la liste des produits si nécessaire
		// Pour l'instant, on affiche juste le formulaire
		$app->render('donInsert');
	});

	// Route POST pour traiter l'insertion du don
	$router->post('/donInsert', function() use ($app) {
		try {
			// Récupération des données du formulaire
			$dateDon = $_POST['dateDon'] ?? null;
			$totalPrix = $_POST['totalPrix'] ?? null;
			$produits = $_POST['produits'] ?? [];

			// Validation
			if (!$dateDon || !$totalPrix || empty($produits)) {
				$app->render('donInsert', ['error' => 'Tous les champs sont obligatoires']);
				return;
			}

			// Validation du montant
			if ((float)$totalPrix <= 0) {
				$app->render('donInsert', ['error' => 'Le montant total doit être supérieur à 0']);
				return;
			}

			// Validation des produits
			$validProduits = array_filter($produits, function($p) {
				return isset($p['idProduit']) && isset($p['quantite']) && (float)$p['quantite'] > 0;
			});

			if (empty($validProduits)) {
				$app->render('donInsert', ['error' => 'Veuillez ajouter au moins un produit avec une quantité valide']);
				return;
			}

			// Création du don
			$don = new Don(null, new \DateTime($dateDon), (float)$totalPrix);
			
			// Insertion du don et récupération de son ID
			$controllerDon = new ControllerDon();
			$idDon = $controllerDon->addDon($don);

			// Insertion des donnations (produits) liées au don
			$controllerDonnation = new ControllerDonnation();
			$nbDonnations = 0;
			
			foreach ($validProduits as $produit) {
				$donnation = new Donnation();
				$donnation->setIdDon($idDon);
				$donnation->setIdProduit((int)$produit['idProduit']);
				$donnation->setQuantiteProduit((float)$produit['quantite']);
				
				$controllerDonnation->addDonnation($donnation);
				$nbDonnations++;
			}

			// Message de succès
			$message = "Don enregistré avec succès ! (ID: $idDon) - $nbDonnations produit(s) ajouté(s)";
			
			// Redirection vers la liste des dons
			$app->redirect('/donsAffichage');
			
		} catch (Exception $e) {
			$app->render('donInsert', ['error' => 'Erreur lors de l\'insertion : ' . $e->getMessage()]);
		}
	});

}, [ SecurityHeadersMiddleware::class ]);