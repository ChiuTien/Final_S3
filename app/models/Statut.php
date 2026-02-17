<?php
namespace app\models;

class Statut {
    // Attributs
    private ?int $idStatut;
    private ?int $idBesoin;
    private ?int $idStatutBesoin;
    private ?\DateTime $dateDeChangement;

    // Constructeur
    public function __construct(
        ?int $idStatut = null, 
        ?int $idBesoin = null, 
        ?int $idStatutBesoin = null, 
        ?\DateTime $dateDeChangement = null
    ) {
        $this->idStatut = $idStatut;
        $this->idBesoin = $idBesoin;
        $this->idStatutBesoin = $idStatutBesoin;
        $this->dateDeChangement = $dateDeChangement ?? new \DateTime();
    }

    // Getters
    public function getIdStatut(): ?int {
        return $this->idStatut;
    }

    public function getIdBesoin(): ?int {
        return $this->idBesoin;
    }

    public function getIdStatutBesoin(): ?int {
        return $this->idStatutBesoin;
    }

    public function getDateDeChangement(): ?\DateTime {
        return $this->dateDeChangement;
    }

    // Setters
    public function setIdStatut(?int $idStatut): void {
        $this->idStatut = $idStatut;
    }

    public function setIdBesoin(?int $idBesoin): void {
        $this->idBesoin = $idBesoin;
    }

    public function setIdStatutBesoin(?int $idStatutBesoin): void {
        $this->idStatutBesoin = $idStatutBesoin;
    }

    public function setDateDeChangement(?\DateTime $dateDeChangement): void {
        $this->dateDeChangement = $dateDeChangement;
    }
}
