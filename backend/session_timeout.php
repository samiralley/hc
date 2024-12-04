<?php
session_start();

$timeout = 600; // 10 minutes
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    header('Location: /frontend/login.html');
    exit;
}
$_SESSION['last_activity'] = time(); // Update activity timestamp
?>
