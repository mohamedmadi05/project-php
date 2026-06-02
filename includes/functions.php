<?php

function getCurrentPage(): string
{
    return basename($_SERVER['PHP_SELF']);
}

function isActivePage(string $page): bool
{
    return getCurrentPage() === $page;
}

function activeClass(string $page): string
{
    return isActivePage($page) ? 'active fw-bold' : '';
}

function getNavLinks(): array
{
    return [
        'Accueil' => '/store/index.php',
        'Menu' => '/store/pages/menu.php',
        'Contact' => '/store/pages/contact.php',
        'Newsletter' => '/store/pages/newsletter.php',
        'Gagner' => '/store/pages/gagner.php',
        'Panier' => '/store/pages/panier.php',
        'Compte' => '/store/pages/compte.php',
        
    ];
}

function e(string $texte): string
{
    return htmlspecialchars($texte, ENT_QUOTES, 'UTF-8');
}