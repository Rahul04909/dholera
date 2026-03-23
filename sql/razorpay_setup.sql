-- Razorpay Configuration for Dholera Smart City
-- Stores API keys and payment mode

CREATE TABLE IF NOT EXISTS `razorpay_config` (
    `id` INT(11) AUTO_INCREMENT PRIMARY KEY,
    `key_id` VARCHAR(255) NOT NULL,
    `key_secret` VARCHAR(255) NOT NULL,
    `mode` ENUM('test', 'live') DEFAULT 'test',
    `status` ENUM('active', 'inactive') DEFAULT 'active',
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Insert default record if not exists
INSERT INTO `razorpay_config` (`key_id`, `key_secret`, `mode`, `status`) 
SELECT '', '', 'test', 'inactive'
WHERE NOT EXISTS (SELECT 1 FROM `razorpay_config` LIMIT 1);
