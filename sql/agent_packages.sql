-- Agent Subscription Packages for Dholera Smart City
-- Stores package details and their periodic durations

CREATE TABLE IF NOT EXISTS `agent_packages` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `package_name` VARCHAR(255) NOT NULL,
    `price` DECIMAL(10, 2) NOT NULL,
    `duration_months` ENUM('1', '3', '6', '12') NOT NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Benefits for each package
CREATE TABLE IF NOT EXISTS `agent_package_benefits` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `package_id` INT(11) NOT NULL,
    `benefit_text` TEXT NOT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`package_id`) REFERENCES `agent_packages`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
