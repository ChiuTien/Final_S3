<?php
    namespace app\repository;

    use app\models\Ville;
    use Flight;
    use PDO;

class RepVille
{
    private PDO $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    public function addVille($ville): void {
        $sql = "INSERT INTO Ville (idRegion, valVille) VALUES (:idRegion, :valVille)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idRegion', $ville->getIdRegion(), PDO::PARAM_INT);
        $stmt->bindValue(':valVille', $ville->getValVille(), PDO::PARAM_STR);
        $stmt->execute();
    }

    public function removeVille($ville): void {
        $sql = "DELETE FROM Ville WHERE idVille = :idVille";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idVille', $ville->getIdVille(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getVilleById($id): Ville {
        $sql = "SELECT * FROM Ville WHERE idVille = :idVille";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idVille', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllVilles() {
        $sql = "SELECT * FROM Ville";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getVillesByRegion($regionId) {
        $sql = "SELECT * FROM Ville WHERE idRegion = :idRegion";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idRegion', $regionId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateVille($ville): void {
        $sql = "UPDATE Ville SET idRegion = :idRegion, valVille = :valVille WHERE idVille = :idVille";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idRegion', $ville->getIdRegion(), PDO::PARAM_INT);
        $stmt->bindValue(':valVille', $ville->getValVille(), PDO::PARAM_STR);
        $stmt->bindValue(':idVille', $ville->getIdVille(), PDO::PARAM_INT);
        $stmt->execute();
    }

}
?>
