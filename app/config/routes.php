<?php

use app\controllers\ControllerEquivalenceDate;
use app\controllers\ControllerEquivalenceProduit;
use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\ControllerDon;
use app\controllers\ControllerDonnation;
use app\controllers\ControllerVille;
use app\controllers\ControllerRegion;
use app\controllers\ControllerBesoin;
use app\controllers\ControllerType;
use app\controllers\ControllerDispatchMere;
use app\controllers\ControllerDispatchFille;
use app\controllers\ControllerProduit;
use app\controllers\ControllerStockage;
use app\controllers\ControllerProduitBesoin;
use app\controllers\ControllerAchat;
use app\controllers\ControllerConfig;
use app\models\Don;
use app\models\Donnation;
use app\models\Achat;
use app\models\DispatchFille;

/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

    // Route pour la page d'accueil
    $router->get('/', function() use ($app) {
        $controllerVille = new ControllerVille();
        $controllerBesoin = new ControllerBesoin();
        $controllerDon = new ControllerDon();
        $controllerDispatchMere = new ControllerDispatchMere();
        $controllerType = new ControllerType();
        $controllerProduit = new ControllerProduit();
        
        // Récupérer les données nécessaires pour les formulaires et statistiques
        $villes = $controllerVille->getAllVilles();
        $types = $controllerType->getAllTypes();
        $produits = $controllerProduit->getAllProduit();
        $besoins = $controllerBesoin->getAllBesoin();
        
        // Créer les maps pour les affichages
        $villeMap = [];
        foreach ($villes as $ville) {
            $id = is_object($ville) ? $ville->getIdVille() : ($ville['idVille'] ?? null);
            if ($id !== null) {
                $villeMap[$id] = is_object($ville) ? $ville->getValVille() : ($ville['valVille'] ?? '');
            }
        }
        
        $typeMap = [];
        foreach ($types as $type) {
            $id = is_object($type) ? $type->getIdType() : ($type['idType'] ?? null);
            if ($id !== null) {
                $typeMap[$id] = is_object($type) ? $type->getValType() : ($type['valType'] ?? '');
            }
        }
        
        // Calculer les statistiques
        $nombreVilles = $controllerVille->getNombreVille();
        $nombreBesoins = $controllerBesoin->getNombreBesoin();
        $nombreDons = $controllerDon->getNombreDons();
        $nombreDispatches = $controllerDispatchMere->getNombreDispatchMeres();
        
        $app->render('welcome', [
            'villes' => $villes,
            'types' => $types,
            'produits' => $produits,
            'besoins' => $besoins,
            'villeMap' => $villeMap,
            'typeMap' => $typeMap,
            'nombreVilles' => $nombreVilles,
            'nombreBesoins' => $nombreBesoins,
            'nombreDons' => $nombreDons,
            'nombreDispatches' => $nombreDispatches
        ]);
    });

    // Route pour l'affichage des villes
    $router->get('/villes', function() use ($app) {
        $controllerVille = new ControllerVille();
        $villes = $controllerVille->getAllVilles();
        $app->render('display/villes', ['controllerVille' => $controllerVille, 'villes' => $villes]);
    });

    $router->get('/besoins', function() use ($app) {
        $controllerBesoin = new ControllerBesoin();
        $controllerVille = new ControllerVille();
        $controllerType = new ControllerType();
        
        $besoins = $controllerBesoin->getAllBesoin();
        $villes = $controllerVille->getAllVilles();
        $types = $controllerType->getAllTypes();
        
        // Créer des maps pour les lookups
        $villeMap = [];
        foreach ($villes as $ville) {
            $id = is_object($ville) ? $ville->getIdVille() : ($ville['idVille'] ?? $ville['id_ville'] ?? null);
            if ($id !== null) {
                $villeMap[$id] = is_object($ville) ? $ville->getValVille() : ($ville['valVille'] ?? $ville['val_ville'] ?? '');
            }
        }
        
        $typeMap = [];
        foreach ($types as $type) {
            $id = is_object($type) ? $type->getIdType() : ($type['idType'] ?? $type['id_type'] ?? null);
            if ($id !== null) {
                $typeMap[$id] = is_object($type) ? $type->getValType() : ($type['valType'] ?? $type['val_type'] ?? '');
            }
        }
        
        // Formater les besoins avec noms de ville/type
        $besoinsFormatted = [];
        foreach ($besoins as $besoin) {
            $valBesoin = is_object($besoin) ? $besoin->getValBesoin() : ($besoin['valBesoin'] ?? $besoin['val_besoin'] ?? '');
            $idVille = is_object($besoin) ? $besoin->getIdVille() : ($besoin['idVille'] ?? $besoin['id_ville'] ?? null);
            $idType = is_object($besoin) ? $besoin->getIdType() : ($besoin['idType'] ?? $besoin['id_type'] ?? null);
            
            $besoinsFormatted[] = [
                'valBesoin' => $valBesoin,
                'villeName' => isset($villeMap[$idVille]) ? $villeMap[$idVille] : 'N/A',
                'typeName' => isset($typeMap[$idType]) ? $typeMap[$idType] : 'N/A'
            ];
        }

        $app->render('display/besoins', ['besoinsFormatted' => $besoinsFormatted]);
    });

    // Route pour afficher la liste des dispatch mère
    $router->get('/dispatch', function() use ($app) {
        // Récupérer tous les contrôleurs et données
        $controllerVille = new ControllerVille();
        $controllerBesoin = new ControllerBesoin();
        $controllerEquivalenceDate = new ControllerEquivalenceDate();
        $controllerProduitBesoin = new ControllerProduitBesoin();
        $controllerEquivalenceProduit = new ControllerEquivalenceProduit();
        $controllerDispatchMere = new ControllerDispatchMere();
        $controllerDonnation = new ControllerDonnation();
        $controllerProduit = new ControllerProduit();

        $villes = $controllerVille->getAllVilles();
        $dispatchMeres = $controllerDispatchMere->getAllDispatchMeres();
        $besoins = $controllerBesoin->getAllBesoin();
        $equivalenceDates = $controllerEquivalenceDate->getAllEquivalenceDate();
        $produitBesoins = $controllerProduitBesoin->getAllProduitBesoin();
        $equivalenceProduits = $controllerEquivalenceProduit->getAllEquivalenceProduit();
        $produits = $controllerProduit->getAllProduit();

        // Créer des maps pour les lookups rapides
        $villeMap = [];
        foreach ($villes as $ville) {
            $id = is_object($ville) ? $ville->getIdVille() : ($ville['idVille'] ?? $ville['id_ville'] ?? null);
            if ($id !== null) {
                $villeMap[$id] = is_object($ville) ? $ville->getValVille() : ($ville['valVille'] ?? $ville['val_ville'] ?? '');
            }
        }

        $produitMap = [];
        foreach ($produits as $produit) {
            $id = is_object($produit) ? $produit->getIdProduit() : ($produit['idProduit'] ?? $produit['id_produit'] ?? null);
            if ($id !== null) {
                $produitMap[$id] = is_object($produit) ? $produit->getValProduit() : ($produit['valProduit'] ?? $produit['val_produit'] ?? '');
            }
        }

        // Formater les dispatchMeres avec noms de ville
        $dispatchMeresList = [];
        foreach ($dispatchMeres as $mere) {
            $mereId = is_object($mere) ? $mere->getIdDispatchMere() : ($mere['idDispatchMere'] ?? $mere['id_Dispatch_mere'] ?? null);
            $mereVilleId = is_object($mere) ? $mere->getIdVille() : ($mere['idVille'] ?? $mere['id_ville'] ?? null);
            $mereDate = is_object($mere) ? $mere->getDateDispatch() : ($mere['dateDispatch'] ?? $mere['date_dispatch'] ?? '');

            $dispatchMeresList[] = [
                'id' => $mereId,
                'villeName' => isset($villeMap[$mereVilleId]) ? $villeMap[$mereVilleId] : 'N/A',
                'date' => $mereDate
            ];
        }

        // Pré-calculer les données pour le tableau "Aperçu par Ville"
        $villeDispatchData = [];
        foreach ($villes as $ville) {
            $villeId = is_object($ville) ? $ville->getIdVille() : ($ville['idVille'] ?? $ville['id_ville'] ?? null);
            $villeName = isset($villeMap[$villeId]) ? $villeMap[$villeId] : 'N/A';

            // Trouver un besoin pour cette ville
            $besoinTrouve = null;
            foreach ($besoins as $b) {
                $bIdVille = is_object($b) ? $b->getIdVille() : ($b['idVille'] ?? $b['id_ville'] ?? null);
                if ($bIdVille == $villeId) {
                    $besoinTrouve = is_object($b) ? $b->getIdBesoin() : ($b['idBesoin'] ?? $b['id_besoin'] ?? null);
                    break;
                }
            }

            // Obtenir la date d'équivalence pour ce besoin
            $dateEquivalence = 'N/A';
            if ($besoinTrouve) {
                foreach ($equivalenceDates as $ed) {
                    $edIdBesoin = is_object($ed) ? $ed->getIdBesoin() : ($ed['idBesoin'] ?? $ed['id_besoin'] ?? null);
                    if ($edIdBesoin == $besoinTrouve) {
                        $dateEquivalence = is_object($ed) ? $ed->getDateEquivalence() : ($ed['dateEquivalence'] ?? $ed['date_equivalence'] ?? 'N/A');
                        break;
                    }
                }
            }

            // Trouver les produits et quantités pour ce besoin
            $produis = [];
            $quantiteDonneeTotal = 'N/A';
            $prixEquivalenceTotal = 'N/A';

            if ($besoinTrouve) {
                foreach ($produitBesoins as $pb) {
                    $pbIdBesoin = is_object($pb) ? $pb->getIdBesoin() : ($pb['idBesoin'] ?? $pb['id_besoin'] ?? null);
                    if ($pbIdBesoin == $besoinTrouve) {
                        $pbIdProduit = is_object($pb) ? $pb->getIdProduit() : ($pb['idProduit'] ?? $pb['id_produit'] ?? null);
                        $pName = isset($produitMap[$pbIdProduit]) ? $produitMap[$pbIdProduit] : 'Produit #' . $pbIdProduit;

                        // Quantité donnée pour ce produit
                        $pQuant = 'N/A';
                        try {
                            $pQuant = $controllerDonnation->getQuantiteProduitByIdProduit($pbIdProduit);
                        } catch (\Exception $e) {
                            $pQuant = 0;
                        }
                        if ($besoinTrouve && $quantiteDonneeTotal === 'N/A' && is_numeric($pQuant)) {
                            $quantiteDonneeTotal = $pQuant;
                        }

                        // Prix d'équivalence pour ce produit
                        $pPrix = 'N/A';
                        foreach ($equivalenceProduits as $ep) {
                            $epIdProduit = is_object($ep) ? $ep->getIdProduit() : ($ep['idProduit'] ?? $ep['id_produit'] ?? null);
                            if ($epIdProduit == $pbIdProduit) {
                                $pPrix = is_object($ep) ? $ep->getPrix() : ($ep['prix'] ?? $ep['price'] ?? 'N/A');
                                if ($prixEquivalenceTotal === 'N/A' && is_numeric($pPrix)) {
                                    $prixEquivalenceTotal = $pPrix;
                                }
                                break;
                            }
                        }

                        $produis[] = [
                            'name' => $pName,
                            'quant' => $pQuant,
                            'prix' => $pPrix
                        ];
                    }
                }
            }

            $villeDispatchData[] = [
                'villeName' => $villeName,
                'dateEquivalence' => $dateEquivalence,
                'quantiteDonnee' => $quantiteDonneeTotal,
                'prixEquivalence' => $prixEquivalenceTotal,
                'produits' => $produis
            ];
        }

        $app->render('dispatch/dispatch', [
            'dispatchMeresList' => $dispatchMeresList,
            'villeDispatchData' => $villeDispatchData
        ]);
    });

    // Route pour afficher les détails d'une dispatch mère et ses filles
    $router->get('/dispatchDetail', function() use ($app) {
        $idDispatchMere = $_GET['id'] ?? null;
        
        if (!$idDispatchMere) {
            $app->redirect('/dispatch');
            return;
        }

        $controllerDispatchMere = new ControllerDispatchMere();
        $controllerDispatchFille = new ControllerDispatchFille();
        $controllerVille = new ControllerVille();
        $controllerProduit = new ControllerProduit();

        // Récupérer les données
        $mere = $controllerDispatchMere->getDispatchMereById($idDispatchMere);
        $filles = $controllerDispatchFille->getFillesByMere($idDispatchMere);
        $produits = $controllerProduit->getAllProduit();
        
        // Vérifier si mere existe
        if (!$mere) {
            $app->redirect('/dispatch');
            return;
        }

        // Formater les données pour la vue
        $mereIdValue = is_object($mere) ? $mere->getIdDispatchMere() : ($mere['idDispatchMere'] ?? $mere['id_Dispatch_mere'] ?? null);
        $mereVilleId = is_object($mere) ? $mere->getIdVille() : ($mere['idVille'] ?? $mere['id_ville'] ?? null);
        $mereDate = is_object($mere) ? $mere->getDateDispatch() : ($mere['dateDispatch'] ?? $mere['date_dispatch'] ?? '');

        // Obtenir le nom de la ville
        $villeObj = $controllerVille->getVilleById($mereVilleId);
        $villeName = is_object($villeObj) ? $villeObj->getValVille() : (is_array($villeObj) ? ($villeObj['valVille'] ?? $villeObj['val_ville'] ?? 'N/A') : 'N/A');

        $mereData = [
            'id' => $mereIdValue,
            'villeName' => $villeName,
            'date' => $mereDate
        ];

        // Formater les filles avec noms de produits
        $fillesFormatted = [];
        foreach ($filles as $fille) {
            $filleIdProduit = is_object($fille) ? $fille->getIdProduit() : ($fille['idProduit'] ?? $fille['id_produit'] ?? null);
            $filleQuantite = is_object($fille) ? $fille->getQuantite() : ($fille['quantite'] ?? 0);

            // Trouver le nom du produit
            $produitName = 'N/A';
            foreach ($produits as $produit) {
                $produitId = is_object($produit) ? $produit->getIdProduit() : ($produit['idProduit'] ?? $produit['id_produit'] ?? null);
                if ($produitId == $filleIdProduit) {
                    $produitName = is_object($produit) ? $produit->getValProduit() : ($produit['valProduit'] ?? $produit['val_produit'] ?? 'N/A');
                    break;
                }
            }

            $fillesFormatted[] = [
                'produitName' => $produitName,
                'quantite' => $filleQuantite
            ];
        }

        // Formater la liste des produits pour le formulaire
        $produitsList = [];
        foreach ($produits as $produit) {
            $produitId = is_object($produit) ? $produit->getIdProduit() : ($produit['idProduit'] ?? $produit['id_produit'] ?? null);
            $produitName = is_object($produit) ? $produit->getValProduit() : ($produit['valProduit'] ?? $produit['val_produit'] ?? '');

            $produitsList[] = [
                'id' => $produitId,
                'name' => $produitName
            ];
        }

        $app->render('dispatch/dispatchDetail', [
            'mereData' => $mereData,
            'fillesFormatted' => $fillesFormatted,
            'produitsList' => $produitsList
        ]);
    });

    // Route pour ajouter une dispatch fille à une dispatch mère
    $router->post('/dispatchDetail/addFille', function() use ($app) {
        $idDispatchMere = $_GET['idDispatchMere'] ?? null;
        $idProduit = $_POST['idProduit'] ?? null;
        $quantite = $_POST['quantite'] ?? null;
        
        if (!$idDispatchMere || !$idProduit || !$quantite || $quantite <= 0) {
            $app->redirect('/dispatchDetail?id=' . urlencode($idDispatchMere));
            return;
        }
         
        
        try {
            $controllerDispatchFille = new ControllerDispatchFille();
            $dispatchFille = new DispatchFille();
            $dispatchFille->setIdDispatchMere($idDispatchMere);
            $dispatchFille->setIdProduit($idProduit);
            $dispatchFille->setQuantite($quantite);
            
            $controllerDispatchFille->addDispatchFille($dispatchFille);
            
            $app->redirect('/dispatchDetail?id=' . urlencode($idDispatchMere));
        } catch (\Exception $e) {
            $app->redirect('/dispatchDetail?id=' . urlencode($idDispatchMere));
        }
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
        
        $app->render('display/villeDetail', [
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

        $router->get('/stockage', function() use ($app) {
            $controllerStockage = new ControllerStockage();
            $controllerProduit = new ControllerProduit();

            $stockages = $controllerStockage->getAllStockage();
            $produits = $controllerProduit->getAllProduit();

            $produitsById = [];
            foreach ($produits as $produit) {
                $produitsById[$produit->getIdProduit()] = $produit->getValProduit();
            }

            $app->render('display/stockage', [
                'stockages' => $stockages,
                'produitsById' => $produitsById
            ]);
        });
    
    // Route pour le dispatch par date
    $router->get('/dispatchDate', function() use ($app) {
        $controllerBesoin = new ControllerBesoin();
        $controllerVille = new ControllerVille();
        $controllerProduitBesoin = new ControllerProduitBesoin();
        $controllerProduit = new ControllerProduit();
        $controllerStockage = new ControllerStockage();
        $controllerEquivalenceProduit = new ControllerEquivalenceProduit();

        $besoins = $controllerBesoin->getAllBesoin();
        $produitBesoins = $controllerProduitBesoin->getAllProduitBesoin();
        $villes = $controllerVille->getAllVilles();
        $produits = $controllerProduit->getAllProduit();
        $equivalenceProduits = $controllerEquivalenceProduit->getAllEquivalenceProduit();
        
        // Créer les maps
        $villeMap = [];
        foreach ($villes as $ville) {
            $id = is_object($ville) ? $ville->getIdVille() : ($ville['idVille'] ?? null);
            if ($id !== null) {
                $villeMap[$id] = is_object($ville) ? $ville->getValVille() : ($ville['valVille'] ?? '');
            }
        }
        
        $produitMap = [];
        foreach ($produits as $produit) {
            $id = is_object($produit) ? $produit->getIdProduit() : ($produit['idProduit'] ?? null);
            if ($id !== null) {
                $produitMap[$id] = is_object($produit) ? $produit->getValProduit() : ($produit['valProduit'] ?? '');
            }
        }
        
        $equiproduitMap = [];
        foreach ($equivalenceProduits as $ep) {
            $id = is_object($ep) ? $ep->getIdProduit() : ($ep['idProduit'] ?? null);
            if ($id !== null) {
                $equiproduitMap[$id] = is_object($ep) ? ($ep->getQuantite() ?? 0) : ($ep['quantite'] ?? 0);
            }
        }
        
        // Trier par idBesoin (plus ancien d'abord)
        usort($besoins, function($a, $b) {
            $aId = is_object($a) ? $a->getIdBesoin() : ($a['idBesoin'] ?? 0);
            $bId = is_object($b) ? $b->getIdBesoin() : ($b['idBesoin'] ?? 0);
            return $aId - $bId;
        });

        $app->render('dispatch/dispatchDate', [
            'besoins' => $besoins,
            'produitBesoins' => $produitBesoins,
            'villeMap' => $villeMap,
            'produitMap' => $produitMap,
            'equiproduitMap' => $equiproduitMap
        ]);
    });

    // Route POST pour dispatcher un besoin
    $router->post('/dispatchDate/dispatch', function() use ($app) {
        try {
            $idBesoin = $_POST['idBesoin'] ?? null;

            if (!$idBesoin) {
                $app->redirect('/dispatchDate');
                return;
            }

            $controllerBesoin = new ControllerBesoin();
            $controllerDispatchMere = new ControllerDispatchMere();
            $controllerDispatchFille = new ControllerDispatchFille();
            $controllerProduitBesoin = new ControllerProduitBesoin();
            $controllerStockage = new ControllerStockage();

            $besoin = $controllerBesoin->getBesoinById($idBesoin);
            $idVille = is_object($besoin) ? $besoin->getIdVille() : ($besoin['idVille'] ?? null);

            // Vérifier que la ville est bien présente
            if (!$idVille) {
                $app->redirect('/dispatchDate?error=' . urlencode('La ville du besoin est introuvable'));
                return;
            }

            // Créer un dispatch mère
            $dispatchMere = new \app\models\DispatchMere();
            $dispatchMere->setIdVille($idVille);
            $dispatchMere->setDateDispatch(date('Y-m-d H:i:s'));
            
            $idDispatchMere = $controllerDispatchMere->addDispatchMere($dispatchMere);

            // Trouver les produits liés au besoin
            $produitBesoins = $controllerProduitBesoin->getAllProduitBesoin();
            foreach ($produitBesoins as $pb) {
                $pbIdBesoin = is_object($pb) ? $pb->getIdBesoin() : ($pb['idBesoin'] ?? null);
                if ($pbIdBesoin == $idBesoin) {
                    $idProduit = is_object($pb) ? $pb->getIdProduit() : ($pb['idProduit'] ?? null);
                    
                    // Récupérer la quantité en stock
                    try {
                        $quantiteStock = $controllerStockage->getQuantiteByProduitId($idProduit);
                    } catch (\Exception $e) {
                        $quantiteStock = 0;
                    }

                    // Créer une dispatch fille avec la quantité disponible
                    if ($quantiteStock > 0) {
                        $dispatchFille = new DispatchFille();
                        $dispatchFille->setIdDispatchMere($idDispatchMere);
                        $dispatchFille->setIdProduit($idProduit);
                        $dispatchFille->setQuantite($quantiteStock);
                        
                        $controllerDispatchFille->addDispatchFille($dispatchFille);
                    }
                }
            }

            $app->redirect('/dispatchDate?success=1');
        } catch (\Exception $e) {
            $app->redirect('/dispatchDate?error=' . urlencode($e->getMessage()));
        }
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
        $controllerType = new ControllerType();
        $controllerDispatchMere = new ControllerDispatchMere();
        $app->render('welcome', ['controllerVille' => $controllerVille, 'controllerBesoin' => $controllerBesoin,
        'controllerDon' => $controllerDon, 'controllerType' => $controllerType, 'controllerDispatchMere' => $controllerDispatchMere,
        ]);
    });

    // Route pour l'affichage des dons
    $router->get('/donsAffichage', function() use ($app) {
        $controllerDon = new ControllerDon();
        $controllerDonnation = new ControllerDonnation();
        
        $dons = $controllerDon->getAllDons();
        $donnations = $controllerDonnation->getAllDonnation();

        // Pré-calculer les statistiques
        $totalValeurDons = 0;
        $donsList = [];
        foreach ($dons as $don) {
            $prixDon = is_object($don) ? ($don->getTotalPrix() ?? 0) : ($don['totalPrix'] ?? 0);
            $totalValeurDons += floatval($prixDon);
            
            $id = is_object($don) ? $don->getIdDon() : ($don['idDon'] ?? null);
            $date = is_object($don) ? $don->getDateDon() : (isset($don['dateDon']) ? (is_string($don['dateDon']) ? new \DateTime($don['dateDon']) : $don['dateDon']) : new \DateTime());
            
            $donsList[] = [
                'id' => $id,
                'date' => $date,
                'prix' => $prixDon
            ];
        }

        // Formater les donnations
        $donnationsList = [];
        foreach ($donnations as $donnation) {
            $donnationsList[] = [
                'id' => is_object($donnation) ? $donnation->getIdDonnation() : ($donnation['idDonnation'] ?? null),
                'idDon' => is_object($donnation) ? $donnation->getIdDon() : ($donnation['idDon'] ?? null),
                'idProduit' => is_object($donnation) ? $donnation->getIdProduit() : ($donnation['idProduit'] ?? null),
                'quantite' => is_object($donnation) ? $donnation->getQuantiteProduit() : ($donnation['quantiteProduit'] ?? 0)
            ];
        }

        $app->render('display/donsAffichage', [
            'donsList' => $donsList,
            'donnationsList' => $donnationsList,
            'nombreDons' => count($donsList),
            'nombreDonnations' => count($donnationsList),
            'totalValeurDons' => $totalValeurDons
        ]);
    });

    // Route GET - Afficher le formulaire d'insertion de don
    $router->get('/donInsert', function() use ($app) {
        $controllerProduit = new ControllerProduit();
        $produits = $controllerProduit->getAllProduit();
        
        $app->render('crud/donInsert', ['produits' => $produits]);
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
                $app->render('crud/donInsert');
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
            $app->render('crud/donInsert');
        }
    });

    // Routes pour Ville
    $router->get('/villeInsert', function() use ($app) {
        $controllerVille = new ControllerVille();
        $controllerRegion = new ControllerRegion();
        $villes = $controllerVille->getAllVilles();
        $regions = $controllerRegion->getAllRegions();
        $app->render('crud/villeInsert', ['villes' => $villes, 'regions' => $regions]);
    });

    $router->post('/villeInsert', function() use ($app) {
        try {
            $request = $app->request();
            $nomVille = trim($request->data->nomVille ?? '');
            $idRegion = (int)($request->data->idRegion ?? 0);

            if (!$nomVille || !$idRegion) {
                $controllerVille = new ControllerVille();
                $controllerRegion = new ControllerRegion();
                $villes = $controllerVille->getAllVilles();
                $regions = $controllerRegion->getAllRegions();
                $app->view()->set('error', 'Le nom et la région sont requis');
                $app->view()->set('villes', $villes);
                $app->view()->set('regions', $regions);
                $app->render('crud/villeInsert');
                return;
            }

            $ville = new \app\models\Ville();
            $ville->setValVille($nomVille);
            $ville->setIdRegion($idRegion);
            
            $controllerVille = new ControllerVille();
            $controllerVille->addVille($ville);
            $app->redirect('/villeInsert?success=1');
        } catch (\Exception $e) {
            error_log('Erreur villeInsert: ' . $e->getMessage());
            $app->view()->set('error', 'Erreur: ' . $e->getMessage());
            $app->render('crud/villeInsert');
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
        
        $app->render('crud/besoinInsert', [
            'villes' => $villes,
            'produits' => $produits,
            'besoins' => $besoins,
            'types' => $types
        ]);
    });

    $router->post('/besoinInsert', function() use ($app) {
        try {
            $request = $app->request();
            $idVille = (int)($request->data->idVille ?? 0);
            $valBesoin = trim($request->data->valBesoin ?? '');
            $idType = (int)($request->data->idType ?? 0);
            $idProduit = (int)($request->data->idProduit ?? 0);
            $dateBesoin = $request->data->dateBesoin ?? '';
            $quantite = (float)($request->data->quantite ?? 0);
            $prixUnitaire = (float)($request->data->prixUnitaire ?? 0);

            // Validations
            if (!$idVille || !$valBesoin || !$idType || !$idProduit || !$dateBesoin) {
                $app->redirect('/?error=' . urlencode('Tous les champs sont requis'));
                return;
            }

            if ($quantite <= 0) {
                $app->redirect('/?error=' . urlencode('La quantité doit être positive'));
                return;
            }

            if ($prixUnitaire < 0) {
                $app->redirect('/?error=' . urlencode('Le prix ne peut pas être négatif'));
                return;
            }

            // Créer le besoin
            $besoin = new \app\models\Besoin();
            $besoin->setIdVille($idVille);
            $besoin->setValBesoin($valBesoin);
            $besoin->setIdType($idType);
            $besoin->setDateBesoin($dateBesoin);

            $controllerBesoin = new ControllerBesoin();
            $idBesoin = $controllerBesoin->createBesoin($besoin);
            
            if (!$idBesoin) {
                throw new \Exception('Erreur lors de la création du besoin');
            }
            
            // Lier le produit au besoin
            $produitBesoin = new \app\models\ProduitBesoin();
            $produitBesoin->setIdProduit($idProduit);
            $produitBesoin->setIdBesoin($idBesoin);
            
            $controllerProduitBesoin = new ControllerProduitBesoin();
            $controllerProduitBesoin->createProduitBesoin($produitBesoin);
            
            // Créer l'équivalence produit avec la quantité demandée et le prix
            $equivalenceProduit = new \app\models\EquivalenceProduit();
            $equivalenceProduit->setIdProduit($idProduit);
            $equivalenceProduit->setQuantite($quantite);
            $equivalenceProduit->setPrix($prixUnitaire);
            
            $controllerEquivalenceProduit = new ControllerEquivalenceProduit();
            $controllerEquivalenceProduit->createEquivalenceProduit($equivalenceProduit);
            
            $app->redirect('/?success=1');
        } catch (\Exception $e) {
            error_log('Erreur besoinInsert: ' . $e->getMessage());
            $app->redirect('/?error=' . urlencode('Erreur: ' . $e->getMessage()));
        }
    });

    // Routes pour Produit
    $router->get('/produitInsert', function() use ($app) {
        $controllerProduit = new ControllerProduit();
        $produits = $controllerProduit->getAllProduit();
        $app->render('crud/produitInsert', ['produits' => $produits]);
    });

    // Routes pour Type
    $router->get('/typeInsert', function() use ($app) {
        $controllerType = new ControllerType();
        $types = $controllerType->getAllTypes();
        $app->render('crud/typeInsert', ['types' => $types]);
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
        
        $app->render('crud/produitBesoinInsert', ['produits' => $produits, 'besoins' => $besoins]);
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
        
        $app->render('crud/equivalenceProduitInsert', ['produits' => $produits, 'equivalences' => $equivalences]);
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

    // ========== V2 ROUTES ==========
    
    // Page d'achat - acheter des produits avec les dons en argent
    $router->get('/achat', function() use ($app) {
        $controllerBesoin = new ControllerBesoin();
        $controllerProduit = new ControllerProduit();
        $controllerConfig = new ControllerConfig();
        $controllerAchat = new ControllerAchat();
        
        $besoins = $controllerBesoin->getAllBesoin();
        $produits = $controllerProduit->getAllProduit();
        $fraisAchat = $controllerConfig->getFraisAchatPourcentage() ?? 10;
        $achatsSimulation = $controllerAchat->getAchatsSimulation() ?? [];
        
        // Formater les besoins
        $besoinsList = [];
        foreach ($besoins as $besoin) {
            $besoinsList[] = [
                'id' => is_object($besoin) ? $besoin->getIdBesoin() : ($besoin['idBesoin'] ?? null),
                'val' => is_object($besoin) ? $besoin->getValBesoin() : ($besoin['valBesoin'] ?? '')
            ];
        }
        
        // Formater les produits
        $produitsList = [];
        foreach ($produits as $produit) {
            $produitsList[] = [
                'id' => is_object($produit) ? $produit->getIdProduit() : ($produit['idProduit'] ?? null),
                'name' => is_object($produit) ? $produit->getValProduit() : ($produit['valProduit'] ?? ''),
                'prix' => is_object($produit) ? $produit->getPrixUnitaire() : ($produit['prixUnitaire'] ?? 0)
            ];
        }
        
        // Formater les achats en simulation
        $achatsSimulationList = [];
        foreach ($achatsSimulation as $achat) {
            $idProduit = is_object($achat) ? $achat->getIdProduit() : ($achat['idProduit'] ?? null);
            
            // Trouver le nom du produit
            $produitName = 'N/A';
            foreach ($produits as $produit) {
                $prodId = is_object($produit) ? $produit->getIdProduit() : ($produit['idProduit'] ?? null);
                if ($prodId == $idProduit) {
                    $produitName = is_object($produit) ? $produit->getValProduit() : ($produit['valProduit'] ?? '');
                    break;
                }
            }
            
            $achatsSimulationList[] = [
                'idBesoin' => is_object($achat) ? $achat->getIdBesoin() : ($achat['idBesoin'] ?? null),
                'produitName' => $produitName,
                'quantite' => is_object($achat) ? $achat->getQuantiteAchetee() : ($achat['quantiteAchetee'] ?? 0),
                'montantAvecFrais' => is_object($achat) ? $achat->getMontantAvecFrais() : ($achat['montantAvecFrais'] ?? 0)
            ];
        }

        $app->render('purchase/achat', [
            'besoinsList' => $besoinsList,
            'produitsList' => $produitsList,
            'fraisAchat' => $fraisAchat,
            'achatsSimulationList' => $achatsSimulationList
        ]);
    });

    // POST pour ajouter un achat en simulation
    $router->post('/achat/acheter', function() use ($app) {
        try {
            $request = $app->request();
            $idBesoin = $request->data->idBesoin ?? null;
            $idProduit = $request->data->idProduit ?? null;
            $quantite = $request->data->quantite ?? null;
            
            if (!$idBesoin || !$idProduit || !$quantite || $quantite <= 0) {
                $app->redirect('/achat');
                return;
            }
            
            $controllerProduit = new ControllerProduit();
            $produit = $controllerProduit->getProduitById($idProduit);
            
            if (!$produit || !$produit->getPrixUnitaire()) {
                $app->redirect('/achat');
                return;
            }
            
            $controllerConfig = new ControllerConfig();
            $frais = $controllerConfig->getFraisAchatPourcentage();
            
            // Calcul: montant = quantité * prix unitaire
            $montantTotal = floatval($quantite) * floatval($produit->getPrixUnitaire());
            $montantFrais = $montantTotal * ($frais / 100);
            $montantAvecFrais = $montantTotal + $montantFrais;
            
            $achat = new Achat();
            $achat->setIdBesoin($idBesoin);
            $achat->setIdProduit($idProduit);
            $achat->setQuantiteAchetee($quantite);
            $achat->setPrixUnitaire($produit->getPrixUnitaire());
            $achat->setMontantTotal($montantTotal);
            $achat->setMontantFrais($montantFrais);
            $achat->setMontantAvecFrais($montantAvecFrais);
            $achat->setStatut('simulation');
            
            $controllerAchat = new ControllerAchat();
            $controllerAchat->addAchat($achat);
            
            $app->redirect('/achat');
        } catch (\Exception $e) {
            $app->redirect('/achat');
        }
    });

    // Page de simulation - voir et valider/rejeter les achats
    $router->get('/simulation', function() use ($app) {
        $controllerAchat = new ControllerAchat();
        $controllerProduit = new ControllerProduit();
        
        $achatsSimulation = $controllerAchat->getAchatsSimulation() ?? [];
        $produits = $controllerProduit->getAllProduit() ?? [];
        
        // Formater les achats en simulation avec données pré-calculées
        $achatsSimulationList = [];
        foreach ($achatsSimulation as $achat) {
            $idProduit = is_object($achat) ? $achat->getIdProduit() : ($achat['idProduit'] ?? null);
            
            // Trouver le nom du produit
            $produitName = 'N/A';
            foreach ($produits as $produit) {
                $prodId = is_object($produit) ? $produit->getIdProduit() : ($produit['idProduit'] ?? null);
                if ($prodId == $idProduit) {
                    $produitName = is_object($produit) ? $produit->getValProduit() : ($produit['valProduit'] ?? '');
                    break;
                }
            }
            
            $achatsSimulationList[] = [
                'idBesoin' => is_object($achat) ? $achat->getIdBesoin() : ($achat['idBesoin'] ?? null),
                'produitName' => $produitName,
                'quantite' => is_object($achat) ? $achat->getQuantiteAchetee() : ($achat['quantiteAchetee'] ?? 0),
                'prixUnitaire' => is_object($achat) ? $achat->getPrixUnitaire() : ($achat['prixUnitaire'] ?? 0),
                'montantTotal' => is_object($achat) ? $achat->getMontantTotal() : ($achat['montantTotal'] ?? 0),
                'montantFrais' => is_object($achat) ? $achat->getMontantFrais() : ($achat['montantFrais'] ?? 0),
                'montantAvecFrais' => is_object($achat) ? $achat->getMontantAvecFrais() : ($achat['montantAvecFrais'] ?? 0)
            ];
        }

        $app->render('purchase/simulation', [
            'achatsSimulationList' => $achatsSimulationList
        ]);
    });

    // POST pour valider tous les achats en simulation
    $router->post('/simulation/valider', function() use ($app) {
        try {
            $controllerAchat = new ControllerAchat();
            $achatsSimulation = $controllerAchat->getAchatsSimulation();
            
            foreach ($achatsSimulation as $achat) {
                $controllerAchat->updateStatutAchat($achat->getIdAchat(), 'validé');
            }
            
            $app->redirect('/recapitulation');
        } catch (\Exception $e) {
            $app->redirect('/simulation');
        }
    });

    // POST pour rejeter tous les achats en simulation
    $router->post('/simulation/rejeter', function() use ($app) {
        try {
            $controllerAchat = new ControllerAchat();
            $achatsSimulation = $controllerAchat->getAchatsSimulation();
            
            foreach ($achatsSimulation as $achat) {
                $controllerAchat->deleteAchat($achat->getIdAchat());
            }
            
            $app->redirect('/achat');
        } catch (\Exception $e) {
            $app->redirect('/simulation');
        }
    });

    // Page de récapitulation - afficher les stats d'achat
    $router->get('/recapitulation', function() use ($app) {
        $controllerAchat = new ControllerAchat();
        $controllerBesoin = new ControllerBesoin();
        $controllerProduit = new ControllerProduit();
        
        $achatsValides = $controllerAchat->getAchatsValides();
        $besoins = $controllerBesoin->getAllBesoin();
        $produits = $controllerProduit->getAllProduit();
        
        // Calculer les stats
        $stats = [
            'totalBesoins' => 0,
            'besoinsSatisfaits' => 0,
            'montantTotal' => 0,
            'montantRestant' => 0
        ];
        
        foreach ($besoins as $besoin) {
            $montantBesoin = floatval($besoin->getValBesoin() ?? 0);
            $stats['totalBesoins'] += $montantBesoin;
        }
        
        foreach ($achatsValides as $achat) {
            $stats['montantTotal'] += floatval($achat->getMontantAvecFrais());
        }
        
        $stats['montantRestant'] = $stats['totalBesoins'] - $stats['montantTotal'];
        if ($stats['montantRestant'] < 0) $stats['montantRestant'] = 0;
        
        $app->render('display/recapitulation', [
            'stats' => $stats,
            'achatsValides' => $achatsValides,
            'besoins' => $besoins,
            'produits' => $produits
        ]);
    });

    $router->get('/villeDelete', function() use ($app) {
        $idVille = $_GET['idVille'] ?? null;
        
        if (!$idVille) {
            $app->redirect('/villes');
            return;
        }
        
        $controllerVille = new ControllerVille();
        $ville = $controllerVille->getVilleById($idVille);
        
        if ($ville) {
            $controllerVille->removeVille($ville);
        }
        
        $app->redirect('/villes');
    });

}, [ SecurityHeadersMiddleware::class ]);