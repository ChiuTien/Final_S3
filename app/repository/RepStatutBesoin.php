<?php
namespace app\repository;

use app\models\StatutBesoin;
use Flight;
use PDO;

class RepStatutBesoin {
    // Attribut
    private PDO $db;

    // Constructeur
    public function __construct() {
        $this->db = Flight::db();
    }

    // Méthodes CRUD

    /**
     * Ajouter un nouveau statut de besoin
     */
    public function ajouterStatutBesoin(StatutBesoin $statutBesoin): int {
        try {
            $sql = "INSERT INTO StatutBesoin (ValStatutBesoin) VALUES (:valStatutBesoin)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':valStatutBesoin', $statutBesoin->getValStatutBesoin(), PDO::PARAM_STR);
            $stmt->execute();
            
            return (int)$this->db->lastInsertId();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Supprimer un statut de besoin
     */
    public function supprimerStatutBesoin(int $idStatutBesoin): void {
        try {
            $sql = "DELETE FROM StatutBesoin WHERE IdStatutBesoin = :idStatutBesoin";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idStatutBesoin', $idStatutBesoin, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Modifier un statut de besoin
     */
    public function modifierStatutBesoin(StatutBesoin $statutBesoin): void {
        try {
            $sql = "UPDATE StatutBesoin 
                    SET ValStatutBesoin = :valStatutBesoin 
                    WHERE IdStatutBesoin = :idStatutBesoin";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idStatutBesoin', $statutBesoin->getIdStatutBesoin(), PDO::PARAM_INT);
            $stmt->bindValue(':valStatutBesoin', $statutBesoin->getValStatutBesoin(), PDO::PARAM_STR);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Récupérer tous les statuts de besoin
     */
    public function getAllStatutBesoin(): array {
        $statutsBesoins = [];
        
        try {
            $sql = "SELECT * FROM StatutBesoin ORDER BY IdStatutBesoin";
            $stmt = $this->db->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($rows as $row) {
                $statutBesoin = new StatutBesoin();
                $statutBesoin->setIdStatutBesoin($row['IdStatutBesoin']);
                $statutBesoin->setValStatutBesoin($row['ValStatutBesoin']);
                $statutsBesoins[] = $statutBesoin;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        
        return $statutsBesoins;
    }

    /**
     * Récupérer un statut de besoin par son ID
     */
    public function getStatutBesoinById(int $idStatutBesoin): ?StatutBesoin {
        try {
            $sql = "SELECT * FROM StatutBesoin WHERE IdStatutBesoin = :idStatutBesoin";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idStatutBesoin', $idStatutBesoin, PDO::PARAM_INT);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$row) {
                return null;
            }
            
            $statutBesoin = new StatutBesoin();
            $statutBesoin->setIdStatutBesoin($row['IdStatutBesoin']);
            $statutBesoin->setValStatutBesoin($row['ValStatutBesoin']);
            
            return $statutBesoin;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
