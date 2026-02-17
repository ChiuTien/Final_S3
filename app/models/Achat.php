<?php
namespace app\models;

class Achat {
    private $idAchat;
    private $idBesoin;
    private $idProduit;
    private $quantiteAchetee;
    private $prixUnitaire;
    private $montantTotal;
    private $montantFrais;
    private $montantAvecFrais;
    private $dateAchat;
    private $statut;

    public function __construct() {}

    // Setters
    public function setIdAchat($id) {
        $this->idAchat = $id;
    }

    public function setIdBesoin($id) {
        $this->idBesoin = $id;
    }

    public function setIdProduit($id) {
        $this->idProduit = $id;
    }

    public function setQuantiteAchetee($quantite) {
        $this->quantiteAchetee = $quantite;
    }

    public function setPrixUnitaire($prix) {
        $this->prixUnitaire = $prix;
    }

    public function setMontantTotal($montant) {
        $this->montantTotal = $montant;
    }

    public function setMontantFrais($frais) {
        $this->montantFrais = $frais;
    }

    public function setMontantAvecFrais($montant) {
        $this->montantAvecFrais = $montant;
    }

    public function setDateAchat($date) {
        $this->dateAchat = $date;
    }

    public function setStatut($statut) {
        $this->statut = $statut;
    }

    // Getters
    public function getIdAchat() {
        return $this->idAchat;
    }

    public function getIdBesoin() {
        return $this->idBesoin;
    }

    public function getIdProduit() {
        return $this->idProduit;
    }

    public function getQuantiteAchetee() {
        return $this->quantiteAchetee;
    }

    public function getPrixUnitaire() {
        return $this->prixUnitaire;
    }

    public function getMontantTotal() {
        return $this->montantTotal;
    }

    public function getMontantFrais() {
        return $this->montantFrais;
    }

    public function getMontantAvecFrais() {
        return $this->montantAvecFrais;
    }

    public function getDateAchat() {
        return $this->dateAchat;
    }

    public function getStatut() {
        return $this->statut;
    }
}
?>
