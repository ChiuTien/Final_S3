<?php
namespace app\repository;

use app\models\TypeDispatch;
use Flight;
use PDO;

class RepTypeDispatch {
    private PDO $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    public function ajouterTypeDispatch(TypeDispatch $t): void {
        try {
            $sql = "INSERT INTO TypeDispatch (valTypeDispatch) VALUES (:valTypeDispatch)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':valTypeDispatch', $t->getValTypeDispatch(), PDO::PARAM_STR);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function supprimerTypeDispatch(int $idTypeDispatch): void {
        try {
            $sql = "DELETE FROM TypeDispatch WHERE idTypeDispatch = :idTypeDispatch";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idTypeDispatch', $idTypeDispatch, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function modifierTypeDispatch(TypeDispatch $t): void {
        try {
            $sql = "UPDATE TypeDispatch SET valTypeDispatch = :valTypeDispatch WHERE idTypeDispatch = :idTypeDispatch";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':valTypeDispatch', $t->getValTypeDispatch(), PDO::PARAM_STR);
            $stmt->bindValue(':idTypeDispatch', $t->getIdTypeDispatch(), PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function getAllTypeDispatch(): array {
        $items = [];
        try {
            $sql = "SELECT * FROM TypeDispatch";
            $stmt = $this->db->query($sql);
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $t = new TypeDispatch();
                $t->setIdTypeDispatch($row['idTypeDispatch']);
                $t->setValTypeDispatch($row['valTypeDispatch']);
                $items[] = $t;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        return $items;
    }

    public function getTypeDispatchById(int $idTypeDispatch): TypeDispatch {
        $t = new TypeDispatch();
        try {
            $sql = "SELECT * FROM TypeDispatch WHERE idTypeDispatch = :idTypeDispatch";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idTypeDispatch', $idTypeDispatch, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row) {
                $t->setIdTypeDispatch($row['idTypeDispatch']);
                $t->setValTypeDispatch($row['valTypeDispatch']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        return $t;
    }
}
