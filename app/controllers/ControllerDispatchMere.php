<?php
namespace app\controllers;

use app\models\DispatchMere;
use app\repository\RepDispatchMere;

class ControllerDispatchMere {
    private RepDispatchMere $repo;

    public function __construct() {
        $this->repo = new RepDispatchMere();
    }

    public function addDispatchMere(DispatchMere $d): int {
        return $this->repo->addDispatchMere($d);
    }

    public function removeDispatchMere(DispatchMere $d): void {
        $this->repo->removeDispatchMere($d);
    }

    public function getDispatchMereById($id) {
        return $this->repo->getDispatchMereById($id);
    }

    public function getAllDispatchMeres() {
        return $this->repo->getAllDispatchMeres();
    }

    public function updateDispatchMere(DispatchMere $d) {
        return $this->repo->updateDispatchMere($d);
    }
    //Methodes supplementaires
    public function getNombreDispatchMeres() {
        $dispatchMeres = $this->getAllDispatchMeres();
        return count($dispatchMeres);
    }
}
?>
