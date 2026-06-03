<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}


$id       = $_POST['id'] ?? null;
$nom      = $_POST['nom'] ?? null;
$prix     = $_POST['prix'] ?? null;
$image    = $_POST['image'] ?? null;
$quantite = (int) ($_POST['quantite'] ?? 1);

if ($id) {


    if (isset($_SESSION['panier'][$id])) {
        $_SESSION['panier'][$id]['quantite'] += $quantite;
    } else {
        $_SESSION['panier'][$id] = [
            'nom' => $nom,
            'prix' => $prix,
            'image' => $image,
            'quantite' => $quantite
        ];
    }
}

header("Location: /store/pages/panier.php");
exit;