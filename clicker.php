<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_functions.php';

$pageTitle = "Кликер Мания";
require_once __DIR__ . '/../includes/header.php';
?>

<section class="game-container">
    <h1>Кликер Мания</h1>
    <p>Кликайте по кнопке как можно быстрее!</p>
    
    <div class="clicker-game">
        <div id="score">0</div>
        <button id="click-btn" class="game-button">Клик!</button>
        <button id="reset-btn" class="game-button secondary">Сбросить</button>
        
        <?php if (isLoggedIn()): ?>
            <button id="save-btn" class="game-button primary">Сохранить результат</button>
        <?php else: ?>
            <p>Войдите, чтобы сохранить результат</p>
        <?php endif; ?>
    </div>
</section>

<script src="/gameteka/assets/js/clicker.js"></script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>