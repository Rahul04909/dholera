-- Project Management Database Schema for Dholera Smart City

-- 1. Main Projects Table
CREATE TABLE IF NOT EXISTS `projects` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `label` VARCHAR(100) DEFAULT NULL,
    `project_type` VARCHAR(100) DEFAULT NULL,
    `legitimate` VARCHAR(255) DEFAULT NULL,
    `location` VARCHAR(255) DEFAULT NULL,
    `google_map_url` TEXT DEFAULT NULL,
    `about_project` LONGTEXT DEFAULT NULL,
    
    -- Images & Files
    `featured_image` VARCHAR(255) DEFAULT NULL,
    `brochure_pdf` VARCHAR(255) DEFAULT NULL,
    `site_plan_image` VARCHAR(255) DEFAULT NULL,
    
    -- Stats / Range
    `plot_size_from` VARCHAR(50) DEFAULT NULL,
    `plot_size_to` VARCHAR(50) DEFAULT NULL,
    `total_units` VARCHAR(50) DEFAULT NULL,
    `price_range` VARCHAR(100) DEFAULT NULL,
    
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 2. Project Gallery / Slides
CREATE TABLE IF NOT EXISTS `project_slides` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `project_id` INT(11) NOT NULL,
    `image_path` VARCHAR(255) NOT NULL,
    `order_index` INT(11) DEFAULT 0,
    FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 3. Project Amenities (with icons)
CREATE TABLE IF NOT EXISTS `project_amenities` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `project_id` INT(11) NOT NULL,
    `name` VARCHAR(100) NOT NULL,
    `icon_path` VARCHAR(255) DEFAULT NULL, -- Can be uploaded image path or FontAwesome class
    `icon_type` ENUM('image', 'icon_class') DEFAULT 'icon_class',
    FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- 4. Project Nearbys (without icons)
CREATE TABLE IF NOT EXISTS `project_nearbys` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `project_id` INT(11) NOT NULL,
    `name` VARCHAR(255) NOT NULL,
    `distance` VARCHAR(100) DEFAULT NULL,
    FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
