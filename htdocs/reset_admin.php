<?php
// RESET ADMIN CREDENTIALS SCRIPT
// Access this file via: http://localhost/blog_omeng/reset_admin.php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
    include 'backend/config/database.php';

    $username = 'admin';
    $password = 'admin123';
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Update admin credentials (assuming id=1)
    $query = "UPDATE admins SET username = ?, password = ? WHERE id = 1";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $hashed_password);
    $result = mysqli_stmt_execute($stmt);

    if ($result) {
        $success = true;
    } else {
        $error = mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Reset Admin Credentials</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 40px;
            background: #000;
            color: #fff;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: #1a1a1a;
            padding: 30px;
            border-radius: 10px;
        }
        h2 {
            color: #FFC0CB;
            margin-bottom: 20px;
        }
        p {
            line-height: 1.6;
        }
        .success {
            background: rgba(0, 255, 0, 0.1);
            border: 1px solid #00ff00;
            padding: 15px;
            border-radius: 5px;
            color: #00ff00;
            margin: 20px 0;
        }
        .error {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid #ff0000;
            padding: 15px;
            border-radius: 5px;
            color: #ff0000;
            margin: 20px 0;
        }
        .form-group {
            margin: 20px 0;
        }
        button {
            background: #FFC0CB;
            color: #000;
            padding: 12px 30px;
            border: none;
            border-radius: 5px;
            font-weight: bold;
            cursor: pointer;
            font-size: 1rem;
        }
        button:hover {
            background: #ff69b4;
        }
        .link {
            margin-top: 20px;
            text-align: center;
        }
        a {
            color: #FFC0CB;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>⚙️ Reset Admin Credentials</h2>

        <?php if (isset($success) && $success): ?>
            <div class="success">
                <strong>✓ Berhasil!</strong><br>
                Username dan password telah direset ke:
                <ul>
                    <li>Username: <strong>admin</strong></li>
                    <li>Password: <strong>admin123</strong></li>
                </ul>
            </div>
            <div class="link">
                <a href="private_admin/login.php" style="font-weight: bold; font-size: 1.1rem;">→ Pergi ke Login Admin</a>
            </div>
        <?php elseif (isset($error)): ?>
            <div class="error">
                <strong>✗ Error!</strong><br>
                <?php echo htmlspecialchars($error); ?>
            </div>
            <div class="link">
                <a href="reset_admin.php">← Kembali</a>
            </div>
        <?php else: ?>
            <p>Klik tombol di bawah untuk mereset admin credentials ke default:</p>
            <ul>
                <li>Username: <strong>admin</strong></li>
                <li>Password: <strong>admin123</strong></li>
            </ul>
            <p style="color: #ff9800; margin-top: 20px;">⚠️ Tindakan ini akan mengganti password yang ada!</p>
            
            <form method="POST">
                <div class="form-group">
                    <button type="submit" name="confirm" value="yes">Reset Admin Credentials</button>
                </div>
            </form>
            
            <div class="link">
                <a href="index.php">← Kembali ke Homepage</a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>
