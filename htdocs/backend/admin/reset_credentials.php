<?php
// RESET ADMIN CREDENTIALS SCRIPT
// This script resets the admin username and password to default values
// After running this, you can login with:
// Username: admin
// Password: admin123

include '../config/database.php';

$username = 'admin';
$password = 'admin123';
$hashed_password = password_hash($password, PASSWORD_BCRYPT);

// Update or insert admin credentials
$query = "UPDATE admins SET username = ?, password = ? WHERE id = 1";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, 'ss', $username, $hashed_password);
$result = mysqli_stmt_execute($stmt);

if ($result) {
    echo "<h2>✓ Berhasil!</h2>";
    echo "<p>Username dan password telah direset ke:</p>";
    echo "<p><strong>Username:</strong> admin</p>";
    echo "<p><strong>Password:</strong> admin123</p>";
    echo "<p><a href='../../private_admin/login.php'>Pergi ke Login</a></p>";
} else {
    echo "<h2>✗ Error!</h2>";
    echo "<p>Gagal mereset credentials: " . mysqli_error($conn) . "</p>";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
