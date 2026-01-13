<?php
if (!isset($_SESSION)) session_start();
// Logger helper for admin actions
// Usage: log_action($conn, $admin_username, $action_type, $target_table, $target_id = null, $details = null)
function log_action($conn, $admin_username, $action_type, $target_table, $target_id = null, $details = null) {
    $ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
    $stmt = mysqli_prepare($conn, "INSERT INTO logs (admin_username, action_type, target_table, target_id, details, ip_address) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssssss', $admin_username, $action_type, $target_table, $target_id, $details, $ip);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    }
}

?>
