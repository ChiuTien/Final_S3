<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <div class="page-title">
        <h2>
            <i class="fas fa-list"></i>
            Ajouter un nouveau besoin
        </h2>
        <p>Enregistrez un nouveau besoin dans le système</p>
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
        <!-- Formulaire d'ajout de besoin -->
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-list"></i> Informations du besoin</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/besoinInsert" id="formBesoin">
                        <div class="form-group">
                            <label class="form-label" for="idVille">
                                <i class="fas fa-city"></i> Ville
                            </label>
                            <select class="form-control" id="idVille" name="idVille" required>
                                <option value="">Sélectionnez une ville</option>
                                <?php if(isset($villes) && count($villes) > 0): ?>
                                    <?php foreach($villes as $ville): ?>
                                        <option value="<?= is_object($ville) ? $ville->getIdVille() : (isset($ville['idVille']) ? $ville['idVille'] : '') ?>">
                                            <?= htmlspecialchars(is_object($ville) ? $ville->getValVille() : (isset($ville['valVille']) ? $ville['valVille'] : '')) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1">Antananarivo</option>
                                    <option value="2">Toamasina</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="valBesoin">
                                <i class="fas fa-align-left"></i> Description du besoin
                            </label>
                            <textarea class="form-control" id="valBesoin" name="valBesoin" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="idType">
                                <i class="fas fa-tag"></i> Type
                            </label>
                            <select class="form-control" id="idType" name="idType" required>
                                <option value="">Sélectionnez un type</option>
                                <?php if(isset($types) && count($types) > 0): ?>
                                    <?php foreach($types as $type): ?>
                                        <option value="<?= is_object($type) ? $type->getIdType() : (isset($type['idType']) ? $type['idType'] : '') ?>">
                                            <?= htmlspecialchars(is_object($type) ? $type->getValType() : (isset($type['valType']) ? $type['valType'] : '')) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1">Type 1</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-box"></i> Produits nécessaires
                            </label>
                            <div id="produits-container">
                                <div class="produit-item" style="display: flex; gap: 10px; margin-bottom: 10px;">
                                    <select class="form-control" name="produits[0][idProduit]" required style="flex: 2;">
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
                                            <option value="3">Eau</option>
                                        <?php endif; ?>
                                    </select>
                                    <input type="number" class="form-control" name="produits[0][quantite]" 
                                           placeholder="Quantité" min="0.01" step="0.01" required style="flex: 1;">
                                    <button type="button" class="btn btn-danger btn-remove-produit" 
                                            style="display: none;">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                            <button type="button" class="btn btn-secondary" id="btnAddProduit" 
                                    style="margin-top: 10px;">
                                <i class="fas fa-plus"></i> Ajouter un produit
                            </button>
                        </div>

                        <div class="form-actions" style="display: flex; gap: 10px; margin-top: 20px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer le besoin
                            </button>
                            <a href="<?= BASE_URL ?>/besoins" class="btn btn-secondary">
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
                    <h6><i class="fas fa-check"></i> Comment ajouter un besoin ?</h6>
                    <ol style="padding-left: 20px; line-height: 1.8;">
                        <li>Sélectionnez la ville</li>
                        <li>Ajoutez les produits nécessaires</li>
                        <li>Indiquez les quantités</li>
                        <li>Cliquez sur "Enregistrer"</li>
                    </ol>

                    <hr style="margin: 15px 0;">

                    <h6><i class="fas fa-lightbulb"></i> Astuces</h6>
                    <ul style="padding-left: 20px; line-height: 1.8;">
                        <li>Vous pouvez ajouter plusieurs produits</li>
                        <li>Les quantités acceptent les décimales</li>
                        <li>Un besoin aide à tracker les nécessités</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des besoins existants -->
    <div class="card" style="margin-top: 30px;">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Besoins enregistrés</h5>
        </div>
        <div class="card-body">
            <?php if(isset($besoins) && count($besoins) > 0): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Ville</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($besoins as $besoin): ?>
                                <tr>
                                    <td><?= htmlspecialchars(is_object($besoin) ? $besoin->getIdBesoin() : (isset($besoin['idBesoin']) ? $besoin['idBesoin'] : '')) ?></td>
                                    <td><?= htmlspecialchars(is_object($besoin) ? $besoin->getIdVille() : (isset($besoin['idVille']) ? $besoin['idVille'] : '')) ?></td>
                                    <td><?= htmlspecialchars(is_object($besoin) ? $besoin->getValBesoin() : (isset($besoin['valBesoin']) ? $besoin['valBesoin'] : '')) ?></td>
                                    <td><?= htmlspecialchars(is_object($besoin) ? $besoin->getIdType() : (isset($besoin['idType']) ? $besoin['idType'] : '')) ?></td>
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
                <p style="text-align: center; color: var(--gray);">Aucun besoin enregistré</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>

<script nonce="<?= $_SERVER['CSP_NONCE'] ?? '' ?>">
(function() {
    'use strict';
    
    let produitIndex = 1;

    function addProduit() {
        const container = document.getElementById('produits-container');
        const firstItem = container.querySelector('.produit-item');
        const newItem = firstItem.cloneNode(true);
        
        const select = newItem.querySelector('select');
        const input = newItem.querySelector('input');
        const button = newItem.querySelector('button');
        
        select.name = `produits[${produitIndex}][idProduit]`;
        select.value = '';
        input.name = `produits[${produitIndex}][quantite]`;
        input.value = '';
        button.style.display = 'inline-block';
        
        container.appendChild(newItem);
        produitIndex++;
        
        updateRemoveButtons();
        attachRemoveHandlers();
    }

    function removeProduit(button) {
        const container = document.getElementById('produits-container');
        if (container.children.length > 1) {
            button.closest('.produit-item').remove();
            updateRemoveButtons();
        }
    }

    function updateRemoveButtons() {
        const container = document.getElementById('produits-container');
        const items = container.querySelectorAll('.produit-item');
        
        items.forEach((item, index) => {
            const button = item.querySelector('button');
            if (items.length === 1) {
                button.style.display = 'none';
            } else {
                button.style.display = 'inline-block';
            }
        });
    }

    function attachRemoveHandlers() {
        document.querySelectorAll('.btn-remove-produit').forEach(btn => {
            btn.removeEventListener('click', handleRemove);
            btn.addEventListener('click', handleRemove);
        });
    }

    function handleRemove(e) {
        removeProduit(e.target.closest('button'));
    }

    document.getElementById('btnAddProduit').addEventListener('click', addProduit);
    attachRemoveHandlers();

    document.getElementById('formBesoin').addEventListener('submit', function(e) {
        const produitItems = document.querySelectorAll('.produit-item');
        let hasValidProduit = false;
        
        produitItems.forEach(item => {
            const select = item.querySelector('select');
            const input = item.querySelector('input');
            
            if (select.value && parseFloat(input.value) > 0) {
                hasValidProduit = true;
            }
        });
        
        if (!hasValidProduit) {
            e.preventDefault();
            alert('Veuillez ajouter au moins un produit avec une quantité valide');
            return false;
        }
    });
})();
</script>
