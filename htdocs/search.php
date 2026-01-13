<?php session_start(); ?>
<?php
include 'backend/config/database.php';

$q = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';

// Fetch Results
$query = "SELECT * FROM projects WHERE judul LIKE '%$q%' OR deskripsi LIKE '%$q%' OR kategori LIKE '%$q%' ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="frontend/images/logo-omeng.png" type="image/png">
    <title>Search Results | Omeng Creations</title>
    <link rel="stylesheet" href="frontend/css/main.css?v=1.5">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="frontend/js/main.js?v=1.1" defer></script>
</head>
<body>
<?php include 'frontend/includes/navbar.php'; ?>

<main>
    <section class="project-section">
        <div class="project-container">
            <div class="project-header">
                <div class="title-area">
                    <h2>Hasil Pencarian: "<?php echo htmlspecialchars($q); ?>"</h2>
                </div>
            </div>

            <div class="project-card-container" style="flex-wrap: wrap; overflow: visible;">
                <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while($row = mysqli_fetch_assoc($result)): 
                        $img_path = (file_exists("backend/assets/uploads/".$row['gambar'])) ? "backend/assets/uploads/".$row['gambar'] : "frontend/images/".$row['gambar'];
                        $is_shop = in_array($row['kategori'], ['Merchandise', 'Digital Art', 'UI Component', 'Service']);
                        
                        if ($is_shop) {
                            $clean_wa = preg_replace('/[^0-9]/', '', $row['link']);
                            if (strpos($clean_wa, '0') === 0) { $clean_wa = '62' . substr($clean_wa, 1); }
                            $message = urlencode("Halo Omeng Creations! Saya tertarik untuk memesan produk \"" . $row['judul'] . "\". Apakah masih tersedia?");
                            $link = "https://wa.me/" . $clean_wa . "?text=" . $message;
                        } else {
                            $link = "detail.php?id=" . $row['id'];
                        }
                        
                        $card_class = $is_shop ? 'shop-card' : 'project-card preview-trigger';
                    ?>
                    <a href="<?php echo $link; ?>" class="<?php echo $card_class; ?>" style="margin-bottom: 30px;">
                        <div class="card-image"><img src="<?php echo $img_path; ?>" alt="<?php echo $row['judul']; ?>" loading="lazy"></div>
                        <div class="card-badges">
                            <span class="badge"><?php echo $row['kategori']; ?></span>
                        </div>
                        <div class="card-content">
                            <h3><?php echo $row['judul']; ?></h3>
                            <p><?php echo $row['deskripsi']; ?></p>
                            <div class="card-footer">
                                <span class="date"><?php echo $is_shop ? 'Rp '.number_format((float)$row['tanggal'], 0, ',', '.') : $row['tanggal']; ?></span>
                                <span class="view-link"><?php echo $is_shop ? 'Order Now' : 'View Project'; ?></span>
                            </div>
                        </div>
                    </a>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="empty-state">
                        <span class="material-icons">search_off</span>
                        <p>Tidak ditemukan hasil untuk "<?php echo htmlspecialchars($q); ?>"</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
</main>

<?php include 'frontend/includes/footer.php'; ?>
</body>
</html>
