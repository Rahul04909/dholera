-- Agent Site Visits Table
-- Dholera Smart City

CREATE TABLE IF NOT EXISTS `agent_site_visits` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `agent_id` INT(11) NOT NULL,
    `site_visit_id` INT(11) NOT NULL,
    `status` ENUM('pending', 'contacted', 'completed', 'cancelled') DEFAULT 'pending',
    `agent_notes` TEXT,
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`agent_id`) REFERENCES `agents`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`site_visit_id`) REFERENCES `site_visits`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `unique_agent_visit` (`agent_id`, `site_visit_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
