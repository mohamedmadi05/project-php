<?php

$title = "Accueil";

$connecte = true; 

if ($connecte):
    require __DIR__ . '/includes/header.php';
else:
    require __DIR__ . '/includes/404.php';
endif;


$prenom = $_COOKIE['prenom'] ?? '';

?>

<?php if ($connecte): ?>

<div class="container mt-5">
    <?php if (!empty($prenom)): ?>

        <div class="alert alert-info">
        <label for="">    👋 hello  <strong><?= htmlspecialchars($prenom) ?></strong>
            <h1> Welcome to our store</h1></label>
        </div>
        <p>
            Votre profil est enregistré dans les cookies.
        </p>
        <a href="pages/profil.php" class="btn btn-primary">
            Modifier mes préférences
        </a>
    <?php else: ?>
        <div class="alert alert-warning">
            Aucun profil trouvé.
        </div>
        <p>
            Créez votre profil pour enregistrer vos préférences.
        </p>
        <a href="pages/profil.php" class="btn btn-success">
            Créer mon profil
        </a>
    <?php endif; ?>

</div>

<?php else: ?>

<div class="container mt-5">

    <p class="alert alert-danger">
        Veuillez vous connecter pour accéder aux produits de notre boutique.
    </p>

    <a href="/store/index.php" class="btn btn-primary">
        Retour à l'accueil
    </a>

</div>

<?php endif; ?>

<?php require __DIR__ . '/includes/footer.php'; ?>