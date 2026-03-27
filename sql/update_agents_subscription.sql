-- Update agents table to support subscriptions
ALTER TABLE `agents` 
ADD COLUMN `package_id` INT(11) DEFAULT NULL AFTER `password`,
ADD COLUMN `package_expiry` DATETIME DEFAULT NULL AFTER `package_id`,
ADD COLUMN `registration_status` ENUM('pending', 'active') DEFAULT 'pending' AFTER `status`;

-- Add foreign key for package_id
ALTER TABLE `agents`
ADD CONSTRAINT `fk_agent_package`
FOREIGN KEY (`package_id`) REFERENCES `agent_packages`(`id`) ON DELETE SET NULL;
