<?php 
namespace app\models;

class TypeBesoin {
    private $idTypeBesoin;
    private $valTypeBesoin;

    public function __construct() {
        
    }

    public function setIdTypeBesoin($idTypeBesoin) {
        $this->idTypeBesoin = $idTypeBesoin;
    }

    public function getIdTypeBesoin() {
        return $this->idTypeBesoin;
    }

    public function setValTypeBesoin($valTypeBesoin) {
        $this->valTypeBesoin = $valTypeBesoin;
    }

    public function getValTypeBesoin() {
        return $this->valTypeBesoin;
    }
}
?>