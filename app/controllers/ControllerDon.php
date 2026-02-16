<?php 
namespace App\Controllers;
use app\models\Don;
use app\repository\RepDon;
class ControllerDon {
    //Attribut
    private RepDon $repDon;
    //Constructeur
    public function __construct() {
        $this->repDon = new RepDon();
    }
    //CRUD
    public function addDon(Don $don): int {
        return $this->repDon->addDon($don);
    }
    public function deleteDon(int $id): void {
        $this->repDon->deleteDon($id);
    }
    public function updateDon(Don $don): void {
        $this->repDon->updateDon($don);
    }
    public function getDonById(int $id): Don {
        return $this->repDon->getDonById($id);
    }
    public function getAllDons(): array {
        return $this->repDon->getAllDons();
    }
    //Methodes supplementaires
    public function getNombreDons() {
        $dons = $this->getAllDons();
        return count($dons);
        //Ceci devrait etre la
    }
}

?>