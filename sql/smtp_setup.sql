-- SMTP Configuration for Dholera Smart City
-- Stores mail server settings

CREATE TABLE IF NOT EXISTS `smtp_config` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `smtp_host` VARCHAR(255) NOT NULL,
    `smtp_port` VARCHAR(10) NOT NULL,
    `smtp_user` VARCHAR(255) NOT NULL,
    `smtp_pass` VARCHAR(255) NOT NULL,
    `smtp_encryption` ENUM('none', 'ssl', 'tls') DEFAULT 'tls',
    `from_email` VARCHAR(255) NOT NULL,
    `from_name` VARCHAR(255) NOT NULL,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default record if not exists
INSERT INTO `smtp_config` (`smtp_host`, `smtp_port`, `smtp_user`, `smtp_pass`, `smtp_encryption`, `from_email`, `from_name`) 
SELECT '', '', '', '', 'tls', '', 'Dholera Smart City'
WHERE NOT EXISTS (SELECT 1 FROM `smtp_config` LIMIT 1);
