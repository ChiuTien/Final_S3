<?php
    namespace app\models;

    class EquivalenceDate {
    //Attributs
        private $idEquivalence;
        private $idBesoin;
        private $dateEquivalence;
    //Constructeur
        public function __construct() {}
    //Setters
        public function setIdEquivalence($id) {
            $this->idEquivalence = $id;
        }
        public function setIdBesoin($id) {
            $this->idBesoin = $id;
        }
        public function setDateEquivalence($date) {
            $this->dateEquivalence = $date;
        }
    //Getters
        public function getIdEquivalence() {
            return $this->idEquivalence;
        }
        public function getIdBesoin() {
            return $this->idBesoin;
        }
        public function getDateEquivalence() {
            return $this->dateEquivalence;
        }
    }
?>
