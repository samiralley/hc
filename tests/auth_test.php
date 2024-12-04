<?php
require '../backend/auth.php';

function testAuth() {
    $_POST = ['email' => 'test@example.com', 'password' => 'password'];
    ob_start();
    include '../backend/auth.php';
    $output = ob_get_clean();
    return strpos($output, "Invalid credentials") === false;
}

echo testAuth() ? "Auth Test Passed" : "Auth Test Failed";
?>
