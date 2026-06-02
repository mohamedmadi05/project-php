<?php
include '../includes/header.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['secret'])) {
    $_SESSION['secret'] = rand(1, 10);
    $_SESSION['tentatives'] = 0;
}

$message = "";
$coupon = "";
$reduction = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $proposition = intval($_POST['nombre']);

    $_SESSION['tentatives']++;

    if ($proposition == $_SESSION['secret']) {

        $t = $_SESSION['tentatives'];

        if ($t == 1) {
            $coupon = "BEST30";
            $reduction = 30;
        }
        elseif ($t == 2) {
            $coupon = "CODE25";
            $reduction = 25;
        }
        elseif ($t == 3) {
            $coupon = "WIN20";
            $reduction = 20;
        }
        elseif ($t == 4) {
            $coupon = "TRY15";
            $reduction = 15;
        }
        else {
            $coupon = "LAST10";
            $reduction = 10;
        }

        // STORE IN SESSION (IMPORTANT)
        $_SESSION['coupon'] = $coupon;
        $_SESSION['reduction'] = $reduction;

        $message = "Bravo ! Coupon obtenu : $coupon (-$reduction%)";

        unset($_SESSION['secret']);
        unset($_SESSION['tentatives']);
    }
    else {
        $message = "Mauvaise réponse. Réessayez.";
    }
}
?>

<div class="container mt-5 text-center">

    <h1>🎰 Gagnez un coupon de réduction !</h1>

    <p>Devinez le nombre secret entre 1 et 10.</p>

    <div class="card p-3">

        <p>Tentatives : <?= $_SESSION['tentatives'] ?? 0 ?></p>

        <form method="POST">
            <input type="number" min="1" max="10" name="nombre" class="form-control mb-3" required>
            <button class="btn btn-primary">Valider</button>
        </form>

    </div>

    <?php if ($message): ?>
        <div class="alert alert-info mt-3">
            <?= $message ?>
        </div>
    <?php endif; ?>

</div>

<?php include '../includes/footer.php'; ?>