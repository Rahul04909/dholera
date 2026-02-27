-- Callback Requests Table for Dholera Smart City
-- Stores call scheduling requests from the website footer

CREATE TABLE IF NOT EXISTS `callbacks` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `preferred_time` VARCHAR(100) DEFAULT NULL,
    `status` ENUM('pending', 'completed', 'closed') DEFAULT 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
