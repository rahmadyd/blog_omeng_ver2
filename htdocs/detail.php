<?php
session_start();
include 'backend/config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = "SELECT * FROM projects WHERE id = $id";
$result = mysqli_query($conn, $query);
$item = mysqli_fetch_assoc($result);

if (!$item) {
    header('Location: index.php');
    exit;
}

// SEO Tags override for Detail Page
$page_title = $item['judul'] . " | Omeng Creations";
$page_desc = substr(strip_tags($item['deskripsi']), 0, 160);
$page_img = (file_exists("backend/assets/uploads/".$item['gambar'])) ? "backend/assets/uploads/".$item['gambar'] : "frontend/images/".$item['gambar'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    
    <link rel="icon" href="frontend/images/logo-omeng.png" type="image/png">
    <link rel="stylesheet" href="frontend/css/main.css?v=1.5">
    <script src="frontend/js/main.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Open Graph for Detail Page -->
    <meta property="og:title" content="<?= $page_title ?>">
    <meta property="og:description" content="<?= $page_desc ?>">
    <meta property="og:image" content="<?= $page_img ?>">
    
    <style>
        .detail-hero { padding-top: 120px; padding-bottom: 60px; background: #fff; }
        .detail-container { max-width: 1000px; margin: 0 auto; display: grid; grid-template-columns: 1fr 1fr; gap: 50px; align-items: start; }
        .detail-image img { width: 100%; border-radius: 24px; box-shadow: 0 20px 50px rgba(0,0,0,0.1); }
        .detail-content h1 { font-family: 'Bebas Neue', sans-serif; font-size: 4rem; color: var(--color-accent); line-height: 1; margin-bottom: 15px; }
        .detail-meta { display: flex; gap: 10px; margin-bottom: 25px; }
        .detail-description { font-size: 1.1rem; line-height: 1.8; color: #444; margin-bottom: 30px; }
        .back-link { display: inline-flex; align-items: center; gap: 8px; color: var(--color-primary-pink); text-decoration: none; font-weight: 600; margin-bottom: 20px; }
        @media (max-width: 768px) {
            .detail-container { grid-template-columns: 1fr; gap: 30px; padding: 0 20px; }
            .detail-content h1 { font-size: 3rem; }
        }
    </style>
</head>
<body>
    <?php include 'frontend/includes/navbar.php'; ?>

    <main>
        <section class="detail-hero">
            <div class="container">
                <a href="javascript:history.back()" class="back-link">
                    <span class="material-icons">arrow_back</span> Kembali
                </a>
                <div class="detail-container">
                    <div class="detail-image">
                        <img src="<?= $page_img ?>" alt="<?= $item['judul'] ?>">
                    </div>
                    <div class="detail-content">
                        <div class="detail-meta">
                            <?php 
                                $badges = explode(',', $item['kategori']);
                                foreach($badges as $badge):
                            ?>
                                <span class="badge" style="background: #000; color: #fff;"><?= trim($badge) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <h1><?= $item['judul'] ?></h1>
                        <p class="detail-description"><?= nl2br(htmlspecialchars($item['deskripsi'])) ?></p>
                        <div class="card-footer" style="padding: 0; border: none;">
                            <span class="date"><?= $item['tanggal'] ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'frontend/includes/footer.php'; ?>
</body>
</html>
