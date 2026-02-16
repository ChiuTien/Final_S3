<?php
namespace app\repository;


use PDO;
use app\models\DispatchFille;

class RepDispatchFille
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function addDispatchFille($dispatch): void {
        $sql = "INSERT INTO dispatch_fille (id_dispatch_mere, id_produit, quantite) VALUES (:id_dispatch_mere, :id_produit, :quantite)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_dispatch_mere', $dispatch->getIdDispatchMere(), PDO::PARAM_INT);
        $stmt->bindValue(':id_produit', $dispatch->getIdProduit(), PDO::PARAM_INT);
        $stmt->bindValue(':quantite', $dispatch->getQuantite(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function removeDispatchFille($dispatch): void {
        $sql = "DELETE FROM dispatch_fille WHERE id_dispatch_fille = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $dispatch->getIdDispatchFille(), PDO::PARAM_INT);
        $stmt->execute();
    }

    public function getDispatchFilleById($id): DispatchFille {
        $sql = "SELECT * FROM dispatch_fille WHERE id_dispatch_fille = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllDispatchFilles() {
        $sql = "SELECT * FROM dispatch_fille";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFillesByMere($mereId) {
        $sql = "SELECT * FROM dispatch_fille WHERE id_dispatch_mere = :id_dispatch_mere";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_dispatch_mere', $mereId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateDispatchFille($dispatch): void {
        $sql = "UPDATE dispatch_fille SET id_dispatch_mere = :id_dispatch_mere, id_produit = :id_produit, quantite = :quantite WHERE id_dispatch_fille = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id_dispatch_mere', $dispatch->getIdDispatchMere(), PDO::PARAM_INT);
        $stmt->bindValue(':id_produit', $dispatch->getIdProduit(), PDO::PARAM_INT);
        $stmt->bindValue(':quantite', $dispatch->getQuantite(), PDO::PARAM_INT);
        $stmt->bindValue(':id', $dispatch->getIdDispatchFille(), PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>
