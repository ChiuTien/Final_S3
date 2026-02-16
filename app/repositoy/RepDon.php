<?php
    namespace App\Repository;
    use app\models\Don;
    use Flight;
    use PDO;

    class RepDon{
        //Attribut 
        private PDO $db;

        public function __construct(PDO $db) {
            $this->db = $db;
        }

        // Méthodes pour interagir avec la table Don
        public function addDon(Don $don):void {
            try {
                $date = $don->getDateDon()->format('Y-m-d H:i:s');
                $totalPrix = $don->getTotalPrix();
                $sql = "INSERT INTO Don(dateDon, totalPrix) VALUES (:dateDon, :totalPrix)";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':dateDon', $date, PDO::PARAM_STR);
                $stmt->bindValue(':totalPrix', $totalPrix, PDO::PARAM_INT);
                $stmt->execute();
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        public function deleteDon(int $id): void {
            try {
                $sql = "DELETE FROM Don WHERE id = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':id', $id);
                $stmt->execute();
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        public function updateDon(Don $don): void {
            try {
                $id = $don->getIdDon();
                $date = $don->getDateDon()->format('Y-m-d H:i:s');
                $totalPrix = $don->getTotalPrix();
                $sql = "UPDATE Don SET dateDon = :dateDon, totalPrix = :totalPrix WHERE idDon = :id";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':id', $id, PDO::PARAM_INT);
                $stmt->bindValue(':dateDon', $date, PDO::PARAM_STR);
                $stmt->bindValue(':totalPrix', $totalPrix, PDO::PARAM_INT);
                $stmt->execute();
            } catch (\Throwable $th) {
                throw $th;
            }
        }
        public function getDonById(int $idDon) :Don {
            $don = new Don();
            try {
                $sql = "SELECT * FROM Don WHERE idDon = :idDon";
                $stmt = $this->db->prepare($sql);
                $stmt->bindValue(':idDon', $idDon, PDO::PARAM_INT);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($result) {
                    $don->setIdDon($result['idDon']);
                    $don->setDateDon(new \DateTime($result['dateDon']));
                    $don->setTotalPrix($result['totalPrix']);
                }
            } catch (\Throwable $th) {
                throw $th;
            }
            return $don;
        }
        public function getAllDons(): array {
            $dons = [];
            try {
                $sql = "SELECT * FROM Don";
                $stmt = $this->db->query($sql);
                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    $don = new Don();
                    $don->setIdDon($row['idDon']);
                    $don->setDateDon(new \DateTime($row['dateDon']));
                    $don->setTotalPrix($row['totalPrix']);
                    $dons[] = $don;
                }
            } catch (\Throwable $th) {
                throw $th;
            }
            return $dons;
        }
    }


?>