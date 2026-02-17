<?php include __DIR__ . '/../includes/header.php'; ?>

<div class="container">
    <div class="page-title">
        <h2><i class="fas fa-list"></i> Liste des besoins</h2>
        <p>Consultez et filtrez les besoins par ville</p>
    </div>

    <div class="card">
        <div class="card-header"><h5>Tous les besoins</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Besoin</th>
                            <th>Ville</th>
                            <th>Type</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($besoinsFormatted)): ?>
                            <?php foreach ($besoinsFormatted as $besoin): ?>
                                <tr>
                                    <td><?= htmlspecialchars($besoin['valBesoin'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($besoin['villeName'] ?? 'N/A') ?></td>
                                    <td><?= htmlspecialchars($besoin['typeName'] ?? 'N/A') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="text-center text-muted">Aucun besoin enregistré</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>
