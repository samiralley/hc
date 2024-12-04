<?php
require '../config/db_config.php';

function rateLimit($userId, $limit, $timeFrame) {
    global $pdo;

    $stmt = $pdo->prepare("SELECT COUNT(*) AS request_count FROM ai_logs 
                           WHERE user_id = :user_id AND created_at > DATE_SUB(NOW(), INTERVAL :time_frame SECOND)");
    $stmt->execute(['user_id' => $userId, 'time_frame' => $timeFrame]);
    $result = $stmt->fetch();

    if ($result['request_count'] >= $limit) {
        http_response_code(429);
        echo json_encode(["error" => "Rate limit exceeded. Please wait before making more requests."]);
        exit;
    }
}
?>
