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

$mereId = $mereId ?? ($_GET['id'] ?? null);
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

                    <!-- Formulaire d'ajout de Dispatch Fille -->
                    <hr>
                    <h5 class="mt-4 mb-3"><i class="fas fa-plus-circle"></i> Ajouter un Produit à ce Dispatch</h5>
                    <form method="POST" action="<?= BASE_URL ?>/dispatchDetail/addFille?idDispatchMere=<?= htmlspecialchars($mereId) ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="idProduit"><i class="fas fa-box"></i> Produit</label>
                                    <select class="form-control form-control-sm" id="idProduit" name="idProduit" required>
                                        <option value="">-- Sélectionner un produit --</option>
                                        <?php 
                                            $produits = $controllerProduit->getAllProduit();
                                            foreach ($produits as $produit):
                                                $prodId = is_object($produit) ? $produit->getIdProduit() : ($produit['id_produit'] ?? '');
                                                $prodVal = is_object($produit) ? $produit->getValProduit() : ($produit['val_produit'] ?? '');
                                        ?>
                                            <option value="<?= htmlspecialchars($prodId) ?>">
                                                <?= htmlspecialchars($prodVal) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantite"><i class="fas fa-list-ol"></i> Quantité</label>
                                    <input type="number" class="form-control form-control-sm" id="quantite" name="quantite" placeholder="Quantité" step="0.01" min="1" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success btn-sm">
                            <i class="fas fa-save"></i> Ajouter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
