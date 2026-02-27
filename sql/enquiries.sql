-- Enquiries Table for Dholera Smart City
-- Stores user leads from the frontend enquiry form

CREATE TABLE IF NOT EXISTS `enquiries` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(100) NOT NULL,
    `phone` VARCHAR(20) NOT NULL,
    `message` TEXT DEFAULT NULL,
    `status` ENUM('pending', 'closed') DEFAULT 'pending',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
