<?php 
namespace app\models;

class Ville {
    private $idVille;

    private $idRegion;
    private $valVille;

    public function __construct() {
        
    }

    public function setIdVille($idVille) {
        $this->idVille = $idVille;
    }

    public function getIdVille() {
        return $this->idVille;
    }

    public function setValVille($valVille) {
        $this->valVille = $valVille;
    }

    public function getValVille() {
        return $this->valVille;
    }

    public function setIdRegion($idRegion) {
        $this->idRegion = $idRegion;
    }

    public function getIdRegion() {
        return $this->idRegion;
    }
}
?>