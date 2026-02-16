<?php 
    namespace app\models;

    class EquivalenceProduit {
    //Attributs
        private $idEquivalenceProduit;
        private $idProduit;
        private $quantite;
        private $prix;
        private $val;
    //Constructeur
        public function __construct() {}
    //Setters
        public function setIdEquivalenceProduit($id) {
            $this->idEquivalenceProduit = $id;
        }
        public function setIdProduit($id) {
            $this->idProduit = $id;
        }
        public function setPrix($prix) {
            $this->prix = $prix;
        }
        public function setQuantite($quantite) {
            $this->quantite = $quantite;
        }
        public function setVal($val) {
            $this->val = $val;
        }
    //Getters
        public function getIdEquivalenceProduit() {
            return $this->idEquivalenceProduit;
        }
        public function getIdProduit() {
            return $this->idProduit;
        }
        public function getPrix() {
            return $this->prix;
        }
        public function getQuantite() {
            return $this->quantite;
        }
        public function getVal() {
            return $this->val;
        }
    }
?>