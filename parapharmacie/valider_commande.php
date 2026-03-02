<?php
session_start();
include '../includes/connexion.php';

$panier = $_SESSION['panier'] ?? [];
$errors = [];
$succes = false;
$commande_id = null;

function sanitize_input(string $data): string {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = sanitize_input($_POST['nom'] ?? '');
    $prenom = sanitize_input($_POST['prenom'] ?? '');
    $adresse = sanitize_input($_POST['adresse'] ?? '');
    $telephone = sanitize_input($_POST['telephone'] ?? '');
    $email = sanitize_input($_POST['email'] ?? '');

    // Validation
    if ($nom === '') { $errors['nom'] = "Le nom est obligatoire."; }
    if ($prenom === '') { $errors['prenom'] = "Le prénom est obligatoire."; }
    if ($adresse === '') { $errors['adresse'] = "L'adresse est obligatoire."; }
    if ($telephone === '') {
        $errors['telephone'] = "Le téléphone est obligatoire.";
    } elseif (!preg_match('/^[0-9 +\-]+$/', $telephone)) {
        $errors['telephone'] = "Le numéro de téléphone est invalide.";
    }
    if ($email === '') {
        $errors['email'] = "L'email est obligatoire.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "L'email n'est pas valide.";
    }
    if (empty($panier)) {
        $errors['global'] = "Votre panier est vide. Impossible de passer la commande.";
    }

    // Traitement si pas d'erreurs
    if (empty($errors)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO commandes (nom, prenom, adresse, telephone, email, date_commande) VALUES (?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$nom, $prenom, $adresse, $telephone, $email]);
            $commande_id = $pdo->lastInsertId();
            $_SESSION['last_commande_id'] = $commande_id;

            // === AJOUT === : insertion avec prix dans commande_produits
            $stmt_produit = $pdo->prepare("INSERT INTO commande_produits (commande_id, produit_id, quantite, prix) VALUES (?, ?, ?, ?)");
            foreach ($panier as $produit_id => $item) {
                // Récupérer le prix actuel du produit
                $stmt_prix = $pdo->prepare("SELECT prix FROM produits WHERE id = ?");
                $stmt_prix->execute([$produit_id]);
                $prix_produit = $stmt_prix->fetchColumn();

                $stmt_produit->execute([$commande_id, $produit_id, $item['quantite'], $prix_produit]);
            }
            // === FIN AJOUT ===

            unset($_SESSION['panier']);
            $succes = true;
        } catch (PDOException $e) {
            $errors['global'] = "Erreur lors de l'enregistrement : " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Valider la commande | Parapharmacie YI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        body { 
            background-color: #f4f6f8;
             font-family: 'Inter', sans-serif; 
            }
        .form-container { 
            max-width: 700px;
             margin: 50px auto; 
             padding: 35px;
              background: #fff; 
              border-radius: 16px; 
              box-shadow: 0 12px 24px rgba(0,0,0,0.08); 
            }
        .form-title { 
            font-weight: 700;
             font-size: 26px;
              text-align: center;
               margin-bottom: 25px;
             }
        .btn-success { 
            background-color: #28a745; 
            border-color: #28a745;
             font-weight: 600; 
             padding: 10px 25px; 
             border-radius: 8px; 
            }
        .btn-success:hover { 
            background-color: #218838; 
        }
        .btn-secondary { 
            border-radius: 8px;
             padding: 10px 25px;
             }
        .invalid-feedback {
             font-size: 0.9rem; 
             color: #e74c3c;
             }
        .form-label {
             font-weight: 600;
             }
        .recu-container { 
            margin-top: 40px;
             border-top: 2px dashed #ccc; 
             padding-top: 30px; 
            }
        table {
             width: 100%; 
            border-collapse: collapse;
             margin-top: 20px; 
            }
        th, td {
             border: 1px solid #aaa; 
             padding: 10px;
              text-align: left;
             }
        th { 
            background: #f2f2f2;
         }
        .total {
             text-align: right; 
             font-weight: bold; 
             margin-top: 10px;
             }
        .btn-print {
             margin-top: 20px;
              background: #333;
               color: white;
                border: none; 
                padding: 10px 20px; 
                border-radius: 6px; 
            }
        @media print { 
            .btn-print, .btn-success, .btn-secondary { display: none; } 
        }
    </style>
</head>
<body>

<div class="container">
    <div class="form-container">
        <?php if ($succes): ?>
            <div class="alert alert-success text-center">
                ✅ Merci pour votre commande ! Elle a bien été prise en compte.
            </div>

            <div class="text-center mt-4">
                <a href="produits.php" class="btn btn-secondary">Retour à l'accueil</a>
            </div>

            <?php
            // Afficher le reçu après commande validée
            $stmt = $pdo->prepare("SELECT * FROM commandes WHERE id = ?");
            $stmt->execute([$commande_id]);
            $commande = $stmt->fetch();

            // === AJOUT === : récupération du prix depuis commande_produits
            $stmt = $pdo->prepare("
                SELECT p.nom, cp.prix, cp.quantite 
                FROM commande_produits cp 
                JOIN produits p ON cp.produit_id = p.id 
                WHERE cp.commande_id = ?
            ");
            $stmt->execute([$commande_id]);
            $produits = $stmt->fetchAll();
            // === FIN AJOUT ===
            ?>

            <div class="recu-container">
                <h3>🧾 Reçu de commande</h3>
                <p><strong>Nom :</strong> <?= htmlspecialchars($commande['nom']) ?></p>
                <p><strong>Prénom :</strong> <?= htmlspecialchars($commande['prenom']) ?></p>
                <p><strong>Adresse :</strong> <?= htmlspecialchars($commande['adresse']) ?></p>
                <p><strong>Téléphone :</strong> <?= htmlspecialchars($commande['telephone']) ?></p>
                <p><strong>Email :</strong> <?= htmlspecialchars($commande['email']) ?></p>
                <p><strong>Date :</strong> <?= $commande['date_commande'] ?></p>

                <table>
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix (DH)</th>
                            <th>Total (DH)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $total = 0; ?>
                        <?php foreach ($produits as $p): ?>
                            <?php $sous_total = $p['prix'] * $p['quantite']; $total += $sous_total; ?>
                            <tr>
                                <td><?= htmlspecialchars($p['nom']) ?></td>
                                <td><?= $p['quantite'] ?></td>
                                <td><?= number_format($p['prix'], 2) ?></td>
                                <td><?= number_format($sous_total, 2) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="total">Total à payer : <?= number_format($total, 2) ?> DH</p>

                <button onclick="window.print()" class="btn-print">🖨 Imprimer ou enregistrer en PDF</button>
            </div>

        <?php else: ?>
            <h2 class="form-title">Formulaire de livraison</h2>

            <?php if (isset($errors['global'])): ?>
                <div class="alert alert-danger mb-4"><?= $errors['global'] ?></div>
            <?php endif; ?>

            <form method="POST" action="valider_commande.php" novalidate>
                <div class="mb-4">
                    <label for="nom" class="form-label">Nom *</label>
                    <input type="text" id="nom" name="nom" class="form-control <?= isset($errors['nom']) ? 'is-invalid' : '' ?>" value="<?= $_POST['nom'] ?? '' ?>" placeholder="Votre nom">
                    <?php if (isset($errors['nom'])): ?><div class="invalid-feedback"><?= $errors['nom'] ?></div><?php endif; ?>
                </div>
                <div class="mb-4">
                    <label for="prenom" class="form-label">Prénom *</label>
                    <input type="text" id="prenom" name="prenom" class="form-control <?= isset($errors['prenom']) ? 'is-invalid' : '' ?>" value="<?= $_POST['prenom'] ?? '' ?>" placeholder="Votre prénom">
                    <?php if (isset($errors['prenom'])): ?><div class="invalid-feedback"><?= $errors['prenom'] ?></div><?php endif; ?>
                </div>
                <div class="mb-4">
                    <label for="adresse" class="form-label">Adresse *</label>
                    <textarea id="adresse" name="adresse" class="form-control <?= isset($errors['adresse']) ? 'is-invalid' : '' ?>" rows="4" placeholder="Votre adresse complète"><?= $_POST['adresse'] ?? '' ?></textarea>
                    <?php if (isset($errors['adresse'])): ?><div class="invalid-feedback"><?= $errors['adresse'] ?></div><?php endif; ?>
                </div>
                <div class="mb-4">
                    <label for="telephone" class="form-label">Téléphone *</label>
                    <input type="tel" id="telephone" name="telephone" class="form-control <?= isset($errors['telephone']) ? 'is-invalid' : '' ?>" value="<?= $_POST['telephone'] ?? '' ?>" placeholder="+212 X XX XX XX XX">
                    <?php if (isset($errors['telephone'])): ?><div class="invalid-feedback"><?= $errors['telephone'] ?></div><?php endif; ?>
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label">Email *</label>
                    <input type="email" id="email" name="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" value="<?= $_POST['email'] ?? '' ?>" placeholder="exemple@mail.com">
                    <?php if (isset($errors['email'])): ?><div class="invalid-feedback"><?= $errors['email'] ?></div><?php endif; ?>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="submit" class="btn btn-success">Valider la commande</button>
                    <a href="produits.php" class="btn btn-secondary">Retour au panier</a>
                </div>
            </form>
        <?php endif; ?>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let firstErrorInput = document.querySelector('.is-invalid');
        if (firstErrorInput) {
            firstErrorInput.focus();
        }
    });
</script>

</body>
</html>