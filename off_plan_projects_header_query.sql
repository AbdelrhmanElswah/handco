-- Query to add Off Plan Projects Header Section in phpMyAdmin
-- Use INSERT IGNORE to avoid duplicate key errors, or use the REPLACE INTO version below

INSERT INTO `cms_sections` 
(`section_key`, `section_name`, `title`, `subtitle`, `content`, `list_items`, `stats_items`, `testimonials`, `accordion_items`, `contact_phones`, `contact_addresses`, `contact_emails`, `social_links`, `is_active`, `created_at`, `updated_at`) 
VALUES 
('off_plan_projects_header', 'Off Plan Projects Header Section', 'Off-Plan Projects in Dubai', 'Explore upcoming developments and secure your investment early.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NOW(), NOW())
ON DUPLICATE KEY UPDATE 
    `section_name` = 'Off Plan Projects Header Section',
    `title` = 'Off-Plan Projects in Dubai',
    `subtitle` = 'Explore upcoming developments and secure your investment early.',
    `updated_at` = NOW();

-- Alternative: If you want to replace existing record completely, use this instead:
-- REPLACE INTO `cms_sections` 
-- (`section_key`, `section_name`, `title`, `subtitle`, `content`, `list_items`, `stats_items`, `testimonials`, `accordion_items`, `contact_phones`, `contact_addresses`, `contact_emails`, `social_links`, `is_active`, `created_at`, `updated_at`) 
-- VALUES 
-- ('off_plan_projects_header', 'Off Plan Projects Header Section', 'Off-Plan Projects in Dubai', 'Explore upcoming developments and secure your investment early.', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, NOW(), NOW());

