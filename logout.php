<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../includes/auth_functions.php';

logoutUser();
header("Location: /gameteka/");
exit;
?>