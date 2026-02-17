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
                            <?php
                                if (!is_object($b) && !is_array($b)) {
                                    continue;
                                }

                                $valBesoin = is_object($b) ? $b->getValBesoin() : ($b['valBesoin'] ?? '');
                                $idVille = is_object($b) ? $b->getIdVille() : ($b['idVille'] ?? null);
                                $idType = is_object($b) ? $b->getIdType() : ($b['idType'] ?? null);

                                $villeData = $idVille ? $ctrlVille->getVilleById($idVille) : null;
                                $villeName = is_object($villeData)
                                    ? $villeData->getValVille()
                                    : (is_array($villeData) ? ($villeData['valVille'] ?? '') : '');

                                $typeData = $idType ? $ctrlType->getTypeById($idType) : null;
                                $typeName = is_object($typeData)
                                    ? $typeData->getValType()
                                    : (is_array($typeData) ? ($typeData['valType'] ?? '') : '');
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($valBesoin ?: 'N/A') ?></td>
                                <td><?= htmlspecialchars($villeName ?: 'N/A') ?></td>
                                <td><?= htmlspecialchars($typeName ?: 'N/A') ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<?php include __DIR__ . '/includes/footer.php'; ?>
