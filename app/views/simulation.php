<?php
$achatsSimulation = $achatsSimulation ?? [];
$besoins = $besoins ?? [];
$produits = $produits ?? [];
$totalAchat = $totalAchat ?? 0;
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>
                <i class="fas fa-check-circle"></i> Simulation des Achats
            </h2>
            <p class="text-muted">Vérifiez et validez vos achats avant confirmation</p>
        </div>
    </div>

    <?php if (!empty($achatsSimulation)): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-table"></i> Achats à Valider (<?= count($achatsSimulation) ?>)
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
                                    <?php foreach ($achatsSimulation as $index => $achat): ?>
                                        <?php
                                            $achatId = is_object($achat) ? $achat->getIdAchat() : ($achat['idAchat'] ?? $index + 1);
                                            $besoinId = is_object($achat) ? $achat->getIdBesoin() : ($achat['idBesoin'] ?? null);
                                            $produitId = is_object($achat) ? $achat->getIdProduit() : ($achat['idProduit'] ?? null);
                                            $quantite = is_object($achat) ? $achat->getQuantiteAchetee() : ($achat['quantiteAchetee'] ?? 0);
                                            $prixUnitaire = is_object($achat) ? $achat->getPrixUnitaire() : ($achat['prixUnitaire'] ?? 0);
                                            $montantTotal = is_object($achat) ? $achat->getMontantTotal() : ($achat['montantTotal'] ?? 0);
                                            $montantFrais = is_object($achat) ? $achat->getMontantFrais() : ($achat['montantFrais'] ?? 0);
                                            $montantAvecFrais = is_object($achat) ? $achat->getMontantAvecFrais() : ($achat['montantAvecFrais'] ?? 0);
                                            
                                            // Récupérer le besoin et produit pour afficher les noms
                                            $besoinObj = null;
                                            $produitObj = null;
                                            
                                            foreach ($besoins as $b) {
                                                $bid = is_object($b) ? $b->getIdBesoin() : ($b['idBesoin'] ?? null);
                                                if ($bid == $besoinId) {
                                                    $besoinObj = $b;
                                                    break;
                                                }
                                            }
                                            
                                            foreach ($produits as $p) {
                                                $pid = is_object($p) ? $p->getIdProduit() : ($p['idProduit'] ?? null);
                                                if ($pid == $produitId) {
                                                    $produitObj = $p;
                                                    break;
                                                }
                                            }
                                            
                                            $besoinVal = $besoinObj ? (is_object($besoinObj) ? substr($besoinObj->getValBesoin(), 0, 30) : substr($besoinObj['valBesoin'] ?? '', 0, 30)) : 'N/A';
                                            $produitVal = $produitObj ? (is_object($produitObj) ? $produitObj->getValProduit() : $produitObj['val'] ?? '') : 'N/A';
                                        ?>
                                        <tr>
                                            <td><small>#<?= htmlspecialchars($achatId) ?></small></td>
                                            <td><small><?= htmlspecialchars($besoinVal) ?></small></td>
                                            <td><small><?= htmlspecialchars($produitVal) ?></small></td>
                                            <td class="text-center"><small><?= htmlspecialchars(number_format($quantite, 2)) ?></small></td>
                                            <td class="text-right"><small><?= htmlspecialchars(number_format($prixUnitaire, 2)) ?>€</small></td>
                                            <td class="text-right"><small><?= htmlspecialchars(number_format($montantTotal, 2)) ?>€</small></td>
                                            <td class="text-right"><small><span class="text-warning"><?= htmlspecialchars(number_format($montantFrais, 2)) ?>€</span></small></td>
                                            <td class="text-right"><small><strong><?= htmlspecialchars(number_format($montantAvecFrais, 2)) ?>€</strong></small></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="table-active fw-bold">
                                        <td colspan="7" class="text-right">TOTAL À VALIDER:</td>
                                        <td class="text-right"><strong class="text-success"><?= htmlspecialchars(number_format($totalAchat, 2)) ?>€</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-6">
                                <form method="POST" action="<?= BASE_URL ?>/simulation/valider" style="display: inline;">
                                    <button type="submit" class="btn btn-success w-100" onclick="return confirm('Êtes-vous sûr de vouloir valider tous les achats?');">
                                        <i class="fas fa-check"></i> Valider tous les achats
                                    </button>
                                </form>
                            </div>
                            <div class="col-md-6">
                                <form method="POST" action="<?= BASE_URL ?>/simulation/rejeter" style="display: inline;">
                                    <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Êtes-vous sûr de vouloir annuler la simulation et revenir à la saisie?');">
                                        <i class="fas fa-times"></i> Annuler et revenir à l'achat
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <strong>Aucun achat en simulation!</strong> Veuillez d'abord ajouter des achats.
                    <a href="<?= BASE_URL ?>/achat" class="alert-link">Retour à l'achat</a>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include 'includes/footer.php'; ?>
