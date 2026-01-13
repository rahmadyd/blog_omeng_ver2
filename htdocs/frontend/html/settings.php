<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo-omeng.png" type="image/png">
    <title>Settings | Omeng Creations</title>
    <link rel="stylesheet" href="../css/main.css?v=1.7">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="../js/main.js" defer></script>
    <script src="../js/theme.js" defer></script>
    <?php include '../includes/header_meta.php'; ?>
    <style>
        .settings-card {
            background: white;
            padding: 30px;
            border-radius: 16px;
            margin-bottom: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .settings-card h3 {
            color: var(--color-primary-pink);
            font-family: 'Bebas Neue', cursive;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }
        .settings-card p {
            color: #666;
            margin-bottom: 20px;
        }
        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }
        .toggle-switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }
        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }
        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }
        input:checked + .slider {
            background-color: var(--color-accent);
        }
        input:checked + .slider:before {
            transform: translateX(26px);
        }
        .font-size-buttons {
            display: flex;
            gap: 10px;
        }
        .font-size-btn {
            padding: 10px 20px;
            border: 2px solid rgba(0,0,0,0.1);
            background: white;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.3s;
            font-weight: 600;
        }
        .font-size-btn.active {
            background: var(--color-accent);
            color: white;
            border-color: var(--color-accent);
        }
        .font-size-btn:hover {
            border-color: var(--color-primary-pink);
        }
        .setting-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0;
            border-bottom: 1px solid rgba(0,0,0,0.05);
        }
        .setting-row:last-child {
            border-bottom: none;
        }
        .setting-info h4 {
            color: #333;
            margin: 0 0 5px 0;
            font-size: 1.1rem;
        }
        .setting-info p {
            margin: 0;
            font-size: 0.9rem;
        }
    </style>
</head>

<body>
    <?php $is_subpage = true; include '../includes/navbar.php'; ?>

    <main>
        <section class="project-section">
            <div class="project-container">
                <div class="project-header-about">
                    <div class="title-area-about">
                        <h2>Settings</h2>
                    </div>
                    
                    <div class="about-content">
                        <p style="color: #2d2d2d; margin-bottom: 30px;">Sesuaikan ukuran teks untuk kenyamanan membaca.</p>
                        
                        <!-- Font Size -->
                        <div class="settings-card">
                            <h3>Accessibility</h3>
                            <div class="setting-row">
                                <div class="setting-info">
                                    <h4>Font Size</h4>
                                    <p>Atur ukuran teks untuk kenyamanan membaca</p>
                                </div>
                                <div class="font-size-buttons">
                                    <button class="font-size-btn" data-size="small">Kecil</button>
                                    <button class="font-size-btn active" data-size="medium">Sedang</button>
                                    <button class="font-size-btn" data-size="large">Besar</button>
                                </div>
                            </div>
                        </div>

                        <!-- Info -->
                        <div class="settings-card">
                            <h3>About</h3>
                            <p style="margin: 0;">Pengaturan ini disimpan di browser Anda dan akan tetap ada saat Anda kembali ke website ini.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>

</html>