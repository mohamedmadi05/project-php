<?php
include '../includes/header.php';

$message = "";
$fichier = "../newsletter.txt";

// Create file if it doesn't exist
if (!file_exists($fichier)) {
    file_put_contents($fichier, "");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = trim($_POST["email"]);

    if (empty($email)) {
        $message = "<div class='alert alert-danger'>Veuillez saisir un email.</div>";
    }
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert alert-danger'>Le format de l'email est invalide.</div>";
    }
    else {

        $dateHeure = date("d/m/Y H:i");

        $ligne = $email . " - " . $dateHeure . PHP_EOL;

        file_put_contents($fichier, $ligne, FILE_APPEND);

        $message = "<div class='alert alert-success'>Inscription réussie.</div>";
    }
}

// Count subscribers
$lignes = file($fichier, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
$nbInscrits = count($lignes);
?>

<div class="container mt-5">

    <h1>Newsletter</h1>

    <?= $message ?>

    <form method="POST">

        <div class="mb-3">
            <label class="form-label">Email</label>

            <input
                type="email"
                name="email"
                class="form-control"
                required>
        </div>

        <button type="submit" class="btn btn-primary">
            S'abonner
        </button>

    </form>

    <p class="mt-3">
        📊 <?= $nbInscrits ?> personnes inscrites.
    </p>

</div>

<?php
include '../includes/footer.php';
?>