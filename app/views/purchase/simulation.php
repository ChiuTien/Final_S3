<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container-fluid mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>
                <i class="fas fa-check-circle"></i> Simulation des Achats
            </h2>
            <p class="text-muted">Vérifiez et validez vos achats avant confirmation</p>
        </div>
    </div>

    <?php if (!empty($achatsSimulationList)): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-table"></i> Achats à Valider (<?= htmlspecialchars((string)(count($achatsSimulationList) ?? 0)) ?>)
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Besoin</th>
                                        <th>Produit</th>
                                        <th class="text-center">Quantité</th>
                                        <th class="text-right">Prix Unit.</th>
                                        <th class="text-right">Montant</th>
                                        <th class="text-right">Frais</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $grandTotal = 0; ?>
                                    <?php foreach ($achatsSimulationList as $index => $achat): ?>
                                        <tr>
                                            <td><strong><?= htmlspecialchars((string)($index + 1)) ?></strong></td>
                                            <td><small>#<?= htmlspecialchars((string)($achat['idBesoin'] ?? 'N/A')) ?></small></td>
                                            <td><?= htmlspecialchars($achat['produitName'] ?? 'N/A') ?></td>
                                            <td class="text-center"><?= htmlspecialchars(number_format($achat['quantite'] ?? 0, 2, ',', ' ')) ?></td>
                                            <td class="text-right"><?= htmlspecialchars(number_format($achat['prixUnitaire'] ?? 0, 2, ',', ' ')) ?>€</td>
                                            <td class="text-right"><?= htmlspecialchars(number_format($achat['montantTotal'] ?? 0, 2, ',', ' ')) ?>€</td>
                                            <td class="text-right"><span style="color: #e74c3c;"><?= htmlspecialchars(number_format($achat['montantFrais'] ?? 0, 2, ',', ' ')) ?>€</span></td>
                                            <td class="text-right"><strong><?= htmlspecialchars(number_format($achat['montantAvecFrais'] ?? 0, 2, ',', ' ')) ?>€</strong></td>
                                        </tr>
                                        <?php $grandTotal += floatval($achat['montantAvecFrais'] ?? 0); ?>
                                    <?php endforeach; ?>
                                </tbody>
                                <tfoot>
                                    <tr class="table-active">
                                        <th colspan="7" class="text-right"><strong>GRAND TOTAL:</strong></th>
                                        <th class="text-right"><strong style="font-size: 1.2rem; color: #27ae60;"><?= htmlspecialchars(number_format($grandTotal, 2, ',', ' ')) ?>€</strong></th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>

                        <!-- Actions -->
                        <div class="mt-4 d-flex gap-2">
                            <form method="POST" action="<?= BASE_URL ?>/simulation/valider" style="flex: 1;">
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-check"></i> Valider les Achats
                                </button>
                            </form>
                            <form method="POST" action="<?= BASE_URL ?>/simulation/rejeter" style="flex: 1;">
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-times"></i> Rejeter
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            <i class="fas fa-info-circle"></i> Aucun achat à simuler
            <br><br>
            <a href="<?= BASE_URL ?>/achat" class="btn btn-primary">
                <i class="fas fa-shopping-cart"></i> Aller aux achats
            </a>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
