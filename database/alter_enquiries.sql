-- Add missing columns to enquiries table if they don't exist
ALTER TABLE enquiries ADD COLUMN IF NOT EXISTS subject VARCHAR(255) DEFAULT 'General Enquiry' AFTER phone;
