<?php
namespace app\repository;

use app\models\EquivalenceProduit;
use Flight;
use PDO;

class RepEquivalenceProduit
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Flight::db();
    }

    public function ajouterEquivalenceProduit(EquivalenceProduit $equivalenceProduit): void
    {
        try {
            $sql = "INSERT INTO EquivalenceProduit (idProduit, quantite, prix, val) VALUES (:idProduit, :quantite, :prix, :val)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idProduit', $equivalenceProduit->getIdProduit(), PDO::PARAM_INT);
            $stmt->bindValue(':quantite', $equivalenceProduit->getQuantite(), PDO::PARAM_INT);
            $stmt->bindValue(':prix', $equivalenceProduit->getPrix(), PDO::PARAM_STR);
            $stmt->bindValue(':val', $equivalenceProduit->getVal(), PDO::PARAM_STR);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function supprimerEquivalenceProduit(int $idEquivalenceProduit): void
    {
        try {
            $sql = "DELETE FROM EquivalenceProduit WHERE idEquivalenceProduit = :idEquivalenceProduit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idEquivalenceProduit', $idEquivalenceProduit, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function modifierEquivalenceProduit(EquivalenceProduit $equivalenceProduit): void
    {
        try {
            $sql = "UPDATE EquivalenceProduit SET idProduit = :idProduit, quantite = :quantite, prix = :prix, val = :val WHERE idEquivalenceProduit = :idEquivalenceProduit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idProduit', $equivalenceProduit->getIdProduit(), PDO::PARAM_INT);
            $stmt->bindValue(':quantite', $equivalenceProduit->getQuantite(), PDO::PARAM_INT);
            $stmt->bindValue(':prix', $equivalenceProduit->getPrix(), PDO::PARAM_STR);
            $stmt->bindValue(':val', $equivalenceProduit->getVal(), PDO::PARAM_STR);
            $stmt->bindValue(':idEquivalenceProduit', $equivalenceProduit->getIdEquivalenceProduit(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAllEquivalenceProduit(): array
    {
        $equivalences = [];

        try {
            $sql = "SELECT * FROM EquivalenceProduit";
            $stmt = $this->db->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $equivalence = new EquivalenceProduit();
                $equivalence->setIdEquivalenceProduit($row['idEquivalenceProduit']);
                $equivalence->setIdProduit($row['idProduit']);
                $equivalence->setQuantite($row['quantite']);
                $equivalence->setPrix($row['prix']);
                $equivalence->setVal($row['val']);
                $equivalences[] = $equivalence;
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return $equivalences;
    }

    public function getEquivalenceProduitById(int $idEquivalenceProduit): EquivalenceProduit
    {
        $equivalence = new EquivalenceProduit();

        try {
            $sql = "SELECT * FROM EquivalenceProduit WHERE idEquivalenceProduit = :idEquivalenceProduit";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idEquivalenceProduit', $idEquivalenceProduit, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $equivalence->setIdEquivalenceProduit($row['idEquivalenceProduit']);
                $equivalence->setIdProduit($row['idProduit']);
                $equivalence->setQuantite($row['quantite']);
                $equivalence->setPrix($row['prix']);
                $equivalence->setVal($row['val']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return $equivalence;
    }
}
