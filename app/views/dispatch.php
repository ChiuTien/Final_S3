<?php
use app\controllers\ControllerDispatchFille;
use app\controllers\ControllerDispatchMere;
use app\controllers\ControllerProduit;
use app\controllers\ControllerVille;

include __DIR__ . '/includes/header.php';



$dM = new ControllerDispatchMere();
$meres = $dM->getAllDispatchMeres();

$dF = new ControllerDispatchFille();
$filles = $dF->getAllDispatchFilles();

$cv = new ControllerVille();

$prod = new ControllerProduit();
?>

<div class="container">
    <div class="page-title">
        <h2><i class="fas fa-truck"></i> Gestion des dispatch</h2>
        <p>Liste des dispatch mère et fille (données via controllers si possible)</p>
    </div>

    <div class="card">
        <div class="card-header"><h5>Dispatchs (Mère)</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr><th>Ville</th><th>Date et heure</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($meres as $m): ?>
                            <tr>
                                <td><?= htmlspecialchars($cv->getVilleById($m['id_ville'])->getValVille() ?? '') ?></td>
                                <td><?= htmlspecialchars($m['date_dispatch'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-header"><h5>Dispatchs (Fille)</h5></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr><th>Produit</th><th>Quantité</th></tr>
                    </thead>
                    <tbody>
                        <?php foreach ($filles as $f): ?>
                            <tr>
                                <td><?= htmlspecialchars($prod->getProduitById($f['id_produit'])->getValProduit() ?? '') ?></td>
                                <td><?= htmlspecialchars($f['quantite'] ?? '') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
