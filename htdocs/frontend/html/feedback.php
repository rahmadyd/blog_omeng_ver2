<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../images/logo-omeng.png" type="image/png">
    <title>Feedback | Omeng Creations</title>
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
                        <h2>Feedback</h2>
                    </div>
                    <div class="about-content">
                        <?php if (isset($_GET['success'])): ?>
                            <p style="color: #27ae60; font-weight: 600; margin-bottom: 20px;">Saran Anda telah kami terima. Terima kasih!</p>
                        <?php elseif (isset($_GET['error'])): ?>
                            <p style="color: #ff4757; font-weight: 600; margin-bottom: 20px;">Gagal mengirim saran. Silakan coba lagi.</p>
                        <?php endif; ?>

                        <p style="color: #2d2d2d; margin-bottom: 20px;">Kirimkan kritik dan saran Anda untuk
                            perkembangan Omeng Creations.</p>
                        
                        <form action="../../backend/proses_feedback.php" method="POST" style="display: flex; flex-direction: column; gap: 15px; max-width: 500px;">
                            <input type="text" name="nama" placeholder="Nama" required
                                style="padding: 12px; border-radius: 8px; border: 1px solid #ddd;">
                            <textarea name="pesan" placeholder="Pesan Anda" required
                                style="padding: 12px; border-radius: 8px; border: 1px solid #ddd; height: 150px;"></textarea>
                            <button type="submit"
                                style="padding: 12px; background: var(--color-primary-pink); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">Kirim
                                Feedback</button>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include '../includes/footer.php'; ?>
</body>

</html>