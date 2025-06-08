<?php
function registerUser($username, $email, $password) {
    global $pdo;
    
    // Проверка существования пользователя
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
    $stmt->execute([$username, $email]);
    
    if ($stmt->rowCount() > 0) {
        return false;
    }
    
    // Хеширование пароля
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    // Создание пользователя
    $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    return $stmt->execute([$username, $email, $hashedPassword]);
}

function loginUser($username, $password) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        return true;
    }
    
    return false;
}

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function saveScore($gameType, $score) {
    global $pdo;
    
    if (!isLoggedIn()) return false;
    
    $stmt = $pdo->prepare("INSERT INTO user_scores (user_id, game_type, score) VALUES (?, ?, ?)");
    return $stmt->execute([$_SESSION['user_id'], $gameType, $score]);
}

function logoutUser() {
    session_unset();
    session_destroy();
}
?>