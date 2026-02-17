<?php include __DIR__ . '/includes/header.php'; ?>

<div class="container">
    <div class="page-title">
        <h2>
            <i class="fas fa-box"></i>
            Ajouter un nouveau produit
        </h2>
        <p>Enregistrez un nouveau produit dans le système</p>
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
        <!-- Formulaire d'ajout de produit -->
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-box"></i> Informations du produit</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/produitInsert" id="formProduit">
                        <div class="form-group">
                            <label class="form-label" for="valProduit">
                                <i class="fas fa-font"></i> Nom du produit
                            </label>
                            <input type="text" class="form-control" id="valProduit" name="valProduit" 
                                   placeholder="Ex: Riz, Huile, Tôles" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="idType">
                                <i class="fas fa-tag"></i> Type de produit
                            </label>
                            <select class="form-control" id="idType" name="idType" required>
                                <option value="">Sélectionnez un type</option>
                                <?php if(isset($types) && count($types) > 0): ?>
                                    <?php foreach($types as $type): ?>
                                        <option value="<?= is_object($type) ? $type->getIdType() : (isset($type['idType']) ? $type['idType'] : '') ?>">
                                            <?= htmlspecialchars(is_object($type) ? ($type->getNomType() ?? $type->getValType() ?? '') : (isset($type['nomType']) ? $type['nomType'] : (isset($type['valType']) ? $type['valType'] : ''))) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1">Alimentaire</option>
                                    <option value="2">Matériaux</option>
                                    <option value="3">Hygiène</option>
                                    <option value="4">Médical</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-actions" style="display: flex; gap: 10px; margin-top: 20px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer le produit
                            </button>
                            <a href="<?= BASE_URL ?>/produits" class="btn btn-secondary">
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
                    <h6><i class="fas fa-check"></i> Comment ajouter un produit ?</h6>
                    <ol style="padding-left: 20px; line-height: 1.8;">
                        <li>Entrez le nom du produit</li>
                        <li>Sélectionnez le type</li>
                        <li>Cliquez sur "Enregistrer"</li>
                    </ol>

                    <hr style="margin: 15px 0;">

                    <h6><i class="fas fa-lightbulb"></i> Astuces</h6>
                    <ul style="padding-left: 20px; line-height: 1.8;">
                        <li>Les noms doivent être uniques</li>
                        <li>Chaque produit a un type spécifique</li>
                        <li>Vous pouvez ajouter des équivalences après</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des produits existants -->
    <div class="card" style="margin-top: 30px;">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Produits enregistrés</h5>
        </div>
        <div class="card-body">
            <?php if(isset($produits) && count($produits) > 0): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($produits as $produit): ?>
                                <tr>
                                    <td><?= htmlspecialchars(is_object($produit) ? $produit->getIdProduit() : (isset($produit['idProduit']) ? $produit['idProduit'] : '')) ?></td>
                                    <td><?= htmlspecialchars(is_object($produit) ? $produit->getValProduit() : (isset($produit['valProduit']) ? $produit['valProduit'] : '')) ?></td>
                                    <td><?= htmlspecialchars(is_object($produit) ? $produit->getIdType() : (isset($produit['idType']) ? $produit['idType'] : '')) ?></td>
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
                <p style="text-align: center; color: var(--gray);">Aucun produit enregistré</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
