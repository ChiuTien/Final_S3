<?php
namespace app\repository;

use app\models\Achat;
use Flight;
use PDO;

class RepAchat {
    private PDO $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    public function addAchat(Achat $achat): int {
        $sql = "INSERT INTO Achat (idBesoin, idProduit, quantiteAchetee, prixUnitaire, montantTotal, montantFrais, montantAvecFrais, statut) 
                VALUES (:idBesoin, :idProduit, :quantiteAchetee, :prixUnitaire, :montantTotal, :montantFrais, :montantAvecFrais, :statut)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idBesoin', $achat->getIdBesoin(), PDO::PARAM_INT);
        $stmt->bindValue(':idProduit', $achat->getIdProduit(), PDO::PARAM_INT);
        $stmt->bindValue(':quantiteAchetee', $achat->getQuantiteAchetee(), PDO::PARAM_STR);
        $stmt->bindValue(':prixUnitaire', $achat->getPrixUnitaire(), PDO::PARAM_STR);
        $stmt->bindValue(':montantTotal', $achat->getMontantTotal(), PDO::PARAM_STR);
        $stmt->bindValue(':montantFrais', $achat->getMontantFrais(), PDO::PARAM_STR);
        $stmt->bindValue(':montantAvecFrais', $achat->getMontantAvecFrais(), PDO::PARAM_STR);
        $stmt->bindValue(':statut', $achat->getStatut(), PDO::PARAM_STR);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function getAchatById($id): ?Achat {
        $sql = "SELECT * FROM Achat WHERE idAchat = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$data) return null;
        
        $achat = new Achat();
        $achat->setIdAchat($data['idAchat']);
        $achat->setIdBesoin($data['idBesoin']);
        $achat->setIdProduit($data['idProduit']);
        $achat->setQuantiteAchetee($data['quantiteAchetee']);
        $achat->setPrixUnitaire($data['prixUnitaire']);
        $achat->setMontantTotal($data['montantTotal']);
        $achat->setMontantFrais($data['montantFrais']);
        $achat->setMontantAvecFrais($data['montantAvecFrais']);
        $achat->setDateAchat($data['dateAchat']);
        $achat->setStatut($data['statut']);
        return $achat;
    }

    public function getAllAchats($statut = null) {
        if ($statut) {
            $sql = "SELECT * FROM Achat WHERE statut = :statut ORDER BY dateAchat DESC";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':statut', $statut, PDO::PARAM_STR);
        } else {
            $sql = "SELECT * FROM Achat ORDER BY dateAchat DESC";
            $stmt = $this->db->prepare($sql);
        }
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $achats = [];
        foreach ($data as $row) {
            $achat = new Achat();
            $achat->setIdAchat($row['idAchat']);
            $achat->setIdBesoin($row['idBesoin']);
            $achat->setIdProduit($row['idProduit']);
            $achat->setQuantiteAchetee($row['quantiteAchetee']);
            $achat->setPrixUnitaire($row['prixUnitaire']);
            $achat->setMontantTotal($row['montantTotal']);
            $achat->setMontantFrais($row['montantFrais']);
            $achat->setMontantAvecFrais($row['montantAvecFrais']);
            $achat->setDateAchat($row['dateAchat']);
            $achat->setStatut($row['statut']);
            $achats[] = $achat;
        }
        return $achats;
    }

    public function updateStatutAchat($idAchat, $statut) {
        $sql = "UPDATE Achat SET statut = :statut WHERE idAchat = :idAchat";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':statut', $statut, PDO::PARAM_STR);
        $stmt->bindValue(':idAchat', $idAchat, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deleteAchat($idAchat) {
        $sql = "DELETE FROM Achat WHERE idAchat = :idAchat";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':idAchat', $idAchat, PDO::PARAM_INT);
        $stmt->execute();
    }
}
?>
