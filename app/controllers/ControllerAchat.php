<?php
namespace app\controllers;

use app\models\Achat;
use app\repository\RepAchat;

class ControllerAchat {
    private RepAchat $repo;

    public function __construct() {
        $this->repo = new RepAchat();
    }

    public function addAchat(Achat $achat): int {
        return $this->repo->addAchat($achat);
    }

    public function getAchatById($id): ?Achat {
        return $this->repo->getAchatById($id);
    }

    public function getAllAchats($statut = null) {
        return $this->repo->getAllAchats($statut);
    }

    public function updateStatutAchat($idAchat, $statut) {
        $this->repo->updateStatutAchat($idAchat, $statut);
    }

    public function deleteAchat($idAchat) {
        $this->repo->deleteAchat($idAchat);
    }

    public function getAchatsSimulation() {
        return $this->repo->getAllAchats('simulation');
    }

    public function getAchatsValides() {
        return $this->repo->getAllAchats('validé');
    }
}
?>
