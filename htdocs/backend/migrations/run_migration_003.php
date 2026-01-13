<?php
// Runner for migration 003_remove_sample_projects.sql
include __DIR__ . "/../config/database.php";
$sqlFile = __DIR__ . '/003_remove_sample_projects.sql';
if (!file_exists($sqlFile)) { echo "SQL file not found."; exit; }
$sql = file_get_contents($sqlFile);
$statements = array_filter(array_map('trim', preg_split('/;\s*\n/', $sql)));
$errors = [];
foreach ($statements as $stmt) {
    if ($stmt === '') continue;
    if (!mysqli_query($conn, $stmt)) {
        $errors[] = mysqli_error($conn) . " -- Statement: " . substr($stmt,0,200);
    }
}
if (count($errors) === 0) echo "Sample projects removed successfully."; else echo "Errors:\n" . implode("\n", $errors);
mysqli_close($conn);
?>