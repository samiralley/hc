<?php
require '../config/db_config.php';

header('Content-Type: application/json');

$stats = [];

// Total requests
$stmt = $pdo->query("SELECT COUNT(*) AS total_requests FROM ai_logs");
$stats['total_requests'] = $stmt->fetch()['total_requests'];

// Total tokens used
$stmt = $pdo->query("SELECT SUM(tokens_used) AS total_tokens FROM ai_logs");
$stats['total_tokens'] = $stmt->fetch()['total_tokens'];

// Cache stats
$stmt = $pdo->query("SELECT COUNT(*) AS cache_hits FROM ai_cache");
$stats['cache_hits'] = $stmt->fetch()['cache_hits'];

$stmt = $pdo->query("SELECT COUNT(*) AS cache_misses FROM ai_logs 
                     WHERE query NOT IN (SELECT query FROM ai_cache)");
$stats['cache_misses'] = $stmt->fetch()['cache_misses'];

echo json_encode($stats);
?>
