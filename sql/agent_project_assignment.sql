-- Agent-Project Assignment Table
-- Dholera Smart City

CREATE TABLE IF NOT EXISTS `agent_projects` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `agent_id` INT(11) NOT NULL,
    `project_id` INT(11) NOT NULL,
    `assigned_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (`agent_id`) REFERENCES `agents`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`project_id`) REFERENCES `projects`(`id`) ON DELETE CASCADE,
    UNIQUE KEY `unique_assignment` (`agent_id`, `project_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
