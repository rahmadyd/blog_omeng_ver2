<?php
// Runner for migration 002_reset_admin_password.sql
// Usage: open in browser: http://localhost/blog_omeng/backend/migrations/run_migration_002.php
// or run via PHP CLI: php run_migration_002.php

set_time_limit(0);
ini_set('display_errors', 1);
error_reporting(E_ALL);

include __DIR__ . "/../config/database.php"; // uses $conn

$sqlFile = __DIR__ . '/002_reset_admin_password.sql';
if (!file_exists($sqlFile)) {
    echo "SQL file not found: $sqlFile";
    exit;
}

$sql = file_get_contents($sqlFile);
if ($sql === false) {
    echo "Failed to read SQL file.";
    exit;
}

// Split statements (basic, works for simple SQL files)
$statements = array_filter(array_map('trim', preg_split('/;\s*\n/', $sql)));

$errors = [];
foreach ($statements as $stmt) {
    if ($stmt === '') continue;
    if (!mysqli_query($conn, $stmt)) {
        $errors[] = mysqli_error($conn) . " -- Statement: " . substr($stmt,0,200);
    }
}

if (count($errors) === 0) {
    echo "Migration applied successfully. You can now try logging in with username: <strong>omeng.gembul</strong> and password: <strong>omengcreations.gembul@#.$</strong>";
} else {
    echo "Migration completed with errors:<br><pre>" . htmlspecialchars(implode("\n", $errors)) . "</pre>";
}

mysqli_close($conn);
?>