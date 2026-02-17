<?php
    namespace app\controllers;

    use app\repository\RepEquivalenceDate;
    use app\models\EquivalenceDate;

    class ControllerEquivalenceDate {
    //Attributs
        private RepEquivalenceDate $repEquivalenceDate;
    //Constructeur
        public function __construct() {
            $this->repEquivalenceDate = new RepEquivalenceDate();
        }
    //CRUD
        public function createEquivalenceDate(EquivalenceDate $equivalenceDate) {
            return $this->repEquivalenceDate->ajouterEquivalenceDate($equivalenceDate);
        }
        public function getAllEquivalenceDate() {
            return $this->repEquivalenceDate->getAllEquivalenceDate();
        }
        public function getEquivalenceDateById($id) {
            return $this->repEquivalenceDate->getEquivalenceDateById($id);
        }
        public function updateEquivalenceDate(EquivalenceDate $equivalenceDate) {
            return $this->repEquivalenceDate->modifierEquivalenceDate($equivalenceDate);
        }
        public function deleteEquivalenceDate($id) {
            return $this->repEquivalenceDate->supprimerEquivalenceDate($id);
        }
    }

?>
