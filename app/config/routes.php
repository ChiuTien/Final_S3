<?php
// Basic routes for the app views
use function Flight\route;

use app\middlewares\SecurityHeadersMiddleware;
use flight\Engine;
use flight\net\Router;
use app\controllers\ControllerDon;
use app\controllers\ControllerDonnation;
use app\controllers\ControllerVille;
use app\controllers\ControllerBesoin;
use app\controllers\ControllerDispatchMere;
// Home
Flight::route('GET /', function() {
    Flight::render('welcome');
});

Flight::route('GET /villes', function() {
    Flight::render('villes');
});

Flight::route('GET /besoins', function() {
    Flight::render('besoins');
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
Flight::route('GET /dispatch', function() {
    Flight::render('dispatch');
});

Flight::route('GET /donsAffichage', function() {
    // Prepare data via controllers if available
    try {
        if (class_exists('\app\controllers\ControllerDon')) {
            $ctrlDon = new \app\controllers\ControllerDon();
            $dons = $ctrlDon->getAllDons();
        }
        if (class_exists('\app\repository\RepDonnation')) {
            $rep = new \app\repository\RepDonnation();
            $donnations = $rep->getAllDonnation();
        }
    } catch (\Throwable $e) {}
    Flight::render('donsAffichage', compact('dons', 'donnations'));
});

// Simple route to render single ville (name)
Flight::route('GET /ville/@name', function($name) {
    // In a fuller app you'd lookup ville details via controller; here render view with name
    Flight::render('ville', ['villeName' => $name]);
});
