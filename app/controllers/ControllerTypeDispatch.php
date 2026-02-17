<?php
namespace app\controllers;

use app\repository\RepTypeDispatch;
use app\models\TypeDispatch;

class ControllerTypeDispatch {
    private RepTypeDispatch $repTypeDispatch;

    public function __construct() {
        $this->repTypeDispatch = new RepTypeDispatch();
    }

    public function createTypeDispatch(TypeDispatch $t) {
        return $this->repTypeDispatch->ajouterTypeDispatch($t);
    }

    public function getAllTypeDispatch() {
        return $this->repTypeDispatch->getAllTypeDispatch();
    }

    public function getTypeDispatchById($id) {
        return $this->repTypeDispatch->getTypeDispatchById($id);
    }

    public function updateTypeDispatch(TypeDispatch $t) {
        return $this->repTypeDispatch->modifierTypeDispatch($t);
    }

    public function deleteTypeDispatch($id) {
        return $this->repTypeDispatch->supprimerTypeDispatch($id);
    }
}
