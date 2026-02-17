<!-- Inclusion du header -->
<?php
include __DIR__ . '/includes/header.php';

$besoins = $controllerBesoin->getAllBesoin();
$villes = $controllerVille->getAllVilles();
$types = $controllerType->getAllTypes();

$villeMap = [];
foreach ($villes as $ville) {
    $id = is_object($ville) ? $ville->getIdVille() : ($ville['idVille'] ?? null);
    if ($id === null) {
        continue;
    }
    $villeMap[$id] = is_object($ville) ? $ville->getValVille() : ($ville['valVille'] ?? '');
}

$typeMap = [];
foreach ($types as $type) {
    $id = is_object($type) ? $type->getIdType() : ($type['idType'] ?? null);
    if ($id === null) {
        continue;
    }
    $typeMap[$id] = is_object($type) ? $type->getValType() : ($type['valType'] ?? '');
}
?>

<div class="container">
    <!-- Page Title -->
    <div class="page-title">
        <h2>
            <i class="fas fa-dashboard"></i>
            Tableau de bord
        </h2>
        <p>Suivi des collectes et distributions de dons par ville</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-3">
            <a class="stat-card" href="<?= BASE_URL ?>/villes">
                <i class="fas fa-city"></i>
                <h3><?= $controllerVille->getNombreVille() ?></h3>
                <p>Villes</p>
            </a>
        </div>
        <div class="col-3">
            <a class="stat-card" href="<?= BASE_URL ?>/besoins" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                <i class="fas fa-list"></i>
                <h3><?= $controllerBesoin->getNombreBesoin() ?></h3>
                <p>Besoins enregistrés</p>
            </a>
        </div>
        <div class="col-3">
            <a class="stat-card" href="<?= BASE_URL ?>/donsAffichage" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%);">
                <i class="fas fa-gift"></i>
                <h3><?= $controllerDon->getNombreDons() ?></h3>
                <p>Dons collectés</p>
            </a>
        </div>
        <div class="col-3">
            <a class="stat-card" href="<?= BASE_URL ?>/dispatch" style="background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);">
                <i class="fas fa-truck"></i>
                <h3><?= $controllerDispatchMere->getNombreDispatchMeres() ?></h3>
                <p>Dispachs effectués</p>
            </a>
        </div>
    </div>

    <!-- V2 Section: Achats -->
    <div class="row" style="margin-top: 30px; margin-bottom: 30px;">
        <div class="col-12">
            <div class="card border-success">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-shopping-cart"></i> Gestion des Achats (V2)
                    </h5>
                </div>
                <div class="card-body">
                    <p class="mb-3">Système d'achat de produits pour satisfaire les besoins</p>
                    <div class="row">
                        <div class="col-md-4">
                            <a href="<?= BASE_URL ?>/achat" class="btn btn-success btn-block" style="width: 100%; margin-bottom: 10px;">
                                <i class="fas fa-plus-circle"></i> Nouveau Achat
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="<?= BASE_URL ?>/simulation" class="btn btn-info btn-block" style="width: 100%; margin-bottom: 10px;">
                                <i class="fas fa-play"></i> Simulation
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href="<?= BASE_URL ?>/recapitulation" class="btn btn-primary btn-block" style="width: 100%; margin-bottom: 10px;">
                                <i class="fas fa-chart-pie"></i> Récapitulation
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 30px;">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-plus-circle"></i> Nouveau besoin</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/besoinInsert">
                        <div class="form-group">
                            <label for="idVille"><i class="fas fa-city"></i> Ville</label>
                            <select class="form-control" id="idVille" name="idVille" required>
                                <option value="">Sélectionnez une ville</option>
                                <?php foreach ($villes as $ville): ?>
                                    <?php
                                        $villeId = is_object($ville) ? $ville->getIdVille() : ($ville['idVille'] ?? '');
                                        $villeName = is_object($ville) ? $ville->getValVille() : ($ville['valVille'] ?? '');
                                    ?>
                                    <option value="<?= htmlspecialchars($villeId) ?>">
                                        <?= htmlspecialchars($villeName) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="valBesoin"><i class="fas fa-align-left"></i> Besoin</label>
                            <textarea class="form-control" id="valBesoin" name="valBesoin" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="idType"><i class="fas fa-tag"></i> Type</label>
                            <select class="form-control" id="idType" name="idType" required>
                                <option value="">Sélectionnez un type</option>
                                <?php foreach ($types as $type): ?>
                                    <?php
                                        $typeId = is_object($type) ? $type->getIdType() : ($type['idType'] ?? '');
                                        $typeName = is_object($type) ? $type->getValType() : ($type['valType'] ?? '');
                                    ?>
                                    <option value="<?= htmlspecialchars($typeId) ?>">
                                        <?= htmlspecialchars($typeName) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-list"></i> Besoins enregistrés</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Besoin</th>
                                    <th>Ville</th>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($besoins)): ?>
                                    <?php foreach ($besoins as $besoin): ?>
                                        <?php
                                            if (!is_object($besoin) && !is_array($besoin)) {
                                                continue;
                                            }
                                            $valBesoin = is_object($besoin) ? $besoin->getValBesoin() : ($besoin['valBesoin'] ?? '');
                                            $idVille = is_object($besoin) ? $besoin->getIdVille() : ($besoin['idVille'] ?? null);
                                            $idType = is_object($besoin) ? $besoin->getIdType() : ($besoin['idType'] ?? null);
                                            $villeName = $idVille !== null ? ($villeMap[$idVille] ?? '') : '';
                                            $typeName = $idType !== null ? ($typeMap[$idType] ?? '') : '';
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($valBesoin ?: 'N/A') ?></td>
                                            <td><?= htmlspecialchars($villeName ?: 'N/A') ?></td>
                                            <td><?= htmlspecialchars($typeName ?: 'N/A') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Aucun besoin enregistré</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>