<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../includes/db.php");


if (isset($_SESSION['user'])) {
    header('Location: /store/pages/profil.php');
    exit;
}

$error = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && $password === $user['password']) {

        $_SESSION['user'] = [
            'id' => $user['id'],
            'prenom' => $user['prenom'],
            'email' => $user['email'],
            'role' => $user['role']
        ];

        header('Location: /store/pages/profil.php');
        exit;
    }

    $error = "Email ou mot de passe incorrect";
}

require_once("../includes/header.php");
?>

<div class="container mt-5">

    <div class="col-md-6 mx-auto">

        <div class="card">

            <div class="card-header">
                🔐 Connexion
            </div>

            <div class="card-body">

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">
                        <label>Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            required>
                    </div>

                    <div class="mb-3">
                        <label>Mot de passe</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            required>
                    </div>

                    <button
                        type="submit"
                        class="btn btn-primary w-100">
                        Se connecter
                    </button>

                </form>

            </div>

        </div>

    </div>
<p class="text-center mt-3">
    Pas de compte ?
    <a href="/store/pages/inscription.php">Créer un compte</a>
</p>
</div>

<?php require_once("../includes/footer.php"); ?>