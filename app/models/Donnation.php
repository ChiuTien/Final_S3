<?php 
    namespace App\Models;
    class Donnation{
        //Attribut 
        private $idDonnation;
        private $idDon;
        private $idProduit;
        private $quantiteProduit;

        //Constructeur
        public function __construct(){
        }

        //Getters
        public function getIdDonnation(){
            return $this->idDonnation;
        }

        public function getIdDon(){
            return $this->idDon;
        }

        public function getIdProduit(){
            return $this->idProduit;
        }

        public function getQuantiteProduit(){
            return $this->quantiteProduit;
        }

        //Setters
        public function setIdDonnation($idDonnation){
            $this->idDonnation = $idDonnation;
        }

        public function setIdDon($idDon){
            $this->idDon = $idDon;
        }

        public function setIdProduit($idProduit){
            $this->idProduit = $idProduit;
        }

        public function setQuantiteProduit($quantiteProduit){
            $this->quantiteProduit = $quantiteProduit;
        }
    }


?>