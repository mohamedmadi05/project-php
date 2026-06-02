<?php
include '../includes/header.php';

$messageSucces = "";
$erreurs = [];

$fichier = "../messages.txt";

if (!file_exists($fichier)) {
    touch($fichier);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = trim($_POST["nom"]);
    $email = trim($_POST["email"]);
    $sujet = trim($_POST["sujet"]);
    $message = trim($_POST["message"]);

    if (empty($nom)) {
        $erreurs[] = "Le nom est obligatoire.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erreurs[] = "Format d'email invalide.";
    }

    if (empty($message)) {
        $erreurs[] = "Le message est obligatoire.";
    }

    if (count($erreurs) == 0) {

        $ligne =
            date("d/m/Y H:i")
            ." | ".$nom
            ." | ".$email
            ." | ".$sujet
            ." | ".$message
            .PHP_EOL;

        file_put_contents($fichier, $ligne, FILE_APPEND);

        $messageSucces = "Votre message a bien été envoyé. Merci !";
    }
}
?>

<div class="container mt-5">

    <div class="row">

        <div class="col-md-8">

            <h1>Contactez-nous</h1>

            <p class="text-light">
                Nous vous répondrons dans les plus brefs délais.
            </p>

            <?php if(!empty($erreurs)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach($erreurs as $e): ?>
                            <li><?= $e ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>

            <?php if($messageSucces): ?>
                <div class="alert alert-success">
                    <?= $messageSucces ?>
                </div>
            <?php endif; ?>

            <form method="POST">

                <div class="mb-3">
                    <label class="form-label">Nom complet *</label>
                    <input
                        type="text"
                        name="nom"
                        class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email *</label>
                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Sujet *</label>

                    <select
                        name="sujet"
                        class="form-select">

                        <option>Information</option>
                        <option>Commande</option>
                        <option>Réclamation</option>
                        <option>Autre</option>

                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Message *</label>

                    <textarea
                        name="message"
                        rows="5"
                        class="form-control"
                        required></textarea>
                </div>

                <button
                    type="submit"
                    class="btn btn-primary">

                    Envoyer le message

                </button>

            </form>

        </div>

        <div class="col-md-4">

            <div class="card">
                <div class="card-body">

                    <h4>📍 our adress</h4>

                    <p>🏠 biougra/ 
                        ait melloul
                    </p>

                    <p>📞 0694708512/0657-038540

                    </p>

                    <p>📧 mohamedmadi@gmail.com/</p>

                </div>
            </div>

        </div>

    </div>

</div>

<?php
include '../includes/footer.php';
?>