<?php
namespace app\models;

class HistoriqueDispatch {
    private $idHistorique;
    private $idVille;
    private $idBesoin;
    private \DateTime $dateChange;
    private $status;

    public function __construct() {}

    public function setIdHistorique($id) { $this->idHistorique = $id; }
    public function getIdHistorique(): int { return $this->idHistorique; }

    public function setIdVille($id) { $this->idVille = $id; }
    public function getIdVille(): int { return $this->idVille; }

    public function setIdBesoin($id) { $this->idBesoin = $id; }
    public function getIdBesoin(): int { return $this->idBesoin; }

    public function setDateChange(\DateTime $date) { $this->dateChange = $date; }
    public function getDateChange(): \DateTime { return $this->dateChange; }

    public function setStatus($status) { $this->status = $status; }
    public function getStatus() { return $this->status; }
}
?>
