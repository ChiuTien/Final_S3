<?php
namespace app\repository;

use app\models\Config;
use Flight;
use PDO;

class RepConfig {
    private PDO $db;

    public function __construct() {
        $this->db = Flight::db();
    }

    public function getConfigByKey($cle): ?Config {
        $sql = "SELECT * FROM Config WHERE cleCongif = :cle";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':cle', $cle, PDO::PARAM_STR);
        $stmt->execute();
        $data = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if (!$data) return null;
        
        $config = new Config();
        $config->setIdConfig($data['idConfig']);
        $config->setCleCongif($data['cleCongif']);
        $config->setValeur($data['valeur']);
        $config->setDescription($data['description']);
        return $config;
    }

    public function getAllConfig() {
        $sql = "SELECT * FROM Config ORDER BY cleCongif";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $configs = [];
        foreach ($data as $row) {
            $config = new Config();
            $config->setIdConfig($row['idConfig']);
            $config->setCleCongif($row['cleCongif']);
            $config->setValeur($row['valeur']);
            $config->setDescription($row['description']);
            $configs[] = $config;
        }
        return $configs;
    }

    public function updateConfig($cle, $valeur) {
        $sql = "UPDATE Config SET valeur = :valeur WHERE cleCongif = :cle";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':valeur', $valeur, PDO::PARAM_STR);
        $stmt->bindValue(':cle', $cle, PDO::PARAM_STR);
        $stmt->execute();
    }

    public function getConfigValue($cle, $default = null) {
        $config = $this->getConfigByKey($cle);
        return $config ? $config->getValeur() : $default;
    }
}
?>
