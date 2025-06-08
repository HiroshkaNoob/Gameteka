<?php
// includes/header.php

$pageTitle = $pageTitle ?? "Игротека";
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($pageTitle); ?></title>
    <link rel="stylesheet" href="/gameteka/assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <a href="/gameteka/" class="logo">
                <img src="/gameteka/assets/images/logo.png" alt="Игротека">
            </a>
            <button class="mobile-menu-toggle">☰</button>
            <nav>
                <?php if (isLoggedIn()): ?>
                    <span>Привет, <?php echo htmlspecialchars($_SESSION['username']); ?>!</span>
                    <a href="/gameteka/auth/logout.php">Выйти</a>
                <?php else: ?>
                    <a href="/gameteka/auth/login.php">Войти</a>
                    <a href="/gameteka/auth/register.php">Регистрация</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>
    <main class="container">