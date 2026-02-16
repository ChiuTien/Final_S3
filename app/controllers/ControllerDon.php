<?php 
namespace app\controllers;
use app\models\Don;
use app\repository\RepDon;
class ControllerDon {
    //Attribut
    private RepDon $repDon;
    //Constructeur
    public function __construct() {
        $this->repDon = new RepDon();
    }
    //Methodes
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

    public function calculerEtMettreAJourPrixTotal(int $idDon): void {
        $this->repDon->calculerEtMettreAJourPrixTotal($idDon);
    }


}

?>