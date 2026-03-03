-- Floor Plan Management Setup
-- Dholera Smart City

CREATE TABLE IF NOT EXISTS `floor_plan_settings` (
    `id` INT PRIMARY KEY CHECK (id = 1),
    `sketch_title` VARCHAR(255) NOT NULL DEFAULT 'Apartments Sketch',
    `main_title` VARCHAR(255) NOT NULL DEFAULT 'Apartments Plan',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `floor_plans` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `tab_title` VARCHAR(100) NOT NULL,
    `plan_title` VARCHAR(255) NOT NULL,
    `plan_desc` TEXT NOT NULL,
    `image_path` VARCHAR(255) NOT NULL,
    `sort_order` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `floor_plan_specs` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `plan_id` INT NOT NULL,
    `label` VARCHAR(100) NOT NULL,
    `value` VARCHAR(100) NOT NULL,
    `sort_order` INT DEFAULT 0,
    FOREIGN KEY (`plan_id`) REFERENCES `floor_plans`(`id`) ON DELETE CASCADE
);

-- Insert Default Settings
INSERT INTO `floor_plan_settings` (`id`, `sketch_title`, `main_title`) VALUES 
(1, 'Apartments Sketch', 'Apartments Plan');

-- Insert Default Floor Plans
INSERT INTO `floor_plans` (`id`, `tab_title`, `plan_title`, `plan_desc`, `image_path`, `sort_order`) VALUES 
(1, 'The Studio', 'The Studio', 'A modern, open-concept studio apartment designed for efficiency and style. Perfect for individuals or small families seeking a premium Smart City lifestyle with optimized space management.', 'https://images.unsplash.com/photo-1574362848149-11496d93a7c7?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 1),
(2, 'Deluxe Portion', 'Deluxe Portion', 'Spacious deluxe portions featuring enhanced privacy and larger living areas. These units offer high-end finishes and a perfect balance between luxury and functionality.', 'https://images.unsplash.com/photo-1628592102751-ba83b03a442a?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 2),
(3, 'Penthouse', 'Penthouse', 'The pinnacle of luxury living. Our penthouses offer panoramic city views, expansive private terraces, and double-height ceilings for a truly majestic living experience.', 'https://images.unsplash.com/photo-1600607687989-ce8a6c72159c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 3),
(4, 'Top Garden', 'Top Garden Units', 'Unique garden-facing apartments that bring nature to your doorstep. Featuring dedicated green zones and large glass walls to integrate indoor and outdoor living.', 'https://images.unsplash.com/photo-1600585154340-be6161a56a0c?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 4),
(5, 'Double Height', 'Double Height', 'Architectural masterpieces featuring double-volume living rooms. These units create an incredible sense of scale and allow for massive artistic installations or libraries.', 'https://images.unsplash.com/photo-1628592102173-b3a9920150d8?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80', 5);

-- Insert Default Specs for Studio
INSERT INTO `floor_plan_specs` (`plan_id`, `label`, `value`, `sort_order`) VALUES 
(1, 'Total Area', '2800 Sq. Ft', 1),
(1, 'Bedroom', '150 Sq. Ft', 2),
(1, 'Bathroom', '45 Sq. Ft', 3),
(1, 'Balcony/Pets', 'Allowed', 4),
(1, 'Lounge', '650 Sq. Ft', 5);

-- Insert Default Specs for Deluxe
INSERT INTO `floor_plan_specs` (`plan_id`, `label`, `value`, `sort_order`) VALUES 
(2, 'Total Area', '3500 Sq. Ft', 1),
(2, 'Bedroom', '220 Sq. Ft', 2),
(2, 'Bathroom', '60 Sq. Ft', 3),
(2, 'Balcony/Pets', 'Allowed', 4),
(2, 'Lounge', '800 Sq. Ft', 5);

-- Insert Default Specs for Penthouse
INSERT INTO `floor_plan_specs` (`plan_id`, `label`, `value`, `sort_order`) VALUES 
(3, 'Total Area', '5200 Sq. Ft', 1),
(3, 'Bedroom', '450 Sq. Ft', 2),
(3, 'Bathroom', '120 Sq. Ft', 3),
(3, 'Terrace Area', '1200 Sq. Ft', 4),
(3, 'Lounge', '1200 Sq. Ft', 5);

-- Insert Default Specs for Garden
INSERT INTO `floor_plan_specs` (`plan_id`, `label`, `value`, `sort_order`) VALUES 
(4, 'Total Area', '4000 Sq. Ft', 1),
(4, 'Garden Space', '500 Sq. Ft', 2),
(4, 'Bedroom', '200 Sq. Ft', 3),
(4, 'Bathroom', '55 Sq. Ft', 4),
(4, 'Lounge', '750 Sq. Ft', 5);

-- Insert Default Specs for Double Height
INSERT INTO `floor_plan_specs` (`plan_id`, `label`, `value`, `sort_order`) VALUES 
(5, 'Total Area', '4800 Sq. Ft', 1),
(5, 'Ceiling Height', '22 Ft', 2),
(5, 'Bedroom', '300 Sq. Ft', 3),
(5, 'Bathroom', '90 Sq. Ft', 4),
(5, 'Lounge', '1100 Sq. Ft', 5);
