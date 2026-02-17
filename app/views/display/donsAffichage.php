<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <div class="page-title">
        <h2>
            <i class="fas fa-gift"></i>
            Liste des dons et donnations
        </h2>
        <p>Consultez tous les dons et donnations enregistrés</p>
    </div>

    <!-- Bouton d'ajout -->
    <div style="margin-bottom: 20px; text-align: right;">
        <a href="<?= BASE_URL ?>/donInsert" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Ajouter un nouveau don
        </a>
    </div>

    <!-- Statistiques -->
    <div class="stats-container">
        <div class="stat-item">
            <i class="fas fa-gift"></i>
            <div class="stat-number"><?= htmlspecialchars((string)($nombreDons ?? 0)) ?></div>
            <div class="stat-label">Dons totaux</div>
        </div>
        <div class="stat-item" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%);">
            <i class="fas fa-box"></i>
            <div class="stat-number"><?= htmlspecialchars((string)($nombreDonnations ?? 0)) ?></div>
            <div class="stat-label">Donnations totales</div>
        </div>
        <div class="stat-item" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
            <i class="fas fa-coins"></i>
            <div class="stat-number"><?= htmlspecialchars(number_format($totalValeurDons ?? 0, 0, ',', ' ')) ?> Ar</div>
            <div class="stat-label">Valeur totale</div>
        </div>
    </div>

    <!-- Liste des dons -->
    <div class="card" style="margin-bottom: 30px;">
        <div class="card-header">
            <h5><i class="fas fa-gift"></i> Liste de tous les dons</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID Don</th>
                            <th>Date du don</th>
                            <th>Valeur totale (Ar)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($donsList)): ?>
                            <?php foreach ($donsList as $don): ?>
                                <tr>
                                    <td><strong>#<?= htmlspecialchars((string)($don['id'] ?? 'N/A')) ?></strong></td>
                                    <td>
                                        <i class="fas fa-calendar"></i> 
                                        <?= htmlspecialchars($don['date'] instanceof \DateTime ? $don['date']->format('d/m/Y') : 'N/A') ?>
                                    </td>
                                    <td>
                                        <strong style="color: #27ae60;">
                                            <?= htmlspecialchars(number_format($don['prix'] ?? 0, 0, ',', ' ')) ?> Ar
                                        </strong>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" style="text-align: center; padding: 40px; color: #999;">
                                    <i class="fas fa-inbox" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                    Aucun don enregistré
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Liste des donnations -->
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-box-open"></i> Liste de toutes les donnations</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID Donnation</th>
                            <th>ID Don</th>
                            <th>ID Produit</th>
                            <th>Quantité</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($donnationsList)): ?>
                            <?php foreach ($donnationsList as $donnation): ?>
                                <tr>
                                    <td><strong>#<?= htmlspecialchars((string)($donnation['id'] ?? 'N/A')) ?></strong></td>
                                    <td>
                                        <span style="background: #667eea; color: white; padding: 3px 10px; border-radius: 15px; font-size: 0.85rem;">
                                            <i class="fas fa-gift"></i> Don #<?= htmlspecialchars((string)($donnation['idDon'] ?? 'N/A')) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span style="background: #27ae60; color: white; padding: 3px 10px; border-radius: 15px; font-size: 0.85rem;">
                                            <i class="fas fa-box"></i> Produit #<?= htmlspecialchars((string)($donnation['idProduit'] ?? 'N/A')) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong><?= htmlspecialchars(number_format($donnation['quantite'] ?? 0, 2, ',', ' ')) ?></strong>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 40px; color: #999;">
                                    <i class="fas fa-inbox" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                    Aucune donnation enregistrée
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
