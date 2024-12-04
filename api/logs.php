<?php
require '../config/db_config.php';

header('Content-Type: application/json');

if (!isset($_GET['type'])) {
    echo json_encode(['error' => 'Type parameter is required']);
    exit;
}

$type = $_GET['type'];
$perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $perPage;

if ($type === 'search_logs') {
    $query = "SELECT users.email, ai_search_logs.query, ai_search_logs.response, ai_search_logs.created_at 
              FROM ai_search_logs 
              INNER JOIN users ON ai_search_logs.user_id = users.id 
              LIMIT $start, $perPage";

    $stmt = $pdo->query($query);
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($logs);
} elseif ($type === 'chat_logs') {
    $query = "SELECT users.email, chatbot_conversations.message, chatbot_conversations.bot_response, chatbot_conversations.created_at 
              FROM chatbot_conversations 
              INNER JOIN users ON chatbot_conversations.user_id = users.id 
              LIMIT $start, $perPage";

    $stmt = $pdo->query($query);
    $logs = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($logs);
} else {
    echo json_encode(['error' => 'Invalid log type']);
}
?>
