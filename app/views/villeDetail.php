<?php
$idVille = $idVille ?? null;
$ville = $ville ?? null;
$besoins = $besoins ?? [];
$dons = $dons ?? [];
$donnations = $donnations ?? [];
$dispatchMeres = $dispatchMeres ?? [];
$types = $types ?? [];
$produits = $produits ?? [];
$produitBesoins = $produitBesoins ?? [];

// Vérifier que idVille est défini
if (!$idVille) {
    echo '<div class="alert alert-danger">Erreur: Aucune ville sélectionnée.</div>';
    exit;
}
?>

<?php include 'includes/header.php'; ?>

<div class="container-fluid mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <?php if (!$idVille): ?>
                <div class="alert alert-danger">
                    <strong>Erreur:</strong> Aucune ville sélectionnée.
                </div>
                <a href="<?= BASE_URL ?>/villes" class="btn btn-secondary btn-sm">
                    <i class="fas fa-arrow-left"></i> Retour aux villes
                </a>
                <?php include 'includes/footer.php'; exit; ?>
            <?php endif; ?>
            
            <h2>
                <i class="fas fa-city"></i>
                Détails de la ville: 
                <?php if (is_object($ville)) {
                    echo htmlspecialchars($ville->getVal());
                } elseif (is_array($ville)) {
                    echo htmlspecialchars($ville['val'] ?? '');
                } else {
                    echo 'Ville non trouvée';
                } ?>
            </h2>
            <a href="<?= BASE_URL ?>/villes" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Retour aux villes
            </a>
        </div>
    </div>

    <div class="row">
        <!-- COLONNE GAUCHE: BESOINS -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i> Besoins de la ville
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Formulaire d'ajout de besoin -->
                    <form method="POST" action="<?= BASE_URL ?>/villeDetail/besoin?id=<?= htmlspecialchars($idVille) ?>" class="mb-4 p-3 bg-light border rounded">
                        <h6 class="mb-3">Ajouter un nouveau besoin</h6>
                        <div class="form-group mb-2">
                            <label class="form-label">Description:</label>
                            <textarea name="valBesoin" class="form-control form-control-sm" placeholder="Description du besoin" required></textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Type:</label>
                            <select name="idType" class="form-control form-control-sm" required>
                                <option value="">-- Sélectionner un type --</option>
                                <?php foreach ($types as $type): ?>
                                    <?php
                                        $typeVal = is_object($type) ? $type->getVal() : ($type['val'] ?? '');
                                        $typeId = is_object($type) ? $type->getIdType() : ($type['idType'] ?? '');
                                    ?>
                                    <option value="<?= htmlspecialchars($typeId) ?>">
                                        <?= htmlspecialchars($typeVal) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <i class="fas fa-plus"></i> Ajouter besoin
                        </button>
                    </form>

                    <!-- Liste des besoins -->
                    <?php
                        $besoinsFiltered = array_filter($besoins, function($b) use ($idVille) {
                            if (!is_object($b) && !is_array($b)) return false;
                            $bIdVille = is_object($b) ? $b->getIdVille() : ($b['idVille'] ?? null);
                            return $bIdVille == $idVille;
                        });
                    ?>
                    <?php if (!empty($besoinsFiltered)): ?>
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Description</th>
                                    <th>Type</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($besoinsFiltered as $besoin): ?>
                                    <?php if (!is_object($besoin) && !is_array($besoin)) continue; ?>
                                    <tr>
                                        <td><?= htmlspecialchars(is_object($besoin) ? $besoin->getIdBesoin() : ($besoin['idBesoin'] ?? '')) ?></td>
                                        <td><?= htmlspecialchars(is_object($besoin) ? $besoin->getValBesoin() : ($besoin['valBesoin'] ?? '')) ?></td>
                                        <td>
                                            <?php
                                                $typeId = is_object($besoin) ? $besoin->getIdType() : ($besoin['idType'] ?? null);
                                                $foundType = array_filter($types, function($t) use ($typeId) {
                                                    $tId = is_object($t) ? $t->getIdType() : ($t['idType'] ?? null);
                                                    return $tId == $typeId;
                                                });
                                                $type = reset($foundType);
                                                if ($type) {
                                                    echo htmlspecialchars(is_object($type) ? $type->getVal() : ($type['val'] ?? ''));
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <a href="<?= BASE_URL ?>/produitBesoinInsert?idBesoin=<?= htmlspecialchars(is_object($besoin) ? $besoin->getIdBesoin() : ($besoin['idBesoin'] ?? '')) ?>" class="btn btn-sm btn-info" title="Ajouter produit">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    <!-- Sous-tableau: Produits du besoin -->
                                    <tr>
                                        <td colspan="4">
                                            <small>
                                                <strong>Produits:</strong>
                                                <?php
                                                    $besoinId = is_object($besoin) ? $besoin->getIdBesoin() : ($besoin['idBesoin'] ?? null);
                                                    $produitsBesoin = array_filter($produitBesoins, function($pb) use ($besoinId) {
                                                        $pbBesoinId = is_object($pb) ? $pb->getIdBesoin() : ($pb['idBesoin'] ?? null);
                                                        return $pbBesoinId == $besoinId;
                                                    });
                                                    
                                                    echo implode(', ', array_map(function($pb) use ($produits) {
                                                        $prodId = is_object($pb) ? $pb->getIdProduit() : ($pb['idProduit'] ?? null);
                                                        $prod = array_filter($produits, function($p) use ($prodId) {
                                                            $pId = is_object($p) ? $p->getIdProduit() : ($p['idProduit'] ?? null);
                                                            return $pId == $prodId;
                                                        });
                                                        $prod = reset($prod);
                                                        return htmlspecialchars(is_object($prod) ? $prod->getVal() : ($prod['val'] ?? 'Produit'));
                                                    }, $produitsBesoin)) ?: 'Pas de produits';
                                                ?>
                                            </small>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-warning">Pas de besoins pour cette ville.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- COLONNE DROITE: DONS ET DISPATCH -->
        <div class="col-md-6">
            <!-- DONS ET DONNATIONS -->
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-gift"></i> Dons et Donations
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Formulaire d'ajout de don -->
                    <form method="POST" action="<?= BASE_URL ?>/villeDetail/don?id=<?= htmlspecialchars($idVille) ?>" class="mb-4 p-3 bg-light border rounded">
                        <h6 class="mb-3">Ajouter un nouveau don</h6>
                        <div class="form-group mb-2">
                            <label for="dateDon" class="form-label">Date du don:</label>
                            <input type="date" id="dateDon" name="dateDon" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group mb-3">
                            <label class="form-label">Produits:</label>
                            <div id="produitContainer">
                                <div class="input-group input-group-sm mb-2">
                                    <select name="produits[0][idProduit]" class="form-control form-control-sm">
                                        <option value="">-- Sélectionner un produit --</option>
                                        <?php foreach ($produits as $produit): ?>
                                            <?php
                                                $prodId = is_object($produit) ? $produit->getIdProduit() : ($produit['idProduit'] ?? '');
                                                $prodVal = is_object($produit) ? $produit->getVal() : ($produit['val'] ?? '');
                                            ?>
                                            <option value="<?= htmlspecialchars($prodId) ?>">
                                                <?= htmlspecialchars($prodVal) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="number" name="produits[0][quantite]" class="form-control form-control-sm" placeholder="Quantité" step="0.01" min="0">
                                    <button class="btn btn-outline-danger btn-sm" type="button" onclick="removeProduitLine(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary mb-2" onclick="addProduitLine()">
                                <i class="fas fa-plus"></i> Ajouter produit
                            </button>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success">
                            <i class="fas fa-plus"></i> Ajouter don
                        </button>
                    </form>

                    <!-- Liste des dons -->
                    <?php if (!empty($dons)): ?>
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Date</th>
                                    <th>Produits</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($dons as $don): ?>
                                    <?php if (!is_object($don) && !is_array($don)) continue; ?>
                                    <tr>
                                        <td><?= htmlspecialchars(is_object($don) ? $don->getIdDon() : ($don['idDon'] ?? '')) ?></td>
                                        <td>
                                            <?php 
                                                $date = is_object($don) ? $don->getDateDon() : ($don['dateDon'] ?? null);
                                                if ($date instanceof \DateTime) {
                                                    echo htmlspecialchars($date->format('Y-m-d'));
                                                } else {
                                                    echo htmlspecialchars($date ?? '');
                                                }
                                            ?>
                                        </td>
                                        <td>
                                            <?php
                                                $donId = is_object($don) ? $don->getIdDon() : ($don['idDon'] ?? null);
                                                $donDonnations = array_filter($donnations, function($d) use ($donId) {
                                                    $dId = is_object($d) ? $d->getIdDon() : ($d['idDon'] ?? null);
                                                    return $dId == $donId;
                                                });
                                                echo implode(', ', array_map(function($d) use ($produits) {
                                                    $prodId = is_object($d) ? $d->getIdProduit() : ($d['idProduit'] ?? null);
                                                    $prod = array_filter($produits, function($p) use ($prodId) {
                                                        $pId = is_object($p) ? $p->getIdProduit() : ($p['idProduit'] ?? null);
                                                        return $pId == $prodId;
                                                    });
                                                    $prod = reset($prod);
                                                    $prodVal = is_object($prod) ? $prod->getVal() : ($prod['val'] ?? 'Produit');
                                                    $qty = is_object($d) ? $d->getQuantiteProduit() : ($d['quantiteProduit'] ?? '');
                                                    return htmlspecialchars($prodVal) . ' (' . htmlspecialchars($qty) . ')';
                                                }, $donDonnations)) ?: 'Pas de produits';
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <div class="alert alert-warning">Pas de dons pour cette ville.</div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- DISPATCH MÈRE ET FILLES -->
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-truck"></i> Dispatches
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Formulaire d'ajout de dispatch mère -->
                    <form method="POST" action="<?= BASE_URL ?>/villeDetail/dispatch?id=<?= htmlspecialchars($idVille) ?>" class="mb-4 p-3 bg-light border rounded">
                        <h6 class="mb-3">Ajouter un nouveau dispatch</h6>
                        <div class="form-group mb-3">
                            <label for="dateDispatch" class="form-label">Date du dispatch:</label>
                            <input type="date" id="dateDispatch" name="dateDispatch" class="form-control form-control-sm" required>
                        </div>
                        <button type="submit" class="btn btn-sm btn-warning">
                            <i class="fas fa-plus"></i> Ajouter dispatch
                        </button>
                    </form>

                    <!-- Liste des dispatch mère avec filles -->
                    <?php
                        $dispatchFiltered = array_filter($dispatchMeres, function($d) use ($idVille) {
                            $dVille = is_object($d) ? $d->getIdVille() : ($d['id_ville'] ?? null);
                            return $dVille == $idVille;
                        });
                    ?>
                    <?php if (!empty($dispatchFiltered)): ?>
                        <div class="accordion" id="dispatchAccordion">
                            <?php foreach ($dispatchFiltered as $index => $dispatch): ?>
                                <?php if (!is_object($dispatch) && !is_array($dispatch)) continue; ?>
                                <?php
                                    $dispatchId = is_object($dispatch) ? $dispatch->getIdDispatchMere() : ($dispatch['id_dispatch_mere'] ?? '');
                                    $dispatchDate = is_object($dispatch) ? $dispatch->getDateDispatch() : ($dispatch['date_dispatch'] ?? '');
                                    if ($dispatchDate instanceof \DateTime) {
                                        $dispatchDate = $dispatchDate->format('Y-m-d');
                                    }
                                ?>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingDispatch<?= $index ?>">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDispatch<?= $index ?>">
                                            <strong>Dispatch #<?= htmlspecialchars($dispatchId) ?></strong> — <?= htmlspecialchars($dispatchDate) ?>
                                        </button>
                                    </h2>
                                    <div id="collapseDispatch<?= $index ?>" class="accordion-collapse collapse" data-bs-parent="#dispatchAccordion">
                                        <div class="accordion-body p-3">
                                            <a href="<?= BASE_URL ?>/dispatchDetail?id=<?= htmlspecialchars($dispatchId) ?>" class="btn btn-sm btn-info mb-3">
                                                <i class="fas fa-eye"></i> Voir détails & ajouter produits
                                            </a>
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Produit</th>
                                                        <th>Quantité</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        // Note: Need to fetch dispatch filles for this dispatch
                                                        // For now, display message that details are in dispatchDetail page
                                                    ?>
                                                    <tr>
                                                        <td colspan="2" class="text-muted small">
                                                            Cliquez sur "Voir détails" pour voir et ajouter des produits.
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">Pas de dispatches pour cette ville.</div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Gestion des champs produit dynamiques pour le don
let produitIndex = 1;

function addProduitLine() {
    const container = document.getElementById('produitContainer');
    const newLine = document.createElement('div');
    newLine.className = 'input-group input-group-sm mb-2';
    
    // Récupérer les produits depuis le premier select
    const firstSelect = container.querySelector('select');
    let optionsHTML = '';
    if (firstSelect) {
        optionsHTML = firstSelect.innerHTML;
    }
    
    newLine.innerHTML = `
        <select name="produits[${produitIndex}][idProduit]" class="form-control form-control-sm">
            ${optionsHTML}
        </select>
        <input type="number" name="produits[${produitIndex}][quantite]" class="form-control form-control-sm" placeholder="Quantité" step="0.01" min="0">
        <button class="btn btn-outline-danger btn-sm" type="button" onclick="removeProduitLine(this)">
            <i class="fas fa-trash"></i>
        </button>
    `;
    container.appendChild(newLine);
    produitIndex++;
}

function removeProduitLine(btn) {
    // Vérifier qu'il y a au moins une ligne
    const container = document.getElementById('produitContainer');
    const lines = container.querySelectorAll('.input-group');
    if (lines.length > 1) {
        btn.closest('.input-group').remove();
    } else {
        alert('Vous devez garder au moins un champ produit.');
    }
}
</script>

<?php include 'includes/footer.php'; ?>
