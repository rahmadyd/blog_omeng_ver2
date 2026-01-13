<?php
// Visitor Tracking Script
include_once __DIR__ . '/database.php';

// Increment visitor count only if it's a real visitor (optional: you could add session checks here)
if (!isset($_SESSION['counted'])) {
    try {
        mysqli_query($conn, "UPDATE visitor_counter SET total_views = total_views + 1 WHERE id = 1");
    } catch (Exception $e) {
        // Silently fail if table doesn't exist
    }
    $_SESSION['counted'] = true;
}
?>
