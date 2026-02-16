<?php 
namespace app\repository;
use app\models\Donnation;
use Flight;
use PDO;
class RepDonnation{
    //Attribut 
    private PDO $db;
    //Constructeur
    public function __construct(){
        $this->db = Flight::db();
    }
    //Methodes 
    public function addDonnation(Donnation $donnation): void {
        try {
            $idDon = $donnation->getIdDon();
            $idProduit = $donnation->getIdProduit();
            $quantiteProduit = $donnation->getQuantiteProduit();
            $sql = "INSERT INTO Donnation(idDon, idProduit, quantiteProduit) VALUES (:idDon, :idProduit, :quantiteProduit)";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idDon', $idDon, PDO::PARAM_INT);
            $stmt->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $stmt->bindValue(':quantiteProduit', $quantiteProduit, PDO::PARAM_STR);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function deleteDonnation(int $idDonnation): void {
        try {
            $sql = "DELETE FROM Donnation WHERE idDonnation = :idDonnation";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idDonnation', $idDonnation, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function updateDon(Donnation $donnation): void {
        try {
            $idDonnation = $donnation->getIdDonnation();
            $idDon = $donnation->getIdDon();
            $idProduit = $donnation->getIdProduit();
            $quantiteProduit = $donnation->getQuantiteProduit();
            $sql = "UPDATE Donnation SET idDon = :idDon, idProduit = :idProduit, quantiteProduit = :quantiteProduit WHERE idDonnation = :idDonnation";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idDonnation', $idDonnation, PDO::PARAM_INT);
            $stmt->bindValue(':idDon', $idDon, PDO::PARAM_INT);
            $stmt->bindValue(':idProduit', $idProduit, PDO::PARAM_INT);
            $stmt->bindValue(':quantiteProduit', $quantiteProduit, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\Throwable $th) {
            throw $th;
        }
    }
    public function getDonnationById(int $idDonnation): Donnation {
        $donnation = new Donnation();
        try {
            $sql = "SELECT * FROM Donnation WHERE idDonnation = :idDonnation";
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':idDonnation', $idDonnation, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $donnation->setIdDonnation($result['idDonnation']);
                $donnation->setIdDon($result['idDon']);
                $donnation->setIdProduit($result['idProduit']);
                $donnation->setQuantiteProduit($result['quantiteProduit']);
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        return $donnation;
    }
    public function getAllDonnation() : array{
        $donnations = [];
        try {
            $sql = "SELECT * FROM Donnation";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($results as $result) {
                $donnation = new Donnation();
                $donnation->setIdDonnation($result['idDonnation']);
                $donnation->setIdDon($result['idDon']);
                $donnation->setIdProduit($result['idProduit']);
                $donnation->setQuantiteProduit($result['quantiteProduit']);
                $donnations[] = $donnation;
            }
        } catch (\Throwable $th) {
            throw $th;
        }
        return $donnations;
    }
}