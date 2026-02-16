<?php 
    namespace app\models;  

    class ProduitBesoin {
    //Attributs
        private $idProduit;
        private $idBesoin;
    //Constructeur
        public function __construct() {}
    //Setters
        public function setIdProduit($id) {
            $this->idProduit = $id;
        }
        public function setIdBesoin($id) {
            $this->idBesoin = $id;
        }
    //Getters
        public function getIdProduit() {
            return $this->idProduit;
        }
        public function getIdBesoin() {
            return $this->idBesoin;

        }
    }
?>