-- Student Manager System — upgrade schema
-- Adds `subjects` and `teachers` modules.
-- Existing `students` data is not touched.
-- Import: mysql -u root < database_upgrade.sql
-- Or via phpMyAdmin: select `student_manager` then Import this file.

USE `student_manager`;

CREATE TABLE IF NOT EXISTS `subjects` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` VARCHAR(50) NOT NULL,
  `name` VARCHAR(150) NOT NULL,
  `description` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_subject_code` (`code`),
  KEY `idx_subject_name` (`name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS `teachers` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `fullname` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `phone` VARCHAR(50) NULL,
  `subject_id` INT UNSIGNED NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_teacher_email` (`email`),
  KEY `fk_teacher_subject` (`subject_id`),
  CONSTRAINT `fk_teacher_subject` FOREIGN KEY (`subject_id`)
    REFERENCES `subjects` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample data (remove in production)
INSERT INTO `subjects` (`code`, `name`, `description`)
VALUES
  ('CS-101', 'Introduction to Programming', 'Programming fundamentals using a high-level language.'),
  ('CS-102', 'Database Systems', 'Relational databases design, SQL and normalization.'),
  ('CS-103', 'Web Development', 'Building dynamic web applications with PHP and JS.'),
  ('MATH-101', 'Calculus I', 'Limits, derivatives and integrals of single variable functions.'),
  ('ENG-101', 'Academic English', 'Technical writing and presentation skills.'),
  ('PHY-101', 'Physics Fundamentals', 'Mechanics, waves and basic electromagnetism.')
ON DUPLICATE KEY UPDATE `name` = VALUES(`name`);

INSERT INTO `teachers` (`fullname`, `email`, `phone`, `subject_id`)
SELECT 'Ali Nasser',      'ali.nasser@school.edu',    '+962790000101', subjects.id FROM `subjects` WHERE subjects.code = 'CS-101'
UNION ALL SELECT 'Lina Barakat', 'lina.barakat@school.edu', '+962790000102', subjects.id FROM `subjects` WHERE subjects.code = 'CS-102'
UNION ALL SELECT 'Yousef Ammar', 'yousef.ammar@school.edu', '+962790000103', subjects.id FROM `subjects` WHERE subjects.code = 'CS-103'
UNION ALL SELECT 'Nadia Smadi',  'nadia.smadi@school.edu',  '+962790000104', subjects.id FROM `subjects` WHERE subjects.code = 'MATH-101'
UNION ALL SELECT 'Omar Qasem',   'omar.qasem@school.edu',   '+962790000105', subjects.id FROM `subjects` WHERE subjects.code = 'ENG-101'
ON DUPLICATE KEY UPDATE `fullname` = VALUES(`fullname`);
