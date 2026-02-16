<?php
namespace app\models;

class DispatchMere {
    private $idDispatchMere;
    private $idVille;
    private $dateDispatch;

    public function __construct() {
    }

    public function setIdDispatchMere($id) {
        $this->idDispatchMere = $id;
    }

    public function getIdDispatchMere() {
        return $this->idDispatchMere;
    }

    public function setIdVille($idVille) {
        $this->idVille = $idVille;
    }

    public function getIdVille() {
        return $this->idVille;
    }

    public function setDateDispatch($date) {
        $this->dateDispatch = $date;
    }

    public function getDateDispatch() {
        return $this->dateDispatch;
    }
}
?>
