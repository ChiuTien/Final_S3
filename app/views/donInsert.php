<?php include __DIR__ . '/includes/header.php'; ?>

<div class="container">
    <div class="page-title">
        <h2>
            <i class="fas fa-plus-circle"></i>
            Ajouter un nouveau don
        </h2>
        <p>Enregistrez un nouveau don dans le système</p>
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
        <!-- Formulaire d'ajout de don -->
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-gift"></i> Informations du don</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/donInsert" id="formDon">
                        <div class="form-group">
                            <label class="form-label" for="dateDon">
                                <i class="fas fa-calendar"></i> Date du don
                            </label>
                            <input type="date" class="form-control" id="dateDon" name="dateDon" 
                                   value="<?= date('Y-m-d') ?>" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                <i class="fas fa-box"></i> Produits à donner
                            </label>
                            <div id="produits-container">
                                <div class="produit-item" style="display: flex; gap: 10px; margin-bottom: 10px;">
                                    <select class="form-control" name="produits[0][idProduit]" required style="flex: 2;">
                                        <option value="">Sélectionnez un produit</option>
                                        <?php if(isset($produits) && count($produits) > 0): ?>
                                            <?php foreach($produits as $produit): ?>
                                                <option value="<?= $produit->getIdProduit() ?>">
                                                    <?= htmlspecialchars($produit->getValProduit()) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php else: ?>
                                            <option value="1">Riz</option>
                                            <option value="2">Huile</option>
                                            <option value="3">Tôles</option>
                                            <option value="4">Eau</option>
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
                                <i class="fas fa-save"></i> Enregistrer le don
                            </button>
                            <a href="<?= BASE_URL ?>/donsAffichage" class="btn btn-secondary">
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
                    <h6><i class="fas fa-check"></i> Comment ajouter un don ?</h6>
                    <ol style="padding-left: 20px; line-height: 1.8;">
                        <li>Sélectionnez la date du don</li>
                        <li>Sélectionnez les produits donnés</li>
                        <li>Indiquez les quantités</li>
                        <li>Cliquez sur "Enregistrer"</li>
                        <li>Le prix sera calculé automatiquement</li>
                    </ol>

                    <hr style="margin: 15px 0;">

                    <h6><i class="fas fa-lightbulb"></i> Astuces</h6>
                    <ul style="padding-left: 20px; line-height: 1.8;">
                        <li>Vous pouvez ajouter plusieurs produits</li>
                        <li>Le prix total est calculé via les équivalences</li>
                        <li>Les quantités acceptent les décimales</li>
                    </ul>
                </div>
            </div>

            <div class="card" style="margin-top: 20px;">
                <div class="card-body" style="text-align: center;">
                    <i class="fas fa-heart" style="font-size: 3rem; color: #e74c3c; margin-bottom: 10px;"></i>
                    <h5>Merci pour votre générosité !</h5>
                    <p style="color: var(--gray); margin: 0;">Chaque don compte et aide les personnes dans le besoin.</p>
                </div>
            </div>

            <div class="card" style="margin-top: 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body">
                    <h6 style="color: white; margin-bottom: 15px;">
                        <i class="fas fa-info-circle"></i> Processus d'insertion
                    </h6>
                    <div style="font-size: 0.9rem; line-height: 1.8;">
                        <p style="margin: 0 0 10px 0;"><strong>1 Don = Plusieurs Produits</strong></p>
                        <p style="margin: 0; opacity: 0.9;">
                            Quand vous enregistrez un don, le système crée automatiquement :
                        </p>
                        <ul style="margin: 10px 0; padding-left: 20px; opacity: 0.9;">
                            <li>1 entrée dans la table <strong>Don</strong></li>
                            <li>N entrées dans <strong>Donnation</strong> (1 par produit)</li>
                        </ul>
                        <p style="margin: 10px 0 0 0; opacity: 0.9; font-size: 0.85rem;">
                            <i class="fas fa-link"></i> Chaque donnation est liée au don via l'ID
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>

<script nonce="<?= $_SERVER['CSP_NONCE'] ?? '' ?>">
(function() {
    'use strict';
    
    let produitIndex = 1;

    function addProduit() {
        const container = document.getElementById('produits-container');
        const firstItem = container.querySelector('.produit-item');
        const newItem = firstItem.cloneNode(true);
        
        // Mettre à jour les indices
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

    // Event listener pour le bouton "Ajouter un produit"
    document.getElementById('btnAddProduit').addEventListener('click', addProduit);

    // Attacher les handlers pour les boutons de suppression existants
    attachRemoveHandlers();

    // Validation du formulaire
    document.getElementById('formDon').addEventListener('submit', function(e) {
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
