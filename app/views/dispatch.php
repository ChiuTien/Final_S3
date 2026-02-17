<?php
// Vue pour la gestion des Dispatch Mère
// Toutes les données sont préparées dans routes.php
include __DIR__ . '/includes/header.php';
?>

<div class="container">
    <div class="page-title">
        <h2><i class="fas fa-truck"></i> Gestion des Dispatch Mère</h2>
        <p>Cliquez sur une ligne pour voir les détails et les produits associés</p>
    </div>

    <div class="card">
        <div class="card-header"><h5>Liste des Dispatchs (Mère)</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID Dispatch</th>
                            <th>Ville</th>
                            <th>Date et Heure</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($dispatchMeres)): ?>
                            <?php foreach ($dispatchMeres as $mere): ?>
                                <?php 
                                    $villeData = $controllerVille->getVilleById(isset($mere['id_ville']) ? $mere['id_ville'] : null);
                                    $villeName = is_object($villeData) ? $villeData->getValVille() : (isset($villeData['val_ville']) ? $villeData['val_ville'] : 'Non définie');
                                ?>
                                <tr style="cursor: pointer;" onclick="window.location.href = '<?= BASE_URL ?>/dispatchDetail?id=<?= isset($mere['id_Dispatch_mere']) ? htmlspecialchars($mere['id_Dispatch_mere']) : '' ?>'">
                                    <td><?= isset($mere['id_Dispatch_mere']) ? htmlspecialchars($mere['id_Dispatch_mere']) : '' ?></td>
                                    <td><?= htmlspecialchars($villeName) ?></td>
                                    <td><?= isset($mere['date_dispatch']) ? htmlspecialchars($mere['date_dispatch']) : '' ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>/dispatchDetail?id=<?= isset($mere['id_Dispatch_mere']) ? htmlspecialchars($mere['id_Dispatch_mere']) : '' ?>" class="btn btn-sm btn-info">
                                            <i class="fas fa-eye"></i> Voir détails
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted">Aucun dispatch mère enregistré</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
