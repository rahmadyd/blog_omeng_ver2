<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../../login.php');
    exit;
}

include '../config/database.php';
include 'logger.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'] ?? '';
    
    // Change Password
    if ($action == 'change_password') {
        $current_password = $_POST['current_password'];
        $new_password = $_POST['new_password'];
        $confirm_password = $_POST['confirm_password'];
        
        // Validate new password matches confirmation
        if ($new_password !== $confirm_password) {
            header('Location: ../../frontend/html/settings.php?error=password_mismatch');
            exit;
        }
        
        // Get current admin credentials
        $query = "SELECT * FROM admins WHERE username = 'omeng.gembul' LIMIT 1";
        $result = mysqli_query($conn, $query);
        $admin = mysqli_fetch_assoc($result);
        
        // Verify current password
        if (!password_verify($current_password, $admin['password'])) {
            header('Location: ../../frontend/html/settings.php?error=wrong_password');
            exit;
        }
        
        // Hash new password and update
        $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);
        $update_query = "UPDATE admins SET password = ? WHERE username = 'omeng.gembul'";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, 's', $hashed_password);
        mysqli_stmt_execute($stmt);
        $admin = $_SESSION['admin_username'] ?? 'omeng.gembul';
        log_action($conn, $admin, 'update', 'admins', null, 'password_changed');
        header('Location: ../../private_admin/index.php?tab=site-settings-section&success=password_changed');
        exit;
    }
    
    // Update WhatsApp Number
    if ($action == 'update_wa') {
        $wa_number = preg_replace('/[^0-9]/', '', $_POST['wa_number']);
        
        // Ensure it starts with 62
        if (strpos($wa_number, '0') === 0) {
            $wa_number = '62' . substr($wa_number, 1);
        }
        
        $update_query = "UPDATE site_settings SET setting_value = ? WHERE setting_key = 'wa_number'";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, 's', $wa_number);
        mysqli_stmt_execute($stmt);
        $admin = $_SESSION['admin_username'] ?? 'unknown';
        log_action($conn, $admin, 'update', 'site_settings', null, 'wa_number_updated');
        header('Location: ../../private_admin/index.php?tab=site-settings-section&success=wa_updated');
        exit;
    }
    
    // Update Site Info
    if ($action == 'update_site_info') {
        $site_title = mysqli_real_escape_string($conn, $_POST['site_title']);
        $site_description = mysqli_real_escape_string($conn, $_POST['site_description']);
        
        // Update title
        $update_title = "UPDATE site_settings SET setting_value = ? WHERE setting_key = 'site_title'";
        $stmt = mysqli_prepare($conn, $update_title);
        mysqli_stmt_bind_param($stmt, 's', $site_title);
        mysqli_stmt_execute($stmt);

        // Update description
        $update_desc = "UPDATE site_settings SET setting_value = ? WHERE setting_key = 'site_description'";
        $stmt = mysqli_prepare($conn, $update_desc);
        mysqli_stmt_bind_param($stmt, 's', $site_description);
        mysqli_stmt_execute($stmt);

        $admin = $_SESSION['admin_username'] ?? 'unknown';
        log_action($conn, $admin, 'update', 'site_settings', null, "site_title_updated: $site_title");
        header('Location: ../../private_admin/index.php?tab=site-settings-section&success=site_info_updated');
        exit;
    }
}

header('Location: ../../admin.php?tab=site-settings-section');
exit;
?>
