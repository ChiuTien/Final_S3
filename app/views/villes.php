<?php

use app\controllers\ControllerVille;
// Vue serveur pour la liste des villes — utilise les controllers si disponibles, sinon données de test
include __DIR__ . '/includes/header.php';
$controllerVille = new ControllerVille();
$villes = $controllerVille->getAllVilles();
?>

<div class="container">
    <div class="page-title">
        <h2><i class="fas fa-city"></i> Villes</h2>
        <p>Liste des villes (données provenant du controller si disponible, sinon données de test)</p>
    </div>

    <div class="card">
        <div class="card-header"><h5>Toutes les villes</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Ville</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($villes as $ville): ?>
                        <tr>
                            <td><strong><?= htmlspecialchars($ville['valVille']) ?></strong></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
