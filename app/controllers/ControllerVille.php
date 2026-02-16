<?php
namespace app\controllers;

use app\models\Ville;
use app\repository\RepVille;

class ControllerVille {
    private RepVille $villeRepo;

    public function __construct() {
        $this->villeRepo = new RepVille();
    }

    public function addVille(Ville $ville) {
        $this->villeRepo->addVille($ville);
    }

    public function removeVille(Ville $ville) {
        return $this->villeRepo->removeVille($ville);
    }

    public function getVilleById($id) {
        return $this->villeRepo->getVilleById($id);
    }

    public function getAllVilles() {
        return $this->villeRepo->getAllVilles();
    }

    public function getVillesByRegion($regionId) {
        return $this->villeRepo->getVillesByRegion($regionId);
    }

    public function updateVille(Ville $ville) {
        return $this->villeRepo->updateVille($ville);
    }

    //Methodes supplementaires
    public function getNombreVille() {
        $villes = $this->getAllVilles();
        return count($villes);
    }
}
?>
