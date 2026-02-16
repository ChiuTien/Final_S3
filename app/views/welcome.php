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

    <!-- Derniers dons et besoins urgents -->
    <div class="row">
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-clock"></i>
                        Derniers dons enregistrés
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div>
                                <i class="fas fa-user" style="color: var(--primary-color); margin-right: 10px;"></i>
                                <strong>Jean R.</strong> - Riz 100kg
                            </div>
                            <small>Il y a 2h</small>
                        </li>
                        <li class="list-group-item">
                            <div>
                                <i class="fas fa-user" style="color: var(--primary-color); margin-right: 10px;"></i>
                                <strong>Marie L.</strong> - Argent 50 000 Ar
                            </div>
                            <small>Il y a 5h</small>
                        </li>
                        <li class="list-group-item">
                            <div>
                                <i class="fas fa-building" style="color: var(--primary-color); margin-right: 10px;"></i>
                                <strong>Entreprise ABC</strong> - Tôles 50
                            </div>
                            <small>Hier</small>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-header">
                    <h5>
                        <i class="fas fa-exclamation-triangle"></i>
                        Besoins urgents
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <div>
                                <i class="fas fa-city" style="color: var(--danger-color); margin-right: 10px;"></i>
                                <strong>Fianarantsoa</strong> - Riz 500kg
                            </div>
                            <span class="badge badge-danger">Urgent</span>
                        </li>
                        <li class="list-group-item">
                            <div>
                                <i class="fas fa-city" style="color: var(--danger-color); margin-right: 10px;"></i>
                                <strong>Toliara</strong> - Eau 1000L
                            </div>
                            <span class="badge badge-danger">Urgent</span>
                        </li>
                        <li class="list-group-item">
                            <div>
                                <i class="fas fa-city" style="color: var(--warning-color); margin-right: 10px;"></i>
                                <strong>Antsiranana</strong> - Médicaments
                            </div>
                            <span class="badge badge-warning">Important</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/includes/footer.php'; ?>