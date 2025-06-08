<?php
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/includes/auth_functions.php';

if (!isLoggedIn()) {
    header("HTTP/1.1 401 Unauthorized");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gameType = $_POST['game_type'] ?? '';
    $score = (int)($_POST['score'] ?? 0);
    
    if (in_array($gameType, ['clicker', 'geography', 'science', 'general', 'guess_number'])) {
        if (saveScore($gameType, $score)) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Save failed']);
        }
    } else {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(['error' => 'Invalid game type']);
    }
} else {
    header("HTTP/1.1 405 Method Not Allowed");
}
?>