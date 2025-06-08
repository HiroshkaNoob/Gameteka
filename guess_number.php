<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_functions.php';

// Генерация случайного числа, если его еще нет в сессии или если начата новая игра
if (!isset($_SESSION['secret_number']) || (isset($_POST['new_game']) && $_POST['new_game'])) {
    $_SESSION['secret_number'] = rand(1, 100);
    $_SESSION['attempts'] = 0;
    $gameOver = false;
    $message = '';
}

$message = $message ?? '';
$gameOver = $gameOver ?? false;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['guess'])) {
    $_SESSION['attempts']++;
    $guess = (int)$_POST['guess'];
    $secretNumber = $_SESSION['secret_number'];
    
    if ($guess < $secretNumber) {
        $message = 'Загаданное число больше!';
    } elseif ($guess > $secretNumber) {
        $message = 'Загаданное число меньше!';
    } else {
        $message = "Поздравляем! Вы угадали число $secretNumber за {$_SESSION['attempts']} попыток.";
        $gameOver = true;
        
        if (isLoggedIn()) {
            saveScore('guess_number', $_SESSION['attempts']);
        }
        
        // Генерация нового числа после угадывания
        $_SESSION['secret_number'] = rand(1, 100);
        $_SESSION['attempts'] = 0;
    }
}

$pageTitle = "Угадай Число";
require_once __DIR__ . '/../includes/header.php';
?>

<section class="game-container">
    <h1>Угадай Число</h1>
    <p>Я загадал число от 1 до 100. Попробуй угадать!</p>
    
    <?php if ($message): ?>
        <div class="message"><?php echo htmlspecialchars($message); ?></div>
    <?php endif; ?>
    
    <?php if (!$gameOver): ?>
        <form method="post">
            <input type="number" name="guess" min="1" max="100" required>
            <button type="submit">Проверить</button>
        </form>
        <p>Попыток: <?php echo $_SESSION['attempts']; ?></p>
    <?php else: ?>
        <div class="success-message">
            <?php echo htmlspecialchars($message); ?>
        </div>
        <form method="post">
            <button type="submit" name="new_game" value="1">Новая игра</button>
        </form>
    <?php endif; ?>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>