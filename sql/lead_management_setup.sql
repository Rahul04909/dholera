-- Lead Management Setup
-- Dholera Smart City

CREATE TABLE IF NOT EXISTS agent_leads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    agent_id INT NOT NULL,
    source_type ENUM('enquiry', 'callback') NOT NULL,
    source_id INT NOT NULL,
    admin_note TEXT,
    agent_feedback TEXT,
    status ENUM('new', 'in-progress', 'junk', 'converted') DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (agent_id) REFERENCES agents(id) ON DELETE CASCADE
);
