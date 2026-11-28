-- Dummy Database Schema for skilledu.in
-- Generated for local development and testing

-- Create database (run once):
CREATE DATABASE IF NOT EXISTS skilledu_dummy;
USE skilledu_dummy;

-- --------------------------------------------------------
-- Table: users
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Table: certifications
-- --------------------------------------------------------
CREATE TABLE IF NOT EXISTS certifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    certificate_id VARCHAR(20) NOT NULL UNIQUE,
    pdf VARCHAR(255) NOT NULL DEFAULT 'uploads/default-certificate.pdf',
    status TINYINT NOT NULL DEFAULT 1,
    deleted TINYINT NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_certificate_id (certificate_id),
    INDEX idx_deleted (deleted)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------
-- Dummy Data
-- --------------------------------------------------------

-- Users table: sample admin and student accounts
-- Password (all set to 'password123' for demo purposes)
INSERT INTO users (email, password) VALUES 
('admin@skilledu.in', '\$2y\$12\$eDd6WVAwn0b.iLOleZ1pSOVNT9IqYdl2Dx.oUK3eUIeFl2bAIsbWq'),
('student1@skilledu.in', '\$2y\$12\$eDd6WVAwn0b.iLOleZ1pSOVNT9IqYdl2Dx.oUK3eUIeFl2bAIsbWq'),
('student2@skilledu.in', '\$2y\$12\$eDd6WVAwn0b.iLOleZ1pSOVNT9IqYdl2Dx.oUK3eUIeFl2bAIsbWq'),
('student3@skilledu.in', '\$2y\$12\$eDd6WVAwn0b.iLOleZ1pSOVNT9IqYdl2Dx.oUK3eUIeFl2bAIsbWq');

-- Certificates table: sample certificate records
-- Certificate ID format: SU + 4 digits + 2 uppercase letters + 3 digits (e.g., SU0324ND017)
INSERT INTO certifications (certificate_id, pdf, status, deleted) VALUES 
-- Verified certificates (active, not deleted)
('SU0324ND017', 'uploads/SU0324ND017.pdf', 1, 0),
('SU0526ND082', 'uploads/SU0526ND082.pdf', 1, 0),
('SU0425FA053', 'uploads/SU0425FA053.pdf', 1, 0),
('SU0625FA060', 'uploads/SU0625FA060.pdf', 1, 0),
('SU0825FA073', 'uploads/SU0825FA073.pdf', 1, 0),
('SU1025ML078', 'uploads/SU1025ML078.pdf', 1, 0),
('SU1124ND042', 'uploads/SU1124ND042.pdf', 1, 0),
('SU1225FA080', 'uploads/SU1225FA080.pdf', 1, 0),
-- Some incomplete/pending certificates (not deleted, but status might vary)
('SU0526SSC01', 'uploads/SU0526SSC01.pdf', 1, 0),
('SU0526SSC02', 'uploads/SU0526SSC02.pdf', 1, 0),
('SU0526SSC03', 'uploads/SU0526SSC03.pdf', 1, 0),
('SU0526SSC04', 'uploads/SU0526SSC04.pdf', 1, 0),
('SU0626SSC05', 'uploads/SU0626SSC05.pdf', 1, 0),
('SU0626SSC06', 'uploads/SU0626SSC06.pdf', 1, 0),
('SU0626SSC07', 'uploads/SU0626SSC07.pdf', 1, 0),
('SU0626SSC08', 'uploads/SU0626SSC08.pdf', 1, 0),
('SU0925FA070', 'uploads/SU0925FA070.pdf', 1, 0),
('SU0925FA071', 'uploads/SU0925FA071.pdf', 1, 0),
('SU1025FA076', 'uploads/SU1025FA076.pdf', 1, 0),
('SU1025ND076', 'uploads/SU1025ND076.pdf', 1, 0),
('SU1125ML079', 'uploads/SU1125ML079.pdf', 1, 0),
('SU1225ND080', 'uploads/SU1225ND080.pdf', 1, 0),
-- Demo/placeholder record
('SU1111DEMO', 'uploads/default-certificate.pdf', 1, 0);