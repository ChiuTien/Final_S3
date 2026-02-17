<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <div class="page-title">
        <h2><i class="fas fa-calendar-alt"></i> Dispatch par Date</h2>
        <p>Dispatcher les besoins en priorité par date (les plus anciens d'abord)</p>
    </div>

    <!-- Messages de succès/erreur -->
    <?php if (isset($_GET['success'])): ?>
        <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #28a745;">
            <i class="fas fa-check-circle"></i> Dispatch réalisé avec succès !
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px; border-left: 4px solid #dc3545;">
            <i class="fas fa-exclamation-circle"></i> Erreur : <?= htmlspecialchars($_GET['error']) ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Liste des besoins à dispatcher (par ordre chronologique)</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID Besoin</th>
                            <th>Ville</th>
                            <th>Description du besoin</th>
                            <th>Type</th>
                            <th>Quantité demandée</th>
                            <th>Produits disponibles</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($besoins)): ?>
                            <?php foreach ($besoins as $besoin): ?>
                                <?php
                                    $idBesoin = is_object($besoin) ? $besoin->getIdBesoin() : ($besoin['idBesoin'] ?? $besoin['id_besoin'] ?? null);
                                    $idVille = is_object($besoin) ? $besoin->getIdVille() : ($besoin['idVille'] ?? $besoin['id_ville'] ?? null);
                                    $idType = is_object($besoin) ? $besoin->getIdType() : ($besoin['idType'] ?? $besoin['id_type'] ?? null);
                                    $valBesoin = is_object($besoin) ? $besoin->getValBesoin() : ($besoin['valBesoin'] ?? $besoin['val_besoin'] ?? 'N/A');

                                    // Utiliser la map pour le nom de la ville
                                    $villeName = isset($villeMap[$idVille]) ? $villeMap[$idVille] : 'Ville #' . $idVille;

                                    // Récupérer les produits liés au besoin
                                    $produitsList = [];
                                    $quantiteDemandeeTotal = 0;
                                    foreach ($produitBesoins as $pb) {
                                        $pbIdBesoin = is_object($pb) ? $pb->getIdBesoin() : ($pb['idBesoin'] ?? $pb['id_besoin'] ?? null);
                                        if ($pbIdBesoin == $idBesoin) {
                                            $idProduit = is_object($pb) ? $pb->getIdProduit() : ($pb['idProduit'] ?? $pb['id_produit'] ?? null);
                                            
                                            // Utiliser la map pour le nom du produit
                                            $produitName = isset($produitMap[$idProduit]) ? $produitMap[$idProduit] : 'Produit #' . $idProduit;
                                            
                                            // La quantité demandée vient de la map 
                                            $quantiteDemandee = isset($equiproduitMap[$idProduit]) ? $equiproduitMap[$idProduit] : 0;
                                            $quantiteDemandeeTotal += $quantiteDemandee;

                                            $produitsList[] = [
                                                'name' => $produitName,
                                                'idProduit' => $idProduit,
                                                'quantiteDemandee' => $quantiteDemandee
                                            ];
                                        }
                                    }
                                ?>
                                <tr>
                                    <td><strong>#<?= htmlspecialchars((string)($idBesoin ?? 0)) ?></strong></td>
                                    <td><?= htmlspecialchars($villeName ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($valBesoin ?? 'N/A') ?></td>
                                    <td><span class="badge" style="background: #667eea;">Type #<?= htmlspecialchars((string)($idType ?? 0)) ?></span></td>
                                    <td>
                                        <strong style="color: #e74c3c;">
                                            <?= number_format($quantiteDemandeeTotal, 2, ',', ' ') ?>
                                        </strong>
                                    </td>
                                    <td>
                                        <?php if (!empty($produitsList)): ?>
                                            <ul style="margin: 0; padding-left: 20px;">
                                                <?php foreach ($produitsList as $p): ?>
                                                    <li>
                                                        <?= htmlspecialchars($p['name']) ?>
                                                        <span style="color: #27ae60; font-weight: bold;">
                                                            (<?= number_format($p['quantiteDemandee'], 2, ',', ' ') ?> demandée)
                                                        </span>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        <?php else: ?>
                                            <span style="color: #999;">Aucun produit lié</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <form method="POST" action="<?= BASE_URL ?>/dispatchDate/dispatch" style="display: inline;">
                                            <input type="hidden" name="idBesoin" value="<?= htmlspecialchars((string)$idBesoin) ?>">
                                            <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Êtes-vous sûr de vouloir dispatcher ce besoin ?')">
                                                <i class="fas fa-paper-plane"></i> Dispatcher
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="7" style="text-align: center; padding: 40px; color: #999;">
                                    <i class="fas fa-inbox" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                    Aucun besoin enregistré
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
