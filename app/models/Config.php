<?php
namespace app\models;

class Config {
    private $idConfig;
    private $cleCongif;
    private $valeur;
    private $description;

    public function __construct() {}

    // Setters
    public function setIdConfig($id) {
        $this->idConfig = $id;
    }

    public function setCleCongif($cle) {
        $this->cleCongif = $cle;
    }

    public function setValeur($valeur) {
        $this->valeur = $valeur;
    }

    public function setDescription($desc) {
        $this->description = $desc;
    }

    // Getters
    public function getIdConfig() {
        return $this->idConfig;
    }

    public function getCleCongif() {
        return $this->cleCongif;
    }

    public function getValeur() {
        return $this->valeur;
    }

    public function getDescription() {
        return $this->description;
    }
}
?>
