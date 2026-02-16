<?php
use app\controllers\ControllerDispatchMere;
use app\controllers\ControllerDispatchFille;
use app\controllers\ControllerVille;
use app\controllers\ControllerProduit;

include __DIR__ . '/includes/header.php';

$controllerDispatchMere = new ControllerDispatchMere();
$controllerDispatchFille = new ControllerDispatchFille();
$controllerVille = new ControllerVille();
$controllerProduit = new ControllerProduit();

$mereId = $mereId ?? null;
$mere = $mereId ? $controllerDispatchMere->getDispatchMereById($mereId) : null;
$filles = $mereId ? $controllerDispatchFille->getFillesByMere($mereId) : [];

if (!$mere) {
    echo '<div class="container"><div class="alert alert-danger mt-3">Dispatch mère non trouvée</div></div>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

$villeData = $controllerVille->getVilleById($mere->getIdVille());
$villeName = is_object($villeData) ? $villeData->getValVille() : (isset($villeData['val_ville']) ? $villeData['val_ville'] : 'Non définie');
?>

<div class="container">
    <div class="page-title">
        <h2><i class="fas fa-box-open"></i> Détails du Dispatch</h2>
        <p>Informations et produits distribués</p>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header"><h5>Informations du Dispatch</h5></div>
                <div class="card-body">
                    <dl class="row">
                        <dt class="col-sm-5"><strong>ID Dispatch:</strong></dt>
                        <dd class="col-sm-7"><?= htmlspecialchars($mere->getIdDispatchMere()) ?></dd>

                        <dt class="col-sm-5"><strong>Ville:</strong></dt>
                        <dd class="col-sm-7"><?= htmlspecialchars($villeName) ?></dd>

                        <dt class="col-sm-5"><strong>Date/Heure:</strong></dt>
                        <dd class="col-sm-7"><?= htmlspecialchars($mere->getDateDispatch()) ?></dd>
                    </dl>
                </div>
            </div>

            <a href="<?= BASE_URL ?>/dispatch" class="btn btn-secondary btn-block w-100">
                <i class="fas fa-arrow-left"></i> Retour à la liste
            </a>
        </div>

        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h5>Produits Distribués (Dispatch Fille)</h5></div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID Distribution</th>
                                    <th>Produit</th>
                                    <th>Quantité</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($filles)): ?>
                                    <?php foreach ($filles as $fille): ?>
                                        <?php 
                                            $produitData = $controllerProduit->getProduitById(isset($fille['id_produit']) ? $fille['id_produit'] : null);
                                            $produitName = is_object($produitData) ? $produitData->getValProduit() : (isset($produitData['val_produit']) ? $produitData['val_produit'] : 'Non défini');
                                        ?>
                                        <tr>
                                            <td><?= isset($fille['id_Dispatch_fille']) ? htmlspecialchars($fille['id_Dispatch_fille']) : '' ?></td>
                                            <td><?= htmlspecialchars($produitName) ?></td>
                                            <td><?= isset($fille['quantite']) ? htmlspecialchars($fille['quantite']) : '' ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center text-muted">Aucun produit distribué pour ce dispatch</td>
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
