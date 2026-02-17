<?php include __DIR__ . '/../includes/header.php'; ?>

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
                        <?php if (!empty($dispatchMeresList)): ?>
                            <?php foreach ($dispatchMeresList as $mere): ?>
                                <tr style="cursor: pointer;" onclick="window.location.href = '<?= BASE_URL ?>/dispatchDetail?id=<?= htmlspecialchars((string)($mere['id'] ?? '')) ?>'">
                                    <td><?= htmlspecialchars((string)($mere['id'] ?? 'N/A')) ?></td>
                                    <td><?= htmlspecialchars($mere['villeName'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($mere['date'] ?? 'N/A') ?></td>
                                    <td>
                                        <a href="<?= BASE_URL ?>/dispatchDetail?id=<?= htmlspecialchars((string)($mere['id'] ?? '')) ?>" class="btn btn-sm btn-info">
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

    <!-- Tableau dynamique: ville | date | quantité | prix | voir plus -->
    <div class="card mt-4">
        <div class="card-header"><h5>Aperçu par Ville</h5></div>
        <div class="card-body">
            <!-- Boutons de tri/filtrage -->
            <div style="margin-bottom: 20px; display: flex; gap: 10px; flex-wrap: wrap;">
                <a href="<?= BASE_URL ?>/dispatchDate" class="btn btn-primary" style="flex: 1; min-width: 200px;">
                    <i class="fas fa-calendar-alt"></i> Par date
                </a>
                <button class="btn btn-info" style="flex: 1; min-width: 200px;">
                    <i class="fas fa-chart-bar"></i> Par demande minimum
                </button>
                <button class="btn btn-success" style="flex: 1; min-width: 200px;">
                    <i class="fas fa-balance-scale"></i> Par proportionnalité
                </button>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Ville</th>
                            <th>Date équivalence (par besoin)</th>
                            <th>Quantité (donnation pour le produit)</th>
                            <th>Prix équivalence (produit)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($villeDispatchData)): ?>
                            <?php foreach ($villeDispatchData as $data): ?>
                                <tr>
                                    <td><?= htmlspecialchars($data['villeName'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($data['dateEquivalence'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars((string)($data['quantiteDonnee'] ?? 'N/A')) ?></td>
                                    <td><?= htmlspecialchars((string)($data['prixEquivalence'] ?? 'N/A')) ?></td>
                                    <td>
                                        <?php if (!empty($data['produits'])): ?>
                                            <ul class="mb-0">
                                                <?php foreach ($data['produits'] as $p): ?>
                                                    <li>
                                                        <?= htmlspecialchars($p['name'] ?? 'N/A') ?> 
                                                        — Quantité: <?= htmlspecialchars((string)($p['quant'] ?? 'N/A')) ?> 
                                                        — Prix: <?= htmlspecialchars((string)($p['prix'] ?? 'N/A')) ?>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <span class="text-muted">Aucun produit lié</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center text-muted">Aucune ville disponible</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
