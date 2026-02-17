<?php include __DIR__ . '/../includes/header.php'; ?>

<?php if (!isset($mereData) || empty($mereData)): ?>
    <div class="container">
        <div class="alert alert-danger mt-3">Dispatch mère non trouvée</div>
    </div>
    <?php include __DIR__ . '/includes/footer.php'; ?>
    <?php exit; ?>
<?php endif; ?>

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
                        <dd class="col-sm-7"><?= htmlspecialchars((string)($mereData['id'] ?? 'N/A')) ?></dd>

                        <dt class="col-sm-5"><strong>Ville:</strong></dt>
                        <dd class="col-sm-7"><?= htmlspecialchars($mereData['villeName'] ?? 'N/A') ?></dd>

                        <dt class="col-sm-5"><strong>Date/Heure:</strong></dt>
                        <dd class="col-sm-7"><?= htmlspecialchars($mereData['date'] ?? 'N/A') ?></dd>
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
                                <?php if (!empty($fillesFormatted)): ?>
                                    <?php foreach ($fillesFormatted as $fille): ?>
                                        <tr>
                                            <td><?= htmlspecialchars($fille['produitName'] ?? 'N/A') ?></td>
                                            <td><?= htmlspecialchars((string)($fille['quantite'] ?? 'N/A')) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="2" class="text-center text-muted">Aucun produit distribué pour ce dispatch</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Formulaire d'ajout de Dispatch Fille -->
                    <hr>
                    <h5 class="mt-4 mb-3"><i class="fas fa-plus-circle"></i> Ajouter un Produit à ce Dispatch</h5>
                    <form method="POST" action="<?= BASE_URL ?>/dispatchDetail/addFille?idDispatchMere=<?= htmlspecialchars((string)($mereData['id'] ?? '')) ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="idProduit"><i class="fas fa-box"></i> Produit</label>
                                    <select class="form-control form-control-sm" id="idProduit" name="idProduit" required>
                                        <option value="">-- Sélectionner un produit --</option>
                                        <?php if (!empty($produitsList)): ?>
                                            <?php foreach ($produitsList as $produit): ?>
                                                <option value="<?= htmlspecialchars((string)($produit['id'] ?? '')) ?>">
                                                    <?= htmlspecialchars($produit['name'] ?? '') ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="quantite"><i class="fas fa-weight"></i> Quantité</label>
                                    <input type="number" class="form-control form-control-sm" id="quantite" name="quantite" step="0.01" min="0.01" placeholder="Quantité" required>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm w-100">
                            <i class="fas fa-plus"></i> Ajouter au Dispatch
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
