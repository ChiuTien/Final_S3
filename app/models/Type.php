<?php 
namespace app\models;

class Type {
    private $idType;
    private $valType;

    public function __construct() {
        
    }

    public function setIdType($idType) {
        $this->idType = $idType;
    }

    public function getIdType() {
        return $this->idType;
    }

    public function setValType($valType) {
        $this->valType = $valType;
    }

    public function getValType() {
        return $this->valType;
    }
}
?>