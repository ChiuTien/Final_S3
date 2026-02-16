<?php
namespace app\controllers;

use app\models\DispatchFille;
use app\repository\RepDispatchFille;

class ControllerDispatchFille {
    private RepDispatchFille $repo;

    public function __construct() {
        $this->repo = new RepDispatchFille();
    }

    public function addDispatchFille(DispatchFille $d): void {
        $this->repo->addDispatchFille($d);
    }

    public function removeDispatchFille(DispatchFille $d): void {
        $this->repo->removeDispatchFille($d);
    }

    public function getDispatchFilleById($id) {
        return $this->repo->getDispatchFilleById($id);
    }

    public function getAllDispatchFilles() {
        return $this->repo->getAllDispatchFilles();
    }

    public function getFillesByMere($mereId) {
        return $this->repo->getFillesByMere($mereId);
    }

    public function updateDispatchFille(DispatchFille $d) {
        return $this->repo->updateDispatchFille($d);
    }
}
?>
