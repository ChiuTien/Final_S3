<?php
namespace app\repository;

use app\models\Region;
use PDO;

class RepRegion
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function addRegion($region): void {
        $sql = "INSERT INTO region (valRegion) VALUES (:valRegion)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':valRegion', $region->getValRegion(), PDO::PARAM_STR);
        $stmt->execute();
    }

    public function removeRegion($region): void {
        $sql = "DELETE FROM region WHERE idRegion = :idRegion";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idRegion', $region->getIdRegion(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getRegionById($id): Region {
        $sql = "SELECT * FROM region WHERE idRegion = :idRegion";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idRegion', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllRegions() {
        $sql = "SELECT * FROM region";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateRegion($region): void {
        $sql = "UPDATE region SET valRegion = :valRegion WHERE idRegion = :idRegion";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':valRegion', $region->getValRegion(), PDO::PARAM_STR);
        $stmt->bindValue(':idRegion', $region->getIdRegion(), PDO::PARAM_INT);
        $stmt->execute();
    }

}
?>
