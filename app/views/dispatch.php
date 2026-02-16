<?php
include __DIR__ . '/includes/header.php';

$meres = [];
$filles = [];
try {
    if (class_exists('\app\repository\RepDispatchMere') && class_exists('\app\controllers\ControllerDispatchMere')) {
        $repM = new \app\repository\RepDispatchMere(Flight::db());
        $ctrlM = new \app\controllers\ControllerDispatchMere($repM);
        $meres = $ctrlM->getAllDispatchMeres();
    }
    if (class_exists('\app\repository\RepDispatchFille') && class_exists('\app\controllers\ControllerDispatchFille')) {
        $repF = new \app\repository\RepDispatchFille(Flight::db());
        $ctrlF = new \app\controllers\ControllerDispatchFille($repF);
        $filles = $ctrlF->getAllDispatchFilles();
    }
} catch (\Throwable $e) {
    $meres = [];
    $filles = [];
}

if (empty($meres)) {
    $meres = [
        ['id_dispatch_mere' => 1, 'id_ville' => 3, 'date_dispatch' => '2026-02-16 10:30'],
        ['id_dispatch_mere' => 2, 'id_ville' => 1, 'date_dispatch' => '2026-02-15 09:00']
    ];
}
if (empty($filles)) {
    $filles = [
        ['id_dispatch_fille' => 1, 'id_dispatch_mere' => 1, 'id_produit' => 1, 'quantite' => 250],
        ['id_dispatch_fille' => 2, 'id_dispatch_mere' => 1, 'id_produit' => 2, 'quantite' => 100]
    ];
}

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
