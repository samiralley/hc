<?php
require '../config/db_config.php';
require '../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$apiKey = $_ENV['OPENAI_API_KEY'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $query = $_POST['query'];
    $startTime = microtime(true);

    $ch = curl_init("https://api.openai.com/v1/chat/completions");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Content-Type: application/json",
        "Authorization: Bearer $apiKey"
    ]);

    $data = [
        "model" => "gpt-4",
        "messages" => [["role" => "user", "content" => $query]],
        "max_tokens" => 100
    ];
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $executionTime = microtime(true) - $startTime;
    curl_close($ch);

    if ($httpCode === 200) {
        $responseData = json_decode($response, true);
        $responseText = $responseData['choices'][0]['message']['content'];
        $tokensUsed = $responseData['usage']['total_tokens'];

        // Log metadata
        $stmt = $pdo->prepare("INSERT INTO ai_logs (user_id, query, response, tokens_used, execution_time, user_agent) VALUES (:user_id, :query, :response, :tokens_used, :execution_time, :user_agent)");
        $stmt->execute([
            'user_id' => $_SESSION['user_id'],
            'query' => $query,
            'response' => $responseText,
            'tokens_used' => $tokensUsed,
            'execution_time' => $executionTime,
            'user_agent' => $_SERVER['HTTP_USER_AGENT']
        ]);

        echo $response;
    } else {
        $errorMessage = json_encode(["status" => $httpCode, "response" => $response]);
        $stmt = $pdo->prepare("INSERT INTO ai_error_logs (user_id, error_message) VALUES (:user_id, :error_message)");
        $stmt->execute([
            'user_id' => $_SESSION['user_id'],
            'error_message' => $errorMessage
        ]);
        echo json_encode(["error" => "Failed to process the AI query. Please try again."]);
    }
}
?>
