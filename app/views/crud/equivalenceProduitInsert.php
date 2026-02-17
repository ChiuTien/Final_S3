<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <div class="page-title">
        <h2>
            <i class="fas fa-exchange-alt"></i>
            Ajouter une équivalence produit
        </h2>
        <p>Définissez les équivalences de prix et quantité pour les produits</p>
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
        <!-- Formulaire d'ajout d'équivalence -->
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-exchange-alt"></i> Informations de l'équivalence</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/equivalenceProduitInsert" id="formEquivalence">
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

                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="quantite">
                                        <i class="fas fa-weight"></i> Quantité
                                    </label>
                                    <input type="number" class="form-control" id="quantite" name="quantite" 
                                           placeholder="Ex: 50" min="0.01" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="prix">
                                        <i class="fas fa-money-bill"></i> Prix (Ar)
                                    </label>
                                    <input type="number" class="form-control" id="prix" name="prix" 
                                           placeholder="Ex: 100000" min="0.01" step="0.01" required>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label class="form-label" for="val">
                                        <i class="fas fa-tag"></i> Unité
                                    </label>
                                    <input type="text" class="form-control" id="val" name="val" 
                                           placeholder="Ex: kg, L, pièce" required>
                                </div>
                            </div>
                        </div>

                        <div class="form-actions" style="display: flex; gap: 10px; margin-top: 20px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer l'équivalence
                            </button>
                            <a href="<?= BASE_URL ?>/equivalences" class="btn btn-secondary">
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
                    <h6><i class="fas fa-check"></i> Comment ajouter une équivalence ?</h6>
                    <ol style="padding-left: 20px; line-height: 1.8;">
                        <li>Sélectionnez un produit</li>
                        <li>Entrez la quantité</li>
                        <li>Entrez le prix correspondant</li>
                        <li>Spécifiez l'unité</li>
                        <li>Cliquez sur "Enregistrer"</li>
                    </ol>

                    <hr style="margin: 15px 0;">

                    <h6><i class="fas fa-lightbulb"></i> Exemple</h6>
                    <p style="font-size: 0.9rem; line-height: 1.8;">
                        Produit : Riz<br>
                        Quantité : 50<br>
                        Prix : 100000<br>
                        Unité : kg<br>
                        <strong>Signifie:</strong> 50 kg de riz = 100000 Ar
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des équivalences existantes -->
    <div class="card" style="margin-top: 30px;">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Équivalences enregistrées</h5>
        </div>
        <div class="card-body">
            <?php if(isset($equivalences) && count($equivalences) > 0): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Produit</th>
                                <th>Quantité</th>
                                <th>Unité</th>
                                <th>Prix (Ar)</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($equivalences as $eq): ?>
                                <tr>
                                    <td><?= htmlspecialchars(is_object($eq) ? $eq->getIdEquivalenceProduit() : (isset($eq['idEquivalenceProduit']) ? $eq['idEquivalenceProduit'] : '')) ?></td>
                                    <td><?= htmlspecialchars(is_object($eq) ? $eq->getIdProduit() : (isset($eq['idProduit']) ? $eq['idProduit'] : '')) ?></td>
                                    <td><?= htmlspecialchars(is_object($eq) ? $eq->getQuantite() : (isset($eq['quantite']) ? $eq['quantite'] : '')) ?></td>
                                    <td><?= htmlspecialchars(is_object($eq) ? $eq->getVal() : (isset($eq['val']) ? $eq['val'] : '')) ?></td>
                                    <td><?= is_object($eq) ? number_format($eq->getPrix(), 0, ',', ' ') : (isset($eq['prix']) ? number_format($eq['prix'], 0, ',', ' ') : '') ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i> Modifier
                                        </button>
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
                <p style="text-align: center; color: var(--gray);">Aucune équivalence enregistrée</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
