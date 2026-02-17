<?php
namespace app\repository;

use app\models\Type;
use Flight;
use PDO;



class RepType
{
    private PDO $db;
    public function __construct()
    {
        $this->db = Flight::db(); // Récupère la connexion PDO depuis Flight
    }

    public function addType($type): void {
        $sql = "INSERT INTO Type (valType) VALUES (:valType)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':valType', $type->getValType(), PDO::PARAM_STR);
        $stmt->execute();
    }

    public function removeType($type): void {
        $sql = "DELETE FROM Type WHERE idType = :idType";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idType', $type->getIdType(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getTypeById($id): ?Type {
        $sql = "SELECT * FROM Type WHERE idType = :idType";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idType', $id, PDO::PARAM_INT);
        $stmt->execute();

        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$data) {
            return null;
        }

        $type = new Type();
        $type->setIdType($data['idType']);
        $type->setValType($data['valType']);
        return $type;
    }

    public function getAllTypes() {
        $sql = "SELECT * FROM Type";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateType($type): void {
        $sql = "UPDATE Type SET valType = :valType WHERE idType = :idType";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':valType', $type->getValType(), PDO::PARAM_STR);
        $stmt->bindValue(':idType', $type->getIdType(), PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>