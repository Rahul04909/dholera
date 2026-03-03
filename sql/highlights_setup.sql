-- Site Highlights Setup
-- Dholera Smart City

CREATE TABLE IF NOT EXISTS `site_highlights_settings` (
    `id` INT PRIMARY KEY CHECK (id = 1),
    `title` VARCHAR(255) NOT NULL DEFAULT 'Highlights',
    `side_image` VARCHAR(255) NOT NULL,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS `site_highlights_items` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `text` TEXT NOT NULL,
    `sort_order` INT DEFAULT 0,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert Default Settings
INSERT INTO `site_highlights_settings` (`id`, `title`, `side_image`) VALUES 
(1, 'Highlights', 'https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?ixlib=rb-4.0.3&auto=format&fit=crop&w=1200&q=80');

-- Insert Default Items
INSERT INTO `site_highlights_items` (`text`, `sort_order`) VALUES 
('World-class infrastructure & connectivity: within & outside.', 1),
('Airport & Sea Port in the vicinity.', 2),
('Benefit of the sea coast, nature park, and golf course.', 3),
('Premium civic amenities.', 4),
('Capable to cater to both the International & Domestic Markets.', 5),
('Close to Gujarat International Finance TechCity (GIFT).', 6),
('Logistic support of the Dedicated Freight Corridor (DMIC).', 7),
('Public investment in core infrastructure.', 8);
