<?php
require 'utils.php';

function authenticate() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        sendResponse(["error" => "Unauthorized access"], 401);
    }
}
?>
