-- Database Schema for Omeng Creations

-- Table structure for projects
CREATE TABLE IF NOT EXISTS projects (
    id INT AUTO_INCREMENT PRIMARY KEY,
    judul VARCHAR(255),
    deskripsi TEXT,
    kategori VARCHAR(50),
    gambar VARCHAR(255),
    tanggal VARCHAR(50),
    link VARCHAR(255)
);

-- Table structure for visitor_counter
CREATE TABLE IF NOT EXISTS visitor_counter (
    id INT PRIMARY KEY,
    total_views INT DEFAULT 0
);

-- Table structure for feedback
CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(255),
    pesan TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Table structure for site settings
CREATE TABLE IF NOT EXISTS site_settings (
    id INT PRIMARY KEY,
    setting_key VARCHAR(50) UNIQUE,
    setting_value TEXT
);

-- Table structure for admin credentials
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
);

-- Initial data for visitor_counter
INSERT IGNORE INTO visitor_counter (id, total_views) VALUES (1, 0);

-- Initial data for site_settings
INSERT IGNORE INTO site_settings (id, setting_key, setting_value) VALUES 
(1, 'wa_number', '6285777145179'),
(2, 'site_title', 'Omeng Creations'),
(3, 'site_description', 'Ruang digital untuk merayakan seni kontras.');

-- Initial admin credentials (password: omengcreations.gembul@#.$)
INSERT IGNORE INTO admins (username, password) VALUES 
('omeng.gembul', '$2y$10$.1cpPgT0FtdkzvFnjcOgG.Clu27LgRuU8a9allonnnaD0MmtsBddq');

-- Sample data for projects
-- (default sample data removed to keep admin and public lists clean)
-- If you need to add sample projects later, insert them manually.

-- Table structure for admin logs
CREATE TABLE IF NOT EXISTS logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    admin_username VARCHAR(100),
    action_type VARCHAR(50),
    target_table VARCHAR(100),
    target_id VARCHAR(50),
    details TEXT,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
