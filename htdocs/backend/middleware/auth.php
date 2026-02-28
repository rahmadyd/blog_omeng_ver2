<?php
/**
 * Authentication Middleware
 * Handles session validation and role-based access control
 */

session_start();

function isAdminLoggedIn() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function requireAdmin() {
    if (!isAdminLoggedIn()) {
        header('Location: /private_admin_creations/login.php');
        exit;
    }
}

function getAdminUsername() {
    return $_SESSION['admin_username'] ?? null;
}

function logoutAdmin() {
    session_destroy();
    header('Location: /private_admin_creations/login.php');
    exit;
}
?>
