<?php
require '../config/db_config.php';
require '../backend/email.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        $resetToken = bin2hex(random_bytes(32));
        $stmt = $pdo->prepare("UPDATE users SET reset_token = :token WHERE id = :id");
        $stmt->execute(['token' => $resetToken, 'id' => $user['id']]);

        $resetLink = "https://yourdomain.com/frontend/reset_password.php?token=$resetToken";
        $resetSubject = "Password Reset Request";
        $resetBody = "<p>Click the link below to reset your password:</p><a href='$resetLink'>$resetLink</a>";

        sendEmail($email, $resetSubject, $resetBody);
        echo "Password reset email sent.";
    } else {
        echo "No account found with that email.";
    }
}
?>
<form method="POST">
    <input type="email" name="email" placeholder="Enter your email" required>
    <button type="submit">Request Password Reset</button>
</form>
