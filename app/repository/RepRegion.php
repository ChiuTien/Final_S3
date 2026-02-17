<?php
namespace app\repository;

use app\models\Region;
use Flight;
use PDO;

class RepRegion
{
    private PDO $db;
    public function __construct()
    {
        $this->db = Flight::db();
    }

    public function addRegion($region): void {
        $sql = "INSERT INTO Region (valRegion) VALUES (:valRegion)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':valRegion', $region->getValRegion(), PDO::PARAM_STR);
        $stmt->execute();
    }

    public function removeRegion($region): void {
        $sql = "DELETE FROM Region WHERE idRegion = :idRegion";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idRegion', $region->getIdRegion(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getRegionById($id): Region {
        $sql = "SELECT * FROM Region WHERE idRegion = :idRegion";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idRegion', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllRegions() {
        $sql = "SELECT * FROM Region";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateRegion($region): void {
        $sql = "UPDATE Region SET valRegion = :valRegion WHERE idRegion = :idRegion";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':valRegion', $region->getValRegion(), PDO::PARAM_STR);
        $stmt->bindValue(':idRegion', $region->getIdRegion(), PDO::PARAM_INT);
        $stmt->execute();
    }

}
?>
