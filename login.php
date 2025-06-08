<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_functions.php';

if (isLoggedIn()) {
    header("Location: /gameteka/");
    exit;
}

$errors = [];
$username = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username)) $errors[] = 'Введите имя пользователя';
    if (empty($password)) $errors[] = 'Введите пароль';
    
    if (empty($errors)) {
        if (loginUser($username, $password)) {
            header("Location: /gameteka/");
            exit;
        } else {
            $errors[] = 'Неверное имя пользователя или пароль';
        }
    }
}

$pageTitle = "Вход";
require_once __DIR__ . '/../includes/header.php';
?>

<h1>Вход</h1>

<?php if (!empty($errors)): ?>
    <div class="errors">
        <?php foreach ($errors as $error): ?>
            <p><?= html($error) ?></p>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<form method="post">
    <div>
        <label for="username">Имя пользователя:</label>
        <input type="text" id="username" name="username" value="<?= html($username) ?>" required>
    </div>
    
    <div>
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>
    </div>
    
    <button type="submit">Войти</button>
</form>

<p>Нет аккаунта? <a href="/gameteka/auth/register.php">Зарегистрируйтесь</a></p>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>