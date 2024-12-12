<?php
require '../config/db_config.php';
require 'middleware.php';
require 'utils.php';

authenticate();

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$apiKey = $_ENV['OPENAI_API_KEY'];
$query = $_POST['query'] ?? '';

if (!$query) {
    sendResponse(["error" => "Query parameter is missing"], 400);
}

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
curl_close($ch);

if ($httpCode !== 200) {
    logError("AI API Error: " . $response);
    sendResponse(["error" => "Failed to fetch response from AI"], 500);
}

$responseData = json_decode($response, true);
sendResponse($responseData);
?>
