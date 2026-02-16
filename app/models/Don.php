<?php 
namespace app\Models;
class Don{
    private $idDon;
    private  DateTime $dateDon;
    private $totalPrix;

    public function __construct($idDon, DateTime $dateDon, $totalPrix) {
        $this->idDon = $idDon;
        $this->dateDon = $dateDon;
        $this->totalPrix = $totalPrix;
    }

    public function getIdDon() :int {
        return $this->idDon;
    }

    public function getDateDon() :DateTime {
        return $this->dateDon;
    }

    public function getTotalPrix() :float {
        return $this->totalPrix;
    }
    public function setIdDon($idDon) :void {
        $this->idDon = $idDon;
    }

    public function setDateDon(DateTime $dateDon) :void {
        $this->dateDon = $dateDon;
    }

    public function setTotalPrix($totalPrix) :void {
        $this->totalPrix = $totalPrix;
    }
}


?>