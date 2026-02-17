<?php
namespace app\models;

class StatutBesoin {
    // Attributs
    private ?int $idStatutBesoin;
    private ?string $valStatutBesoin;

    // Constructeur
    public function __construct(?int $idStatutBesoin = null, ?string $valStatutBesoin = null) {
        $this->idStatutBesoin = $idStatutBesoin;
        $this->valStatutBesoin = $valStatutBesoin;
    }

    // Getters
    public function getIdStatutBesoin(): ?int {
        return $this->idStatutBesoin;
    }

    public function getValStatutBesoin(): ?string {
        return $this->valStatutBesoin;
    }

    // Setters
    public function setIdStatutBesoin(?int $idStatutBesoin): void {
        $this->idStatutBesoin = $idStatutBesoin;
    }

    public function setValStatutBesoin(?string $valStatutBesoin): void {
        $this->valStatutBesoin = $valStatutBesoin;
    }
}
