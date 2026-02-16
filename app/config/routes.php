<?php

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\ControllerDon;
use app\controllers\ControllerDonnation;
use app\controllers\ControllerVille;
use app\controllers\ControllerBesoin;
use app\controllers\ControllerType;
use app\controllers\ControllerDispatchMere;
use app\controllers\ControllerDispatchFille;
use app\controllers\ControllerProduit;
use app\controllers\ControllerProduitBesoin;
use app\models\Don;
use app\models\Donnation;
use app\models\DispatchFille;

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

    // Route pour afficher la liste des dispatch mère
    $router->get('/dispatch', function() use ($app) {
        $app->render('dispatch');
    });

    // Route pour afficher les détails d'une dispatch mère et ses filles
    $router->get('/dispatchDetail', function() use ($app) {
        $idDispatchMere = $_GET['id'] ?? null;
        $app->render('dispatchDetail', ['mereId' => $idDispatchMere]);
    });

    // Route pour afficher les détails d'une ville
    $router->get('/villeDetail', function() use ($app) {
        $idVille = $_GET['id'] ?? null;
        
        if (!$idVille) {
            $app->redirect('/villes');
            return;
        }
        
        $controllerVille = new ControllerVille();
        $controllerBesoin = new ControllerBesoin();
        $controllerDon = new ControllerDon();
        $controllerDispatchMere = new ControllerDispatchMere();
        $controllerDispatchFille = new ControllerDispatchFille();
        $controllerProduit = new ControllerProduit();
        $controllerProduitBesoin = new ControllerProduitBesoin();
        $controllerType = new ControllerType();
        $controllerDonnation = new ControllerDonnation();
        
        $ville = $controllerVille->getVilleById($idVille);
        $besoins = $controllerBesoin->getAllBesoin();
        $dons = $controllerDon->getAllDons();
        $donnations = $controllerDonnation->getAllDonnation();
        $dispatchMeres = $controllerDispatchMere->getAllDispatchMeres();
        $types = $controllerType->getAllTypes();
        $produits = $controllerProduit->getAllProduit();
        $produitBesoins = $controllerProduitBesoin->getAllProduitBesoin();
        
        $app->render('villeDetail', [
            'ville' => $ville,
            'idVille' => $idVille,
            'besoins' => $besoins,
            'dons' => $dons,
            'donnations' => $donnations,
            'dispatchMeres' => $dispatchMeres,
            'types' => $types,
            'produits' => $produits,
            'produitBesoins' => $produitBesoins
        ]);
    });

    // Route POST pour ajouter un besoin depuis villeDetail
    $router->post('/villeDetail/besoin', function() use ($app) {
        try {
            $request = $app->request();
            $idVille = $_GET['id'] ?? null;
            $valBesoin = $request->data->valBesoin ?? null;
            $idType = $request->data->idType ?? null;

            if (!$idVille || !$valBesoin || !$idType) {
                $app->redirect('/villeDetail?id=' . htmlspecialchars($idVille));
                return;
            }

            $besoin = new \app\models\Besoin();
            $besoin->setIdVille($idVille);
            $besoin->setValBesoin($valBesoin);
            $besoin->setIdType($idType);

            $controllerBesoin = new ControllerBesoin();
            $controllerBesoin->createBesoin($besoin);

            $app->redirect('/villeDetail?id=' . htmlspecialchars($idVille));
        } catch (\Exception $e) {
            $app->redirect('/villeDetail?id=' . htmlspecialchars($_GET['id'] ?? ''));
        }
    });

    // Route POST pour ajouter un don depuis villeDetail
    $router->post('/villeDetail/don', function() use ($app) {
        try {
            $request = $app->request();
            $idVille = $_GET['id'] ?? null;
            $dateDon = $request->data->dateDon ?? null;
            $produits = $request->data->produits ?? [];

            if (!$idVille || !$dateDon) {
                $app->redirect('/villeDetail?id=' . htmlspecialchars($idVille));
                return;
            }

            // Vérifier qu'il y a au moins un produit valide
            $produitsValides = 0;
            if (is_array($produits)) {
                foreach ($produits as $produit) {
                    if (!empty($produit['idProduit']) && !empty($produit['quantite']) && floatval($produit['quantite']) > 0) {
                        $produitsValides++;
                    }
                }
            }
            
            if ($produitsValides === 0) {
                $app->redirect('/villeDetail?id=' . htmlspecialchars($idVille));
                return;
            }

            $don = new Don(null, new \DateTime($dateDon), 0);
            $controllerDon = new ControllerDon();
            $idDon = $controllerDon->addDon($don);

            $controllerDonnation = new ControllerDonnation();
            foreach ($produits as $produit) {
                if (!empty($produit['idProduit']) && !empty($produit['quantite']) && floatval($produit['quantite']) > 0) {
                    $donnation = new Donnation(null, $idDon, $produit['idProduit'], $produit['quantite']);
                    $controllerDonnation->addDonnation($donnation);
                }
            }

            $controllerDon->calculerEtMettreAJourPrixTotal($idDon);
            $app->redirect('/villeDetail?id=' . htmlspecialchars($idVille));
        } catch (\Exception $e) {
            $app->redirect('/villeDetail?id=' . htmlspecialchars($_GET['id'] ?? ''));
        }
    });

    // Route POST pour ajouter un dispatch mère depuis villeDetail
    $router->post('/villeDetail/dispatch', function() use ($app) {
        try {
            $request = $app->request();
            $idVille = $_GET['id'] ?? null;
            $dateDispatch = $request->data->dateDispatch ?? null;

            if (!$idVille || !$dateDispatch) {
                $app->redirect('/villeDetail?id=' . htmlspecialchars($idVille));
                return;
            }

            $dispatch = new \app\models\DispatchMere();
            $dispatch->setIdVille($idVille);
            $dispatch->setDateDispatch($dateDispatch);

            $controllerDispatchMere = new ControllerDispatchMere();
            $controllerDispatchMere->addDispatchMere($dispatch);

            $app->redirect('/villeDetail?id=' . htmlspecialchars($idVille));
        } catch (\Exception $e) {
            $app->redirect('/villeDetail?id=' . htmlspecialchars($_GET['id'] ?? ''));
        }
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

    // Routes pour Ville
    $router->get('/villeInsert', function() use ($app) {
        $controllerVille = new ControllerVille();
        $villes = $controllerVille->getAllVilles();
        $app->render('villeInsert', ['villes' => $villes]);
    });

    $router->post('/villeInsert', function() use ($app) {
        try {
            $request = $app->request();
            $nomVille = $request->data->nomVille ?? null;
            $idRegion = $request->data->idRegion ?? null;

            if (!$nomVille || !$idRegion) {
                $controllerVille = new ControllerVille();
                $villes = $controllerVille->getAllVilles();
                $app->view()->set('error', 'Le nom et la région sont requis');
                $app->view()->set('villes', $villes);
                $app->render('villeInsert');
                return;
            }

            $ville = new \app\models\Ville(null, $nomVille, $idRegion);
            $controllerVille = new ControllerVille();
            $controllerVille->addVille($ville);
            $app->redirect('/villeInsert');
        } catch (\Exception $e) {
            $app->view()->set('error', 'Erreur: ' . $e->getMessage());
            $app->render('villeInsert');
        }
    });

    // Routes pour Besoin
    $router->get('/besoinInsert', function() use ($app) {
        $controllerVille = new ControllerVille();
        $controllerProduit = new ControllerProduit();
        $controllerBesoin = new ControllerBesoin();
        $controllerType = new ControllerType();
        
        $villes = $controllerVille->getAllVilles();
        $produits = $controllerProduit->getAllProduit();
        $besoins = $controllerBesoin->getAllBesoin();
        $types = $controllerType->getAllTypes();
        
        $app->render('besoinInsert', [
            'villes' => $villes,
            'produits' => $produits,
            'besoins' => $besoins,
            'types' => $types
        ]);
    });

    $router->post('/besoinInsert', function() use ($app) {
        try {
            $request = $app->request();
            $idVille = $request->data->idVille ?? null;
            $valBesoin = $request->data->valBesoin ?? null;
            $idType = $request->data->idType ?? null;

            if (!$idVille || !$valBesoin || !$idType) {
                $app->view()->set('error', 'La ville, la description et le type sont requis');
                $app->redirect('/besoinInsert');
                return;
            }

            $besoin = new \app\models\Besoin();
            $besoin->setIdVille($idVille);
            $besoin->setValBesoin($valBesoin);
            $besoin->setIdType($idType);

            $controllerBesoin = new ControllerBesoin();
            $controllerBesoin->createBesoin($besoin);
            
            $app->redirect('/besoinInsert');
        } catch (\Exception $e) {
            $app->view()->set('error', 'Erreur: ' . $e->getMessage());
            $app->redirect('/besoinInsert');
        }
    });

    // Routes pour Produit
    $router->get('/produitInsert', function() use ($app) {
        $controllerProduit = new ControllerProduit();
        $produits = $controllerProduit->getAllProduit();
        $app->render('produitInsert', ['produits' => $produits]);
    });

    // Routes pour Type
    $router->get('/typeInsert', function() use ($app) {
        $controllerType = new ControllerType();
        $types = $controllerType->getAllTypes();
        $app->render('typeInsert', ['types' => $types]);
    });

    $router->post('/typeInsert', function() use ($app) {
        try {
            $request = $app->request();
            $valType = $request->data->valType ?? null;

            if (!$valType) {
                $app->view()->set('error', 'Le libellé du type est requis');
                $app->redirect('/typeInsert');
                return;
            }

            $type = new \app\models\Type();
            $type->setValType($valType);

            $controllerType = new ControllerType();
            $controllerType->addType($type);

            $app->redirect('/typeInsert');
        } catch (\Exception $e) {
            $app->view()->set('error', 'Erreur: ' . $e->getMessage());
            $app->redirect('/typeInsert');
        }
    });

    $router->post('/produitInsert', function() use ($app) {
        try {
            $request = $app->request();
            $valProduit = $request->data->valProduit ?? null;
            $idType = $request->data->idType ?? null;

            if (!$valProduit || !$idType) {
                $app->view()->set('error', 'Le nom et le type sont requis');
                $app->redirect('/produitInsert');
                return;
            }

            $produit = new \app\models\Produit();
            $produit->setValProduit($valProduit);
            $produit->setIdType($idType);
            
            $controllerProduit = new ControllerProduit();
            $controllerProduit->createProduit($produit);
            
            $app->redirect('/produitInsert');
        } catch (\Exception $e) {
            $app->view()->set('error', 'Erreur: ' . $e->getMessage());
            $app->redirect('/produitInsert');
        }
    });

    // Routes pour ProduitBesoin
    $router->get('/produitBesoinInsert', function() use ($app) {
        $controllerProduit = new ControllerProduit();
        $controllerBesoin = new ControllerBesoin();
        
        $produits = $controllerProduit->getAllProduit();
        $besoins = $controllerBesoin->getAllBesoin();
        
        $app->render('produitBesoinInsert', ['produits' => $produits, 'besoins' => $besoins]);
    });

    $router->post('/produitBesoinInsert', function() use ($app) {
        try {
            $request = $app->request();
            $idProduit = $request->data->idProduit ?? null;
            $idBesoin = $request->data->idBesoin ?? null;

            if (!$idProduit || !$idBesoin) {
                $app->view()->set('error', 'Le produit et le besoin sont requis');
                $app->redirect('/produitBesoinInsert');
                return;
            }

            $produitBesoin = new \app\models\ProduitBesoin();
            $produitBesoin->setIdProduit($idProduit);
            $produitBesoin->setIdBesoin($idBesoin);
            
            $controllerProduitBesoin = new \app\controllers\ControllerProduitBesoin();
            $controllerProduitBesoin->createProduitBesoin($produitBesoin);
            
            $app->redirect('/produitBesoinInsert');
        } catch (\Exception $e) {
            $app->view()->set('error', 'Erreur: ' . $e->getMessage());
            $app->redirect('/produitBesoinInsert');
        }
    });

    // Routes pour EquivalenceProduit
    $router->get('/equivalenceProduitInsert', function() use ($app) {
        $controllerProduit = new ControllerProduit();
        $controllerEquivalence = new \app\controllers\ControllerEquivalenceProduit();
        
        $produits = $controllerProduit->getAllProduit();
        $equivalences = $controllerEquivalence->getAllEquivalenceProduit();
        
        $app->render('equivalenceProduitInsert', ['produits' => $produits, 'equivalences' => $equivalences]);
    });

    $router->post('/equivalenceProduitInsert', function() use ($app) {
        try {
            $request = $app->request();
            $idProduit = $request->data->idProduit ?? null;
            $quantite = $request->data->quantite ?? null;
            $prix = $request->data->prix ?? null;
            $val = $request->data->val ?? null;

            if (!$idProduit || !$quantite || !$prix || !$val) {
                $app->view()->set('error', 'Tous les champs sont requis');
                $app->redirect('/equivalenceProduitInsert');
                return;
            }

            $equivalence = new \app\models\EquivalenceProduit();
            $equivalence->setIdProduit($idProduit);
            $equivalence->setQuantite($quantite);
            $equivalence->setPrix($prix);
            $equivalence->setVal($val);
            
            $controllerEquivalence = new \app\controllers\ControllerEquivalenceProduit();
            $controllerEquivalence->createEquivalenceProduit($equivalence);
            
            $app->redirect('/equivalenceProduitInsert');
        } catch (\Exception $e) {
            $app->view()->set('error', 'Erreur: ' . $e->getMessage());
            $app->redirect('/equivalenceProduitInsert');
        }
    });
        

}, [ SecurityHeadersMiddleware::class ]);