<?php
require '../config/db_config.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: /frontend/login.html');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("UPDATE users SET email = :email, password_hash = :password_hash WHERE id = :id");
    $stmt->execute([
        'email' => htmlspecialchars($email),
        'password_hash' => password_hash($password, PASSWORD_DEFAULT),
        'id' => $_SESSION['user_id'],
    ]);
    echo "Profile updated successfully.";
}

$stmt = $pdo->prepare("SELECT email FROM users WHERE id = :id");
$stmt->execute(['id' => $_SESSION['user_id']]);
$user = $stmt->fetch();
?>
<div class="profile-page">
    <h2>Update Profile</h2>
    <form method="POST">
        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
        <label>Password:</label>
        <input type="password" name="password" required>
        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>
