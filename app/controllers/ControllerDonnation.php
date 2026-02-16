<?php 
    namespace app\controllers;

    use app\model\Donnation;
    use app\repository\RepDonnation;

    class ControllerDonnation {
        // Attribut
        private RepDonnation $repDonnation;

        // Constructeur
        public function __construct(RepDonnation $repDonnation) {
            $this->repDonnation = $repDonnation;
        }

        // Méthodes
        public function addDonnation(Donnation $donnation): void {
            $this->repDonnation->addDonnation($donnation);
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
    }


?>
