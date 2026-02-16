<?php
// Vue serveur pour la liste des villes — utilise les controllers si disponibles, sinon données de test
include __DIR__ . '/includes/header.php';

$donsTest = [
    ['donateur' => 'Jean R.', 'produit' => 'Riz', 'quantite' => '100kg', 'date' => 'Il y a 2h'],
    ['donateur' => 'Marie L.', 'produit' => 'Argent', 'quantite' => '50 000 Ar', 'date' => 'Il y a 5h'],
    ['donateur' => 'Entreprise ABC', 'produit' => 'Tôles', 'quantite' => '50', 'date' => 'Hier']
];

$regionsTest = [
    ['idRegion' => 1, 'valRegion' => 'Analamanga'],
    ['idRegion' => 2, 'valRegion' => 'Atsinanana'],
    ['idRegion' => 3, 'valRegion' => 'Boeny']
];

$villes = [];
$regionsMap = [];

try {
    if (function_exists('Flight')) {
        $db = \Flight::db();
    } elseif (class_exists('Flight')) {
        $db = \Flight::db();
    } else {
        $db = null;
    }

    if ($db && class_exists('\app\repository\RepVille') && class_exists('\app\repository\RepRegion') && class_exists('\app\controllers\ControllerVille') && class_exists('\app\controllers\ControllerRegion')) {
        $repRegion = new \app\repository\RepRegion($db);
        $ctrlRegion = new \app\controllers\ControllerRegion($repRegion);
        $regions = $ctrlRegion->getAllRegions();
        foreach ($regions as $r) {
            $key = $r['idRegion'] ?? $r['id_region'] ?? ($r['id'] ?? null);
            $regionsMap[$key] = $r['valRegion'] ?? $r['val_region'] ?? ($r['name'] ?? '');
        }

        $repVille = new \app\repository\RepVille($db);
        $ctrlVille = new \app\controllers\ControllerVille($repVille);
        $villesRaw = $ctrlVille->getAllVilles();
        foreach ($villesRaw as $vr) {
            $nom = $vr['valVille'] ?? $vr['val_ville'] ?? $vr['valville'] ?? ($vr['name'] ?? 'Ville');
            $regionName = $regionsMap[$vr['idRegion'] ?? $vr['id_region'] ?? null] ?? 'Inconnue';
            $villes[] = [
                'nom' => $nom,
                'region' => $regionName,
                'besoins' => [],
                'dons' => [],
                'statut' => 'N/A'
            ];
        }
    }
} catch (\Throwable $e) {
    // fallback to test data below
}

if (empty($villes)) {
    $villes = [
        ['nom' => 'Antananarivo','region' => 'Analamanga','besoins'=>[['produit'=>'Riz','quantite'=>'500kg'],['produit'=>'Huile','quantite'=>'200L']], 'dons'=>[['produit'=>'Riz','quantite'=>'300kg']],'statut'=>'Partiellement couvert'],
        ['nom' => 'Toamasina','region' => 'Atsinanana','besoins'=>[['produit'=>'Riz','quantite'=>'300kg'],['produit'=>'Clous','quantite'=>'50kg']],'dons'=>[['produit'=>'Riz','quantite'=>'300kg']],'statut'=>'Couvert'],
        ['nom' => 'Mahajanga','region' => 'Boeny','besoins'=>[['produit'=>'Riz','quantite'=>'400kg'],['produit'=>'Huile','quantite'=>'100L']],'dons'=>[['produit'=>'Riz','quantite'=>'100kg']],'statut'=>'Urgent']
    ];
}

?>

<div class="container">
    <div class="page-title">
        <h2><i class="fas fa-city"></i> Villes</h2>
        <p>Liste des villes (données provenant du controller si disponible, sinon données de test)</p>
    </div>

    <div class="card">
        <div class="card-header"><h5>Toutes les villes</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ville</th>
                            <th>Région</th>
                            <th>Besoins</th>
                            <th>Dons reçus</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($villes as $ville): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($ville['nom']) ?></strong></td>
                            <td><?= htmlspecialchars($ville['region']) ?></td>
                            <td>
                                <?php if (!empty($ville['besoins'])): foreach ($ville['besoins'] as $b): ?>
                                    <span class="badge badge-besoin"><?= htmlspecialchars($b['produit']) ?>: <?= htmlspecialchars($b['quantite']) ?></span>
                                <?php endforeach; else: ?>
                                    <small class="text-muted">Aucun besoin listé</small>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($ville['dons'])): foreach ($ville['dons'] as $d): ?>
                                    <span class="badge badge-don"><?= htmlspecialchars($d['produit']) ?>: <?= htmlspecialchars($d['quantite']) ?></span>
                                <?php endforeach; else: ?>
                                    <small class="text-muted">Aucun don attribué</small>
                                <?php endif; ?>
                            </td>
                            <td><span class="badge <?= (stripos($ville['statut'],'Urgent')!==false)?'badge-danger':((stripos($ville['statut'],'Couvert')!==false)?'badge-success':'badge-warning') ?>"><?= htmlspecialchars($ville['statut']) ?></span></td>
                            <td>
                                <a href="<?= BASE_URL ?>/ville/<?= urlencode($ville['nom']) ?>" class="btn btn-sm btn-outline-primary"><i class="fas fa-eye"></i></a>
                                <a href="<?= BASE_URL ?>/dispatch?ville=<?= urlencode($ville['nom']) ?>" class="btn btn-sm btn-outline-success"><i class="fas fa-truck"></i></a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h5><i class="fas fa-clock"></i> Derniers dons enregistrés</h5></div>
                <div class="card-body">
                    <ul class="list-group">
                        <?php foreach ($donsTest as $don): ?>
                            <li class="list-group-item"><strong><?= htmlspecialchars($don['donateur']) ?></strong> - <?= htmlspecialchars($don['produit']) ?> <?= htmlspecialchars($don['quantite']) ?> <small class="text-muted"><?= htmlspecialchars($don['date']) ?></small></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"><h5><i class="fas fa-exclamation-triangle"></i> Besoins urgents</h5></div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item"><strong>Fianarantsoa</strong> - Riz 500kg <span class="badge badge-danger">Urgent</span></li>
                        <li class="list-group-item"><strong>Toliara</strong> - Eau 1000L <span class="badge badge-danger">Urgent</span></li>
                        <li class="list-group-item"><strong>Antsiranana</strong> - Médicaments <span class="badge badge-warning">Important</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
