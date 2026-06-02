<?php

$titre = "Détail produit";

$produit = null;


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Produit invalide.");
}

$id = (int) $_GET['id'];


if (($handle = fopen("../data/produits.csv", "r")) !== false) {

    fgetcsv($handle, 10000, ",");

    while (($row = fgetcsv($handle, 10000, ",")) !== false) {

        if (count($row) < 6) continue;

        if ((int)$row[0] === $id) {

            $produit = [
                "id" => (int)$row[0],
                "nom" => $row[1],
                "categorie" => $row[2],
                "prix" => (float)$row[3],
                "stock" => (int)$row[4],
                "image" => $row[5]
            ];

            break;
        }
    }

    fclose($handle);
}

include '../includes/header.php';
?>

<div class="container py-5">

<?php if (!$produit): ?>

    <div class="alert alert-danger">
        Produit introuvable.
    </div>

<?php else: ?>

    <!-- BREADCRUMB -->
    <nav class="mb-4">
        <a href="../index.php">Accueil</a> /
        <a href="menu.php">Produits</a> /
        <?= htmlspecialchars($produit['nom']) ?>
    </nav>

    <div class="row g-4">

        <!-- LEFT -->
        <div class="col-lg-4">

            <div class="card shadow-sm">
                <div class="card-body text-center">

                    <img
                        src="../image/<?= htmlspecialchars($produit['image']) ?>"
                        class="img-fluid rounded"
                        style="max-height:350px; object-fit:contain;">

                </div>
            </div>

            <div class="text-center mt-3">
                <span class="badge bg-secondary fs-6 px-4 py-2">
                    <?= htmlspecialchars($produit['categorie']) ?>
                </span>
            </div>

            <a href="menu.php" class="btn btn-outline-secondary w-100 mt-3">
                ← Retour au catalogue
            </a>

        </div>

        <!-- RIGHT -->
        <div class="col-lg-8">

            <h1 class="fw-bold">
                <?= htmlspecialchars($produit['nom']) ?>
            </h1>

            <p class="text-muted">
                Référence : PROD-<?= $produit['id'] ?>
            </p>

            <hr>

            <!-- PRICE + STOCK -->
            <div class="row g-3 mb-4">

                <div class="col-md-6">
                    <div class="card border-primary h-100">
                        <div class="card-body text-center">
                            <p class="text-muted">Prix unitaire</p>
                            <h2 class="text-primary">
                                <?= number_format($produit['prix'], 2, ',', ' ') ?> €
                            </h2>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card border-success h-100">
                        <div class="card-body text-center">
                            <p class="text-muted">Disponibilité</p>

                            <h3 class="text-success">
                                <?= $produit['stock'] ?> unités
                            </h3>

                            <?php if ($produit['stock'] > 0): ?>
                                <span class="badge bg-success">En stock</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Rupture</span>
                            <?php endif; ?>

                        </div>
                    </div>
                </div>

            </div>

            <!-- ADD TO CART -->
            <div class="card border-success">

                <div class="card-header bg-white">
                    <strong>🛒 Commander ce produit</strong>
                </div>

                <div class="card-body">

                    <form method="post" action="/store/pages/add_to_cart.php">

                        <input type="hidden" name="id" value="<?= $produit['id'] ?>">
                        <input type="hidden" name="nom" value="<?= htmlspecialchars($produit['nom']) ?>">
                        <input type="hidden" name="prix" value="<?= $produit['prix'] ?>">
                        <input type="hidden" name="image" value="<?= htmlspecialchars($produit['image']) ?>">

                        <div class="row g-3">

                            <div class="col-md-4">
                                <label>Quantité</label>
                                <input
                                    type="number"
                                    name="quantite"
                                    class="form-control"
                                    min="1"
                                    max="<?= $produit['stock'] ?>"
                                    value="1">
                            </div>

                            <div class="col-md-4">
                                <label>Total</label>
                                <input
                                    id="total"
                                    type="text"
                                    class="form-control"
                                    readonly>
                            </div>

                            <div class="col-md-4 d-flex align-items-end">
                                <button class="btn btn-success w-100">
                                    Ajouter au panier
                                </button>
                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

<?php endif; ?>

</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const prix = <?= $produit ? $produit['prix'] : 0 ?>;
    const qty = document.querySelector("input[name='quantite']");
    const total = document.getElementById("total");

    function update() {
        let q = parseInt(qty.value);
        if (!q || q < 1) q = 1;

        total.value = (prix * q).toLocaleString('fr-FR', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        }) + " €";
    }

    if (qty && total) {
        qty.addEventListener("input", update);
        update();
    }

});
</script>

<?php include '../includes/footer.php'; ?>