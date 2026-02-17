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
        public function ajouterBesoin(Besoin $besoin) :int {
            try {
                $sql = "INSERT INTO Besoin (valBesoin, idType, idVille, dateBesoin) VALUES (:valBesoin, :idType, :idVille, :dateBesoin)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':valBesoin', $besoin->getValBesoin(), PDO::PARAM_STR);
                $stmt->bindValue(':idType', $besoin->getIdType(), PDO::PARAM_INT);
                $stmt->bindValue(':idVille', $besoin->getIdVille(), PDO::PARAM_INT);
                $stmt->bindValue(':dateBesoin', $besoin->getDateBesoin(), PDO::PARAM_STR);
                $stmt->execute();
                return (int) $this->db->lastInsertId();
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
                $sql = "UPDATE Besoin SET valBesoin = :valBesoin, idType = :idType, idVille = :idVille, dateBesoin = :dateBesoin WHERE idBesoin = :idBesoin";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':valBesoin', $besoin->getValBesoin(), PDO::PARAM_STR);
                $stmt->bindValue(':idType', $besoin->getIdType(), PDO::PARAM_INT);
                $stmt->bindValue(':idVille', $besoin->getIdVille(), PDO::PARAM_INT);
                $stmt->bindValue(':dateBesoin', $besoin->getDateBesoin(), PDO::PARAM_STR);
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
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $besoins = [];
                foreach ($rows as $row) {
                    $besoin = new Besoin();
                    $besoin->setIdBesoin($row['idBesoin'] ?? $row['id_besoin'] ?? null);
                    $besoin->setValBesoin($row['valBesoin'] ?? $row['val_besoin'] ?? '');
                    $besoin->setIdType($row['idType'] ?? $row['id_type'] ?? null);
                    $besoin->setIdVille($row['idVille'] ?? $row['id_ville'] ?? null);
                    $besoin->setDateBesoin($row['dateBesoin'] ?? $row['date_besoin'] ?? null);
                    $besoins[] = $besoin;
                }
                return $besoins;
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
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if (!$row) {
                    throw new \Exception("Besoin non trouvé");
                }
                $besoin = new Besoin();
                $besoin->setIdBesoin($row['idBesoin'] ?? $row['id_besoin'] ?? null);
                $besoin->setValBesoin($row['valBesoin'] ?? $row['val_besoin'] ?? '');
                $besoin->setIdType($row['idType'] ?? $row['id_type'] ?? null);
                $besoin->setIdVille($row['idVille'] ?? $row['id_ville'] ?? null);
                $besoin->setDateBesoin($row['dateBesoin'] ?? $row['date_besoin'] ?? null);
                return $besoin;
            } catch(\Throwable $th) {
                throw $th;
            }
        }
    }
?>