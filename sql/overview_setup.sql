-- Site Overview Setup
-- Dholera Smart City

CREATE TABLE IF NOT EXISTS `site_overview` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `title` VARCHAR(255) NOT NULL,
    `subtitle` TEXT NOT NULL,
    `content` LONGTEXT NOT NULL,
    `image_path` VARCHAR(255) NOT NULL,
    `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Insert Default Content
INSERT INTO `site_overview` (`title`, `subtitle`, `content`, `image_path`) VALUES 
(
    'Overview', 
    'India''s First Greenfield Smart City', 
    '<p>Dholera Special Investment Regions (SIR) is a Greenfield Industrial City, planned developed and managed by a SPV named Dholera Industrial City Development Limited (DICDL), incorporated between the Government of India represented by NICDIT and the State Government represented by Dholera Special Investment Region Development Authority (DSIRDA). The greenfield city is planned to be developed over 920 sq.km. with access to other proximate major cities like Ahmedabad, Rajkot, Baroda. The city is envisioned as a self-sustaining integrated ecosystem of urban and industrial economy. Being located in Gujarat, Dholera SIR has inherent advantages for industrial development.</p><p>DSIR, under Town Planning Schemes 1 to 6 covers an area of 422 sq. km. Initially an area of 22.54 sq. km is being developed as activation zone for industrial & residential uses. The city plan includes mixed, recreational, tourism, knowledge & IT, city center and logistics land use that will chart the economic road map of Dholera.</p>',
    'assets/overview.webp'
);
