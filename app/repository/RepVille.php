<?php
namespace app\repository;

use PDO;

class RepVille
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function addVille($ville) {
        $sql = "INSERT INTO ville (idRegion, valVille) VALUES (:idRegion, :valVille)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idRegion', $ville->getIdRegion(), PDO::PARAM_INT);
        $stmt->bindValue(':valVille', $ville->getValVille(), PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function removeVille($ville) {
        $sql = "DELETE FROM ville WHERE idVille = :idVille";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idVille', $ville->getIdVille(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getVilleById($id) {
        $sql = "SELECT * FROM ville WHERE idVille = :idVille";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idVille', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllVilles() {
        $sql = "SELECT * FROM ville";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVillesByRegion($regionId) {
        $sql = "SELECT * FROM ville WHERE idRegion = :idRegion";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idRegion', $regionId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>
