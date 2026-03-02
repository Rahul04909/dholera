-- Agents Table for Dholera Smart City
-- Stores agent profiles, contact info, and login credentials

CREATE TABLE IF NOT EXISTS `agents` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `full_name` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) NOT NULL UNIQUE,
    `mobile` VARCHAR(20) NOT NULL UNIQUE,
    `profile_image` VARCHAR(255) DEFAULT NULL,
    `country` VARCHAR(100) DEFAULT 'India',
    `state` VARCHAR(100) DEFAULT NULL,
    `city` VARCHAR(100) DEFAULT NULL,
    `pincode` VARCHAR(10) DEFAULT NULL,
    `full_address` TEXT DEFAULT NULL,
    `password` VARCHAR(255) NOT NULL,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
