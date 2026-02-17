<?php
namespace app\repository;

use app\models\Stockage;
use Flight;
use PDO;

class RepStockage
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Flight::db();
    }

    public function ajouterStockage(Stockage $stockage): void
    {
        try {
            $sql = "INSERT INTO Stockage (idProduit, quantite) VALUES (:idProduit, :quantite)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idProduit', $stockage->getIdProduit(), PDO::PARAM_INT);
            $stmt->bindValue(':quantite', $stockage->getQuantite(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function supprimerStockage(int $idStockage): void
    {
        try {
            $sql = "DELETE FROM Stockage WHERE idStockage = :idStockage";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idStockage', $idStockage, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function modifierStockage(Stockage $stockage): void
    {
        try {
            $sql = "UPDATE Stockage SET idProduit = :idProduit, quantite = :quantite WHERE idStockage = :idStockage";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idProduit', $stockage->getIdProduit(), PDO::PARAM_INT);
            $stmt->bindValue(':quantite', $stockage->getQuantite(), PDO::PARAM_INT);
            $stmt->bindValue(':idStockage', $stockage->getIdStockage(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAllStockage(): array
    {
        try {
            $sql = "SELECT * FROM Stockage";
            $stmt = $this->db->query($sql);
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $stockages = [];
            foreach ($rows as $row) {
                $stockage = new Stockage();
                $stockage->setIdStockage($row['idStockage']);
                $stockage->setIdProduit($row['idProduit']);
                $stockage->setQuantite($row['quantite']);
                $stockages[] = $stockage;
            }
            return $stockages;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getStockageById(int $idStockage): Stockage
    {
        try {
            $sql = "SELECT * FROM Stockage WHERE idStockage = :idStockage";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idStockage', $idStockage, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                throw new \Exception('Stockage non trouve');
            }
            $stockage = new Stockage();
            $stockage->setIdStockage($row['idStockage']);
            $stockage->setIdProduit($row['idProduit']);
            $stockage->setQuantite($row['quantite']);
            return $stockage;
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getQuantiteByProduitId(int $idProduit): int
    {
        try {
            $sql = "SELECT quantite FROM Stockage WHERE idProduit = :idProduit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) {
                throw new \Exception('Stockage non trouve pour ce produit');
            }
            return (int) $row['quantite'];
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function updateQuantiteByProduitId(int $idProduit, int $quantite): void
    {
        try {
            $sql = "UPDATE Stockage SET quantite = :quantite WHERE idProduit = :idProduit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':quantite', $quantite, PDO::PARAM_INT);
            $stmt->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
