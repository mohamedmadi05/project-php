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

if (($handle = fopen($file, "r")) !== false) {

    $header = fgetcsv($handle, 10000, ",");

    while (($row = fgetcsv($handle, 10000, ",")) !== false) {

        if (!$row || count($row) < 6) continue;

        $produits[] = [
            "id" => $row[0],
            "nom" => $row[1],
            "categorie" => $row[2],
            "prix" => $row[3],
            "stock" => $row[4],
            "image" => $row[5]
        ];
    }

    fclose($handle);
}
?>

<div class="container py-5">

    <h1 class="mb-4">🛠 Admin Dashboard</h1>

    <a href="add.php" class="btn btn-success mb-3">
        ➕ Ajouter un produit
    </a>

    <!-- STATS -->
    <div class="row mb-4">

        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h3><?= count($produits) ?></h3>
                <p>Total produits</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h3><?= array_sum(array_column($produits, 'stock')) ?></h3>
                <p>Total stock</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 text-center">
                <h3><?= count(array_unique(array_column($produits, 'categorie'))) ?></h3>
                <p>Catégories</p>
            </div>
        </div>

    </div>

    <!-- TABLE -->
    <div class="card shadow-sm">

        <div class="card-header bg-dark text-white">
            📦 Liste des produits
        </div>

        <div class="card-body p-0">

            <table class="table table-striped mb-0">

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

                            <!-- IMAGE -->
                            <td>
                                <img src="/store/image/<?= htmlspecialchars($p['image']) ?>"
                                     alt="<?= htmlspecialchars($p['nom']) ?>"
                                     style="width:60px;height:60px;object-fit:contain;">
                            </td>

                            <td><?= htmlspecialchars($p['nom']) ?></td>
                            <td><?= htmlspecialchars($p['categorie']) ?></td>

                            <td>
                                <?= number_format($p['prix'], 2, ',', ' ') ?> €
                            </td>

                            <td>
                                <?php if ($p['stock'] > 5): ?>
                                    <span class="badge bg-success"><?= $p['stock'] ?></span>
                                <?php elseif ($p['stock'] > 0): ?>
                                    <span class="badge bg-warning text-dark"><?= $p['stock'] ?></span>
                                <?php else: ?>
                                    <span class="badge bg-danger">0</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <a href="delete.php?id=<?= $p['id'] ?>"
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Supprimer ce produit ?')">
                                    🗑 Delete
                                </a>
                            </td>

                        </tr>

                    <?php endforeach; ?>

                </tbody>

            </table>

        </div>
    </div>

</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>