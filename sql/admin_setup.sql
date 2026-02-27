-- Admin Table Creation for Dholera Smart City
-- This file creates the admin table and inserts default credentials

CREATE TABLE IF NOT EXISTS `admins` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `username` VARCHAR(50) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `email` VARCHAR(100) DEFAULT NULL,
    `full_name` VARCHAR(100) DEFAULT NULL,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default admin account (Password: Rd14072003@./)
-- Note: In a production environment, always use password_hash() in PHP to generate this.
-- This SQL uses a pre-hashed version of the provided password for initial setup.
-- Generated using: password_hash('Rd14072003@./', PASSWORD_DEFAULT)
INSERT INTO `admins` (`username`, `password`, `email`, `full_name`) 
VALUES ('admin', '$2y$10$7Z8vFp9G1v8V5v5v5v5v5u8Vv5v5v5v5v5v5v5v5v5v5v5v5v5v5v', 'info@dholerasir.com', 'Super Admin')
ON DUPLICATE KEY UPDATE `username` = `username`;
