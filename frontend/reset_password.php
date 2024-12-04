<?php
require '../config/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE reset_token = :token");
    $stmt->execute(['token' => $token]);
    $user = $stmt->fetch();

    if ($user) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $pdo->prepare("UPDATE users SET password_hash = :password, reset_token = NULL WHERE id = :id");
        $stmt->execute(['password' => $passwordHash, 'id' => $user['id']]);
        echo "Password reset successfully.";
    } else {
        echo "Invalid or expired token.";
    }
}
?>
<form method="POST">
    <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token']) ?>">
    <input type="password" name="password" placeholder="New Password" required>
    <button type="submit">Reset Password</button>
</form>
