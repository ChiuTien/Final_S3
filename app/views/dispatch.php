<?php

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

        <!-- Tableau dynamique demandé: ville | date (Equivalence_date) | quantité (Donnation) | prix (EquivalenceProduit) | voir plus -->
        <div class="card mt-4">
            <div class="card-header"><h5>Aperçu par Ville</h5></div>
            <div class="card-body">
                <?php
                    $equivalenceDates = [];
                    if (isset($controllerEquivalence)) {
                        $equivalenceDates = $controllerEquivalence->getAllEquivalenceDate();
                    }
                    $produitBesoins = $controllerProduitBesoin->getAllProduitBesoin();
                    $equivalenceProduits = [];
                    if (isset($controllerEquivalenceProduit)) {
                        $equivalenceProduits = $controllerEquivalenceProduit->getAllEquivalenceProduit();
                    }
                ?>

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
                            <?php if (!empty($villes)): ?>
                                <?php foreach ($villes as $ville): ?>
                                    <?php
                                        $villeId = is_object($ville) ? $ville->getIdVille() : (isset($ville['idVille']) ? $ville['idVille'] : (isset($ville['id_ville']) ? $ville['id_ville'] : null));
                                        $villeName = is_object($ville) ? $ville->getValVille() : (isset($ville['valVille']) ? $ville['valVille'] : (isset($ville['val_ville']) ? $ville['val_ville'] : 'Ville'));

                                        // Trouver un besoin pour la ville
                                        $besoinTrouve = null;
                                        $besoins = $controllerBesoin->getAllBesoin();
                                        foreach ($besoins as $b) {
                                            $bIdVille = is_object($b) ? $b->getIdVille() : ($b['idVille'] ?? $b['id_ville'] ?? null);
                                            if ($bIdVille == $villeId) { $besoinTrouve = is_object($b) ? $b->getIdBesoin() : ($b['idBesoin'] ?? $b['id_besoin'] ?? null); break; }
                                        }

                                        // Date équivalence pour ce besoin
                                        $dateEquivalence = 'N/A';
                                        if ($besoinTrouve) {
                                            foreach ($equivalenceDates as $ed) {
                                                $edIdBesoin = is_object($ed) ? ($ed->getIdBesoin() ?? null) : ($ed['id_besoin'] ?? null);
                                                $edDate = is_object($ed) ? ($ed->getDateEquivalence() ?? null) : ($ed['date_equivalence'] ?? null);
                                                if ($edIdBesoin == $besoinTrouve) { $dateEquivalence = $edDate; break; }
                                            }
                                        }

                                        // Trouver un produit lié au besoin
                                        $produitId = null;
                                        if ($besoinTrouve) {
                                            foreach ($produitBesoins as $pb) {
                                                $pbIdBesoin = is_object($pb) ? $pb->getIdBesoin() : ($pb['idBesoin'] ?? $pb['id_besoin'] ?? null);
                                                if ($pbIdBesoin == $besoinTrouve) { $produitId = is_object($pb) ? $pb->getIdProduit() : ($pb['idProduit'] ?? $pb['id_produit'] ?? null); break; }
                                            }
                                        }

                                        // Quantité totale donnée pour ce produit
                                        $quantiteDonnee = 'N/A';
                                        if ($produitId && isset($controllerDonnation)) {
                                            $quantiteDonnee = $controllerDonnation->getQuantiteProduitByIdProduit($produitId);
                                        }

                                        // Prix d'équivalence pour ce produit
                                        $prixEquivalence = 'N/A';
                                        if ($produitId) {
                                            foreach ($equivalenceProduits as $ep) {
                                                $epIdProduit = is_object($ep) ? $ep->getIdProduit() : ($ep['idProduit'] ?? $ep['id_produit'] ?? null);
                                                if ($epIdProduit == $produitId) { $prixEquivalence = is_object($ep) ? $ep->getPrix() : ($ep['prix'] ?? $ep['price'] ?? 'N/A'); break; }
                                            }
                                        }
                                    ?>
                                    <tr>
                                        <td><?= htmlspecialchars($villeName) ?></td>
                                        <td><?= htmlspecialchars($dateEquivalence ?? 'N/A') ?></td>
                                        <td><?= htmlspecialchars((string)$quantiteDonnee) ?></td>
                                        <td><?= htmlspecialchars((string)$prixEquivalence) ?></td>
                                        <?php
                                            // Construire une liste HTML des produits liés au besoin
                                            $lines = [];
                                            if ($besoinTrouve) {
                                                foreach ($produitBesoins as $pbItem) {
                                                    $pbIdBesoin = is_object($pbItem) ? $pbItem->getIdBesoin() : ($pbItem['idBesoin'] ?? $pbItem['id_besoin'] ?? null);
                                                    if ($pbIdBesoin == $besoinTrouve) {
                                                        $pbIdProduit = is_object($pbItem) ? $pbItem->getIdProduit() : ($pbItem['idProduit'] ?? $pbItem['id_produit'] ?? null);
                                                        $pName = 'Produit #' . ($pbIdProduit ?? '');
                                                        if (isset($controllerProduit)) {
                                                            $pObj = $controllerProduit->getProduitById($pbIdProduit);
                                                            if ($pObj) $pName = is_object($pObj) ? $pObj->getValProduit() : ($pObj['valProduit'] ?? $pObj['val_produit'] ?? $pName);
                                                        }
                                                        $pQuant = 'N/A';
                                                        if (isset($controllerDonnation)) {
                                                            $pQuant = $controllerDonnation->getQuantiteProduitByIdProduit($pbIdProduit);
                                                        }
                                                        $pPrix = 'N/A';
                                                        if (!empty($equivalenceProduits)) {
                                                            foreach ($equivalenceProduits as $ep) {
                                                                $epIdProduit = is_object($ep) ? $ep->getIdProduit() : ($ep['idProduit'] ?? $ep['id_produit'] ?? null);
                                                                if ($epIdProduit == $pbIdProduit) { $pPrix = is_object($ep) ? $ep->getPrix() : ($ep['prix'] ?? $ep['price'] ?? 'N/A'); break; }
                                                            }
                                                        }
                                                        $lines[] = ['name' => $pName, 'quant' => $pQuant, 'prix' => $pPrix];
                                                    }
                                                }
                                            }
                                        ?>
                                        <td>
                                            <?php if (!empty($lines)): ?>
                                                <ul class="mb-0">
                                                    <?php foreach ($lines as $l): ?>
                                                        <li><?= htmlspecialchars($l['name']) ?> — Quantité: <?= htmlspecialchars((string)$l['quant']) ?> — Prix: <?= htmlspecialchars((string)$l['prix']) ?></li>
                                                    <?php endforeach; ?>
                                                </ul>
                                            <?php else: ?>
                                                <span class="text-muted">Aucun produit lié</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center text-muted">Aucune ville disponible</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        

    <?php include __DIR__ . '/includes/footer.php'; ?>
