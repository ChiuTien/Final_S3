<?php
namespace app\repository;

use app\models\DispatchMere;
use Flight;
use PDO;

class RepDispatchMere
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Flight::db();
    }

    public function addDispatchMere($dispatch): void {
        $sql = "INSERT INTO Dispatch_mere (id_ville, date_dispatch) VALUES (:id_ville, :date_dispatch)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_ville', $dispatch->getIdVille(), PDO::PARAM_INT);
        $stmt->bindValue(':date_dispatch', $dispatch->getDateDispatch(), PDO::PARAM_STR);
        $stmt->execute();
    }

    public function removeDispatchMere($dispatch): void {
        $sql = "DELETE FROM Dispatch_mere WHERE id_dispatch_mere = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $dispatch->getIdDispatchMere(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getDispatchMereById($id): DispatchMere {
        $sql = "SELECT * FROM Dispatch_mere WHERE id_dispatch_mere = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllDispatchMeres() {
        $sql = "SELECT * FROM Dispatch_mere";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateDispatchMere($dispatch): void {
        $sql = "UPDATE Dispatch_mere SET id_ville = :id_ville, date_dispatch = :date_dispatch WHERE id_dispatch_mere = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_ville', $dispatch->getIdVille(), PDO::PARAM_INT);
        $stmt->bindValue(':date_dispatch', $dispatch->getDateDispatch(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $dispatch->getIdDispatchMere(), PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>
