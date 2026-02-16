<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$ds = DIRECTORY_SEPARATOR;
require 'vendor' . $ds . 'autoload.php';
require 'app' . $ds . 'config' . $ds . 'config.php';
require 'app' . $ds . 'config' . $ds . 'services.php';

use app\controllers\ControllerDon;
use app\controllers\ControllerDonnation;
use app\models\Don;
use app\models\Donnation;

echo "=== TEST D'INSERTION DE DON ET DONNATIONS ===\n\n";

try {
    // 1. Créer un don
    echo "1. Création d'un don...\n";
    $don = new Don(null, new \DateTime('2026-02-16'), 0);
    $controllerDon = new ControllerDon();
    $idDon = $controllerDon->addDon($don);
    echo "✅ Don créé avec ID: $idDon\n\n";
    
    // 2. Créer des donnations
    echo "2. Création de donnations...\n";
    $controllerDonnation = new ControllerDonnation();
    
    // Donnation 1: 2 kg de Riz (idProduit=1)
    $donnation1 = new Donnation(null, $idDon, 1, 2.5);
    $controllerDonnation->addDonnation($donnation1);
    echo "✅ Donnation 1 créée: 2.5 kg de Riz (ID produit: 1)\n";
    
    // Donnation 2: 3 litres d'Huile (idProduit=2)
    $donnation2 = new Donnation(null, $idDon, 2, 3.0);
    $controllerDonnation->addDonnation($donnation2);
    echo "✅ Donnation 2 créée: 3.0 litres d'Huile (ID produit: 2)\n\n";
    
    // 3. Calculer le prix total
    echo "3. Calcul du prix total...\n";
    $controllerDon->calculerEtMettreAJourPrixTotal($idDon);
    echo "✅ Prix total calculé\n\n";
    
    // 4. Vérifier les données insérées
    echo "4. Vérification des données dans la base...\n";
    $db = Flight::db();
    
    // Vérifier le don
    $stmt = $db->prepare("SELECT * FROM Don WHERE idDon = :idDon");
    $stmt->execute([':idDon' => $idDon]);
    $donData = $stmt->fetch(PDO::FETCH_ASSOC);
    echo "Don ID $idDon:\n";
    echo "  - Date: " . $donData['dateDon'] . "\n";
    echo "  - Prix total: " . $donData['totalPrix'] . " Ar\n\n";
    
    // Vérifier les donnations
    $stmt = $db->prepare("SELECT * FROM Donnation WHERE idDon = :idDon");
    $stmt->execute([':idDon' => $idDon]);
    $donnations = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Donnations pour ce don:\n";
    foreach($donnations as $d) {
        echo "  - ID: " . $d['idDonnation'] . ", Produit: " . $d['idProduit'] . ", Quantité: " . $d['quantiteProduit'] . "\n";
    }
    
    echo "\n✅ TEST RÉUSSI !\n";
    
} catch (\Exception $e) {
    echo "\n❌ ERREUR: " . $e->getMessage() . "\n";
    echo "Trace:\n" . $e->getTraceAsString() . "\n";
}
