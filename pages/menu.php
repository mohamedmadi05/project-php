<?php

$titre = "Menu";

$produits = [];


if (($handle = fopen("../data/produits.csv", "r")) !== false) {
    fgetcsv($handle, 10000, ",");

    while (($row = fgetcsv($handle, 10000, ",")) !== false) {

        if (!$row || count($row) < 6) {
            continue;
        }

        if ($row[0] === 'id') {
            continue;
        }

        $produits[] = [
            "id" => (int)($row[0] ?? 0),
            "nom" => $row[1] ?? '',
            "categorie" => $row[2] ?? '',
            "prix" => (float)($row[3] ?? 0),
            "stock" => (int)($row[4] ?? 0),
            "image" => $row[5] ?? ''
        ];
    }

    fclose($handle);
}

include '../includes/header.php';

?>

<div class="container py-5">

    <h1 class="mb-3">🖥️ Nos Produits</h1>

    <p class="text-light mb-4">
        Cliquez sur un produit pour voir ses détails, son prix et sa disponibilité.
    </p>

    <div class="row g-4">

        <?php foreach ($produits as $produit): ?>

            <div class="col-md-3">

                <div class="card h-100 text-center shadow-sm">

                    <div class="card-body">

                        <!-- IMAGE -->
                        <img
                            src="../image/<?= htmlspecialchars($produit['image']) ?>"
                            alt="<?= htmlspecialchars($produit['nom']) ?>"
                            class="img-fluid mb-3"
                            style="max-height:120px; object-fit:contain;">

                 
                        <h5 class="card-title">
                            <?= htmlspecialchars($produit['nom']) ?>
                        </h5>

                        <p class="text-light">
                            <?= htmlspecialchars($produit['categorie']) ?>
                        </p>

               
                        <h4 class="text-primary fw-bold">
                            <?= number_format($produit['prix'], 2, ',', ' ') ?> €
                        </h4>

             
                        <?php if ($produit['stock'] > 5): ?>

                            <span class="badge bg-success">
                                En stock (<?= $produit['stock'] ?> disponibles)
                            </span>

                        <?php elseif ($produit['stock'] > 0): ?>

                            <span class="badge bg-warning text-dark">
                                Stock limité (<?= $produit['stock'] ?> restants)
                            </span>

                        <?php else: ?>

                            <span class="badge bg-danger">
                                Rupture de stock
                            </span>

                        <?php endif; ?>

                   
                        <div class="mt-3">
                            <a href="produit.php?id=<?= $produit['id'] ?>"
                               class="btn btn-outline-primary btn-sm">
                                Voir détails →
                            </a>
                        </div>

                    </div>

                </div>

            </div>

        <?php endforeach; ?>

    </div>

</div>

<?php include '../includes/footer.php'; ?>