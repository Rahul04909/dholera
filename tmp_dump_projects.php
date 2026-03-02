<?php
require_once 'd:/wamp/www/dholera/database/db_config.php';
try {
    $stmt = $conn->query("SELECT id, title, featured_image FROM projects");
    $projects = $stmt->fetchAll();
    echo json_encode($projects, JSON_PRETTY_PRINT);
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
