<?php include __DIR__ . '/includes/header.php'; ?>

<div class="container">
    <div class="page-title">
        <h2>
            <i class="fas fa-tag"></i>
            Ajouter un nouveau type
        </h2>
        <p>Créez un type de besoin ou de produit</p>
    </div>

    <?php if (isset($success)): ?>
        <div class="alert alert-success" style="background-color: #d4edda; border: 1px solid #c3e6cb; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-check-circle"></i> <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger" style="background-color: #f8d7da; border: 1px solid #f5c6cb; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px;">
            <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-tag"></i> Nouveau type</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= BASE_URL ?>/typeInsert">
                        <div class="form-group">
                            <label class="form-label" for="valType">
                                <i class="fas fa-pen"></i> Libelle du type
                            </label>
                            <input type="text" class="form-control" id="valType" name="valType" required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Enregistrer
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5><i class="fas fa-list"></i> Types enregistrés</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (isset($types) && count($types) > 0): ?>
                                    <?php foreach ($types as $type): ?>
                                        <?php
                                            $valType = is_object($type)
                                                ? $type->getValType()
                                                : (isset($type['valType']) ? $type['valType'] : '');
                                        ?>
                                        <tr>
                                            <td><?= htmlspecialchars($valType ?: 'N/A') ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td class="text-center text-muted">Aucun type enregistre</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
