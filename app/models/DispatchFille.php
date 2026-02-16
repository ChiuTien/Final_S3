<?php
namespace app\models;

class DispatchFille {
    private $idDispatchFille;
    private $idDispatchMere;
    private $idProduit;
    private $quantite;

    public function __construct() {
    }

    public function setIdDispatchFille($id) {
        $this->idDispatchFille = $id;
    }

    public function getIdDispatchFille() {
        return $this->idDispatchFille;
    }

    public function setIdDispatchMere($id) {
        $this->idDispatchMere = $id;
    }

    public function getIdDispatchMere() {
        return $this->idDispatchMere;
    }

    public function setIdProduit($idProduit) {
        $this->idProduit = $idProduit;
    }

    public function getIdProduit() {
        return $this->idProduit;
    }

    public function setQuantite($q) {
        $this->quantite = $q;
    }

    public function getQuantite() {
        return $this->quantite;
    }
}
?>
