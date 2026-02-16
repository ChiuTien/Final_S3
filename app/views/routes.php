<?php

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\ControllerDon;
use app\controllers\ControllerDonnation;
use app\controllers\ControllerVille;
use app\controllers\ControllerBesoin;
use app\controllers\ControllerDispatchMere;

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
        $app->render('welcome', ['controllerVille' => $controllerVille, 'controllerBesoin' => $controllerBesoin, 
        'controllerDispatchMere' => $controllerDispatchMere, 'controllerDon' => $controllerDon]);
    });

    // Route pour l'affichage des dons
    $router->get('/donsAffichage', function() use ($app) {
        $controllerDon = new ControllerDon();
        $dons = $controllerDon->getAllDons();
        
        $controllerDonnation = new ControllerDonnation();
        $donnations = $controllerDonnation->getAllDonnation();

        $app->render('donsAffichage', ['dons' => $dons, 'donnations' => $donnations]);
    });

    $router->get('/villes', function() use ($app) {
        $controllerVille = new ControllerVille();
        $app->render('villes', ['controllerVille' => $controllerVille]);
    });

}, [ SecurityHeadersMiddleware::class ]);