<?php
require_once 'database/db_config.php';
header('Content-Type: text/plain');

try {
    $stmt = $conn->query("DESCRIBE projects");
    echo "Columns in 'projects' table:\n";
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $row['Field'] . " (" . $row['Type'] . ")\n";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
