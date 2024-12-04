<?php
function logError($error) {
    $logFile = __DIR__ . '/../logs/error.log';
    if (!file_exists(dirname($logFile))) {
        mkdir(dirname($logFile), 0755, true);
    }
    $current = file_exists($logFile) ? file_get_contents($logFile) : "";
    $current .= "[" . date('Y-m-d H:i:s') . "] " . $error . "\n";
    file_put_contents($logFile, $current);
}
?>
