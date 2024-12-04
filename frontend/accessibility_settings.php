<?php
require '../config/db_config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $text_size = $_POST['text_size'];
    $high_contrast = isset($_POST['high_contrast']) ? 1 : 0;

    $stmt = $pdo->prepare("UPDATE accessibility_settings SET text_size = :text_size, high_contrast = :high_contrast WHERE user_id = :user_id");
    $stmt->execute([
        'text_size' => $text_size,
        'high_contrast' => $high_contrast,
        'user_id' => $user_id
    ]);
    echo "Accessibility settings updated.";
}

$stmt = $pdo->query("SELECT users.email, accessibility_settings.text_size, accessibility_settings.high_contrast, accessibility_settings.user_id 
                     FROM accessibility_settings 
                     INNER JOIN users ON accessibility_settings.user_id = users.id");
$settings = $stmt->fetchAll();
?>
<div class="accessibility-settings">
    <h2>Accessibility Settings</h2>
    <form method="POST" action="">
        <table class="table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Text Size</th>
                    <th>High Contrast</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($settings as $setting): ?>
                <tr>
                    <td><?= htmlspecialchars($setting['email']) ?></td>
                    <td>
                        <select name="text_size">
                            <option value="small" <?= $setting['text_size'] === 'small' ? 'selected' : '' ?>>Small</option>
                            <option value="medium" <?= $setting['text_size'] === 'medium' ? 'selected' : '' ?>>Medium</option>
                            <option value="large" <?= $setting['text_size'] === 'large' ? 'selected' : '' ?>>Large</option>
                        </select>
                    </td>
                    <td>
                        <input type="checkbox" name="high_contrast" <?= $setting['high_contrast'] ? 'checked' : '' ?>>
                    </td>
                    <td>
                        <button type="submit" class="btn btn-primary" name="user_id" value="<?= $setting['user_id'] ?>">Update</button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </form>
</div>
