<?php
    namespace app\Controllers;

    use app\repository\RepEquivalenceProduit;
    use app\models\EquivalenceProduit;

    class ControllerEquivalenceProduit {
    //Attributs
        private RepEquivalenceProduit $repEquivalenceProduit;
    //Constructeur
        public function __construct() {
            $this->repEquivalenceProduit = new RepEquivalenceProduit();
        }
    //CRUD
        public function createEquivalenceProduit(EquivalenceProduit $equivalenceProduit) {
            return $this->repEquivalenceProduit->ajouterEquivalenceProduit($equivalenceProduit);
        }
        public function getAllEquivalenceProduit() {
            return $this->repEquivalenceProduit->getAllEquivalenceProduit();
        }
        public function getEquivalenceProduitById($id) {
            return $this->repEquivalenceProduit->getEquivalenceProduitById($id);
        }
        public function updateEquivalenceProduit(EquivalenceProduit $equivalenceProduit) {
            return $this->repEquivalenceProduit->modifierEquivalenceProduit($equivalenceProduit);
        }
        public function deleteEquivalenceProduit($id) {
            return $this->repEquivalenceProduit->supprimerEquivalenceProduit($id);
        }
    }

?>
