<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: /store/pages/profil.php");
    exit;
}

$titre = "Modifier Produit";

$file = __DIR__ . '/../data/produits.csv';

$id = $_GET['id'] ?? '';

$produits = [];
$produit = null;

if (($handle = fopen($file, "r")) !== false) {

    $header = fgetcsv($handle, 10000, ",");

    while (($row = fgetcsv($handle, 10000, ",")) !== false) {

        $produits[] = $row;

        if ($row[0] == $id) {
            $produit = $row;
        }
    }

    fclose($handle);
}

if (!$produit) {
    die("Produit introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    foreach ($produits as &$row) {

        if ($row[0] == $id) {

            $row[1] = trim($_POST['nom']);
            $row[2] = trim($_POST['categorie']);
            $row[3] = trim($_POST['prix']);
            $row[4] = trim($_POST['stock']);
            $row[5] = trim($_POST['image']);
        }
    }

    $handle = fopen($file, "w");

    fputcsv($handle, $header, ",");

    foreach ($produits as $row) {
        fputcsv($handle, $row, ",");
    }

    fclose($handle);

    header("Location: index.php");
    exit;
}

require __DIR__ . '/../includes/header.php';
?>

<div class="container py-5">

    <h1 class="mb-4">✏️ Modifier Produit</h1>

    <form method="post">

        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input
                type="text"
                name="nom"
                class="form-control"
                value="<?= htmlspecialchars($produit[1]) ?>"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Catégorie</label>
            <input
                type="text"
                name="categorie"
                class="form-control"
                value="<?= htmlspecialchars($produit[2]) ?>"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Prix</label>
            <input
                type="number"
                step="0.01"
                name="prix"
                class="form-control"
                value="<?= htmlspecialchars($produit[3]) ?>"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Stock</label>
            <input
                type="number"
                name="stock"
                class="form-control"
                value="<?= htmlspecialchars($produit[4]) ?>"
                required>
        </div>

        <div class="mb-3">
            <label class="form-label">Nom de l'image</label>
            <input
                type="text"
                name="image"
                class="form-control"
                value="<?= htmlspecialchars($produit[5]) ?>"
                required>
        </div>

        <div class="mb-3">
            <img
                src="/store/image/<?= htmlspecialchars($produit[5]) ?>"
                width="120"
                style="object-fit:contain;"
                alt="Produit">
        </div>

        <button type="submit" class="btn btn-success">
            💾 Enregistrer
        </button>

        <a href="index.php" class="btn btn-secondary">
            Retour
        </a>

    </form>

</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>