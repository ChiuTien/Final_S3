<?php
require_once __DIR__ . '/app/config/bootstrap.php';

use app\controllers\ControllerBesoin;

$ctrl = new ControllerBesoin();
$besoins = $ctrl->getAllBesoin();

echo "<pre>";
foreach ($besoins as $besoin) {
    echo "ID: " . var_export($besoin->getIdBesoin(), true) . "\n";
    echo "Val: " . var_export($besoin->getValBesoin(), true) . "\n";
    echo "IdVille: " . var_export($besoin->getIdVille(), true) . "\n";
    echo "IdType: " . var_export($besoin->getIdType(), true) . "\n";
    echo "---\n";
}
echo "</pre>";
?>
