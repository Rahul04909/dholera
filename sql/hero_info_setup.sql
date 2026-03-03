-- Hero Info Stats and Settings Setup
-- Dholera Smart City

CREATE TABLE IF NOT EXISTS `hero_info_stats` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `icon` VARCHAR(100) NOT NULL COMMENT 'FontAwesome class or image path',
    `label` VARCHAR(100) NOT NULL,
    `value` VARCHAR(255) NOT NULL,
    `sort_order` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `hero_info_settings` (
    `setting_key` VARCHAR(100) PRIMARY KEY,
    `setting_value` TEXT,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert Default Stats
INSERT INTO `hero_info_stats` (`icon`, `label`, `value`, `sort_order`) VALUES 
('fas fa-home', 'Land Parcel', '130 Sq.Yd.', 1),
('fas fa-th-large', 'Type', 'Plots', 2),
('fas fa-road', 'Amenities', 'Infrastructure & Connectivity', 3),
('fas fa-tag', 'Price', '₹ 12.5 Lacs*', 4);

-- Insert Default Settings for Brochure
INSERT INTO `hero_info_settings` (`setting_key`, `setting_value`) VALUES 
('brochure_text', 'Download Brochure'),
('brochure_icon', 'far fa-map'),
('brochure_file', '#');
