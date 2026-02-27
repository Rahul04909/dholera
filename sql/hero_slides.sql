-- Hero Slides Table for Dholera Smart City
-- This table stores images and text for the homepage slider

CREATE TABLE IF NOT EXISTS `hero_slides` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) DEFAULT NULL,
    `subtitle` VARCHAR(255) DEFAULT NULL,
    `image_path` VARCHAR(255) NOT NULL,
    `order_index` INT(11) DEFAULT 0,
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
