<?php
include __DIR__ . '/includes/header.php';

use \app\controllers\ControllerBesoin;

$ctrl = new ControllerBesoin();
$besoins = $ctrl->getAllBesoin();

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
                            <th>Besoins</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($besoins as $b): ?>
                            <?php if (is_array($b)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($b['valBesoin'] ?? 'N/A') ?></td>
                                </tr>
                            <?php else: ?>
                                <tr><td colspan="9">Données non disponibles</td></tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
