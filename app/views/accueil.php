<!-- Inclusion du header -->
<?php include __DIR__ . '/layouts/header.php'; ?>
<script>
    fetch('<?= BASE_URL ?>includes/header.html')
        .then(response => response.text())
        .then(data => {
            document.body.insertAdjacentHTML('afterbegin', data);
        });
</script>

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
            <div class="stat-card">
                <i class="fas fa-city"></i>
                <h3>15</h3>
                <p>Villes sinistrées</p>
            </div>
        </div>
        <div class="col-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #3498db 0%, #2980b9 100%);">
                <i class="fas fa-list"></i>
                <h3>47</h3>
                <p>Besoins enregistrés</p>
            </div>
        </div>
        <div class="col-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #27ae60 0%, #229954 100%);">
                <i class="fas fa-gift"></i>
                <h3>89</h3>
                <p>Dons collectés</p>
            </div>
        </div>
        <div class="col-3">
            <div class="stat-card" style="background: linear-gradient(135deg, #e67e22 0%, #d35400 100%);">
                <i class="fas fa-truck"></i>
                <h3>34</h3>
                <p>Dispachs effectués</p>
            </div>
        </div>
    </div>

    <!-- Villes avec besoins et dons -->
    <div class="card">
        <div class="card-header">
            <h5>
                <i class="fas fa-map-marker-alt"></i>
                Liste des villes - Besoins et dons attribués
            </h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Ville</th>
                            <th>Région</th>
                            <th>Besoins</th>
                            <th>Dons attribués</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><strong>Antananarivo</strong></td>
                            <td>Analamanga</td>
                            <td>
                                <span class="badge badge-besoin">Riz: 500kg</span>
                                <span class="badge badge-besoin">Huile: 200L</span>
                                <span class="badge badge-besoin">Tôles: 100</span>
                            </td>
                            <td>
                                <span class="badge badge-don">Riz: 300kg</span>
                                <span class="badge badge-don">Huile: 150L</span>
                                <span class="badge badge-don">Argent: 500 000 Ar</span>
                            </td>
                            <td>
                                <span class="badge badge-warning">Partiellement couvert</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary" title="Voir détails">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success" title="Dispatch">
                                    <i class="fas fa-truck"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Toamasina</strong></td>
                            <td>Atsinanana</td>
                            <td>
                                <span class="badge badge-besoin">Riz: 300kg</span>
                                <span class="badge badge-besoin">Clous: 50kg</span>
                            </td>
                            <td>
                                <span class="badge badge-don">Riz: 300kg</span>
                                <span class="badge badge-don">Clous: 50kg</span>
                            </td>
                            <td>
                                <span class="badge badge-success">Couvert</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-truck"></i>
                                </button>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Mahajanga</strong></td>
                            <td>Boeny</td>
                            <td>
                                <span class="badge badge-besoin">Riz: 400kg</span>
                                <span class="badge badge-besoin">Huile: 100L</span>
                                <span class="badge badge-besoin">Tôles: 50</span>
                                <span class="badge badge-besoin">Argent: 200 000 Ar</span>
                            </td>
                            <td>
                                <span class="badge badge-don">Riz: 100kg</span>
                            </td>
                            <td>
                                <span class="badge badge-danger">Urgent</span>
                            </td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-success">
                                    <i class="fas fa-truck"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
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

<!-- Inclusion du footer -->
<script>
    fetch('<?= BASE_URL ?>includes/footer.html')
        .then(response => response.text())
        .then(data => {
            document.body.insertAdjacentHTML('beforeend', data);
        });
</script>