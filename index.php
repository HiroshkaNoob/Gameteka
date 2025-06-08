<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth_functions.php';

$pageTitle = "Игротека - Главная";
require_once __DIR__ . '/includes/header.php';
?>

<section class="hero">
    <h1>Добро пожаловать в Игротеку!</h1>
    <p>Откройте для себя коллекцию увлекательных мини-игр. Войдите или зарегистрируйтесь, чтобы сохранять свои рекорды и соревноваться с друзьями!</p>
</section>

<section class="games">
    <h2>Наши Игры</h2>
    
    <div class="game-card">
        <h3>Кликер Мания</h3>
        <p>Кликайте как можно быстрее, чтобы набрать очки!</p>
        <a href="/gameteka/games/clicker.php" class="play-button">Играть</a>
    </div>
    
    <div class="game-card">
        <h3>Угадай Число</h3>
        <p>Компьютер загадывает число от 1 до 100. Попробуй угадать!</p>
        <a href="/gameteka/games/guess_number.php" class="play-button">Играть</a>
    </div>
    
    <div class="game-card">
        <h3>Викторина: Общие Знания</h3>
        <p>Проверь свою эрудицию в различных областях!</p>
        <a href="/gameteka/games/general_quiz.php" class="play-button">Играть</a>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>