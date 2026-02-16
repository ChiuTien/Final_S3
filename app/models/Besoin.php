<?php 
    namespace app\models;  

    class Besoin {
    //Attributs
        private $idBesoin;
        private $valBesoin;
        private $idType;
    //Constructeur
        public function __construct() {}
    //Setters
        public function setIdBesoin($id) {
            $this->idBesoin = $id;
        }
        public function setIdType($id) {
            $this->idType = $id;
        }
        public function setValBesoin($val) {
            $this->valBesoin = $val;
        }
    //Getters
        public function getIdBesoin() {
            return $this->idBesoin;
        }
        public function getIdType() {
            return $this->idType;
        }
        public function getValBesoin() {
            return $this->valBesoin;
        }
    }
?>