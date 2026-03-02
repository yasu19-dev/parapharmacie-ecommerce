// Toggle affichage dropdown contact au clic
document.getElementById('contactToggle').addEventListener('click', function(e) {
  e.preventDefault();
  const dropdown = document.getElementById('contactDropdown');
  if (dropdown.style.display === 'block') {
    dropdown.style.display = 'none';
  } else {
    dropdown.style.display = 'block';
  }
});

// Clic ailleurs ferme le dropdown
document.addEventListener('click', function(e) {
  const dropdown = document.getElementById('contactDropdown');
  const toggle = document.getElementById('contactToggle');
  if (!toggle.contains(e.target) && !dropdown.contains(e.target)) {
    dropdown.style.display = 'none';
  }
});

// Fonction pour afficher une carte flottante (notification)
function afficherCarteNotification(message, type = 'success') {
  // Créer un conteneur (div) sans recréer un bouton X
  const carte = document.createElement('div');
  carte.className = `position-fixed top-0 end-0 m-4`;
  carte.style.zIndex = 1050;
  carte.style.minWidth = '300px';

  // Injecter directement le HTML du message (ton PHP envoie déjà une alert complète)
  carte.innerHTML = message;

  // Ajouter au body
  document.body.appendChild(carte);

  // Supprimer après 4 secondes
  setTimeout(() => {
    carte.remove();
  }, 4000);
}


// Script pour gérer le clic sur "Ajouter au panier"
document.querySelectorAll('.ajouter-panier').forEach(button => {
  button.addEventListener('click', function () {
    const id = this.dataset.id;
    const nom = this.dataset.nom;
    const prix = this.dataset.prix;
    const image = this.dataset.image;

fetch('ajouter_panier.php', {
  method: 'POST',
  headers: {'Content-Type': 'application/x-www-form-urlencoded'},
  body: `id=${encodeURIComponent(id)}&nom=${encodeURIComponent(nom)}&prix=${encodeURIComponent(prix)}&image=${encodeURIComponent(image)}`
})

    .then(res => res.text())
    .then(msg => {
          afficherCarteNotification(msg, 'success');
          mettreAJourCompteurPanier();  // 👉 mettre à jour compteur !
         })  
    .catch(() => afficherCarteNotification("Erreur lors de l'ajout au panier.", 'danger'));
  });
});
function mettreAJourCompteurPanier() {
  fetch('compteur_panier.php')
    .then(res => res.text())
    .then(compteur => {
      document.getElementById('compteur-panier').textContent = compteur;
    });

    // on met à jour le compteur dès le chargement de la page
    document.addEventListener('DOMContentLoaded', () => {
        mettreAJourCompteurPanier();
    });
}
