<?php
require '../config/db_config.php';

$stmt = $pdo->query("SELECT users.email, chatbot_conversations.message, chatbot_conversations.bot_response, chatbot_conversations.created_at 
                     FROM chatbot_conversations 
                     INNER JOIN users ON chatbot_conversations.user_id = users.id 
                     ORDER BY chatbot_conversations.created_at DESC");
$conversations = $stmt->fetchAll();
?>
<div class="chat-logs">
    <h2>Chatbot Conversations</h2>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>User Message</th>
                <th>Bot Response</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($conversations as $conversation): ?>
            <tr>
                <td><?= htmlspecialchars($conversation['email']) ?></td>
                <td><?= htmlspecialchars($conversation['message']) ?></td>
                <td><?= htmlspecialchars($conversation['bot_response']) ?></td>
                <td><?= htmlspecialchars($conversation['created_at']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
