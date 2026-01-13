<?php
session_start();
session_unset();
session_destroy();
// After logout return user to public homepage
header('Location: ../../index.php');
exit;
?>
