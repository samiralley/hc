<?php
require '../config/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role']; // 'admin' or 'user'

    $passwordHash = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $pdo->prepare("INSERT INTO users (email, password_hash, role) VALUES (:email, :password_hash, :role)");
    $stmt->execute([
        'email' => htmlspecialchars($email),
        'password_hash' => $passwordHash,
        'role' => $role,
    ]);

    echo "User registered successfully.";
}
?>
