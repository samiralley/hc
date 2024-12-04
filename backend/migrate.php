<?php
require 'db_config.php';

$sql = file_get_contents(__DIR__ . '/../db/schema.sql');
try {
    $pdo->exec($sql);
    echo "Database migration completed successfully.";
} catch (PDOException $e) {
    echo "Migration failed: " . $e->getMessage();
}
?>
