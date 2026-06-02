<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = basename($_SERVER['PHP_SELF']);
require_once __DIR__ . '/functions.php';

$theme = $_COOKIE['theme'] ?? 'clair';
$prenom = $_COOKIE['prenom'] ?? '';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tamount Store</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html, body {
            height: 100%;
        }

        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        <?php if ($theme === 'sombre'): ?>

        body {
            background: #121212;
            color: white;
        }

        .card {
            background: #1e1e1e;
            color: white;
        }

        .table {
            color: white;
        }

        .form-control,
        .form-select {
            background: #2b2b2b;
            color: white;
            border-color: #555;
        }

        <?php endif; ?>
    </style>
</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">

        <a class="navbar-brand" href="/store/index.php">
            Tamount Store
        </a>

        <ul class="navbar-nav">

            <!-- PUBLIC LINKS -->
            <?php foreach (getNavLinks() as $nom => $url): ?>

                <li class="nav-item">
                    <a class="nav-link <?= activeClass(basename($url)) ?>"
                       href="<?= $url ?>">
                        <?= e($nom) ?>
                    </a>
                </li>

            <?php endforeach; ?>

            <!-- USER LINKS -->
            <?php if (isset($_SESSION['user'])): ?>

                <li class="nav-item">
                    <a class="nav-link" href="/store/pages/profil.php">
                        Profil
                    </a>
                </li>

                <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                    <li class="nav-item">
                        <a class="nav-link text-warning" href="/store/admin/index.php">
                            Admin
                        </a>
                    </li>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link text-danger" href="/store/pages/logout.php">
                        Déconnexion
                    </a>
                </li>

            <?php else: ?>

                <li class="nav-item">
                    <a class="nav-link" href="/store/pages/compte.php">
                        Connexion
                    </a>
                </li>

            <?php endif; ?>

        </ul>

        <!-- GREETING -->
        <?php if (isset($_SESSION['user'])): ?>
            <span class="text-white ms-auto">
                👋 Bonjour, <?= e($_SESSION['user']['prenom']) ?>
            </span>

        <?php elseif (!empty($prenom)): ?>
            <span class="text-white ms-auto">
                👋 Bonjour, <?= e($prenom) ?>
            </span>
        <?php endif; ?>

    </div>
</nav>