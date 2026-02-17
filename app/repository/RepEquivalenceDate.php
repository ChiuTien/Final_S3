<?php
namespace app\repository;

use app\models\EquivalenceDate;
use Flight;
use PDO;

class RepEquivalenceDate
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Flight::db();
    }

    public function ajouterEquivalenceDate(EquivalenceDate $equivalenceDate): void
    {
        try {
            $sql = "INSERT INTO Equivalence_date (id_besoin, date_equivalence) VALUES (:id_besoin, :date_equivalence)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id_besoin', $equivalenceDate->getIdBesoin(), PDO::PARAM_INT);
            $stmt->bindValue(':date_equivalence', $equivalenceDate->getDateEquivalence(), PDO::PARAM_STR);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function supprimerEquivalenceDate(int $idEquivalence): void
    {
        try {
            $sql = "DELETE FROM Equivalence_date WHERE idEquivalence = :idEquivalence";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idEquivalence', $idEquivalence, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function modifierEquivalenceDate(EquivalenceDate $equivalenceDate): void
    {
        try {
            $sql = "UPDATE Equivalence_date SET id_besoin = :id_besoin, date_equivalence = :date_equivalence WHERE idEquivalence = :idEquivalence";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':id_besoin', $equivalenceDate->getIdBesoin(), PDO::PARAM_INT);
            $stmt->bindValue(':date_equivalence', $equivalenceDate->getDateEquivalence(), PDO::PARAM_STR);
            $stmt->bindValue(':idEquivalence', $equivalenceDate->getIdEquivalence(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAllEquivalenceDate(): array
    {
        $equivalences = [];

        try {
            $sql = "SELECT * FROM Equivalence_date";
            $stmt = $this->db->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $equivalence = new EquivalenceDate();
                $equivalence->setIdEquivalence($row['idEquivalence']);
                $equivalence->setIdBesoin($row['id_besoin']);
                $equivalence->setDateEquivalence($row['date_equivalence']);
                $equivalences[] = $equivalence;
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return $equivalences;
    }

    public function getEquivalenceDateById(int $idEquivalence): EquivalenceDate
    {
        $equivalence = new EquivalenceDate();

        try {
            $sql = "SELECT * FROM Equivalence_date WHERE idEquivalence = :idEquivalence";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idEquivalence', $idEquivalence, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $equivalence->setIdEquivalence($row['idEquivalence']);
                $equivalence->setIdBesoin($row['id_besoin']);
                $equivalence->setDateEquivalence($row['date_equivalence']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }

        return $equivalence;
    }
}
