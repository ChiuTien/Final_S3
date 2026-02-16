<?php 
    namespace app\Repository;

    use app\models\Besoin;
    use Flight;
    use PDO;

    class RepBesoin {
    //Attributs
        private PDO $db;
    //Constructeur
        public function __construct() {
            $this->db = Flight::db();
        }
    //Methodes
        public function ajouterBesoin(Besoin $besoin) :void {
            try {
                $sql = "INSERT INTO Besoin (valBesoin, idType) VALUES (:valBesoin, :idType)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':valBesoin', $besoin->getValBesoin(), PDO::PARAM_STR);
                $stmt->bindValue(':idType', $besoin->getIdType(), PDO::PARAM_INT);
                $stmt->execute();
            } catch(\Throwable $th) {
                throw $th;
            }
        }
        public function supprimerBesoin($idBesoin) :void {
            try {
                $sql = "DELETE FROM Besoin WHERE idBesoin = :idBesoin";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':idBesoin', $idBesoin, PDO::PARAM_INT);
                $stmt->execute();
            } catch(\Throwable $th) {
                throw $th;
            }
        }
        public function modifierBesoin(Besoin $besoin) :void {
            try {
                $sql = "UPDATE Besoin SET valBesoin = :valBesoin, idType = :idType WHERE idBesoin = :idBesoin";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':valBesoin', $besoin->getValBesoin(), PDO::PARAM_STR);
                $stmt->bindValue(':idType', $besoin->getIdType(), PDO::PARAM_INT);
                $stmt->bindValue(':idBesoin', $besoin->getIdBesoin(), PDO::PARAM_INT);
                $stmt->execute();
            } catch(\Throwable $th) {
                throw $th;
            }
        }
        public function getAllBesoin() :array {
            try {
                $sql = "SELECT * FROM Besoin";
                $stmt = $this->db->query($sql);
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                return $result;
            } catch(\Throwable $th) {
                throw $th;
            }
        }
        public function getBesoinById($idBesoin) :Besoin {
            try {
                $sql = "SELECT * FROM Besoin WHERE idBesoin = :idBesoin";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':idBesoin', $idBesoin, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                return $result;
            } catch(\Throwable $th) {
                throw $th;
            }
        }
    }
?>