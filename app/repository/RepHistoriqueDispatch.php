<?php
namespace app\repository;

use app\models\HistoriqueDispatch;
use Flight;
use PDO;

class RepHistoriqueDispatch {
    private PDO $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    public function ajouterHistoriqueDispatch(HistoriqueDispatch $h): void {
        try {
            $sql = "INSERT INTO Historique_dispatch (idVille, idBesoin, date_change, status) VALUES (:idVille, :idBesoin, :date_change, :status)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idVille', $h->getIdVille(), PDO::PARAM_INT);
            $stmt->bindValue(':idBesoin', $h->getIdBesoin(), PDO::PARAM_INT);
            $stmt->bindValue(':date_change', $h->getDateChange(), PDO::PARAM_STR);
            $stmt->bindValue(':status', $h->getStatus(), PDO::PARAM_STR);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function supprimerHistoriqueDispatch(int $idHistorique): void {
        try {
            $sql = "DELETE FROM Historique_dispatch WHERE idHistorique = :idHistorique";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idHistorique', $idHistorique, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function modifierHistoriqueDispatch(HistoriqueDispatch $h): void {
        try {
            $sql = "UPDATE Historique_dispatch SET idVille = :idVille, idBesoin = :idBesoin, date_change = :date_change, status = :status WHERE idHistorique = :idHistorique";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idVille', $h->getIdVille(), PDO::PARAM_INT);
            $stmt->bindValue(':idBesoin', $h->getIdBesoin(), PDO::PARAM_INT);
            $stmt->bindValue(':date_change', $h->getDateChange(), PDO::PARAM_STR);
            $stmt->bindValue(':status', $h->getStatus(), PDO::PARAM_STR);
            $stmt->bindValue(':idHistorique', $h->getIdHistorique(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAllHistoriqueDispatch(): array {
        $items = [];
        try {
            $sql = "SELECT * FROM Historique_dispatch";
            $stmt = $this->db->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $h = new HistoriqueDispatch();
                $h->setIdHistorique($row['idHistorique']);
                $h->setIdVille($row['idVille']);
                $h->setIdBesoin($row['idBesoin']);
                $h->setDateChange($row['date_change']);
                $h->setStatus($row['status']);
                $items[] = $h;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        return $items;
    }

    public function getHistoriqueDispatchById(int $idHistorique): HistoriqueDispatch {
        $h = new HistoriqueDispatch();
        try {
            $sql = "SELECT * FROM Historique_dispatch WHERE idHistorique = :idHistorique";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idHistorique', $idHistorique, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $h->setIdHistorique($row['idHistorique']);
                $h->setIdVille($row['idVille']);
                $h->setIdBesoin($row['idBesoin']);
                $h->setDateChange($row['date_change']);
                $h->setStatus($row['status']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        return $h;
    }
}
