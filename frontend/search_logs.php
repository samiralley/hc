<?php
require '../config/db_config.php';

$stmt = $pdo->query("SELECT users.email, ai_search_logs.query, ai_search_logs.response, ai_search_logs.created_at 
                     FROM ai_search_logs 
                     INNER JOIN users ON ai_search_logs.user_id = users.id 
                     ORDER BY ai_search_logs.created_at DESC");
$logs = $stmt->fetchAll();
?>
<div class="search-logs">
    <h2>AI Search Logs</h2>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Query</th>
                <th>Response</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= htmlspecialchars($log['email']) ?></td>
                <td><?= htmlspecialchars($log['query']) ?></td>
                <td><?= htmlspecialchars($log['response']) ?></td>
                <td><?= htmlspecialchars($log['created_at']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
