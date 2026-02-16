<?php

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\ControllerDon;
use app\controllers\ControllerDonnation;
use app\controllers\ControllerVille;
use app\controllers\ControllerBesoin;
    use app\controllers\ControllerProduit;
use app\models\Don;
use app\models\Donnation;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

    $router->get('/villes', function() use ($app) {
        $app->render('villes');
    });

    $router->get('/besoins', function() use ($app) {
        $app->render('besoins');
    });

    $router->get('/dispatch', function() use ($app) {
        $app->render('dispatch');
    });

    // Route pour la page d'accueil
    $router->get('/', function() use ($app) {
		$controllerVille = new ControllerVille();
	    $controllerBesoin = new ControllerBesoin();
        $controllerDon = new ControllerDon();
        $controllerDispatchMere = new ControllerDispatchMere();
        $app->render('welcome', ['controllerVille' => $controllerVille, 'controllerBesoin' => $controllerBesoin,
        'controllerDon' => $controllerDon, 'controllerDispatchMere' => $controllerDispatchMere]);
    });

    // Route pour l'affichage des dons
    $router->get('/donsAffichage', function() use ($app) {
        $controllerDon = new ControllerDon();
        $dons = $controllerDon->getAllDons();
        
        $controllerDonnation = new ControllerDonnation();
        $donnations = $controllerDonnation->getAllDonnation();

        $app->render('donsAffichage', ['dons' => $dons, 'donnations' => $donnations]);
    });

    // Route GET - Afficher le formulaire d'insertion de don
    $router->get('/donInsert', function() use ($app) {
        $controllerProduit = new ControllerProduit();
        $produits = $controllerProduit->getAllProduit();
        
        $app->render('donInsert', ['produits' => $produits]);
    });

    // Route POST - Traiter l'insertion d'un don avec plusieurs donnations
    $router->post('/donInsert', function() use ($app) {
        try {
            $request = $app->request();
            
            // DEBUG: Log des données reçues
            error_log("=== DON INSERT POST DATA ===");
            error_log("dateDon: " . ($request->data->dateDon ?? 'NULL'));
            error_log("produits: " . print_r($request->data->produits ?? [], true));
            
            // Récupérer les données du formulaire
            $dateDon = $request->data->dateDon ?? null;
            $produits = $request->data->produits ?? [];

            // Validation basique
            if (!$dateDon || empty($produits)) {
                $controllerProduit = new ControllerProduit();
                $produitsData = $controllerProduit->getAllProduit();
                $app->view()->set('error', 'La date et au moins un produit sont requis');
                $app->view()->set('produits', $produitsData);
                $app->render('donInsert');
                return;
            }

            // Créer le don avec un prix total à 0 (sera calculé après)
            $don = new Don(null, new \DateTime($dateDon), 0);
            $controllerDon = new ControllerDon();
            $idDon = $controllerDon->addDon($don);
            
            error_log("Don créé avec ID: $idDon");

            // Créer les donnations associées
            $controllerDonnation = new ControllerDonnation();
            $countDonnations = 0;
            foreach ($produits as $index => $produit) {
                error_log("Produit $index: idProduit=" . ($produit['idProduit'] ?? 'NULL') . ", quantite=" . ($produit['quantite'] ?? 'NULL'));
                
                if (!empty($produit['idProduit']) && !empty($produit['quantite']) && floatval($produit['quantite']) > 0) {
                    $donnation = new Donnation(
                        null,
                        $idDon,
                        $produit['idProduit'],
                        $produit['quantite']
                    );
                    $controllerDonnation->addDonnation($donnation);
                    $countDonnations++;
                    error_log("Donnation créée: produit=" . $produit['idProduit'] . ", quantite=" . $produit['quantite']);
                }
            }
            
            error_log("Total donnations créées: $countDonnations");

            // Calculer et mettre à jour le prix total du don
            $controllerDon->calculerEtMettreAJourPrixTotal($idDon);
            error_log("Prix total calculé pour don $idDon");

            // Redirection vers la liste des dons
            $app->redirect('/donsAffichage');
        } catch (\Exception $e) {
            error_log("ERREUR lors de l'insertion: " . $e->getMessage());
            error_log($e->getTraceAsString());
            
            $controllerProduit = new ControllerProduit();
            $produitsData = $controllerProduit->getAllProduit();
            $app->view()->set('error', 'Erreur lors de l\'insertion: ' . $e->getMessage());
            $app->view()->set('produits', $produitsData);
            $app->render('donInsert');
        }
    });
        

}, [ SecurityHeadersMiddleware::class ]);