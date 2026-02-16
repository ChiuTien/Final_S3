<?php include __DIR__ . '/includes/header.php'; ?>

<div class="container">
    <div class="page-title">
        <h2>
            <i class="fas fa-gift"></i>
            Liste des dons
        </h2>
        <p>Consultez et filtrez les dons par ville</p>
    </div>

    <!-- Filtres -->
    <div class="filter-section">
        <div class="filter-group">
            <label for="filterDonVille"><i class="fas fa-filter"></i> Filtrer par ville</label>
            <select class="filter-select" id="filterDonVille" onchange="filterDonsByVille()">
                <option value="">Toutes les villes</option>
                <option value="Antananarivo">Antananarivo</option>
                <option value="Toamasina">Toamasina</option>
                <option value="Mahajanga">Mahajanga</option>
                <option value="Fianarantsoa">Fianarantsoa</option>
                <option value="Toliara">Toliara</option>
                <option value="Antsiranana">Antsiranana</option>
                <option value="Non attribué">Non attribué</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="filterDonType">Filtrer par type</label>
            <select class="filter-select" id="filterDonType">
                <option value="">Tous les types</option>
                <option value="nature">Nature</option>
                <option value="materiaux">Matériaux</option>
                <option value="argent">Argent</option>
            </select>
        </div>
        <div class="filter-group">
            <label for="filterDonStatut">Filtrer par statut</label>
            <select class="filter-select" id="filterDonStatut">
                <option value="">Tous</option>
                <option value="distribue">Distribué</option>
                <option value="en-attente">En attente</option>
                <option value="urgent">Urgent</option>
            </select>
        </div>
        <button class="btn btn-primary">
            <i class="fas fa-search"></i> Appliquer les filtres
        </button>
    </div>

    <!-- Statistiques -->
    <div class="stats-container">
        <div class="stat-item">
            <i class="fas fa-gift"></i>
            <div class="stat-number"><?= count($dons ?? []) ?></div>
            <div class="stat-label">Dons totaux</div>
        </div>
        <div class="stat-item" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%);">
            <i class="fas fa-box"></i>
            <div class="stat-number"><?= count($donnations ?? []) ?></div>
            <div class="stat-label">Articles donnés</div>
        </div>
        <div class="stat-item" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
            <i class="fas fa-coins"></i>
            <div class="stat-number"><?php 
                $total = 0;
                if(isset($dons)) {
                    foreach($dons as $don) {
                        $total += $don->getTotalPrix();
                    }
                }
                echo number_format($total, 0, ',', ' ') . ' Ar';
            ?></div>
            <div class="stat-label">Valeur totale</div>
        </div>
        <div class="stat-item" style="background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);">
            <i class="fas fa-calendar"></i>
            <div class="stat-number"><?php 
                if(isset($dons) && count($dons) > 0) {
                    echo $dons[0]->getDateDon()->format('d/m/Y');
                } else {
                    echo date('d/m/Y');
                }
            ?></div>
            <div class="stat-label">Dernier don</div>
        </div>
    </div>

    <!-- Liste des dons -->
    <div class="card">
        <div class="card-header">
            <h5>Tous les dons</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID Don</th>
                            <th>Date</th>
                            <th>Valeur totale (Ar)</th>
                            <th>Articles donnés</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($dons) && count($dons) > 0): ?>
                            <?php foreach($dons as $don): ?>
                                <tr>
                                    <td><strong>#<?= $don->getIdDon() ?></strong></td>
                                    <td><?= $don->getDateDon()->format('d/m/Y') ?></td>
                                    <td><?= number_format($don->getTotalPrix(), 0, ',', ' ') ?> Ar</td>
                                    <td>
                                        <?php 
                                        $countArticles = 0;
                                        if(isset($donnations)) {
                                            foreach($donnations as $donnation) {
                                                if($donnation->getIdDon() == $don->getIdDon()) {
                                                    $countArticles++;
                                                }
                                            }
                                        }
                                        echo $countArticles . ' article(s)';
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">Aucun don enregistré</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Liste des donnations (détails des produits donnés) -->
    <div class="card" style="margin-top: 20px;">
        <div class="card-header">
            <h5>Détails des produits donnés</h5>
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
                        <?php if(isset($donnations) && count($donnations) > 0): ?>
                            <?php foreach($donnations as $donnation): ?>
                                <tr>
                                    <td><strong>#<?= $donnation->getIdDonnation() ?></strong></td>
                                    <td>Don #<?= $donnation->getIdDon() ?></td>
                                    <td>Produit #<?= $donnation->getIdProduit() ?></td>
                                    <td><?= number_format($donnation->getQuantiteProduit(), 2, ',', ' ') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center;">Aucune donnation enregistrée</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Résumé des dons -->
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-box" style="font-size: 2rem; color: var(--primary-color);"></i>
                    <h3 style="margin: 10px 0;"><?= count($donnations ?? []) ?></h3>
                    <p>Total articles donnés</p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-coins" style="font-size: 2rem; color: var(--success-color);"></i>
                    <h3 style="margin: 10px 0;"><?php 
                        $total = 0;
                        if(isset($dons)) {
                            foreach($dons as $don) {
                                $total += $don->getTotalPrix();
                            }
                        }
                        echo number_format($total, 0, ',', ' ') . ' Ar';
                    ?></h3>
                    <p>Total valeur des dons</p>
                </div>
            </div>
        </div>
        <div class="col-4">
            <div class="card">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-gift" style="font-size: 2rem; color: var(--warning-color);"></i>
                    <h3 style="margin: 10px 0;"><?= count($dons ?? []) ?></h3>
                    <p>Nombre de dons</p>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>