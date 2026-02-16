<?php
namespace app\repository;

use app\models\Produit;
use Flight;
use PDO;

class RepProduit
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Flight::db();
    }

    public function ajouterProduit(Produit $produit): void
    {
        try {
            $sql = "INSERT INTO Produit (valProduit, idType) VALUES (:valProduit, :idType)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':valProduit', $produit->getValProduit(), PDO::PARAM_STR);
            $stmt->bindValue(':idType', $produit->getIdType(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function supprimerProduit(int $idProduit): void
    {
        try {
            $sql = "DELETE FROM Produit WHERE idProduit = :idProduit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function modifierProduit(Produit $produit): void
    {
        try {
            $sql = "UPDATE Produit SET valProduit = :valProduit, idType = :idType WHERE idProduit = :idProduit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':valProduit', $produit->getValProduit(), PDO::PARAM_STR);
            $stmt->bindValue(':idType', $produit->getIdType(), PDO::PARAM_INT);
            $stmt->bindValue(':idProduit', $produit->getIdProduit(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAllProduit(): array
    {
        $produits = [];

        try {
            $sql = "SELECT * FROM Produit";
            $stmt = $this->db->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $produit = new Produit();
                $produit->setIdProduit($row['idProduit']);
                $produit->setValProduit($row['valProduit']);
                $produit->setIdType($row['idType']);
                $produits[] = $produit;
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return $produits;
    }

    public function getProduitById(int $idProduit): Produit
    {
        $produit = new Produit();

        try {
            $sql = "SELECT * FROM Produit WHERE idProduit = :idProduit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $produit->setIdProduit($row['idProduit']);
                $produit->setValProduit($row['valProduit']);
                $produit->setIdType($row['idType']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return $produit;
    }
}
