<?php
namespace app\controllers;

use app\models\Statut;
use app\repository\RepStatut;

class ControllerStatut {
    // Attribut
    private RepStatut $repStatut;

    // Constructeur
    public function __construct() {
        $this->repStatut = new RepStatut();
    }

    // Méthodes CRUD

    /**
     * Créer un nouveau statut
     */
    public function createStatut(Statut $statut): int {
        return $this->repStatut->ajouterStatut($statut);
    }

    /**
     * Récupérer tous les statuts
     */
    public function getAllStatut(): array {
        return $this->repStatut->getAllStatut();
    }

    /**
     * Récupérer un statut par son ID
     */
    public function getStatutById(int $id): ?Statut {
        return $this->repStatut->getStatutById($id);
    }

    /**
     * Mettre à jour un statut
     */
    public function updateStatut(Statut $statut): void {
        $this->repStatut->modifierStatut($statut);
    }

    /**
     * Supprimer un statut
     */
    public function deleteStatut(int $id): void {
        $this->repStatut->supprimerStatut($id);
    }

    /**
     * Récupérer tous les statuts d'un besoin spécifique
     */
    public function getStatutsByBesoin(int $idBesoin): array {
        return $this->repStatut->getStatutsByBesoin($idBesoin);
    }

    /**
     * Récupérer le statut actuel d'un besoin
     */
    public function getStatutActuelBesoin(int $idBesoin): ?Statut {
        return $this->repStatut->getStatutActuelBesoin($idBesoin);
    }

    /**
     * Changer le statut d'un besoin (crée un nouvel enregistrement)
     */
    public function changerStatutBesoin(int $idBesoin, int $idStatutBesoin): int {
        $statut = new Statut(null, $idBesoin, $idStatutBesoin, new \DateTime());
        return $this->createStatut($statut);
    }

    /**
     * Récupérer le nombre total de statuts
     */
    public function getNombreStatut(): int {
        $statuts = $this->getAllStatut();
        return count($statuts);
    }

    /**
     * Récupérer l'historique des changements de statut pour un besoin
     */
    public function getHistoriqueStatutBesoin(int $idBesoin): array {
        return $this->getStatutsByBesoin($idBesoin);
    }
}
