-- Site Visit Requests Table for Dholera Smart City
-- Stores detailed tour requests from project-details.php

CREATE TABLE IF NOT EXISTS `site_visits` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `project_id` INT(11) DEFAULT NULL,
    `project_name` VARCHAR(255) DEFAULT NULL,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `visit_date` DATE NOT NULL,
    `visit_time` VARCHAR(50) NOT NULL,
    `message` TEXT DEFAULT NULL,
    `status` ENUM('pending', 'confirmed', 'cancelled', 'completed') DEFAULT 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
