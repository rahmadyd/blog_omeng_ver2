<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo-omeng.png" type="image/png">
    <title>QNA | Omeng Creations</title>
    <link rel="stylesheet" href="../css/main.css?v=1.5">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <script src="../js/main.js" defer></script>
    <?php include '../includes/header_meta.php'; ?>
</head>

<body>
    <?php $is_subpage = true; include '../includes/navbar.php'; ?>

    <main>
        <section class="project-section">
            <div class="project-container">
                <div class="project-header-about">
                    <div class="title-area-about">
                        <h2>QNA</h2>
                    </div>
                    <div class="about-content">
                        <p style="color: #2d2d2d; margin-bottom: 20px;">Pertanyaan yang sering diajukan.</p>
                        <div style="display: flex; flex-direction: column; gap: 20px;">
                            <div class="qna-card">
                                <h4 style="color: var(--color-primary-pink); margin-bottom: 8px;">Bagaimana cara memesan
                                    aset?</h4>
                                <p>Anda bisa menekan tombol "Order Now" pada halaman Shop untuk diarahkan ke WhatsApp
                                    kami.</p>
                            </div>
                            <div class="qna-card">
                                <h4 style="color: var(--color-primary-pink); margin-bottom: 8px;">Apakah aset bisa
                                    digunakan untuk komersial?</h4>
                                <p>Ya, semua aset yang dibeli melalui Shop kami sudah termasuk lisensi komersial
                                    standar.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>

</html>