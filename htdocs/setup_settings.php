<?php
// Database Setup Script for Settings Feature
include 'backend/config/database.php';

echo "Setting up database tables...\n\n";

// Create site_settings table
$create_settings = "CREATE TABLE IF NOT EXISTS site_settings (
    id INT PRIMARY KEY,
    setting_key VARCHAR(50) UNIQUE,
    setting_value TEXT
)";
if (mysqli_query($conn, $create_settings)) {
    echo "✓ Table 'site_settings' created\n";
} else {
    echo "✗ Error creating site_settings: " . mysqli_error($conn) . "\n";
}

// Create admins table
$create_admins = "CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255)
)";
if (mysqli_query($conn, $create_admins)) {
    echo "✓ Table 'admins' created\n";
} else {
    echo "✗ Error creating admins: " . mysqli_error($conn) . "\n";
}

// Insert default settings
$insert_settings = "INSERT IGNORE INTO site_settings (id, setting_key, setting_value) VALUES 
(1, 'wa_number', '6285777145179'),
(2, 'site_title', 'Omeng Creations'),
(3, 'site_description', 'Ruang digital untuk merayakan seni kontras.')";
if (mysqli_query($conn, $insert_settings)) {
    echo "✓ Default settings inserted\n";
} else {
    echo "✗ Error inserting settings: " . mysqli_error($conn) . "\n";
}

// Insert default admin
$insert_admin = "INSERT IGNORE INTO admins (username, password) VALUES 
('omeng.gembul', '$2y$10\$.1cpPgT0FtdkzvFnjcOgG.Clu27LgRuU8a9allonnnaD0MmtsBddq')";
if (mysqli_query($conn, $insert_admin)) {
    echo "✓ Default admin inserted\n";
} else {
    echo "✗ Error inserting admin: " . mysqli_error($conn) . "\n";
}

echo "\n✓ Database setup complete!\n";
echo "\nYou can now access Settings page and change:\n";
echo "- Admin password\n";
echo "- WhatsApp number\n";
echo "- Site title & description\n";
?>
