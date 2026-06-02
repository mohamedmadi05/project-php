<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: /store/pages/compte.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

 
    if (isset($_POST["deleteCookies"])) {

        setcookie("prenom", "", time() - 3600, "/");
        setcookie("theme", "", time() - 3600, "/");
        setcookie("langue", "", time() - 3600, "/");

        header("Location: profil.php");
        exit;
    }

    
    $prenom = trim($_POST["prenom"] ?? "");
    $theme  = $_POST["theme"] ?? "clair";
    $langue = $_POST["langue"] ?? "fr";

    setcookie("prenom", $prenom, time() + (365 * 24 * 60 * 60), "/");
    setcookie("theme", $theme, time() + (365 * 24 * 60 * 60), "/");
    setcookie("langue", $langue, time() + (30 * 24 * 60 * 60), "/");

    header("Location: profil.php");
    exit;
}


$prenom = $_COOKIE["prenom"] ?? "";
$theme  = $_COOKIE["theme"] ?? "";
$langue = $_COOKIE["langue"] ?? "";


$user = $_SESSION['user'];


require_once("../includes/header.php");

?>

<div class="container mt-5">

    

    <?php if ($user['role'] === 'admin'): ?>
        <div class="alert alert-warning">
            👑 Bienvenue Admin <?= htmlspecialchars($user['prenom']) ?>
        </div>
    <?php else: ?>
        <div class="alert alert-success">
            👋 Bienvenue <?= htmlspecialchars($user['prenom']) ?>
        </div>
    <?php endif; ?>

    <h1 class="mb-3">⚙️ Mes Préférences</h1>

    <p class="text-light">
        Vos préférences sont sauvegardées dans des cookies.
    </p>

    <?php if (!empty($prenom)): ?>
        <div class="alert alert-success">
            ✅ Prénom « <?= htmlspecialchars($prenom) ?> » enregistré.
        </div>
    <?php endif; ?>

    <?php if (!empty($theme)): ?>
        <div class="alert alert-success">
            🎨 Thème « <?= htmlspecialchars($theme) ?> » enregistré.
        </div>
    <?php endif; ?>

    <?php if (!empty($langue)): ?>
        <div class="alert alert-success">
            🌍 Langue « <?= htmlspecialchars($langue) ?> » enregistrée.
        </div>
    <?php endif; ?>

    <div class="row">

        <!-- FORM -->
        <div class="col-md-7">

            <div class="card mb-4">

                <div class="card-header">
                    📝 Renseigner mes préférences
                </div>

                <div class="card-body">

                    <form method="post">

                        <div class="mb-3">
                            <label>Votre prénom</label>
                            <input type="text" name="prenom" class="form-control"
                                value="<?= htmlspecialchars($prenom) ?>">
                        </div>

                        <div class="mb-3">
                            <label>Thème</label><br>

                            <label>
                                <input type="radio" name="theme" value="clair"
                                    <?= ($theme === "clair") ? "checked" : "" ?>>
                                ☀️ Clair
                            </label>

                            <label class="ms-3">
                                <input type="radio" name="theme" value="sombre"
                                    <?= ($theme === "sombre") ? "checked" : "" ?>>
                                🌙 Sombre
                            </label>
                        </div>

                        <div class="mb-3">
                            <label>Langue</label>

                            <select name="langue" class="form-select">
                                <option value="fr" <?= ($langue === "fr") ? "selected" : "" ?>>Français</option>
                                <option value="en" <?= ($langue === "en") ? "selected" : "" ?>>English</option>
                                <option value="es" <?= ($langue === "es") ? "selected" : "" ?>>Español</option>
                            </select>
                        </div>

                        <button class="btn btn-primary">💾 Sauvegarder</button>

                    </form>

                    <form method="post" class="mt-3">
                        <button name="deleteCookies" class="btn btn-danger">
                            🗑️ Tout effacer
                        </button>
                    </form>

                </div>

            </div>

        </div>

        <!-- COOKIES TABLE -->
        <div class="col-md-5">

            <div class="card">

                <div class="card-header">
                    🍪 Cookies
                </div>

                <div class="card-body">

                    <table class="table">
                        <tr><th>prenom</th><td><?= $prenom ?: "—" ?></td></tr>
                        <tr><th>theme</th><td><?= $theme ?: "—" ?></td></tr>
                        <tr><th>langue</th><td><?= $langue ?: "—" ?></td></tr>
                    </table>

                </div>

            </div>

           
            <?php if ($user['role'] === 'admin'): ?>

                <div class="card mt-4 border-warning">

                    <div class="card-header bg-warning">
                        🔐 Admin Panel
                    </div>

                    <div class="card-body">

                        <p>Accès administrateur activé.</p>

                        <ul>
                            <li>Gérer les produits</li>
                            <li>Gérer les utilisateurs</li>
                            <li>Voir les commandes</li>
                        </ul>

                        <a href="/store/admin/index.php" class="btn btn-dark">
                            Aller au dashboard admin
                        </a>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>

<?php require_once("../includes/footer.php"); ?>