<?php
require '../config/db_config.php';

$stmt = $pdo->query("SELECT id, email, created_at FROM users");
$users = $stmt->fetchAll();
?>
<div class="user-management">
    <h2>User Management</h2>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Email</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
            <tr>
                <td><?= htmlspecialchars($user['id']) ?></td>
                <td><?= htmlspecialchars($user['email']) ?></td>
                <td><?= htmlspecialchars($user['created_at']) ?></td>
                <td>
                    <a href="/backend/delete_user.php?id=<?= $user['id'] ?>" class="btn btn-danger">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
