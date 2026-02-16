<?php
include __DIR__ . '/includes/header.php';

$besoins = [];
try {
    if (class_exists('\app\controllers\ControllerBesoin')) {
        $ctrl = new \app\controllers\ControllerBesoin();
        $besoins = $ctrl->getAllBesoin();
    }
} catch (\Throwable $e) {
    $besoins = [];
}

// fallback test data
if (empty($besoins)) {
    $besoins = [
        ['ville' => 'Antananarivo','type'=>'Nature','produit'=>'Riz','quantite'=>'500 kg','prix_unitaire'=>'2000','total'=>'1000000','urgence'=>'important','date'=>'2026-02-16','statut'=>'Partiel'],
        ['ville' => 'Mahajanga','type'=>'Matériaux','produit'=>'Tôles','quantite'=>'100 pièces','prix_unitaire'=>'25000','total'=>'2500000','urgence'=>'urgent','date'=>'2026-02-16','statut'=>'Non couvert'],
        ['ville' => 'Toamasina','type'=>'Nature','produit'=>'Riz','quantite'=>'300 kg','prix_unitaire'=>'2000','total'=>'600000','urgence'=>'normal','date'=>'2026-02-15','statut'=>'Couvert']
    ];
}

?>

<div class="container">
    <div class="page-title">
        <h2><i class="fas fa-list"></i> Liste des besoins</h2>
        <p>Consultez et filtrez les besoins par ville</p>
    </div>

    <div class="card">
        <div class="card-header"><h5>Tous les besoins</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ville</th>
                            <th>Type</th>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Total (Ar)</th>
                            <th>Urgence</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($besoins as $b): ?>
                            <?php if (is_array($b)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($b['ville'] ?? ($b['valVille'] ?? 'N/A')) ?></td>
                                    <td><?= htmlspecialchars($b['type'] ?? ($b['typeName'] ?? '')) ?></td>
                                    <td><?= htmlspecialchars($b['produit'] ?? ($b['valBesoin'] ?? '')) ?></td>
                                    <td><?= htmlspecialchars($b['quantite'] ?? ($b['quantiteBesoin'] ?? '-')) ?></td>
                                    <td><?= htmlspecialchars($b['prix_unitaire'] ?? '-') ?></td>
                                    <td><?= htmlspecialchars($b['total'] ?? '-') ?></td>
                                    <td><span class="badge <?= (stripos($b['urgence'] ?? '', 'urgent')!==false)?'badge-danger':((stripos($b['urgence'] ?? '', 'important')!==false)?'badge-warning':'badge-success') ?>"><?= htmlspecialchars($b['urgence'] ?? '') ?></span></td>
                                    <td><?= htmlspecialchars($b['date'] ?? '') ?></td>
                                    <td><span class="badge badge-info"><?= htmlspecialchars($b['statut'] ?? '') ?></span></td>
                                </tr>
                            <?php else: ?>
                                <tr><td colspan="9">Données non disponibles</td></tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
