<?php
session_start();

// Exemple : le panier est stocké en session comme tableau associatif
// Format attendu : $_SESSION['panier'] = [
//    id_produit => ['nom' => ..., 'prix' => ..., 'quantite' => ...],
//    ...
// ];

$panier = $_SESSION['panier'] ?? [];

// Calcul du total
$total = 0;
foreach ($panier as $item) {
    $total += $item['prix'] * $item['quantite'];
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Panier | Parapharmacie YI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

  <style>
    body {
      background: #f9f7fb;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
      padding: 2rem;
    }

    .card-panier {
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(168, 92, 161, 0.25);
      margin-bottom: 1.5rem;
      padding: 1rem;
      background: #fff;
      display: flex;
      align-items: center;
    }

    .card-panier img {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 12px;
      margin-right: 1.5rem;
    }

    .card-details {
      flex-grow: 1;
    }

    .card-details h5 {
      color: #8b3a84;
      font-weight: 700;
      margin-bottom: 0.5rem;
    }

    .card-details p {
      font-weight: 600;
      color: #b55ca1;
      margin-bottom: 0.25rem;
    }

    .btn-supprimer {
      background-color: #d96bc9;
      border: none;
      color: white;
      border-radius: 12px;
      padding: 8px 16px;
      font-weight: 600;
      transition: background-color 0.3s ease;
      cursor: pointer;
    }

    .btn-supprimer:hover {
      background-color: #b14f9a;
    }
    .btn-primary {
      background-color: #8b3a84;
      border: none;
      font-weight: 600;
      border-radius: 12px;
      padding: 10px 18px;
      transition: background-color 0.3s ease;
      color: white;
      align-self: flex-start;
    }

    .btn-primary:hover {
      background-color: #b14f9a;
    }

    .total-panier {
      font-size: 1.5rem;
      font-weight: 700;
      color: #8b3a84;
      text-align: right;
      margin-top: 2rem;
    }
  </style>
</head>
<body>
  <?php
     include '../includes/header.php';
  ?>

  

  <?php if (empty($panier)): ?>
  <div style="max-width: 400px; margin: 3rem auto; padding: 2rem; background: #f3e5f5; border-radius: 20px; box-shadow: 0 4px 15px rgba(139, 58, 132, 0.3); text-align: center; color: #6a1b9a; font-weight: 600; font-size: 1.25rem;">
    <i class="fas fa-shopping-cart" style="font-size: 4rem; margin-bottom: 1rem; color: #8b3a84;"></i>
    <p>Votre panier est vide pour l’instant.</p>
    <p>Explorez nos produits et faites-vous plaisir !</p>
    <a href="produits.php" class="btn" style="background-color: #8b3a84; color: white; font-weight: 700; padding: 10px 25px; border-radius: 12px; transition: background-color 0.3s ease;">
      Retour à l'accueil
    </a>
  </div>

  <style>
    .btn:hover {
      background-color: #b14f9a !important;
      color: white !important;
    }
  </style>
<?php else: ?>



    <?php foreach ($panier as $id => $item): ?>
      <div class="card-panier mt-5">
        
        <img src="<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['nom']) ?>">

        <div class="card-details">
          <h5><?= htmlspecialchars($item['nom']) ?></h5>
          <p>Prix unitaire : <?= number_format($item['prix'], 2, ',', ' ') ?> DH</p>
          <p>Quantité : <?= intval($item['quantite']) ?></p>
          <p>Sous-total : <?= number_format($item['prix'] * $item['quantite'], 2, ',', ' ') ?> DH</p>
        </div>

        <form method="post" action="supprimer_panier.php" onsubmit="return confirm('Supprimer cet article ?');">
          <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
          <button type="submit" class="btn-supprimer"><i class="fas fa-trash-alt"></i> Supprimer</button>
        </form>
      </div>
    <?php endforeach; ?>

    <div class="total-panier">
      Total : <?= number_format($total, 2, ',', ' ') ?> DH
    </div>

    <div class="text-end mt-4">
      <a href="valider_commande.php" class="btn btn-lg" style="background-color: #8b3a84; color: white; font-weight: 700; padding: 10px 25px; border-radius: 12px; transition: background-color 0.3s ease;">Valider la commande</a>
    </div>

  <?php endif; ?>
  <script src="../assets/js/script.js"></script>
  <?php
    include '../includes/footer.php';
  ?>

</body>
</html>
