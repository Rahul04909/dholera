$host = 'localhost';
$db_name = 'jhdindus_dholera';
$username = 'jhdindus_dholera';
$password = 'Rd14072003@./';

try {
    $conn = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = "
    ALTER TABLE `agents` 
    ADD COLUMN IF NOT EXISTS `package_id` INT(11) DEFAULT NULL AFTER `password`,
    ADD COLUMN IF NOT EXISTS `package_expiry` DATETIME DEFAULT NULL AFTER `package_id`,
    ADD COLUMN IF NOT EXISTS `registration_status` ENUM('pending', 'active') DEFAULT 'pending' AFTER `status`;

    -- Add foreign key for package_id
    SET @exist = (SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS WHERE CONSTRAINT_NAME = 'fk_agent_package' AND TABLE_NAME = 'agents' AND TABLE_SCHEMA = DATABASE());
    SET @sql_stmt = IF(@exist > 0, 'SELECT 1', 'ALTER TABLE agents ADD CONSTRAINT fk_agent_package FOREIGN KEY (package_id) REFERENCES agent_packages(id) ON DELETE SET NULL');
    PREPARE stmt FROM @sql_stmt;
    EXECUTE stmt;
    DEALLOCATE PREPARE stmt;
    ";

    $conn->exec($sql);
    echo "Agents table updated successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
