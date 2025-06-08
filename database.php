<?php
// Настройки подключения к базе данных
define('DB_HOST', 'localhost');
define('DB_NAME', 'gameteka');
define('DB_USER', 'root');
define('DB_PASS', '');

// Устанавливаем соединение
try {
    $pdo = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=utf8mb4", 
        DB_USER, 
        DB_PASS,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

session_start();

// Функция для безопасного вывода
function html($data) {
    return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
}
?>