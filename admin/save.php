<?php

session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: /store/pages/profil.php");
    exit;
}

$file = __DIR__ . '/../data/produits.csv';

// Get form data
$nom = $_POST['nom'];
$categorie = $_POST['categorie'];
$prix = $_POST['prix'];
$stock = $_POST['stock'];
$image = $_POST['image'];

// Generate new ID
$lines = file($file);
$id = count($lines);

// Append new product
$handle = fopen($file, "a");

fputcsv($handle, [$id, $nom, $categorie, $prix, $stock, $image]);

fclose($handle);

// Redirect back to admin
header("Location: index.php");
exit;