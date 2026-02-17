<?php
    namespace app\controllers;

    use app\repository\RepStockage;
    use app\models\Stockage;

    class ControllerStockage {
    //Attributs
        private RepStockage $repStockage;
    //Constructeur
        public function __construct() {
            $this->repStockage = new RepStockage();
        }
    //CRUD
        public function createStockage(Stockage $stockage) {
            return $this->repStockage->ajouterStockage($stockage);
        }
        public function getAllStockage() {
            return $this->repStockage->getAllStockage();
        }
        public function getStockageById($id) {
            return $this->repStockage->getStockageById($id);
        }
        public function updateStockage(Stockage $stockage) {
            return $this->repStockage->modifierStockage($stockage);
        }
        public function deleteStockage($id) {
            return $this->repStockage->supprimerStockage($id);
        }
    //Methodes supplémentaires
        public function getNombreStockage() {
            $stockages = $this->getAllStockage();
            return count($stockages);
        }

        public function getQuantiteByProduitId($idProduit) {
            return $this->repStockage->getQuantiteByProduitId($idProduit);
        }

        public function updateQuantiteByProduitId($idProduit, $quantite) {
            return $this->repStockage->updateQuantiteByProduitId($idProduit, $quantite);
        }
    }

?>
