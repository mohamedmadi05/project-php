<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: /store/pages/profil.php");
    exit;
}

$titre = "Ajouter produit";
require __DIR__ . '/../includes/header.php';
?>

<div class="container py-5">

    <h1 class="mb-4">➕ Ajouter un produit</h1>

    <form action="save.php" method="POST" class="card p-4">

        <input type="text" name="nom" class="form-control mb-2" placeholder="Nom produit" required>

        <input type="text" name="categorie" class="form-control mb-2" placeholder="Catégorie" required>

        <input type="number" step="0.01" name="prix" class="form-control mb-2" placeholder="Prix" required>

        <input type="number" name="stock" class="form-control mb-2" placeholder="Stock" required>

        <input type="text" name="image" class="form-control mb-2" placeholder="Nom image (ex: pc.jpg)" required>

        <button class="btn btn-success">
            💾 Enregistrer
        </button>

    </form>

</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>