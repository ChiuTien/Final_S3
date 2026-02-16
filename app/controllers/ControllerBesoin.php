<?php 
    namespace app\Controllers;

    use app\repository\RepBesoin;
    use app\models\Besoin;

    class ControllerBesoin {
    //Attributs
        private RepBesoin $repBesoin;
    //Constructeur
        public function __construct() {
            $this->repBesoin = new RepBesoin();
        }
    //CRUD
        public function createBesoin(Besoin $besoin) {
            return $this->repBesoin->ajouterBesoin($besoin);
        }
        public function getAllBesoin() {
            return $this->repBesoin->getAllBesoin();
        }
        public function getBesoinById($id) {
            return $this->repBesoin->getBesoinById($id);
        }
        public function updateBesoin(Besoin $besoin) {
            return $this->repBesoin->modifierBesoin($besoin);
        }
        public function deleteBesoin($id) {
            return $this->repBesoin->supprimerBesoin($id);
        }
    }

?>