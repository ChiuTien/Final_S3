<?php
namespace app\repository;

use app\models\Statut;
use Flight;
use PDO;

class RepStatut {
    // Attribut
    private PDO $db;

    // Constructeur
    public function __construct() {
        $this->db = Flight::db();
    }

    // Méthodes CRUD

    /**
     * Ajouter un nouveau statut
     */
    public function ajouterStatut(Statut $statut): int {
        try {
            $sql = "INSERT INTO Statut (IdBesoin, IdStatutBesoin, DateDeChangement) 
                    VALUES (:idBesoin, :idStatutBesoin, :dateDeChangement)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idBesoin', $statut->getIdBesoin(), PDO::PARAM_INT);
            $stmt->bindValue(':idStatutBesoin', $statut->getIdStatutBesoin(), PDO::PARAM_INT);
            $stmt->bindValue(':dateDeChangement', $statut->getDateDeChangement()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->execute();
            
            return (int)$this->db->lastInsertId();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Supprimer un statut
     */
    public function supprimerStatut(int $idStatut): void {
        try {
            $sql = "DELETE FROM Statut WHERE IdStatut = :idStatut";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idStatut', $idStatut, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Modifier un statut
     */
    public function modifierStatut(Statut $statut): void {
        try {
            $sql = "UPDATE Statut 
                    SET IdBesoin = :idBesoin, 
                        IdStatutBesoin = :idStatutBesoin, 
                        DateDeChangement = :dateDeChangement 
                    WHERE IdStatut = :idStatut";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idStatut', $statut->getIdStatut(), PDO::PARAM_INT);
            $stmt->bindValue(':idBesoin', $statut->getIdBesoin(), PDO::PARAM_INT);
            $stmt->bindValue(':idStatutBesoin', $statut->getIdStatutBesoin(), PDO::PARAM_INT);
            $stmt->bindValue(':dateDeChangement', $statut->getDateDeChangement()->format('Y-m-d H:i:s'), PDO::PARAM_STR);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Récupérer tous les statuts
     */
    public function getAllStatut(): array {
        $statuts = [];
        
        try {
            $sql = "SELECT * FROM Statut ORDER BY DateDeChangement DESC";
            $stmt = $this->db->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($rows as $row) {
                $statut = new Statut();
                $statut->setIdStatut($row['IdStatut']);
                $statut->setIdBesoin($row['IdBesoin']);
                $statut->setIdStatutBesoin($row['IdStatutBesoin']);
                $statut->setDateDeChangement(new \DateTime($row['DateDeChangement']));
                $statuts[] = $statut;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        
        return $statuts;
    }

    /**
     * Récupérer un statut par son ID
     */
    public function getStatutById(int $idStatut): ?Statut {
        try {
            $sql = "SELECT * FROM Statut WHERE IdStatut = :idStatut";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idStatut', $idStatut, PDO::PARAM_INT);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$row) {
                return null;
            }
            
            $statut = new Statut();
            $statut->setIdStatut($row['IdStatut']);
            $statut->setIdBesoin($row['IdBesoin']);
            $statut->setIdStatutBesoin($row['IdStatutBesoin']);
            $statut->setDateDeChangement(new \DateTime($row['DateDeChangement']));
            
            return $statut;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Récupérer tous les statuts d'un besoin spécifique
     */
    public function getStatutsByBesoin(int $idBesoin): array {
        $statuts = [];
        
        try {
            $sql = "SELECT s.*, sb.ValStatutBesoin 
                    FROM Statut s 
                    JOIN StatutBesoin sb ON s.IdStatutBesoin = sb.IdStatutBesoin 
                    WHERE s.IdBesoin = :idBesoin 
                    ORDER BY s.DateDeChangement DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idBesoin', $idBesoin, PDO::PARAM_INT);
            $stmt->execute();
            
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($rows as $row) {
                $statut = new Statut();
                $statut->setIdStatut($row['IdStatut']);
                $statut->setIdBesoin($row['IdBesoin']);
                $statut->setIdStatutBesoin($row['IdStatutBesoin']);
                $statut->setDateDeChangement(new \DateTime($row['DateDeChangement']));
                $statuts[] = $statut;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        
        return $statuts;
    }

    /**
     * Récupérer le statut actuel d'un besoin (le plus récent)
     */
    public function getStatutActuelBesoin(int $idBesoin): ?Statut {
        try {
            $sql = "SELECT s.*, sb.ValStatutBesoin 
                    FROM Statut s 
                    JOIN StatutBesoin sb ON s.IdStatutBesoin = sb.IdStatutBesoin 
                    WHERE s.IdBesoin = :idBesoin 
                    ORDER BY s.DateDeChangement DESC 
                    LIMIT 1";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idBesoin', $idBesoin, PDO::PARAM_INT);
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if (!$row) {
                return null;
            }
            
            $statut = new Statut();
            $statut->setIdStatut($row['IdStatut']);
            $statut->setIdBesoin($row['IdBesoin']);
            $statut->setIdStatutBesoin($row['IdStatutBesoin']);
            $statut->setDateDeChangement(new \DateTime($row['DateDeChangement']));
            
            return $statut;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
