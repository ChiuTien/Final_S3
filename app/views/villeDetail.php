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
                    echo htmlspecialchars($ville->getValVille());
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
        <!-- COLONNE 1: BESOINS -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i> Besoins
                    </h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <!-- Liste des besoins -->
                    <div class="flex-grow-1 mb-3">
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
                                        <th>Description</th>
                                        <th>Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($besoinsFiltered as $besoin): ?>
                                        <?php if (!is_object($besoin) && !is_array($besoin)) continue; ?>
                                        <tr>
                                            <td>
                                                <small><?= htmlspecialchars(is_object($besoin) ? $besoin->getValBesoin() : ($besoin['valBesoin'] ?? '')) ?></small>
                                            </td>
                                            <td>
                                                <small>
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
                                                </small>
                                            </td>
                                            <td>
                                                <a href="<?= BASE_URL ?>/produitBesoinInsert?idBesoin=<?= htmlspecialchars(is_object($besoin) ? $besoin->getIdBesoin() : ($besoin['idBesoin'] ?? '')) ?>" class="btn btn-sm btn-info" title="Ajouter produit">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="alert alert-warning alert-sm">Aucun besoin</div>
                        <?php endif; ?>
                    </div>

                    <!-- Formulaire d'ajout de besoin -->
                    <form method="POST" action="<?= BASE_URL ?>/villeDetail/besoin?id=<?= htmlspecialchars($idVille) ?>" class="border-top pt-3">
                        <h6 class="mb-2">Ajouter un besoin</h6>
                        <div class="form-group mb-2">
                            <textarea name="valBesoin" class="form-control form-control-sm" placeholder="Description" required></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <select name="idType" class="form-control form-control-sm" required>
                                <option value="">-- Type --</option>
                                <?php foreach ($types as $type): ?>
                                    <?php
                                        $typeVal = is_object($type) ? $type->getValType() : ($type['val'] ?? '');
                                        $typeId = is_object($type) ? $type->getIdType() : ($type['idType'] ?? '');
                                    ?>
                                    <option value="<?= htmlspecialchars($typeId) ?>">
                                        <?= htmlspecialchars($typeVal) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-sm btn-primary w-100">
                            <i class="fas fa-plus"></i> Ajouter
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- COLONNE 2: DONS -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-gift"></i> Dons
                    </h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <!-- Liste des dons -->
                    <div class="flex-grow-1 mb-3">
                        <?php if (!empty($dons)): ?>
                            <table class="table table-sm table-striped">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Produits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($dons as $don): ?>
                                        <?php if (!is_object($don) && !is_array($don)) continue; ?>
                                        <tr>
                                            <td>
                                                <small>
                                                    <?php 
                                                        $date = is_object($don) ? $don->getDateDon() : ($don['dateDon'] ?? null);
                                                        if ($date instanceof \DateTime) {
                                                            echo htmlspecialchars($date->format('Y-m-d'));
                                                        } else {
                                                            echo htmlspecialchars($date ?? '');
                                                        }
                                                    ?>
                                                </small>
                                            </td>
                                            <td>
                                                <small>
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
                                                            $prodVal = is_object($prod) ? $prod->getValProduit() : ($prod['valProduit'] ?? 'Produit');
                                                            return htmlspecialchars($prodVal);
                                                        }, $donDonnations)) ?: '-';
                                                    ?>
                                                </small>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php else: ?>
                            <div class="alert alert-warning alert-sm">Aucun don</div>
                        <?php endif; ?>
                    </div>

                    <!-- Formulaire d'ajout de don -->
                    <form method="POST" action="<?= BASE_URL ?>/villeDetail/don?id=<?= htmlspecialchars($idVille) ?>" class="border-top pt-3">
                        <h6 class="mb-2">Ajouter un don</h6>
                        <div class="form-group mb-2">
                            <input type="date" name="dateDon" class="form-control form-control-sm" required>
                        </div>
                        <div class="form-group mb-2">
                            <div id="produitContainer">
                                <div class="input-group input-group-sm mb-2">
                                    <select name="produits[0][idProduit]" class="form-control form-control-sm">
                                        <option value="">Produit</option>
                                        <?php foreach ($produits as $produit): ?>
                                            <?php
                                                $prodId = is_object($produit) ? $produit->getIdProduit() : ($produit['idProduit'] ?? '');
                                                $prodVal = is_object($produit) ? $produit->getValProduit() : ($produit['val'] ?? '');
                                            ?>
                                            <option value="<?= htmlspecialchars($prodId) ?>">
                                                <?= htmlspecialchars($prodVal) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <input type="number" name="produits[0][quantite]" class="form-control form-control-sm" placeholder="Qté" step="0.01" min="0">
                                    <button class="btn btn-outline-danger btn-sm" type="button" onclick="removeProduitLine(this)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary w-100 mb-2" onclick="addProduitLine()">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                        <button type="submit" class="btn btn-sm btn-success w-100">
                            <i class="fas fa-plus"></i> Ajouter
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- COLONNE 3: DISPATCHES -->
        <div class="col-md-4">
            <div class="card h-100">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-truck"></i> Dispatches
                    </h5>
                </div>
                <div class="card-body d-flex flex-column">
                    <!-- Liste des dispatch mère -->
                    <div class="flex-grow-1 mb-3">
                        <?php
                            $dispatchFiltered = array_filter($dispatchMeres, function($d) use ($idVille) {
                                $dVille = is_object($d) ? $d->getIdVille() : ($d['id_ville'] ?? null);
                                return $dVille == $idVille;
                            });
                        ?>
                        <?php if (!empty($dispatchFiltered)): ?>
                            <div class="list-group list-group-sm">
                                <?php foreach ($dispatchFiltered as $dispatch): ?>
                                    <?php if (!is_object($dispatch) && !is_array($dispatch)) continue; ?>
                                    <?php
                                        $dispatchId = is_object($dispatch) ? $dispatch->getIdDispatchMere() : ($dispatch['id_dispatch_mere'] ?? '');
                                        $dispatchDate = is_object($dispatch) ? $dispatch->getDateDispatch() : ($dispatch['date_dispatch'] ?? '');
                                        if ($dispatchDate instanceof \DateTime) {
                                            $dispatchDate = $dispatchDate->format('Y-m-d');
                                        }
                                    ?>
                                    <a href="<?= BASE_URL ?>/dispatchDetail?id=<?= htmlspecialchars($dispatchId) ?>" class="list-group-item list-group-item-action">
                                        <small>
                                            <strong>#<?= htmlspecialchars($dispatchId) ?></strong><br>
                                            <?= htmlspecialchars($dispatchDate) ?>
                                        </small>
                                    </a>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning alert-sm">Aucun dispatch</div>
                        <?php endif; ?>
                    </div>

                    <!-- Formulaire d'ajout de dispatch -->
                    <form method="POST" action="<?= BASE_URL ?>/villeDetail/dispatch?id=<?= htmlspecialchars($idVille) ?>" class="border-top pt-3">
                        <h6 class="mb-2">Ajouter un dispatch</h6>
                        <div class="form-group mb-2">
                            <input type="date" name="dateDispatch" class="form-control form-control-sm" required>
                        </div>
                        <button type="submit" class="btn btn-sm btn-warning w-100">
                            <i class="fas fa-plus"></i> Ajouter
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.alert-sm {
    padding: 0.25rem 0.5rem;
    font-size: 0.85rem;
    margin-bottom: 0;
}
.card {
    min-height: 600px;
}
</style>

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
