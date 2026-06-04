<?php

$title = "Accueil";

$connecte = true;

// Header
if ($connecte) {
    require_once __DIR__ . '/includes/header.php';
} else {
    require_once __DIR__ . '/includes/404.php';
    exit;
}

$prenom = $_COOKIE['prenom'] ?? '';

?>

<?php if ($connecte): ?>

<div class="container mt-5">

    <?php if (!empty($prenom)): ?>

        <div class="alert alert-info">
            👋 Hello <strong><?= htmlspecialchars($prenom) ?></strong>
            <h1>Welcome to our store</h1>
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

    <div class="alert alert-danger">
        Veuillez vous connecter pour accéder aux produits de notre boutique.
    </div>

    <a href="index.php" class="btn btn-primary">
        Retour à l'accueil
    </a>

</div>

<?php endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>