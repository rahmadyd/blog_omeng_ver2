<?php
session_start();
if (isset($_SESSION['admin_logged_in'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Omeng Creations</title>
    <link rel="icon" href="../frontend/images/logo-omeng.png" type="image/png">
    <script src="../frontend/js/main.js" defer></script>
    <link rel="stylesheet" href="../frontend/css/main.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: var(--color-primary-black);
            display: flex;
            flex-direction: column;
            margin: 0;
        }
        main {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: calc(100vh - 120px);
            padding: 40px 20px;
        }
        .login-card {
            background: var(--color-primary-pink);
            padding: 40px;
            border-radius: 32px;
            width: 100%;
            max-width: 400px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.5);
            text-align: center;
        }
        .login-card h2 {
            font-family: 'Bebas Neue', cursive;
            font-size: 3rem;
            color: var(--color-primary-black);
            margin-bottom: 30px;
        }
        .login-form {
            display: grid;
            gap: 20px;
        }
        .login-form input {
            padding: 14px;
            border: 2px solid rgba(0,0,0,0.1);
            border-radius: 12px;
            background: rgba(255,255,255,0.8);
            font-family: 'Poppins', sans-serif;
            font-size: 1rem;
        }
        .login-form input:focus {
            outline: none;
            border-color: var(--color-accent);
        }
        .btn-login {
            background: var(--color-primary-black);
            color: var(--color-primary-pink);
            padding: 14px;
            border-radius: 12px;
            font-weight: bold;
            text-transform: uppercase;
            cursor: pointer;
            transition: transform 0.3s;
            border: none;
        }
        .btn-login:hover {
            transform: translateY(-2px);
        }
        .error-msg {
            color: #d00;
            background: rgba(255,0,0,0.1);
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <?php include '../frontend/includes/navbar.php'; ?>
    <main>
        <div class="login-card">
        <h2>Admin Login</h2>
        <?php if (isset($_GET['error'])): ?>
            <div class="error-msg">Username atau Password salah!</div>
        <?php endif; ?>
        <form action="../backend/admin/login_handler.php" method="POST" class="login-form">
            <input type="text" name="username" placeholder="Username" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit" class="btn-login">Masuk</button>
        </form>
        </div>
    </main>
    <footer><div class="container"><p>&copy; 2025 Rahmad. All rights reserved.</p></div></footer>
</body>
</html>
