<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <div class="page-title">
        <h2>
            <i class="fas fa-warehouse"></i>
            Stockage
        </h2>
        <p>Consultez les quantites disponibles par produit</p>
    </div>

    <div class="stats-container">
        <div class="stat-item">
            <i class="fas fa-boxes"></i>
            <div class="stat-number"><?= count($stockages ?? []) ?></div>
            <div class="stat-label">Produits en stock</div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-warehouse"></i> Tableau des stocks</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID Stockage</th>
                            <th>Produit</th>
                            <th>Quantite</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($stockages) && count($stockages) > 0): ?>
                            <?php foreach ($stockages as $stockage): ?>
                                <?php
                                    $idProduit = $stockage->getIdProduit();
                                    $nomProduit = $produitsById[$idProduit] ?? ('Produit #' . $idProduit);
                                ?>
                                <tr>
                                    <td><strong>#<?= $stockage->getIdStockage() ?></strong></td>
                                    <td>
                                        <i class="fas fa-box"></i>
                                        <?= htmlspecialchars($nomProduit) ?>
                                    </td>
                                    <td><strong><?= number_format($stockage->getQuantite(), 2, ',', ' ') ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 40px; color: #999;">
                                    <i class="fas fa-inbox" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                    Aucun stock enregistre
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
