<?php
require '../config/db_config.php';

$whereClauses = [];
$params = [];

if (!empty($_GET['user'])) {
    $whereClauses[] = "users.email LIKE :user";
    $params['user'] = "%" . $_GET['user'] . "%";
}
if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
    $whereClauses[] = "ai_logs.created_at BETWEEN :start_date AND :end_date";
    $params['start_date'] = $_GET['start_date'];
    $params['end_date'] = $_GET['end_date'];
}
$whereSql = count($whereClauses) > 0 ? "WHERE " . implode(" AND ", $whereClauses) : "";

$stmt = $pdo->prepare("SELECT users.email, ai_logs.query, ai_logs.response, ai_logs.tokens_used, ai_logs.execution_time, ai_logs.created_at 
                       FROM ai_logs 
                       INNER JOIN users ON ai_logs.user_id = users.id 
                       $whereSql 
                       ORDER BY ai_logs.created_at DESC");
$stmt->execute($params);
$logs = $stmt->fetchAll();
?>
<div class="filter">
    <form method="GET">
        <input type="text" name="user" placeholder="Filter by user" value="<?= htmlspecialchars($_GET['user'] ?? '') ?>">
        <input type="date" name="start_date" value="<?= htmlspecialchars($_GET['start_date'] ?? '') ?>">
        <input type="date" name="end_date" value="<?= htmlspecialchars($_GET['end_date'] ?? '') ?>">
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
</div>
<div class="admin-ai-logs">
    <h2>Filtered AI Logs</h2>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Query</th>
                <th>Response</th>
                <th>Tokens Used</th>
                <th>Execution Time (s)</th>
                <th>Timestamp</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($logs as $log): ?>
            <tr>
                <td><?= htmlspecialchars($log['email']) ?></td>
                <td><?= htmlspecialchars($log['query']) ?></td>
                <td><?= htmlspecialchars($log['response']) ?></td>
                <td><?= htmlspecialchars($log['tokens_used']) ?></td>
                <td><?= htmlspecialchars($log['execution_time']) ?></td>
                <td><?= htmlspecialchars($log['created_at']) ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
