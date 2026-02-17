<?php 
    namespace app\controllers;

    use app\models\Donnation;
    use app\repository\RepDonnation;
    use app\repository\RepStockage;

    class ControllerDonnation {
        // Attribut
        private RepDonnation $repDonnation;
        private RepStockage $repStockage;

        // Constructeur
        public function __construct() {
            $this->repDonnation = new RepDonnation();
            $this->repStockage = new RepStockage();
        }

        // Méthodes
        public function addDonnation(Donnation $donnation): void {
            $this->repDonnation->addDonnation($donnation);
            $this->repStockage->increaseQuantiteByProduitId(
                $donnation->getIdProduit(),
                (float) $donnation->getQuantiteProduit()
            );
        }

        public function deleteDonnation(int $idDonnation): void {
            $this->repDonnation->deleteDonnation($idDonnation);
        }

        public function updateDon(Donnation $donnation): void {
            $this->repDonnation->updateDon($donnation);
        }

        public function getDonnationById(int $idDonnation): Donnation {
            return $this->repDonnation->getDonnationById($idDonnation);
        }

        public function getAllDonnation(): array {
            return $this->repDonnation->getAllDonnation();
        }

        public function getQuantiteProduitByIdProduit(int $idProduit): int {
            return $this->repDonnation->getQuantiteProduitByIdProduit($idProduit);
        }
    }


?>
