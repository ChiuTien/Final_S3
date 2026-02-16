<?php
include __DIR__ . '/includes/header.php';

use app\Controllers\ControllerDispatchFille;
use app\controllers\ControllerDispatchMere;

$dM = new ControllerDispatchMere();
$meres = $dM->getAllDispatchMeres();

$dF = new ControllerDispatchFille();
$filles = $dF->getAllDispatchFilles();

?>

<div class="container">
    <div class="page-title">
        <h2><i class="fas fa-truck"></i> Gestion des dispatch</h2>
        <p>Liste des dispatch mère et fille (données via controllers si possible)</p>
    </div>

    <div class="card">
        <div class="card-header"><h5>Dispatchs (Mère)</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr><th>ID</th><th>Ville (id)</th><th>Date</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($meres as $m): ?>
                            <tr>
                                <td><?= htmlspecialchars($m['id_dispatch_mere'] ?? $m['id'] ?? '') ?></td>
                                <td><?= htmlspecialchars($m['id_ville'] ?? '') ?></td>
                                <td><?= htmlspecialchars($m['date_dispatch'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header"><h5>Dispatchs (Fille)</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr><th>ID</th><th>ID Mère</th><th>ID Produit</th><th>Quantité</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($filles as $f): ?>
                            <tr>
                                <td><?= htmlspecialchars($f['id_dispatch_fille'] ?? $f['id'] ?? '') ?></td>
                                <td><?= htmlspecialchars($f['id_dispatch_mere'] ?? '') ?></td>
                                <td><?= htmlspecialchars($f['id_produit'] ?? '') ?></td>
                                <td><?= htmlspecialchars($f['quantite'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
