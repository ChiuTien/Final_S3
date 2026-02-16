<?php 
namespace app\models;

class Region {
    private $idRegion;
    private $valRegion;

    public function __construct() {
        
    }

    public function setIdRegion($idRegion) {
        $this->idRegion = $idRegion;
    }

    public function getIdRegion() {
        return $this->idRegion;
    }

    public function setValRegion($valRegion) {
        $this->valRegion = $valRegion;
    }

    public function getValRegion() {
        return $this->valRegion;
    }
}
?>