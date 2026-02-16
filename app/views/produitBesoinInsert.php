<?php include __DIR__ . '/includes/header.php'; ?>

<div class="container">
    <div class="page-title">
        <h2>
            <i class="fas fa-link"></i>
            Associer un produit à un besoin
        </h2>
        <p>Reliez les produits aux besoins existants</p>
    </div>

    <?php if(isset($success)): ?>
        <div class="alert alert-success" style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if(isset($error)): ?>
        <div class="alert alert-danger" style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <!-- Formulaire d'association -->
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-link"></i> Associer un produit à un besoin</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/produitBesoinInsert" id="formProduitBesoin">
                        <div class="form-group">
                            <label class="form-label" for="idProduit">
                                <i class="fas fa-box"></i> Produit
                            </label>
                            <select class="form-control" id="idProduit" name="idProduit" required>
                                <option value="">Sélectionnez un produit</option>
                                <?php if(isset($produits) && count($produits) > 0): ?>
                                    <?php foreach($produits as $produit): ?>
                                        <option value="<?= is_object($produit) ? $produit->getIdProduit() : (isset($produit['idProduit']) ? $produit['idProduit'] : '') ?>">
                                            <?= htmlspecialchars(is_object($produit) ? $produit->getValProduit() : (isset($produit['valProduit']) ? $produit['valProduit'] : '')) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1">Riz</option>
                                    <option value="2">Huile</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="idBesoin">
                                <i class="fas fa-list"></i> Besoin
                            </label>
                            <select class="form-control" id="idBesoin" name="idBesoin" required>
                                <option value="">Sélectionnez un besoin</option>
                                <?php if(isset($besoins) && count($besoins) > 0): ?>
                                    <?php foreach($besoins as $besoin): ?>
                                        <option value="<?= is_object($besoin) ? $besoin->getIdBesoin() : (isset($besoin['idBesoin']) ? $besoin['idBesoin'] : '') ?>">
                                            <?= htmlspecialchars(is_object($besoin) ? ($besoin->getIdBesoin() . ' - ' . $besoin->getDescriptionBesoin()) : (isset($besoin['idBesoin']) ? ($besoin['idBesoin'] . ' - ' . (isset($besoin['descriptionBesoin']) ? $besoin['descriptionBesoin'] : '')) : '')) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1">Besoin 1</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-actions" style="display: flex; gap: 10px; margin-top: 20px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer l'association
                            </button>
                            <a href="<?= BASE_URL ?>/produitsBesoin" class="btn btn-secondary">
                                <i class="fas fa-times"></i> Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Instructions -->
        <div class="col-4">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-info-circle"></i> Instructions</h5>
                </div>
                <div class="card-body">
                    <h6><i class="fas fa-check"></i> Comment associer un produit à un besoin ?</h6>
                    <ol style="padding-left: 20px; line-height: 1.8;">
                        <li>Sélectionnez un produit</li>
                        <li>Sélectionnez un besoin</li>
                        <li>Cliquez sur "Enregistrer"</li>
                    </ol>

                    <hr style="margin: 15px 0;">

                    <h6><i class="fas fa-lightbulb"></i> Astuces</h6>
                    <ul style="padding-left: 20px; line-height: 1.8;">
                        <li>Un produit peut répondre à plusieurs besoins</li>
                        <li>Un besoin peut être satisfait par plusieurs produits</li>
                        <li>Cela crée une relation N:N</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des associations existantes -->
    <div class="card" style="margin-top: 30px;">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Associations enregistrées</h5>
        </div>
        <div class="card-body">
            <?php if(isset($produitsBesoin) && count($produitsBesoin) > 0): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID Produit</th>
                                <th>Produit</th>
                                <th>ID Besoin</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($produitsBesoin as $pb): ?>
                                <tr>
                                    <td><?= htmlspecialchars(is_object($pb) ? $pb->getIdProduit() : (isset($pb['idProduit']) ? $pb['idProduit'] : '')) ?></td>
                                    <td><?= htmlspecialchars(is_object($pb) ? $pb->getIdProduit() : (isset($pb['idProduit']) ? $pb['idProduit'] : '')) ?></td>
                                    <td><?= htmlspecialchars(is_object($pb) ? $pb->getIdBesoin() : (isset($pb['idBesoin']) ? $pb['idBesoin'] : '')) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-danger">
                                            <i class="fas fa-trash"></i> Supprimer
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p style="text-align: center; color: var(--gray);">Aucune association enregistrée</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
