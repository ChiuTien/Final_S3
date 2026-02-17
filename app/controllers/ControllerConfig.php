<?php
namespace app\controllers;

use app\repository\RepConfig;

class ControllerConfig {
    private RepConfig $repo;

    public function __construct() {
        $this->repo = new RepConfig();
    }

    public function getConfigByKey($cle) {
        return $this->repo->getConfigByKey($cle);
    }

    public function getAllConfig() {
        return $this->repo->getAllConfig();
    }

    public function updateConfig($cle, $valeur) {
        $this->repo->updateConfig($cle, $valeur);
    }

    public function getConfigValue($cle, $default = null) {
        return $this->repo->getConfigValue($cle, $default);
    }

    public function getFraisAchatPourcentage() {
        return floatval($this->repo->getConfigValue('frais_achat_pourcentage', 10));
    }
}
?>
