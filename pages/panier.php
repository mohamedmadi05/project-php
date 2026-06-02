<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user'])) {
    header('Location: /store/pages/compte.php');
    exit;
}

if (isset($_GET['remove'])) {

    $id = $_GET['remove'];

    if (isset($_SESSION['panier'][$id])) {
        unset($_SESSION['panier'][$id]);
    }

    header("Location: panier.php");
    exit;
}

if (isset($_GET['clear'])) {
    unset($_SESSION['panier']);
    header("Location: panier.php");
    exit;
}

$panier = $_SESSION['panier'] ?? [];

require __DIR__ . '/../includes/header.php';

?>

<div class="container mt-5">

    <h1 class="mb-4">🛒 Mon Panier</h1>

    <?php if (empty($panier)): ?>

        <div class="alert alert-info">
            Ton panier est vide
        </div>

    <?php else: ?>

        <table class="table table-bordered">

            <thead>
                <tr>
                    <th>Image</th>
                    <th>Produit</th>
                    <th>Prix</th>
                    <th>Quantité</th>
                    <th>Total</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                <?php $total = 0; ?>

                <?php foreach ($panier as $id => $item): ?>

                    <?php
                        $sousTotal = $item['prix'] * $item['quantite'];
                        $total += $sousTotal;
                    ?>

                    <tr>

                        <td>
                            <img src="/store/image/<?= htmlspecialchars($item['image']) ?>" width="60">
                        </td>

                        <td>
                            <?= htmlspecialchars($item['nom']) ?>
                        </td>

                        <td>
                            <?= number_format($item['prix'], 2) ?> €
                        </td>

                        <td>
                            <?= $item['quantite'] ?>
                        </td>

                        <td>
                            <?= number_format($sousTotal, 2) ?> €
                        </td>

                        <td>
                            <a href="panier.php?remove=<?= $id ?>" class="btn btn-danger btn-sm">
                                Supprimer
                            </a>
                        </td>

                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

        <div class="d-flex justify-content-between align-items-center">

            <h3>Total : <?= number_format($total, 2) ?> €</h3>

            <div>
                <a href="panier.php?clear=1" class="btn btn-warning">
                    Vider panier
                </a>

                <a href="/store/pages/checkout.php" class="btn btn-success">
                    Passer commande
                </a>
            </div>

        </div>

    <?php endif; ?>

</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>