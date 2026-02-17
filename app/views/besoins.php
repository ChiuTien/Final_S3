<?php
include __DIR__ . '/includes/header.php';
?>

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
                        <?php foreach ($besoins as $b): ?>
                            <tr>
                                <td><?= htmlspecialchars($b['valBesoin'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($b['villeName'] ?? 'N/A') ?></td>
                                <td><?= htmlspecialchars($b['typeName'] ?? 'N/A') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
