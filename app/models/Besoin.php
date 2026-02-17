<?php 
    namespace app\models;  

    class Besoin {
    //Attributs
        private $idBesoin;
        private $valBesoin;
        private $idVille;
        private $idType;
        private $dateBesoin;
    //Constructeur
        public function __construct() {}
    //Setters
        public function setIdBesoin($id) {
            $this->idBesoin = $id;
        }
        public function setIdVille($id) {
            $this->idVille = $id;
        }
        public function setIdType($id) {
            $this->idType = $id;
        }
        public function setValBesoin($val) {
            $this->valBesoin = $val;
        }
        public function setDateBesoin($date) {
            $this->dateBesoin = $date;
        }
    //Getters
        public function getIdBesoin() {
            return $this->idBesoin;
        }
        public function getIdVille() {
            return $this->idVille;
        }
        public function getIdType() {
            return $this->idType;
        }
        public function getValBesoin() {
            return $this->valBesoin;
        }
        public function getDateBesoin() {
            return $this->dateBesoin;
        }
    }
?>