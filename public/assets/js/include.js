// Fonction pour inclure le header et le footer
function includeHTML() {
    // Inclure le header
    fetch('header.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('header-placeholder').innerHTML = data;
        })
        .catch(error => console.error('Erreur chargement header:', error));
    
    // Inclure le footer
    fetch('footer.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('footer-placeholder').innerHTML = data;
        })
        .catch(error => console.error('Erreur chargement footer:', error));
}

// Appeler la fonction au chargement
document.addEventListener('DOMContentLoaded', includeHTML);