-- 1. Create the database with full UTF-8 support for Arabic text
CREATE DATABASE IF NOT EXISTS saudi_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE saudi_db;

-- 2. Admin Table
CREATE TABLE admin (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Note: Storing plain text passwords ('password') is a major security risk. 
-- In a real-world application, you should hash this using PHP's password_hash() function.
INSERT INTO admin (username, password) VALUES ('admin', 'password');

-- 3. Regions Table
CREATE TABLE regions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- 4. Places Table
CREATE TABLE places (
    id INT AUTO_INCREMENT PRIMARY KEY,
    region_id INT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    image VARCHAR(255),
    -- Added ON DELETE CASCADE so if you delete a region in the admin panel, its places are cleanly removed too
    FOREIGN KEY (region_id) REFERENCES regions(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample data
INSERT INTO regions (name, description, image) VALUES 
('الرياض', 'عاصمة المملكة العربية السعودية', 'riyadh.jpg'),
('مكة المكرمة', 'مدينة دينية يقصدها المسلمون للحج', 'mecca.jpg');

INSERT INTO places (region_id, name, description, image) VALUES 
(1, 'برج المملكة', 'أطول برج في السعودية', 'kingdom_tower.jpg'),
(2, 'المسجد الحرام', 'أقدس مسجد في الإسلام', 'kaaba.jpg');
