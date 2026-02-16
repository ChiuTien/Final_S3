<?php
// Basic routes for the app views
use function Flight\route;


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
