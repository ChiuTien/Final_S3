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
                $sql = "INSERT INTO Besoin (valBesoin, idType, idVille) VALUES (:valBesoin, :idType, :idVille)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':valBesoin', $besoin->getValBesoin(), PDO::PARAM_STR);
                $stmt->bindValue(':idType', $besoin->getIdType(), PDO::PARAM_INT);
                $stmt->bindValue(':idVille', $besoin->getIdVille(), PDO::PARAM_INT);
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
                $sql = "UPDATE Besoin SET valBesoin = :valBesoin, idType = :idType, idVille = :idVille WHERE idBesoin = :idBesoin";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':valBesoin', $besoin->getValBesoin(), PDO::PARAM_STR);
                $stmt->bindValue(':idType', $besoin->getIdType(), PDO::PARAM_INT);
                $stmt->bindValue(':idVille', $besoin->getIdVille(), PDO::PARAM_INT);
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
                    $besoin->setIdBesoin($row['idBesoin']);
                    $besoin->setValBesoin($row['valBesoin'] ?? '');
                    $besoin->setIdType($row['idType'] ?? null);
                    // idVille est optionnel, peut ne pas exister dans la table
                    if (isset($row['idVille'])) {
                        $besoin->setIdVille($row['idVille']);
                    }
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
                $besoin->setIdBesoin($row['idBesoin']);
                $besoin->setValBesoin($row['valBesoin']);
                $besoin->setIdType($row['idType']);
                $besoin->setIdVille($row['idVille']);
                return $besoin;
            } catch(\Throwable $th) {
                throw $th;
            }
        }
    }
?>