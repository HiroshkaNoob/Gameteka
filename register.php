<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_functions.php';

$errors = [];
$username = $email = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Валидация
    if (empty($username)) $errors[] = 'Введите имя пользователя';
    if (empty($email)) $errors[] = 'Введите email';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Неверный формат email';
    if (empty($password)) $errors[] = 'Введите пароль';
    if ($password !== $confirm_password) $errors[] = 'Пароли не совпадают';
    
    if (empty($errors)) {
        if (registerUser($username, $email, $password)) {
            loginUser($username, $password);
            header("Location: /gameteka/");
            exit;
        } else {
            $errors[] = 'Пользователь с таким именем или email уже существует';
        }
    }
}

$pageTitle = "Регистрация";
require_once __DIR__ . '/../includes/header.php';
?>

<h1>Регистрация</h1>

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
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= html($email) ?>" required>
    </div>
    
    <div>
        <label for="password">Пароль:</label>
        <input type="password" id="password" name="password" required>
    </div>
    
    <div>
        <label for="confirm_password">Подтвердите пароль:</label>
        <input type="password" id="confirm_password" name="confirm_password" required>
    </div>
    
    <button type="submit">Зарегистрироваться</button>
</form>

<p>Уже есть аккаунт? <a href="/gameteka/auth/login.php">Войдите</a></p>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>