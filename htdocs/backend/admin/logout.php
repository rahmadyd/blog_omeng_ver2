<?php
require_once '../middleware/auth.php';

session_unset();
session_destroy();

// Redirect to login with confirmation
header('Location: ../../private_admin_creations/login.php?logged_out=1');
exit;
?>
