<?php
namespace app\controllers;

use app\models\StatutBesoin;
use app\repository\RepStatutBesoin;

class ControllerStatutBesoin {
    // Attribut
    private RepStatutBesoin $repStatutBesoin;

    // Constructeur
    public function __construct() {
        $this->repStatutBesoin = new RepStatutBesoin();
    }

    // Méthodes CRUD

    /**
     * Créer un nouveau statut de besoin
     */
    public function createStatutBesoin(StatutBesoin $statutBesoin): int {
        return $this->repStatutBesoin->ajouterStatutBesoin($statutBesoin);
    }

    /**
     * Récupérer tous les statuts de besoin
     */
    public function getAllStatutBesoin(): array {
        return $this->repStatutBesoin->getAllStatutBesoin();
    }

    /**
     * Récupérer un statut de besoin par son ID
     */
    public function getStatutBesoinById(int $id): ?StatutBesoin {
        return $this->repStatutBesoin->getStatutBesoinById($id);
    }

    /**
     * Mettre à jour un statut de besoin
     */
    public function updateStatutBesoin(StatutBesoin $statutBesoin): void {
        $this->repStatutBesoin->modifierStatutBesoin($statutBesoin);
    }

    /**
     * Supprimer un statut de besoin
     */
    public function deleteStatutBesoin(int $id): void {
        $this->repStatutBesoin->supprimerStatutBesoin($id);
    }

    /**
     * Récupérer le nombre total de statuts de besoin
     */
    public function getNombreStatutBesoin(): int {
        $statuts = $this->getAllStatutBesoin();
        return count($statuts);
    }
}
