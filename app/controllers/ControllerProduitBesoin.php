<?php
    namespace app\Controllers;

    use app\repository\RepProduitBesoin;
    use app\models\ProduitBesoin;

    class ControllerProduitBesoin {
    //Attributs
        private RepProduitBesoin $repProduitBesoin;
    //Constructeur
        public function __construct() {
            $this->repProduitBesoin = new RepProduitBesoin();
        }
    //CRUD
        public function createProduitBesoin(ProduitBesoin $produitBesoin) {
            return $this->repProduitBesoin->ajouterProduitBesoin($produitBesoin);
        }
        public function getAllProduitBesoin() {
            return $this->repProduitBesoin->getAllProduitBesoin();
        }
        public function getProduitBesoinById($id) {
            return $this->repProduitBesoin->getProduitBesoinByIds($id);
        }
        public function updateProduitBesoin(ProduitBesoin $produitBesoin) {
            return $this->repProduitBesoin->modifierProduitBesoin($produitBesoin);
        }
        public function deleteProduitBesoin($id) {
            return $this->repProduitBesoin->supprimerProduitBesoin($id);
        }
    }

?>
