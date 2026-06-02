<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once("../includes/db.php");

$error = "";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $prenom   = trim($_POST['prenom'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (empty($prenom) || empty($email) || empty($password)) {
        $error = "Tous les champs sont obligatoires";
    } else {

        // check if email already exists
        $check = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $check->execute([$email]);

        if ($check->fetch()) {

            $error = "Cet email existe déjà";

        } else {

            $sql = "INSERT INTO users (prenom, email, password, role)
                    VALUES (?, ?, ?, 'user')";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([$prenom, $email, $password]);

            
            $user_id = $pdo->lastInsertId();

            $_SESSION['user'] = [
                'id' => $user_id,
                'prenom' => $prenom,
                'email' => $email,
                'role' => 'user'
            ];

          
            header("Location: /store/pages/profil.php");
            exit;
        }
    }
}

require_once("../includes/header.php");
?>

<div class="container mt-5">

    <div class="col-md-6 mx-auto">

        <div class="card">

            <div class="card-header">
                📝 Créer un compte
            </div>

            <div class="card-body">

                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form method="POST">

                    <div class="mb-3">
                        <label>Prénom</label>
                        <input type="text" name="prenom" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Mot de passe</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button class="btn btn-success w-100">
                        Créer mon compte
                    </button>

                </form>

                <p class="mt-3 text-center">
                    Déjà un compte ?
                    <a href="/store/pages/compte.php">Se connecter</a>
                </p>

            </div>

        </div>

    </div>

</div>

<?php require_once("../includes/footer.php"); ?>