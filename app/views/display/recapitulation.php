<?php
$stats = $stats ?? [];
$achatsValides = $achatsValides ?? [];
$besoins = $besoins ?? [];
$produits = $produits ?? [];

$totalBesoins = $stats['totalBesoins'] ?? 0;
$montantTotal = $stats['montantTotal'] ?? 0;
$montantRestant = $stats['montantRestant'] ?? 0;
$pourcentageCompletion = $totalBesoins > 0 ? min(100, ($montantTotal / $totalBesoins) * 100) : 0;
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>
                <i class="fas fa-chart-pie"></i> Récapitulation des Achats
            </h2>
            <p class="text-muted">Vue d'ensemble des achats validés et des besoins à satisfaire</p>
        </div>
    </div>

    <!-- SECTION STATISTIQUES -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center border-primary">
                <div class="card-body">
                    <h6 class="card-title text-muted">Total des Besoins</h6>
                    <h3 class="text-primary"><?= htmlspecialchars(number_format($totalBesoins, 2)) ?>€</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-success">
                <div class="card-body">
                    <h6 class="card-title text-muted">Montant Satisfait</h6>
                    <h3 class="text-success"><?= htmlspecialchars(number_format($montantTotal, 2)) ?>€</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-danger">
                <div class="card-body">
                    <h6 class="card-title text-muted">Montant Restant</h6>
                    <h3 class="text-danger"><?= htmlspecialchars(number_format($montantRestant, 2)) ?>€</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card text-center border-info">
                <div class="card-body">
                    <h6 class="card-title text-muted">Taux de Complétion</h6>
                    <h3 class="text-info"><?= htmlspecialchars(number_format($pourcentageCompletion, 1)) ?>%</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- BARRE DE PROGRESSION -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="progress" style="height: 25px;">
                        <div class="progress-bar bg-success" role="progressbar" style="width: <?= htmlspecialchars($pourcentageCompletion) ?>%;" aria-valuenow="<?= htmlspecialchars($pourcentageCompletion) ?>" aria-valuemin="0" aria-valuemax="100">
                            <small><?= htmlspecialchars(number_format($pourcentageCompletion, 1)) ?>% Complété</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION ACHATS VALIDÉS -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-check-double"></i> Achats Validés (<?= count($achatsValides) ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($achatsValides)): ?>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Date</th>
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
                                    <?php foreach ($achatsValides as $achat): ?>
                                        <?php
                                            $achatId = is_object($achat) ? $achat->getIdAchat() : ($achat['idAchat'] ?? '');
                                            $dateAchat = is_object($achat) ? $achat->getDateAchat() : ($achat['dateAchat'] ?? '');
                                            $besoinId = is_object($achat) ? $achat->getIdBesoin() : ($achat['idBesoin'] ?? null);
                                            $produitId = is_object($achat) ? $achat->getIdProduit() : ($achat['idProduit'] ?? null);
                                            $quantite = is_object($achat) ? $achat->getQuantiteAchetee() : ($achat['quantiteAchetee'] ?? 0);
                                            $prixUnitaire = is_object($achat) ? $achat->getPrixUnitaire() : ($achat['prixUnitaire'] ?? 0);
                                            $montantTotal = is_object($achat) ? $achat->getMontantTotal() : ($achat['montantTotal'] ?? 0);
                                            $montantFrais = is_object($achat) ? $achat->getMontantFrais() : ($achat['montantFrais'] ?? 0);
                                            $montantAvecFrais = is_object($achat) ? $achat->getMontantAvecFrais() : ($achat['montantAvecFrais'] ?? 0);
                                            
                                            // Mettre en forme la date
                                            $dateFormatee = $dateAchat;
                                            if ($dateAchat) {
                                                try {
                                                    $date = new DateTime($dateAchat);
                                                    $dateFormatee = $date->format('d/m/Y H:i');
                                                } catch (Exception $e) {
                                                    // Garder la date comme est
                                                }
                                            }
                                            
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
                                            $produitVal = $produitObj ? (is_object($produitObj) ? $produitObj->getVal() : $produitObj['val'] ?? '') : 'N/A';
                                        ?>
                                        <tr>
                                            <td><small>#<?= htmlspecialchars($achatId) ?></small></td>
                                            <td><small><?= htmlspecialchars($dateFormatee) ?></small></td>
                                            <td><small><?= htmlspecialchars($besoinVal) ?></small></td>
                                            <td><small><?= htmlspecialchars($produitVal) ?></small></td>
                                            <td class="text-center"><small><?= htmlspecialchars(number_format($quantite, 2)) ?></small></td>
                                            <td class="text-right"><small><?= htmlspecialchars(number_format($prixUnitaire, 2)) ?>€</small></td>
                                            <td class="text-right"><small><?= htmlspecialchars(number_format($montantTotal, 2)) ?>€</small></td>
                                            <td class="text-right"><small><span class="text-warning"><?= htmlspecialchars(number_format($montantFrais, 2)) ?>€</span></small></td>
                                            <td class="text-right"><small><strong class="text-success"><?= htmlspecialchars(number_format($montantAvecFrais, 2)) ?>€</strong></small></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <tr class="table-active fw-bold">
                                        <td colspan="8" class="text-right">TOTAL ACQUIS:</td>
                                        <td class="text-right"><strong class="text-success"><?= htmlspecialchars(number_format($montantTotal, 2)) ?>€</strong></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-3">
                            <a href="<?= BASE_URL ?>/achat" class="btn btn-primary">
                                <i class="fas fa-plus-circle"></i> Effectuer d'autres achats
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> Aucun achat validé pour le moment.
                            <a href="<?= BASE_URL ?>/achat" class="alert-link">Créer un achat</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
