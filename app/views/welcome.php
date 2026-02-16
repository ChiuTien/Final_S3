<!-- Inclusion du header -->
<?php include __DIR__ . '/includes/header.php'; ?>

<div class="container">
    <!-- Page Title -->
    <div class="page-title">
        <h2>
            <i class="fas fa-dashboard"></i>
            Tableau de bord
        </h2>
        <p>Suivi des collectes et distributions de dons par ville</p>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-3">
            <a class="stat-card" href="#">
                <i class="fas fa-city"></i>
                <h3><?= $controllerVille->getNombreVille() ?></h3>
                <p>Villes</p>
            </a>
        </div>
        <div class="col-3">
            <a class="stat-card" href="#" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                <i class="fas fa-list"></i>
                <h3><?= $controllerBesoin->getNombreBesoin() ?></h3>
                <p>Besoins enregistrés</p>
            </a>
        </div>
        <div class="col-3">
            <a class="stat-card" href="#" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%);">
                <i class="fas fa-gift"></i>
                <h3><?= $controllerDon->getNombreDons() ?></h3>
                <p>Dons collectés</p>
            </a>
        </div>
        <div class="col-3">
            <a class="stat-card" href="#" style="background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);">
                <i class="fas fa-truck"></i>
                <h3><?= $controllerDispatchMere->getNombreDispatchMeres() ?></h3>
                <p>Dispachs effectués</p>
            </a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>