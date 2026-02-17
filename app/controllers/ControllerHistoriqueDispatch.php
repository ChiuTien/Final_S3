<?php
namespace app\controllers;

use app\repository\RepHistoriqueDispatch;
use app\models\HistoriqueDispatch;

class ControllerHistoriqueDispatch {
    private RepHistoriqueDispatch $repHistoriqueDispatch;

    public function __construct() {
        $this->repHistoriqueDispatch = new RepHistoriqueDispatch();
    }

    public function createHistoriqueDispatch(HistoriqueDispatch $h) {
        return $this->repHistoriqueDispatch->ajouterHistoriqueDispatch($h);
    }

    public function getAllHistoriqueDispatch() {
        return $this->repHistoriqueDispatch->getAllHistoriqueDispatch();
    }

    public function getHistoriqueDispatchById($id) {
        return $this->repHistoriqueDispatch->getHistoriqueDispatchById($id);
    }

    public function updateHistoriqueDispatch(HistoriqueDispatch $h) {
        return $this->repHistoriqueDispatch->modifierHistoriqueDispatch($h);
    }

    public function deleteHistoriqueDispatch($id) {
        return $this->repHistoriqueDispatch->supprimerHistoriqueDispatch($id);
    }
}
