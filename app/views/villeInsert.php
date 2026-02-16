<?php include __DIR__ . '/includes/header.php'; ?>

<div class="container">
    <div class="page-title">
        <h2>
            <i class="fas fa-city"></i>
            Ajouter une nouvelle ville
        </h2>
        <p>Enregistrez une nouvelle ville dans le système</p>
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
        <!-- Formulaire d'ajout de ville -->
        <div class="col-8">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-city"></i> Informations de la ville</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/villeInsert" id="formVille">
                        <div class="form-group">
                            <label class="form-label" for="nomVille">
                                <i class="fas fa-font"></i> Nom de la ville
                            </label>
                            <input type="text" class="form-control" id="nomVille" name="nomVille" 
                                   placeholder="Ex: Antananarivo" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="idRegion">
                                <i class="fas fa-map"></i> Région
                            </label>
                            <select class="form-control" id="idRegion" name="idRegion" required>
                                <option value="">Sélectionnez une région</option>
                                <?php if(isset($regions) && count($regions) > 0): ?>
                                    <?php foreach($regions as $region): ?>
                                        <option value="<?= $region->getIdRegion() ?>">
                                            <?= htmlspecialchars($region->getValRegion()) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option value="1">Analamanga</option>
                                    <option value="2">Atsinanana</option>
                                    <option value="3">Boeny</option>
                                    <option value="4">Haute Matsiatra</option>
                                <?php endif; ?>
                            </select>
                        </div>

                        <div class="form-actions" style="display: flex; gap: 10px; margin-top: 20px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Enregistrer la ville
                            </button>
                            <a href="<?= BASE_URL ?>/villes" class="btn btn-secondary">
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
                    <h6><i class="fas fa-check"></i> Comment ajouter une ville ?</h6>
                    <ol style="padding-left: 20px; line-height: 1.8;">
                        <li>Entrez le nom de la ville</li>
                        <li>Sélectionnez la région</li>
                        <li>Cliquez sur "Enregistrer"</li>
                    </ol>

                    <hr style="margin: 15px 0;">

                    <h6><i class="fas fa-lightbulb"></i> Astuces</h6>
                    <ul style="padding-left: 20px; line-height: 1.8;">
                        <li>Chaque ville doit avoir une région</li>
                        <li>Les noms doivent être uniques</li>
                        <li>Vous pouvez ajouter des besoins après</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Liste des villes existantes -->
    <div class="card" style="margin-top: 30px;">
        <div class="card-header">
            <h5><i class="fas fa-list"></i> Villes enregistrées</h5>
        </div>
        <div class="card-body">
            <?php if(isset($villes) && count($villes) > 0): ?>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nom de la ville</th>
                                <th>Région</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($villes as $ville): ?>
                                <tr>
                                    <td><?= htmlspecialchars(is_object($ville) ? $ville->getIdVille() : (isset($ville['idVille']) ? $ville['idVille'] : '')) ?></td>
                                    <td><?= htmlspecialchars(is_object($ville) ? $ville->getValVille() : (isset($ville['valVille']) ? $ville['valVille'] : '')) ?></td>
                                    <td><?= htmlspecialchars(is_object($ville) ? $ville->getIdRegion() : (isset($ville['idRegion']) ? $ville['idRegion'] : '')) ?></td>
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
                <p style="text-align: center; color: var(--gray);">Aucune ville enregistrée</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
