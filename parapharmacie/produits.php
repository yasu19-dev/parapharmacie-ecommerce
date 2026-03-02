<?php
session_start();
$produits = json_decode(file_get_contents("C:/wamp64/www/PROJET/data/produits.json"), true);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <title>Produits | Parapharmacie YI</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
  


  <style>
    body {
      background: linear-gradient(135deg, #fdf1f9 0%, #ede3f5 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
    }

    /* Navbar custom */
    .navbar {
      background-color: #fce6f4;
      box-shadow: 0 4px 10px rgba(200, 150, 220, 0.2);
      position: relative; /* important pour dropdown */
    }

    .navbar-brand,
    .nav-link {
      color: #914aa3 !important;
      font-weight: 500;
      transition: color 0.3s ease;
      cursor: pointer;
    }

    .navbar-brand:hover,
    .nav-link:hover {
      color: #c55da1 !important;
    }

    /* Dropdown contact card */
    #contactDropdown {
      position: absolute;
      top: 100%; /* juste sous la navbar */
      right: 10px; /* à droite */
      background: #fff0f7;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(168, 92, 161, 0.35);
      padding: 20px 30px;
      width: 280px;
      display: none; /* caché par défaut */
      z-index: 1050;
      color: #8b3a84;
      font-weight: 600;
      text-align: center;
    }

    #contactDropdown h3 {
      margin-bottom: 15px;
    }

    #contactDropdown p {
      font-size: 1.1rem;
      margin-bottom: 10px;
    }

    /* Cartes produits */
    .card {
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(168, 92, 161, 0.25);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
      background: #fff;

      display: flex;
      flex-direction: column;
      height: 100%;
      min-height: 350px;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 40px rgba(168, 92, 161, 0.45);
    }

    .card-img-top {
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
      height: 200px;
      object-fit: cover;
    }

    .card-body {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 1rem;
    }

    .card-title {
      color: #8b3a84;
      font-weight: 700;
      font-size: 1.25rem;
      margin-bottom: 0.5rem;
    }

    .card-text {
      color: #b55ca1;
      font-weight: 700;
      font-size: 1.1rem;
      margin-bottom: 1rem;
    }

    .btn-primary {
      background-color: #d96bc9;
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
    .badge-custom {
     background-color: #8b3a84; /* un violet foncé assorti à ton thème */
     color: white;
}
#compteur-panier {
  position: absolute;
  top: 20%;   /* Ajuste cette valeur pour descendre ou monter le badge */
  left: 90%; /* Ajuste pour le décaler un peu à droite du panier */
  transform: translate(0, -50%);
  background-color:rgb(115, 73, 132); /* Une couleur violette assortie à ton thème */
  color: white;
  padding: 3px 7px;
  border-radius: 40%;
  font-size: 0.8rem;
  font-weight: bold;
  z-index: 10;
}


  </style>
</head>
<body>

<!-- NAVBAR -->
 <!doctype html>
<html lang="en">
  <head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
      crossorigin="anonymous"
    />
    <style>
      
    body {
      background: linear-gradient(135deg, #fdf1f9 0%, #ede3f5 100%);
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      min-height: 100vh;
    }

    /* Navbar custom */
    .navbar {
      background-color: #fce6f4;
      box-shadow: 0 4px 10px rgba(200, 150, 220, 0.2);
      position: relative; /* important pour dropdown */
    }

    .navbar-brand,
    .nav-link {
      color: #914aa3 !important;
      font-weight: 500;
      transition: color 0.3s ease;
      cursor: pointer;
    }

    .navbar-brand:hover,
    .nav-link:hover {
      color: #c55da1 !important;
    }

    /* Dropdown contact card */
    #contactDropdown {
      position: absolute;
      top: 100%; /* juste sous la navbar */
      right: 10px; /* à droite */
      background: #fff0f7;
      border-radius: 15px;
      box-shadow: 0 8px 30px rgba(168, 92, 161, 0.35);
      padding: 20px 30px;
      width: 350px;
      display: none; /* caché par défaut */
      z-index: 1050;
      color: #8b3a84;
      font-weight: 600;
      text-align: center;
    }

    #contactDropdown h3 {
      margin-bottom: 15px;
    }

    #contactDropdown p {
      font-size: 1.1rem;
      margin-bottom: 10px;
    }

    /* Cartes produits */
    .card {
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(168, 92, 161, 0.25);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      cursor: pointer;
      background: #fff;

      display: flex;
      flex-direction: column;
      height: 100%;
      min-height: 350px;
    }

    .card:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 40px rgba(168, 92, 161, 0.45);
    }

    .card-img-top {
      border-top-left-radius: 20px;
      border-top-right-radius: 20px;
      height: 200px;
      object-fit: cover;
    }

    .card-body {
      flex-grow: 1;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      padding: 1rem;
    }

    .card-title {
      color: #8b3a84;
      font-weight: 700;
      font-size: 1.25rem;
      margin-bottom: 0.5rem;
    }

    .card-text {
      color: #b55ca1;
      font-weight: 700;
      font-size: 1.1rem;
      margin-bottom: 1rem;
    }

    .btn-primary {
      background-color: #d96bc9;
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
    .badge-custom {
     background-color: #8b3a84; /* un violet foncé assorti à ton thème */
     color: white;
}
#compteur-panier {
  position: absolute;
  top: 20%;   /* Ajuste cette valeur pour descendre ou monter le badge */
  left: 90%; /* Ajuste pour le décaler un peu à droite du panier */
  transform: translate(0, -50%);
  background-color:rgb(115, 73, 132); /* Une couleur violette assortie à ton thème */
  color: white;
  padding: 3px 7px;
  border-radius: 40%;
  font-size: 0.8rem;
  font-weight: bold;
  z-index: 10;
}
    </style>
  </head>

  <body>
    <header>
      <nav class="navbar navbar-expand-lg">
  <div class="container position-relative">
    <a class="navbar-brand d-flex align-items-center" href="index.html">
      <i class="fas fa-heartbeat me-2"></i> Parapharmacie YI
    </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" 
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon" style="filter: invert(1);"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-center">
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center" href="index.html">
            <i class="fas fa-home me-2"></i> Accueil
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link d-flex align-items-center position-relative" href="panier.php">
            <i class="fas fa-shopping-cart me-2"></i> Panier
            <span id="compteur-panier">0</span>
          </a>
        </li>
        <li class="nav-item position-relative">
          <a id="contactToggle" class="nav-link d-flex align-items-center" href="#">
            <i class="fas fa-phone-alt me-2"></i> Contact
          </a>

          <!-- Dropdown contact card -->
          <div id="contactDropdown" role="menu" aria-labelledby="contactToggle">
            <h3>Contactez Parapharmacie YI</h3>
            <p><i class="fas fa-phone"></i> Téléphone : <a href="tel:+212539394939">+212 539394939</a></p>
            <p><i class="fas fa-envelope"></i> Email : <a href="mailto:contact@parapharmacie-yi.com">contact@parapharmacie-yi.com</a></p>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

    </header>
    <script
      src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
      integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
      crossorigin="anonymous"
    ></script>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
      integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
      crossorigin="anonymous"
    ></script>
  </body>
</html>





<!-- CONTENU PRODUITS -->


<div class="container my-5">
  <h2 class="text-center mb-5" style="color:#8b3a84;">Nos Produits Cosmétiques</h2>
  <div class="row g-4">

    <?php foreach ($produits as $produit): ?>
      <div class="col-12 col-sm-6 col-md-4 col-lg-3">
        <div class="card shadow-sm">
          <img src="<?= htmlspecialchars($produit['image']) ?>" class="card-img-top" alt="<?= htmlspecialchars($produit['nom']) ?>">
          <div class="card-body">
            <h5 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h5>
            <p class="card-text text-success fw-bold"><?= number_format($produit['prix'], 2, ',', ' ') ?> DH</p>
            <button class="btn btn-primary ajouter-panier"
                    data-id="<?= htmlspecialchars($produit['id']) ?>"
                    data-nom="<?= htmlspecialchars($produit['nom']) ?>"
                    data-prix="<?= htmlspecialchars($produit['prix']) ?>"
                    data-image="<?= htmlspecialchars($produit['image']) ?>">Ajouter au panier</button>
          </div>
        </div>
      </div>
    <?php endforeach; ?>

  </div>
</div>
<div id="message-panier"></div>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script src="../assets/js/script.js"></script>

<footer style="margin-top: auto; text-align: center; color: #a64ca6; padding: 15px 0; font-size: 0.9rem; font-weight: bold;">
  © 2025 YI Parapharmacie - Tous droits réservés
</footer>

</body>
</html>
