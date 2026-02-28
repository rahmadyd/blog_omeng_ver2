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

// Category check for Shop Items
$shop_categories = ['Merchandise', 'Digital Art', 'UI Component', 'Service'];
$is_shop_item = in_array($item['kategori'], $shop_categories);

if ($is_shop_item) {
    $clean_wa = preg_replace('/[^0-9]/', '', $item['link']);
    if (strpos($clean_wa, '0') === 0) { $clean_wa = '62' . substr($clean_wa, 1); }
    $message = urlencode("Halo Omeng Creations! Saya tertarik untuk memesan produk \"" . $item['judul'] . "\". Apakah masih tersedia?");
    $wa_link = "https://wa.me/" . $clean_wa . "?text=" . $message;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $page_title ?></title>
    
    <link rel="icon" href="frontend/images/logo-omeng.png" type="image/png">
    <link rel="stylesheet" href="frontend/css/main.css?v=1.8">
    <script src="frontend/js/main.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <!-- Open Graph for Detail Page -->
    <meta property="og:title" content="<?= $page_title ?>">
    <meta property="og:description" content="<?= $page_desc ?>">
    <meta property="og:image" content="<?= $page_img ?>">
    
    <style>
        body { background-color: var(--color-primary-black); color: #fff; }
        .detail-hero { padding-top: 140px; padding-bottom: 80px; background: var(--color-primary-black); }
        .detail-container { 
            max-width: 1200px; 
            margin: 0 auto; 
            display: grid; 
            grid-template-columns: 1.2fr 1fr; 
            gap: 60px; 
            align-items: start;
            background: rgba(255, 255, 255, 0.03);
            padding: 40px;
            border-radius: 40px;
            border: 1px solid rgba(255, 192, 203, 0.1);
        }
        .detail-image {
            position: relative;
            cursor: pointer;
            overflow: hidden;
            border-radius: 24px;
        }
        .detail-image img { 
            width: 100%; 
            display: block;
            transition: transform 0.5s ease;
        }
        .detail-image:hover img {
            transform: scale(1.05);
        }
        .detail-image::after {
            content: 'VIEW PREVIEW';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: rgba(255, 105, 180, 0.8);
            color: white;
            padding: 10px 20px;
            border-radius: 50px;
            font-weight: 600;
            opacity: 0;
            transition: opacity 0.3s;
            pointer-events: none;
        }
        .detail-image:hover::after {
            opacity: 1;
        }
        .detail-content h1 { 
            font-family: 'Bebas Neue', sans-serif; 
            font-size: 5rem; 
            color: var(--color-accent); 
            line-height: 0.9; 
            margin-bottom: 25px; 
        }
        .detail-meta { display: flex; flex-wrap: wrap; gap: 10px; margin-bottom: 30px; }
        .detail-description { 
            font-size: 1.1rem; 
            line-height: 1.8; 
            color: rgba(255, 255, 255, 0.8); 
            margin-bottom: 40px; 
            white-space: pre-wrap;
        }
        .back-link { 
            display: inline-flex; 
            align-items: center; 
            gap: 8px; 
            color: var(--color-primary-pink); 
            text-decoration: none; 
            font-weight: 600; 
            margin-bottom: 30px; 
            transition: color 0.3s;
        }
        .back-link:hover { color: white; }
        
        .order-btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            background: var(--color-accent);
            color: white;
            padding: 18px 35px;
            border-radius: 16px;
            font-weight: 700;
            font-size: 1.1rem;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            box-shadow: 0 10px 20px rgba(255, 105, 180, 0.3);
        }
        .order-btn:hover {
            transform: translateY(-5px);
            background: white;
            color: var(--color-primary-black);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.5);
        }

        .price-tag {
            font-size: 2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 20px;
            display: block;
        }

        @media (max-width: 968px) {
            .detail-container { grid-template-columns: 1fr; gap: 40px; padding: 25px; }
            .detail-content h1 { font-size: 3.5rem; }
        }
    </style>
</head>
<body>
    <?php include 'frontend/includes/navbar.php'; ?>

    <main>
        <section class="detail-hero">
            <div class="container">
                <a href="javascript:history.back()" class="back-link">
                    <span class="material-icons">arrow_back</span> Kembali Ke Galeri
                </a>
                <div class="detail-container">
                    <div class="detail-image preview-trigger">
                        <img src="<?= $page_img ?>" alt="<?= $item['judul'] ?>">
                        <h3 style="display:none;"><?= $item['judul'] ?></h3>
                    </div>
                    <div class="detail-content">
                        <div class="detail-meta">
                            <?php 
                                $badges = explode(',', $item['kategori']);
                                foreach($badges as $badge):
                            ?>
                                <span class="badge" style="background: var(--color-primary-pink); color: #000;"><?= trim($badge) ?></span>
                            <?php endforeach; ?>
                        </div>
                        <h1><?= $item['judul'] ?></h1>

                        <?php if ($is_shop_item && !empty($item['tanggal'])): ?>
                            <span class="price-tag">Rp <?= number_format((float)$item['tanggal'], 0, ',', '.') ?></span>
                        <?php endif; ?>

                        <p class="detail-description"><?= htmlspecialchars($item['deskripsi']) ?></p>
                        
                        <div style="display: flex; flex-direction: column; gap: 20px; align-items: flex-start;">
                            <?php if ($is_shop_item): ?>
                                <a href="<?= $wa_link ?>" target="_blank" class="order-btn">
                                    <span class="material-icons">shopping_cart</span> Order Now via WhatsApp
                                </a>
                            <?php endif; ?>
                            
                            <div class="card-footer" style="padding: 0; border: none; opacity: 0.6;">
                                <span class="date">Dipublikasikan pada: <?= $item['tanggal'] ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <?php include 'frontend/includes/footer.php'; ?>
</body>
</html>
