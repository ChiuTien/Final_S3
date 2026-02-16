<?php
namespace app\repository;

use PDO;

class RepRegion
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function addRegion($region) {
        $sql = "INSERT INTO region (valRegion) VALUES (:valRegion)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':valRegion', $region->getValRegion(), PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function removeRegion($region) {
        $sql = "DELETE FROM region WHERE idRegion = :idRegion";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idRegion', $region->getIdRegion(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getRegionById($id) {
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

}
?>
