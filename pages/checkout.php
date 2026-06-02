<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['user'])) {
    header("Location: /store/pages/compte.php");
    exit;
}


$panier = $_SESSION['panier'] ?? [];

if (empty($panier)) {
    header("Location: /store/pages/panier.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "store_db");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}


$user_id = $_SESSION['user']['id'];


$total = 0;

foreach ($panier as $item) {
    $total += $item['prix'] * $item['quantite'];
}

$insertOrder = $conn->query("
    INSERT INTO orders (user_id, total)
    VALUES ($user_id, $total)
");

if (!$insertOrder) {
    die("Order error: " . $conn->error);
}

$order_id = $conn->insert_id;


foreach ($panier as $id => $item) {

    $name  = $conn->real_escape_string($item['nom']);
    $price = $item['prix'];
    $qty   = $item['quantite'];

    $insertItem = $conn->query("
        INSERT INTO order_items (order_id, product_id, product_name, price, quantity)
        VALUES ($order_id, $id, '$name', $price, $qty)
    ");

    if (!$insertItem) {
        die("Order item error: " . $conn->error);
    }
}


unset($_SESSION['panier']);


require __DIR__ . '/../includes/header.php';

?>

<div class="container mt-5">

    <div class="alert alert-success">
        🎉 Commande passée avec succès !
    </div>


    <p>
        <strong>Total :</strong> <?= number_format($total, 2) ?> €
    </p>

    <a href="/store/index.php" class="btn btn-primary">
        Retour à la boutique
    </a>

</div>

<?php require __DIR__ . '/../includes/footer.php'; ?>