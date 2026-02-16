<?php 
    namespace app\models;  

    class Besoin {
    //Attributs
        private $idBesoin;
        private $idTypeBesoin;
        private $valBesoin;
    //Constructeur
        public function __construct() {}
    //Setters
        public function setIdBesoin($id) {
            $this->idBesoin = $id;
        }
        public function setIdTypeBesoin($id) {
            $this->idTypeBesoin = $id;
        }
        public function setValBesoin($val) {
            $this->valBesoin = $val;
        }
    //Getters
        public function getIdBesoin() {
            return $this->idBesoin;
        }
        public function getIdTypeBesoin() {
            return $this->idTypeBesoin;
        }
        public function getValBesoin() {
            return $this->valBesoin;
        }
    }
?>