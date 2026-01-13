<?php
// TEST ADMIN LOGIN
include 'backend/config/database.php';

$username = 'omeng.gembul';
$password = 'omengcreations.gembul@#.$';

echo "<!DOCTYPE html><html><head><meta charset='UTF-8'><title>Test Login</title><style>body{font-family:Arial;padding:20px;background:#000;color:#fff;}h2{color:#FFC0CB;}.box{background:#1a1a1a;padding:20px;border-radius:10px;margin:10px 0;}</style></head><body>";
echo "<h2>Test Admin Login</h2>";

// Check if admin exists
$query = "SELECT * FROM admins WHERE username = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 's', $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$admin = mysqli_fetch_assoc($result);

echo "<div class='box'>";
if ($admin) {
    echo "<strong>✓ Admin ditemukan:</strong><br>";
    echo "Username: " . htmlspecialchars($admin['username']) . "<br>";
    echo "Password Hash: " . htmlspecialchars($admin['password']) . "<br><br>";
    
    // Test password
    $is_valid = password_verify($password, $admin['password']);
    echo "<strong>Password Test:</strong><br>";
    echo "Input: " . htmlspecialchars($password) . "<br>";
    echo "Hash: " . htmlspecialchars($admin['password']) . "<br>";
    echo "Match: " . ($is_valid ? "✓ YES" : "✗ NO") . "<br>";
    
    if (!$is_valid) {
        echo "<br><em style='color:#ff9800;'>Password tidak match. Coba password lain atau reset di database.</em>";
    }
} else {
    echo "<strong>✗ Admin tidak ditemukan dengan username: " . htmlspecialchars($username) . "</strong><br><br>";
    echo "Daftar semua admin di database:<br>";
    
    $all = mysqli_query($conn, "SELECT id, username FROM admins");
    if ($all && mysqli_num_rows($all) > 0) {
        while ($row = mysqli_fetch_assoc($all)) {
            echo "- ID: " . $row['id'] . ", Username: " . htmlspecialchars($row['username']) . "<br>";
        }
    } else {
        echo "<em>Tidak ada admin di database</em>";
    }
}
echo "</div>";
echo "</body></html>";

mysqli_close($conn);
?>
