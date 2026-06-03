<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: /store/pages/profil.php");
    exit;
}

$titre = "Admin Dashboard";
require __DIR__ . '/../includes/header.php';

$produits = [];
$file = __DIR__ . '/../data/produits.csv';

if (file_exists($file)) {

    if (($handle = fopen($file, "r")) !== false) {

        // Ignore header line
        fgetcsv($handle, 10000, ",");

        while (($row = fgetcsv($handle, 10000, ",")) !== false) {

            if (count($row) < 6) {
                continue;
            }

            $produits[] = [
                'id'        => trim($row[0]),
                'nom'       => trim($row[1]),
                'categorie' => trim($row[2]),
                'prix'      => (float) trim($row[3]),
                'stock'     => (int) trim($row[4]),
                'image'     => trim($row[5])
            ];
        }

        fclose($handle);
    }
}
?>

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>🛠 Admin Dashboard</h1>

        <a href="add.php" class="btn btn-success">
            ➕ Ajouter un produit
        </a>
    </div>

    <?php if (empty($produits)): ?>

        <div class="alert alert-warning">
            Aucun produit trouvé dans produits.csv
        </div>

    <?php else: ?>

        <table class="table table-bordered table-striped align-middle">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Nom</th>
                    <th>Catégorie</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

            <?php foreach ($produits as $p): ?>

                <tr>

                    <td><?= htmlspecialchars($p['id']) ?></td>

                    <td>
                        <img
                            src="/store/image/<?= htmlspecialchars($p['image']) ?>"
                            alt="<?= htmlspecialchars($p['nom']) ?>"
                            width="70"
                            height="70"
                            loading="lazy"
                            style="object-fit:contain;"
                            onerror="this.style.display='none';"
                        >
                    </td>

                    <td><?= htmlspecialchars($p['nom']) ?></td>

                    <td><?= htmlspecialchars($p['categorie']) ?></td>

                    <td><?= number_format($p['prix'], 2, ',', ' ') ?> €</td>

                    <td><?= htmlspecialchars($p['stock']) ?></td>

                    <td>
                        <a
                            href="edit.php?id=<?= urlencode($p['id']) ?>"
                            class="btn btn-warning btn-sm">
                            ✏️ Modifier
                        </a>

                        <a
                            href="delete.php?id=<?= urlencode($p['id']) ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Supprimer ce produit ?');">
                            🗑 Supprimer
                        </a>
                    </td>

                </tr>

            <?php endforeach; ?>

            </tbody>

        </table>

    <?php endif; ?>

</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>