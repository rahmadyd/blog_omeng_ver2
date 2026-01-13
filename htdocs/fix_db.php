<?php
include 'backend/config/database.php';

echo "<h2>Database Fix Tool</h2>";

// 1. Force update the number
$new_no = '+6285777145179';
$sql_update = "UPDATE projects SET link = '$new_no' WHERE kategori IN ('Merchandise', 'Digital Art', 'UI Component', 'Service')";
if (mysqli_query($conn, $sql_update)) {
    echo "✅ SUCCESS: All shop items updated to: $new_no (Affected: " . mysqli_affected_rows($conn) . " rows)<br>";
} else {
    echo "❌ ERROR: " . mysqli_error($conn) . "<br>";
}

// 2. Check for duplicates or old entries
$res = mysqli_query($conn, "SELECT id, judul, link, kategori FROM projects");
echo "<h3>Current Database Content:</h3>";
echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
echo "<tr><th>ID</th><th>Judul</th><th>WA Number</th><th>Category</th></tr>";
while ($row = mysqli_fetch_assoc($res)) {
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['judul']}</td>";
    echo "<td>{$row['link']}</td>";
    echo "<td>{$row['kategori']}</td>";
    echo "</tr>";
}
echo "</table>";

echo "<br><br><a href='index.php'>Go back to Home</a>";
?>
