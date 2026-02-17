<?php include __DIR__ . '/includes/header.php'; ?>

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

                                    // DEBUG: afficher les valeurs
                                    // echo "DEBUG - idVille: " . var_export($idVille, true) . " | Type: " . gettype($idVille) . "\n";

                                    // Récupérer le nom de la ville
                                    $villeName = 'Ville #' . ($idVille ?? 'vide');
                                    if ($idVille) {
                                        try {
                                            $villeObj = $controllerVille->getVilleById($idVille);
                                            if (is_object($villeObj)) {
                                                $villeName = $villeObj->getValVille() ?? ('Ville #' . $idVille);
                                            } elseif (isset($villeObj['valVille'])) {
                                                $villeName = $villeObj['valVille'] ?? ('Ville #' . $idVille);
                                            } elseif (isset($villeObj['val_ville'])) {
                                                $villeName = $villeObj['val_ville'] ?? ('Ville #' . $idVille);
                                            }
                                        } catch (\Exception $e) {
                                            $villeName = 'Ville #' . $idVille . ' (erreur)';
                                        }
                                    }

                                    // Récupérer les produits liés au besoin
                                    $produitsList = [];
                                    $quantiteDemandeeTotal = 0;
                                    foreach ($produitBesoins as $pb) {
                                        $pbIdBesoin = is_object($pb) ? $pb->getIdBesoin() : ($pb['idBesoin'] ?? $pb['id_besoin'] ?? null);
                                        if ($pbIdBesoin == $idBesoin) {
                                            $idProduit = is_object($pb) ? $pb->getIdProduit() : ($pb['idProduit'] ?? $pb['id_produit'] ?? null);
                                            
                                            // Récupérer le nom du produit
                                            $produitName = 'Produit #' . $idProduit;
                                            try {
                                                $prodObj = $controllerProduit->getProduitById($idProduit);
                                                if (is_object($prodObj)) {
                                                    $produitName = $prodObj->getValProduit() ?? ('Produit #' . $idProduit);
                                                } elseif (isset($prodObj['valProduit'])) {
                                                    $produitName = $prodObj['valProduit'] ?? ('Produit #' . $idProduit);
                                                } elseif (isset($prodObj['val_produit'])) {
                                                    $produitName = $prodObj['val_produit'] ?? ('Produit #' . $idProduit);
                                                }
                                            } catch (\Exception $e) {
                                                // Garder le nom par défaut
                                            }

                                            // Récupérer la quantité en stock
                                            $quantiteStock = 0;
                                            try {
                                                $quantiteStock = $controllerStockage->getQuantiteByProduitId($idProduit);
                                            } catch (\Exception $e) {
                                                $quantiteStock = 0;
                                            }

                                            // Récupérer la quantité demandée depuis EquivalenceProduit
                                            $quantiteDemandee = 0;
                                            try {
                                                $equivalenceProduits = $controllerEquivalenceProduit->getAllEquivalenceProduit();
                                                foreach ($equivalenceProduits as $ep) {
                                                    $epIdProduit = is_object($ep) ? $ep->getIdProduit() : ($ep['idProduit'] ?? $ep['id_produit'] ?? null);
                                                    if ($epIdProduit == $idProduit) {
                                                        $quantiteDemandee = is_object($ep) ? ($ep->getQuantite() ?? 0) : ($ep['quantite'] ?? $ep['quantité'] ?? 0);
                                                        break;
                                                    }
                                                }
                                            } catch (\Exception $e) {
                                                $quantiteDemandee = 0;
                                            }

                                            $quantiteDemandeeTotal += $quantiteDemandee;

                                            $produitsList[] = [
                                                'name' => $produitName,
                                                'quantite' => $quantiteStock,
                                                'idProduit' => $idProduit
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
                                                            (<?= number_format($p['quantite'], 2, ',', ' ') ?> disponible)
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
                                <td colspan="6" style="text-align: center; padding: 40px; color: #999;">
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

<?php include __DIR__ . '/includes/footer.php'; ?>
