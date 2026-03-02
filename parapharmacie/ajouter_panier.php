<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Récupérer les champs du formulaire
    $id = $_POST['id'] ?? null;
    $nom = $_POST['nom'] ?? null;
    $prix = $_POST['prix'] ?? null;

    // Ici je suppose que ton champ image est un champ texte (ex: URL ou nom de fichier), PAS un upload
    $image = $_POST['image'] ?? null;  

    // Vérification que tous les champs sont bien remplis
    if ($id && $nom && $prix && $image) {

        // Initialiser le panier s'il n'existe pas encore
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }

        // Si le produit existe déjà dans le panier → augmenter la quantité
        if (isset($_SESSION['panier'][$id])) {
            $_SESSION['panier'][$id]['quantite']++;
        } else {
            // Sinon, ajouter le produit avec quantité = 1
            $_SESSION['panier'][$id] = [
                'nom' => htmlspecialchars($nom),  // Toujours sécuriser l'affichage
                'prix' => (float) $prix,
                'quantite' => 1,
                'image' => htmlspecialchars($image)
            ];
        }

        // Réponse HTML : alerte Bootstrap pour succès
        echo '<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
                ✅ <strong>' . htmlspecialchars($nom) . '</strong> a été ajouté au panier !
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
              </div>';

    } else {
        // Si des données sont manquantes
        echo '<div class="alert alert-danger mt-3" role="alert">
                ❌ Erreur : Données manquantes.
              </div>';
    }

} else {
    // Si la requête n'est pas de type POST
    echo '<div class="alert alert-danger mt-3" role="alert">
            ❌ Erreur : Requête invalide.
          </div>';
}
?>
