<?php
// Mock SERVER variables for db_config.php
$_SERVER['HTTPS'] = 'off';
$_SERVER['HTTP_HOST'] = 'localhost';
$_SERVER['SCRIPT_FILENAME'] = __FILE__;
$_SERVER['SCRIPT_NAME'] = '/debug_db.php';

require_once 'database/db_config.php';

function dumpTable($conn, $table) {
    echo "--- Table: $table ---\n";
    try {
        $stmt = $conn->query("SELECT * FROM $table");
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as $row) {
            print_r($row);
        }
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage() . "\n";
    }
    echo "\n";
}

dumpTable($conn, 'agents');
dumpTable($conn, 'projects');
dumpTable($conn, 'agent_projects');
dumpTable($conn, 'site_visits');
dumpTable($conn, 'agent_site_visits');
