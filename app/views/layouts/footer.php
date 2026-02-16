    </main>
    
    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h5><i class="fas fa-hand-holding-heart"></i> BNGRC</h5>
                    <p>Bureau National de Gestion des Risques et Catastrophes</p>
                    <p>
                        <i class="fas fa-clock"></i> Lun-Ven: 8h - 17h<br>
                        <i class="fas fa-clock"></i> Sam: 8h - 12h
                    </p>
                </div>
                <div class="footer-section">
                    <h5>Liens rapides</h5>
                    <ul>
                        <li><a href="<?= BASE_URL ?>index.html"><i class="fas fa-chevron-right"></i>Tableau de bord</a></li>
                        <li><a href="<?= BASE_URL ?>villes.html"><i class="fas fa-chevron-right"></i>Villes sinistrées</a></li>
                        <li><a href="<?= BASE_URL ?>besoins.html"><i class="fas fa-chevron-right"></i>Besoins</a></li>
                        <li><a href="<?= BASE_URL ?>dons.html"><i class="fas fa-chevron-right"></i>Dons</a></li>
                        <li><a href="<?= BASE_URL ?>dispatch.html"><i class="fas fa-chevron-right"></i>Dispatch</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h5>Contact</h5>
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> Antananarivo 101, Madagascar</li>
                        <li><i class="fas fa-phone"></i> +261 34 00 000 00</li>
                        <li><i class="fas fa-envelope"></i> contact@bngrc.mg</li>
                        <li><i class="fas fa-globe"></i> www.bngrc.mg</li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <small>&copy; 2026 BNGRC - ETU004225(Christelle) - ETU003914(Christian) - ETU004339(Alexandre)</small>
            </div>
        </div>
    </footer>

    <script>
        // Fonction pour ouvrir les modals
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
            document.body.style.overflow = 'hidden';
        }

        // Fonction pour fermer les modals
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        // Fonction pour voir les détails d'une ville
        function viewVilleDetails(villeNom) {
            // Ici vous pouvez implémenter l'affichage des détails
            alert('Affichage des détails pour ' + villeNom + '\n\nListe des besoins:\n- Riz: 500kg\n- Huile: 200L\n- Tôles: 100\n\nListe des dons attribués:\n- Riz: 300kg\n- Huile: 150L\n- Argent: 500 000 Ar');
        }

        // Fonction pour filtrer les besoins par ville
        function filterBesoinsByVille() {
            const ville = document.getElementById('filterVille').value;
            if(ville) {
                alert('Filtrage des besoins pour la ville: ' + ville);
            }
        }

        // Fonction pour filtrer les dons par ville
        function filterDonsByVille() {
            const ville = document.getElementById('filterDonVille').value;
            if(ville) {
                alert('Filtrage des dons pour la ville: ' + ville);
            }
        }

        // Fonction pour rechercher
        function searchItems() {
            const searchTerm = document.getElementById('searchInput').value;
            if(searchTerm) {
                alert('Recherche de: ' + searchTerm);
            }
        }

        // Fermer les modals si on clique en dehors
        window.onclick = function(event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }

        // Gestionnaire de soumission des formulaires
        document.addEventListener('DOMContentLoaded', function() {
            // Formulaire ville
            const formVille = document.getElementById('formVille');
            if(formVille) {
                formVille.onsubmit = function(e) {
                    e.preventDefault();
                    alert('Ville ajoutée avec succès!');
                    closeModal('villeModal');
                };
            }

            // Formulaire besoin
            const formBesoin = document.getElementById('formBesoin');
            if(formBesoin) {
                formBesoin.onsubmit = function(e) {
                    e.preventDefault();
                    alert('Besoin ajouté avec succès!');
                    closeModal('besoinModal');
                };
            }

            // Formulaire don
            const formDon = document.getElementById('formDon');
            if(formDon) {
                formDon.onsubmit = function(e) {
                    e.preventDefault();
                    alert('Don ajouté avec succès!');
                    closeModal('donModal');
                };
            }

            // Formulaire dispatch
            const formDispatch = document.getElementById('formDispatch');
            if(formDispatch) {
                formDispatch.onsubmit = function(e) {
                    e.preventDefault();
                    alert('Dispatch ajouté avec succès!');
                    closeModal('dispatchModal');
                };
            }
        });

        // Fonction pour le menu responsive
        function toggleMenu() {
            document.getElementById('navbarMenu').classList.toggle('active');
        }
    </script>
</body>
</html>