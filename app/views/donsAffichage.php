<?php include __DIR__ . '/includes/header.php'; ?>

<div class="container">
    <div class="page-title">
        <h2>
            <i class="fas fa-gift"></i>
            Liste des dons et donnations
        </h2>
        <p>Consultez tous les dons et donnations enregistrés</p>
    </div>

    <!-- Bouton d'ajout -->
    <div style="margin-bottom: 20px; text-align: right;">
        <a href="<?= BASE_URL ?>/donInsert" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Ajouter un nouveau don
        </a>
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
            <div class="stat-label">Donnations totales</div>
        </div>
        <div class="stat-item" style="background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);">
            <i class="fas fa-coins"></i>
            <div class="stat-number"><?php 
                $total = 0;
                if(isset($dons)) {
                    foreach($dons as $don) {
                        $total += $don->getTotalPrix() ?? 0;
                    }
                }
                echo number_format($total, 0, ',', ' ') . ' Ar';
            ?></div>
            <div class="stat-label">Valeur totale</div>
        </div>
    </div>

    <!-- Liste des dons -->
    <div class="card" style="margin-bottom: 30px;">
        <div class="card-header">
            <h5><i class="fas fa-gift"></i> Liste de tous les dons</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID Don</th>
                            <th>Date du don</th>
                            <th>Valeur totale (Ar)</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($dons) && count($dons) > 0): ?>
                            <?php foreach($dons as $don): ?>
                                <tr>
                                    <td><strong>#<?= $don->getIdDon() ?></strong></td>
                                    <td>
                                        <i class="fas fa-calendar"></i> 
                                        <?= $don->getDateDon()->format('d/m/Y') ?>
                                    </td>
                                    <td>
                                        <strong style="color: #27ae60;">
                                            <?= $don->getTotalPrix() ? number_format($don->getTotalPrix(), 0, ',', ' ') : '0' ?> Ar
                                        </strong>
                                    </td>
                                    
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 40px; color: #999;">
                                    <i class="fas fa-inbox" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                    Aucun don enregistré
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Liste des donnations -->
    <div class="card">
        <div class="card-header">
            <h5><i class="fas fa-box-open"></i> Liste de toutes les donnations</h5>
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
                                    <td>
                                        <span style="background: #667eea; color: white; padding: 3px 10px; border-radius: 15px; font-size: 0.85rem;">
                                            <i class="fas fa-gift"></i> Don #<?= $donnation->getIdDon() ?>
                                        </span>
                                    </td>
                                    <td>
                                        <span style="background: #27ae60; color: white; padding: 3px 10px; border-radius: 15px; font-size: 0.85rem;">
                                            <i class="fas fa-box"></i> Produit #<?= $donnation->getIdProduit() ?>
                                        </span>
                                    </td>
                                    <td>
                                        <strong><?= $donnation->getQuantiteProduit() ? number_format($donnation->getQuantiteProduit(), 2, ',', ' ') : '0,00' ?></strong>
                                    </td>
                                   
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 40px; color: #999;">
                                    <i class="fas fa-inbox" style="font-size: 2rem; display: block; margin-bottom: 10px;"></i>
                                    Aucune donnation enregistrée
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