<?php
namespace app\repository;

use PDO;



class RepType
{
    private PDO $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function addType($type) {
        $sql = "INSERT INTO type (valType) VALUES (:valType)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':valType', $type->getValType(), PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function removeType($type) {
        $sql = "DELETE FROM type WHERE idType = :idType";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idType', $type->getIdType(), PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getTypeById($id) {
        $sql = "SELECT * FROM type WHERE idType = :idType";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idType', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllTypes() {
        $sql = "SELECT * FROM type";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>