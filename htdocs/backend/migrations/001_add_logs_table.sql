-- Migration: 001 - Add admin logs table
-- Run with: mysql -u user -p db_omeng < 001_add_logs_table.sql
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
