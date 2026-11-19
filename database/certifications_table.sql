-- ========================================================
-- Schema for Skilled.u Certificate Verification System
-- Database: skilledu1_skilledu_main
-- ========================================================

CREATE DATABASE IF NOT EXISTS `skilledu1_skilledu_main` 
  CHARACTER SET utf8mb4 
  COLLATE utf8mb4_unicode_ci;

USE `skilledu1_skilledu_main`;

CREATE TABLE IF NOT EXISTS `certifications` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `certificate_id` VARCHAR(50) NOT NULL,
  `student_name` VARCHAR(150) NOT NULL,
  `course` VARCHAR(150) NOT NULL,
  `issue_date` DATE NOT NULL,
  `pdf` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `idx_certificate_id` (`certificate_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

