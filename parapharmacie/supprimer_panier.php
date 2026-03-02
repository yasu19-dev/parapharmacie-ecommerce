<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? null;

    if ($id !== null && isset($_SESSION['panier'][$id])) {
        // Supprimer le produit du panier
        unset($_SESSION['panier'][$id]);
    }
}

// Redirection vers la page panier
header('Location: panier.php');
exit;
