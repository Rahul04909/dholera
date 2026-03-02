<?php
// Environment Debugger
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once 'database/db_config.php';

echo "<h3>Environment Check</h3>";
echo "Current Directory: " . __DIR__ . "<br>";
echo "Script Filename: " . $_SERVER['SCRIPT_FILENAME'] . "<br>";
echo "Document Root: " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] . "<br>";

echo "<h3>Uploads Directory Check</h3>";
$dirs = [
    'uploads',
    'uploads/projects',
    'uploads/projects/slides',
    'uploads/projects/brochures',
    'uploads/projects/amenities'
];

foreach ($dirs as $dir) {
    if (is_dir($dir)) {
        echo "[OK] Directory exists: $dir (" . substr(sprintf('%o', fileperms($dir)), -4) . ")<br>";
    } else {
        echo "[FAIL] Directory missing: $dir<br>";
    }
}

echo "<h3>Database Projects Dump</h3>";
try {
    $stmt = $conn->query("SELECT id, title, featured_image FROM projects LIMIT 5");
    $rows = $stmt->fetchAll();
    echo "<pre>" . print_r($rows, true) . "</pre>";
    
    foreach ($rows as $row) {
        $path = $row['featured_image'];
        if ($path) {
            echo "Project ID: {$row['id']} - Title: {$row['title']}<br>";
            echo "DB Path: $path<br>";
            if (file_exists($path)) {
                echo "[OK] File exists on server: $path<br>";
            } else {
                echo "[FAIL] File NOT found on server: $path<br>";
            }
            echo "<hr>";
        }
    }
} catch (Exception $e) {
    echo "DB Error: " . $e->getMessage();
}
?>
