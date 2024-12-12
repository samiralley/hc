<?php
function logError($message) {
    $logFile = __DIR__ . '/../logs/error.log';
    $timestamp = "[" . date('Y-m-d H:i:s') . "] ";
    file_put_contents($logFile, $timestamp . $message . PHP_EOL, FILE_APPEND);
}

function sendResponse($data, $httpCode = 200) {
    http_response_code($httpCode);
    echo json_encode($data);
    exit;
}
?>
