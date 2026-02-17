<?php 
    namespace app\models;

    class Stockage {
    //Attributs
        private $idStockage;
        private $idProduit;
        private $quantite;
    //Constructeur
        public function __contruct() {}
    //Setters
        public function setIdStockage($idStockage) {
            $this->idStockage = $idStockage;
        }
        public function setIdProduit($idProduit) {
            $this->idProduit = $idProduit;
        }
        public function setQuantite($quantite) {
            $this->quantite = $quantite;
        }
    //Getters
        public function getIdStockage() {
            return $this->idStockage;
        }
        public function getIdProduit() {
            return $this->idProduit;
        }
        public function getQuantite() {
            return $this->quantite;
        }
    }
?>