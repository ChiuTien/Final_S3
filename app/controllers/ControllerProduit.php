<?php
    namespace app\controllers;

    use app\repository\RepProduit;
    use app\models\Produit;

    class ControllerProduit {
    //Attributs
        private RepProduit $repProduit;
    //Constructeur
        public function __construct() {
            $this->repProduit = new RepProduit();
        }
    //CRUD
        public function createProduit(Produit $produit) {
            return $this->repProduit->ajouterProduit($produit);
        }
        public function getAllProduit() {
            return $this->repProduit->getAllProduit();
        }
        public function getProduitById($id) {
            return $this->repProduit->getProduitById($id);
        }
        public function updateProduit(Produit $produit) {
            return $this->repProduit->modifierProduit($produit);
        }
        public function deleteProduit($id) {
            return $this->repProduit->supprimerProduit($id);
        }
    }

?>
