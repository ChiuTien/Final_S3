<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container-fluid mt-5">
    <div class="row mb-4">
        <div class="col-md-12">
            <h2>
                <i class="fas fa-shopping-cart"></i> Achat de Produits pour les Besoins
            </h2>
            <p class="text-muted">Frais d'achat appliqués: <strong><?= htmlspecialchars((string)($fraisAchat ?? 10)) ?>%</strong></p>
        </div>
    </div>

    <div class="row">
        <!-- COLONNE GAUCHE: FORMULAIRE D'ACHAT -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-plus-circle"></i> Ajouter un Achat
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/achat/acheter">
                        <div class="form-group mb-3">
                            <label class="form-label">Besoin:</label>
                            <select name="idBesoin" id="idBesoin" class="form-control form-control-sm" required>
                                <option value="">-- Sélectionner un besoin --</option>
                                <?php if (!empty($besoinsList)): ?>
                                    <?php foreach ($besoinsList as $besoin): ?>
                                        <option value="<?= htmlspecialchars((string)($besoin['id'] ?? '')) ?>">
                                            #<?= htmlspecialchars((string)($besoin['id'] ?? '')) ?> - <?= htmlspecialchars(substr($besoin['val'] ?? '', 0, 50)) ?>...
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Produit:</label>
                            <select name="idProduit" id="idProduit" class="form-control form-control-sm" required>
                                <option value="">-- Sélectionner un produit --</option>
                                <?php if (!empty($produitsList)): ?>
                                    <?php foreach ($produitsList as $produit): ?>
                                        <option value="<?= htmlspecialchars((string)($produit['id'] ?? '')) ?>" data-prix="<?= htmlspecialchars((string)($produit['prix'] ?? 0)) ?>">
                                            <?= htmlspecialchars($produit['name'] ?? '') ?> (<?= htmlspecialchars((string)($produit['prix'] ?? 0)) ?>€)
                                        </option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="form-label">Quantité:</label>
                            <input type="number" name="quantite" id="quantite" class="form-control form-control-sm" placeholder="Quantité" step="0.01" min="1" required>
                        </div>

                        <div class="alert alert-info">
                            <small>
                                <strong>Montant total:</strong> <span id="montantTotal">0.00</span>€<br>
                                <strong>Frais (<?= htmlspecialchars((string)($fraisAchat ?? 10)) ?>%):</strong> <span id="montantFrais">0.00</span>€<br>
                                <strong>Montant avec frais:</strong> <span id="montantAvecFrais" class="text-success">0.00</span>€
                            </small>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">
                            <i class="fas fa-cart-plus"></i> Ajouter à la simulation
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- COLONNE DROITE: LISTE DES ACHATS EN SIMULATION -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0">
                        <i class="fas fa-list"></i> Achats en Simulation (<?= htmlspecialchars((string)(count($achatsSimulationList ?? []) ?? 0)) ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <?php if (!empty($achatsSimulationList)): ?>
                        <table class="table table-sm table-striped">
                            <thead>
                                <tr>
                                    <th>Besoin</th>
                                    <th>Produit</th>
                                    <th>Qté</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                    $totalSimulation = 0;
                                    foreach ($achatsSimulationList as $achat): 
                                ?>
                                    <tr>
                                        <td><small>#<?= htmlspecialchars((string)($achat['idBesoin'] ?? '')) ?></small></td>
                                        <td><small><?= htmlspecialchars($achat['produitName'] ?? '-') ?></small></td>
                                        <td><small><?= htmlspecialchars((string)($achat['quantite'] ?? '')) ?></small></td>
                                        <td><small><?= htmlspecialchars(number_format($achat['montantAvecFrais'] ?? 0, 2)) ?>€</small></td>
                                    </tr>
                                    <?php $totalSimulation += floatval($achat['montantAvecFrais'] ?? 0); ?>
                                <?php endforeach; ?>
                                <tr class="table-active">
                                    <td colspan="3"><strong>TOTAL</strong></td>
                                    <td><strong><?= htmlspecialchars(number_format($totalSimulation, 2)) ?>€</strong></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="mt-3">
                            <a href="<?= BASE_URL ?>/simulation" class="btn btn-sm btn-success w-100">
                                <i class="fas fa-play"></i> Voir la Simulation
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            <i class="fas fa-info-circle"></i> Aucun achat en simulation
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script nonce="<?= $_SERVER['CSP_NONCE'] ?? '' ?>">
(function() {
    'use strict';
    
    const fraisAchat = <?= floatval($fraisAchat ?? 10) ?>;
    
    document.getElementById('quantite').addEventListener('change', calculerMontant);
    document.getElementById('idProduit').addEventListener('change', calculerMontant);

    function calculerMontant() {
        const select = document.getElementById('idProduit');
        const option = select.options[select.selectedIndex];
        const prix = parseFloat(option.getAttribute('data-prix')) || 0;
        const quantite = parseFloat(document.getElementById('quantite').value) || 0;
        
        const montantTotal = prix * quantite;
        const montantFrais = montantTotal * (fraisAchat / 100);
        const montantAvecFrais = montantTotal + montantFrais;
        
        document.getElementById('montantTotal').textContent = montantTotal.toFixed(2);
        document.getElementById('montantFrais').textContent = montantFrais.toFixed(2);
        document.getElementById('montantAvecFrais').textContent = montantAvecFrais.toFixed(2);
    }
})();
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
