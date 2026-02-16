<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BNGRC - Gestion des dons</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/bootstrap-icons/font/bootstrap-icons.min.css">
    <!-- Notre CSS personnalisé -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/bootstrap/css/bootstrap.min.css">
</head>
<body>
    <!-- Header / Navbar -->
    <nav class="navbar">
        <div class="container">
            <a href="<?= BASE_URL ?>/" class="navbar-brand">
                <i class="fas fa-hand-holding-heart"></i>
                BNGRC
            </a>
            <div class="navbar-toggle" onclick="toggleMenu()">
                <i class="fas fa-bars"></i>
            </div>
            <ul class="navbar-menu" id="navbarMenu">
                <li><a href="<?= BASE_URL ?>/"><i class="fas fa-dashboard"></i>Tableau de bord</a></li>
                <li><a href="<?= BASE_URL ?>/villes"><i class="fas fa-city"></i>Villes</a></li>
                <li><a href="<?= BASE_URL ?>/besoins"><i class="fas fa-list"></i>Besoins</a></li>
                <li><a href="<?= BASE_URL ?>/donsAffichage"><i class="fas fa-gift"></i>Dons</a></li>
                <li><a href="<?= BASE_URL ?>/dispatch"><i class="fas fa-truck"></i>Dispatch</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle"><i class="fas fa-plus-circle"></i>Insertions <i class="fas fa-chevron-down" style="font-size: 12px; margin-left: 5px;"></i></a>
                    <div class="dropdown-content">
                        <a href="<?= BASE_URL ?>/donInsert"><i class="fas fa-gift"></i>Nouveau don</a>
                        <a href="#" onclick="openModal('villeModal'); return false;"><i class="fas fa-city"></i>Nouvelle ville</a>
                        <a href="#" onclick="openModal('besoinModal'); return false;"><i class="fas fa-list"></i>Nouveau besoin</a>
                        <a href="#" onclick="openModal('dispatchModal'); return false;"><i class="fas fa-truck"></i>Nouveau dispatch</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Modals pour les insertions -->
    
    <!-- Modal Nouvelle Ville -->
    <div id="villeModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-city"></i> Ajouter une nouvelle ville</h3>
                <span class="close-modal" onclick="closeModal('villeModal')">&times;</span>
            </div>
            <div class="modal-body">
                <form id="formVille">
                    <div class="form-group">
                        <label class="form-label" for="villeNom">Nom de la ville</label>
                        <input type="text" class="form-control" id="villeNom" placeholder="Ex: Antananarivo" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="villeRegion">Région</label>
                        <select class="form-control" id="villeRegion" required>
                            <option value="">Sélectionnez une région</option>
                            <option>Analamanga</option>
                            <option>Atsinanana</option>
                            <option>Boeny</option>
                            <option>Haute Matsiatra</option>
                            <option>Atsimo Andrefana</option>
                            <option>Diana</option>
                            <option>Vakinankaratra</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="villePopulation">Population sinistrée</label>
                        <input type="number" class="form-control" id="villePopulation" placeholder="Nombre de personnes" required>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Ajouter la ville
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Nouveau Besoin -->
    <div id="besoinModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-list"></i> Ajouter un nouveau besoin</h3>
                <span class="close-modal" onclick="closeModal('besoinModal')">&times;</span>
            </div>
            <div class="modal-body">
                <form id="formBesoin">
                    <div class="form-group">
                        <label class="form-label" for="besoinVille">Ville</label>
                        <select class="form-control" id="besoinVille" required>
                            <option value="">Sélectionnez une ville</option>
                            <option>Antananarivo</option>
                            <option>Toamasina</option>
                            <option>Mahajanga</option>
                            <option>Fianarantsoa</option>
                            <option>Toliara</option>
                            <option>Antsiranana</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="besoinType">Type de besoin</label>
                        <select class="form-control" id="besoinType" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="nature">Nature (riz, huile, ...)</option>
                            <option value="materiaux">Matériaux (tôle, clou, ...)</option>
                            <option value="argent">Argent</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="besoinProduit">Produit</label>
                        <input type="text" class="form-control" id="besoinProduit" placeholder="Ex: Riz" required>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="besoinQuantite">Quantité</label>
                                <input type="number" class="form-control" id="besoinQuantite" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="besoinUnite">Unité</label>
                                <select class="form-control" id="besoinUnite">
                                    <option>kg</option>
                                    <option>L</option>
                                    <option>pièce</option>
                                    <option>Ar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="besoinPrix">Prix unitaire (Ar)</label>
                                <input type="number" class="form-control" id="besoinPrix">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="besoinUrgence">Niveau d'urgence</label>
                        <select class="form-control" id="besoinUrgence">
                            <option value="normal">Normal</option>
                            <option value="important">Important</option>
                            <option value="urgent">Urgent</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Ajouter le besoin
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Nouveau Don -->
    <div id="donModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-gift"></i> Ajouter un nouveau don</h3>
                <span class="close-modal" onclick="closeModal('donModal')">&times;</span>
            </div>
            <div class="modal-body">
                <form id="formDon">
                    <div class="form-group">
                        <label class="form-label" for="donDonateur">Nom du donateur</label>
                        <input type="text" class="form-control" id="donDonateur" placeholder="Nom ou organisation" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="donType">Type de don</label>
                        <select class="form-control" id="donType" required>
                            <option value="">Sélectionnez un type</option>
                            <option value="nature">Nature (riz, huile, ...)</option>
                            <option value="materiaux">Matériaux (tôle, clou, ...)</option>
                            <option value="argent">Argent</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="donProduit">Produit</label>
                        <input type="text" class="form-control" id="donProduit" placeholder="Ex: Riz" required>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="donQuantite">Quantité</label>
                                <input type="number" class="form-control" id="donQuantite" required>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="donUnite">Unité</label>
                                <select class="form-control" id="donUnite">
                                    <option>kg</option>
                                    <option>L</option>
                                    <option>pièce</option>
                                    <option>Ar</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="form-group">
                                <label class="form-label" for="donDate">Date</label>
                                <input type="date" class="form-control" id="donDate" value="2026-02-16">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="donVille">Destination (optionnel)</label>
                        <select class="form-control" id="donVille">
                            <option value="">À attribuer</option>
                            <option>Antananarivo</option>
                            <option>Toamasina</option>
                            <option>Mahajanga</option>
                            <option>Fianarantsoa</option>
                            <option>Toliara</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Ajouter le don
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Nouveau Dispatch -->
    <div id="dispatchModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-truck"></i> Ajouter un nouveau dispatch</h3>
                <span class="close-modal" onclick="closeModal('dispatchModal')">&times;</span>
            </div>
            <div class="modal-body">
                <form id="formDispatch">
                    <div class="form-group">
                        <label class="form-label" for="dispatchVille">Ville de destination</label>
                        <select class="form-control" id="dispatchVille" required>
                            <option value="">Sélectionnez une ville</option>
                            <option>Antananarivo</option>
                            <option>Toamasina</option>
                            <option>Mahajanga</option>
                            <option>Fianarantsoa</option>
                            <option>Toliara</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="dispatchProduit">Produit à dispatcher</label>
                        <select class="form-control" id="dispatchProduit" required>
                            <option value="">Sélectionnez un produit</option>
                            <option>Riz</option>
                            <option>Huile</option>
                            <option>Tôles</option>
                            <option>Clous</option>
                            <option>Argent</option>
                            <option>Eau</option>
                            <option>Médicaments</option>
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="dispatchQuantite">Quantité</label>
                                <input type="number" class="form-control" id="dispatchQuantite" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label class="form-label" for="dispatchDate">Date du dispatch</label>
                                <input type="date" class="form-control" id="dispatchDate" value="2026-02-16">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label" for="dispatchPriorite">Priorité</label>
                        <select class="form-control" id="dispatchPriorite">
                            <option>Normale</option>
                            <option>Urgente</option>
                            <option>Très urgente</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Ajouter le dispatch
                    </button>
                </form>
            </div>
        </div>
    </div>

    <main>