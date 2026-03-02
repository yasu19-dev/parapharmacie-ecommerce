<?php
session_start();

$compteur = 0;

if (!empty($_SESSION['panier'])) {
    // Soit tu veux le total des quantités
    foreach ($_SESSION['panier'] as $item) {
        $compteur += $item['quantite'];  // Somme des quantités
    }

    // Ou bien si tu veux juste le nombre d'articles différents
    // $compteur = count($_SESSION['panier']);
}

echo $compteur;

?>
