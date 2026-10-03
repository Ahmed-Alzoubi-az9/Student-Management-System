-- Student Manager System — database schema
-- Database: student_manager
-- Import: mysql -u root -p < database.sql
-- Or via phpMyAdmin: create DB `student_manager` then Import this file.

CREATE DATABASE IF NOT EXISTS `student_manager`
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `student_manager`;

CREATE TABLE IF NOT EXISTS `students` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `student_id` VARCHAR(50) NOT NULL,
  `fullname` VARCHAR(150) NOT NULL,
  `email` VARCHAR(150) NOT NULL,
  `class` VARCHAR(50) NOT NULL,
  `grade` VARCHAR(20) NOT NULL,
  `date_of_birth` DATE NULL,
  `address` VARCHAR(255) NULL,
  `nationality` VARCHAR(100) NULL,
  `parent_number` VARCHAR(50) NULL,
  `health_info` TEXT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_student_id` (`student_id`),
  KEY `idx_fullname` (`fullname`),
  KEY `idx_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample data (remove in production)
INSERT INTO `students`
  (`student_id`, `fullname`, `email`, `class`, `grade`, `date_of_birth`, `address`, `nationality`, `parent_number`, `health_info`)
VALUES
  ('STU-1001', 'Ahmed Alzoubi', 'ahmed@example.com', 'CS-101', '92', '2003-04-12', 'Amman, Jordan', 'Jordanian', '+962790000001', 'No issues'),
  ('STU-1002', 'Sara Khaled', 'sara.k@example.com', 'CS-101', '88', '2004-01-25', 'Irbid, Jordan', 'Jordanian', '+962790000002', ''),
  ('STU-1003', 'John Smith', 'john.smith@example.com', 'CS-102', '75', '2003-09-03', 'New York, USA', 'American', '+10000000003', 'Allergy: peanuts'),
  ('STU-1004', 'Maria Garcia', 'maria.g@example.com', 'CS-102', '81', '2004-06-17', 'Madrid, Spain', 'Spanish', '+34000000004', ''),
  ('STU-1005', 'Omar Haddad', 'omar.h@example.com', 'CS-103', '95', '2002-11-30', 'Zarqa, Jordan', 'Jordanian', '+962790000005', '')
ON DUPLICATE KEY UPDATE `fullname` = VALUES(`fullname`);
