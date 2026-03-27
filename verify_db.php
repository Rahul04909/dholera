<?php
$host = 'localhost';
$db_name = 'jhdindus_dholera';
$username = 'jhdindus_dholera';
$password = 'Rd14072003@./';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $stmt = $conn->query("DESCRIBE agents");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    echo "Columns in agents table:\n";
    print_r($columns);
    
    if (in_array('package_id', $columns)) {
        echo "\nSUCCESS: package_id exists.\n";
    } else {
        echo "\nFAILURE: package_id missing.\n";
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
