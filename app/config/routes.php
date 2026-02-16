<?php

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\models\Don;
use app\models\Donnation;
use app\controllers\ControllerDon;
use app\controllers\ControllerDonnation;
/** 
 * @var Router $router 
 * @var Engine $app
 */

// This wraps all routes in the group with the SecurityHeadersMiddleware
$router->group('', function(Router $router) use ($app) {

<<<<<<< HEAD
	//Get
	$router->get('/', function() use ($app) {
		$app->render('accueil');
	});

	//Post
	
=======
    // Route pour la page d'accueil
    $router->get('/', function() use ($app) {
        $app->render('welcome');
    });

    // Route pour l'affichage des dons
    $router->get('/donsAffichage', function() use ($app) {
        $controllerDon = new ControllerDon();
        $dons = $controllerDon->getAllDons();
        
        $controllerDonnation = new ControllerDonnation();
        $donnations = $controllerDonnation->getAllDonnation();

        $app->render('donsAffichage', ['dons' => $dons, 'donnations' => $donnations]);
    });

>>>>>>> Christelle
}, [ SecurityHeadersMiddleware::class ]);