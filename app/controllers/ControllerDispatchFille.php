<?php
namespace app\controllers;

use app\models\DispatchFille;
use app\repository\RepDispatchFille;
use app\repository\RepStockage;

class ControllerDispatchFille {
    private RepDispatchFille $repo;
    private RepStockage $repStockage;

    public function __construct() {
        $this->repo = new RepDispatchFille();
        $this->repStockage = new RepStockage();
    }

    public function addDispatchFille(DispatchFille $d): void {
        $this->repo->addDispatchFille($d);
        $this->repStockage->decreaseQuantiteByProduitId(
            $d->getIdProduit(),
            (float) $d->getQuantite()
        );
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
