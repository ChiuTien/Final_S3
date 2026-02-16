<?php 
    namespace app\models;  

    class Produit {
    //Attributs
        private $idProduit;
        private $valProduit;
        private $idType;
    //Constructeur
        public function __construct() {}
    //Setters
        public function setIdProduit($id) {
            $this->idProduit = $id;
        }
        public function setIdType($id) {
            $this->idType = $id;
        }
        public function setValProduit($val) {
            $this->valProduit = $val;
        }
    //Getters
        public function getIdProduit() {
            return $this->idProduit;
        }
        public function getIdType() {
            return $this->idType;
        }
        public function getValProduit() {
            return $this->valProduit;
        }
    }
?>