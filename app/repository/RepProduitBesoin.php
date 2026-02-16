<?php
    namespace app\repository;

    use app\models\ProduitBesoin;
    use Flight;
    use PDO;

    class RepProduitBesoin {
    //Attribut
        private PDO $db;
    //Constructeur
        public function __construct() {
            $this->db = Flight::db();
        }

        public function ajouterProduitBesoin(ProduitBesoin $produitBesoin): void {
            try {
                $sql = "INSERT INTO ProduitBesoin (idProduit, idBesoin) VALUES (:idProduit, :idBesoin)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':idProduit', $produitBesoin->getIdProduit(), PDO::PARAM_INT);
                $stmt->bindValue(':idBesoin', $produitBesoin->getIdBesoin(), PDO::PARAM_INT);
                $stmt->execute();
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        public function supprimerProduitBesoin(int $idProduitBesoin): void
        {
            try {
                $sql = "DELETE FROM ProduitBesoin WHERE idProduitBesoin = :idProduitBesoin";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':idProduitBesoin', $idProduitBesoin, PDO::PARAM_INT);
                $stmt->execute();
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        public function modifierProduitBesoin(ProduitBesoin $produitBesoin): void {
            try {
                $sql = "UPDATE ProduitBesoin SET idProduit = :idProduit, idBesoin = :idBesoin WHERE idProduitBesoin = :idProduitBesoin";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':idProduit', $produitBesoin->getIdProduit(), PDO::PARAM_INT);
                $stmt->bindValue(':idBesoin', $produitBesoin->getIdBesoin(), PDO::PARAM_INT);
                $stmt->bindValue(':idProduitBesoin', $produitBesoin->getIdProduitBesoin(), PDO::PARAM_INT);
                $stmt->execute();
            } catch (\Throwable $th) {
                throw $th;
            }
        }

        public function getAllProduitBesoin(): array {
            $produitsBesoin = [];
            try {
                $sql = "SELECT * FROM ProduitBesoin";
                $stmt = $this->db->query($sql);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $produitBesoin = new ProduitBesoin();
                    $produitBesoin->setIdProduitBesoin($row['idProduitBesoin']);
                    $produitBesoin->setIdProduit($row['idProduit']);
                    $produitBesoin->setIdBesoin($row['idBesoin']);
                    $produitsBesoin[] = $produitBesoin;
                }
            } catch (\Throwable $th) {
                throw $th;
            }
            return $produitsBesoin;
        }

        public function getProduitBesoinByIds(int $idProduitBesoin): ProduitBesoin {
            $produitBesoin = new ProduitBesoin();
            try {
                $sql = "SELECT * FROM ProduitBesoin WHERE idProduitBesoin = :idProduitBesoin";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':idProduitBesoin', $idProduitBesoin, PDO::PARAM_INT);
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $produitBesoin->setIdProduitBesoin($row['idProduitBesoin']);
                    $produitBesoin->setIdProduit($row['idProduit']);
                    $produitBesoin->setIdBesoin($row['idBesoin']);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
            return $produitBesoin;
    }
}
