<?php
ini_set('display_errors', 0);
error_reporting(0);

session_start();
require_once __DIR__ . '/backend/config/database.php';

// Fetch Projects
$query_projects = "SELECT * FROM projects WHERE kategori NOT IN ('Merchandise', 'Digital Art', 'UI Component', 'Service') ORDER BY id DESC LIMIT 4";
$result_projects = mysqli_query($conn, $query_projects);

// Fetch Shop Items
$query_shop = "SELECT * FROM projects WHERE kategori IN ('Merchandise', 'Digital Art', 'UI Component', 'Service') ORDER BY id DESC LIMIT 4";
$result_shop = mysqli_query($conn, $query_shop);
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Omeng's Site</title>

  <link rel="icon" href="frontend/images/logo-omeng.png" type="image/png">
  <script src="frontend/js/main.js?v=1.2" defer></script>
  <link rel="stylesheet" href="frontend/css/main.css?v=1.7">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <?php include_once __DIR__ . '/frontend/includes/header_meta.php'; ?>
</head>


<body>
  <?php include_once __DIR__ . '/frontend/includes/navbar.php'; ?>

  <main>

    <!-- HERO -->
    <section class="hero-section">
      <div class="hero-content">
        <h1>WELCOME to <br>OMENG Creations</h1>
        <p>
          Ruang digital untuk merayakan seni kontras.
          Ikuti perjalanan kami dalam mengeksplorasi karya visual.
        </p>
        <a href="#project" class="btn btn-primary hero-cta">Let see the Journey!</a>
      </div>

      <div class="hero-visual">
        <img src="frontend/images/logo-circle.png" class="rotating-text">
        <img src="frontend/images/logo-omeng.png" class="cat-logo">
      </div>
    </section>

    <!-- MARQUEE -->
    <div class="marquee-container" id="project">
      <div class="marquee-content marquee-right">
        <!-- Part 1 -->
        <span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span>
        <span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span>
        <span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span>
        <!-- Part 2 (Duplicate for seamless loop) -->
        <span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span>
        <span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span>
        <span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span>
      </div>
    </div>

    <!-- PROJECT -->
    <section class="project-section">
      <div class="project-container">

        <div class="project-header">
          <div class="title-area">
            <h2>Let see My Project</h2>
          </div>

          <a href="myproject.php" class="more-btn">
            <span>Explore More</span>
            <svg class="arrow-icon" width="20" height="20" viewBox="0 0 24 24">
              <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" />
            </svg>
          </a>
        </div>

        <div class="project-card-container">
            <?php 
            if ($result_projects && mysqli_num_rows($result_projects) > 0):
                while($row = mysqli_fetch_assoc($result_projects)):
                    $uploadPath = __DIR__ . "/backend/assets/uploads/" . $row['gambar'];
                    $img_path = (file_exists($uploadPath)) ? "backend/assets/uploads/".$row['gambar'] : "frontend/images/".$row['gambar'];
            ?>
            <a href="detail.php?id=<?php echo $row['id']; ?>" class="project-card">
              <div class="card-image"><img src="<?php echo $img_path; ?>" alt="<?php echo $row['judul']; ?>" loading="lazy"></div>
              <div class="card-badges">
                <?php
                  $badges = explode(',', $row['kategori']);
                  foreach($badges as $badge):
                ?>
                  <span class="badge"><?php echo trim($badge); ?></span>
                <?php endforeach; ?>
              </div>
              <div class="card-content">
                <h3><?php echo $row['judul']; ?></h3>
                <p><?php echo $row['deskripsi']; ?></p>
                <div class="card-footer">
                  <span class="date"><?php echo $row['tanggal']; ?></span>
                  <span class="view-link">View Project</span>
                </div>
              </div>
            </a>
            <?php endwhile; 
            else: ?>
                <p style="text-align:center; width:100%; color: white;">Belum ada project yang ditampilkan.</p>
            <?php endif; ?>
        </div>

      </div>
    </section>

    <div class="marquee-container">
      <div class="marquee-content marquee-left">
        <!-- Part 1 -->
        <span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span>
        <span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span>
        <span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span>
        <!-- Part 2 (Duplicate for seamless loop) -->
        <span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span>
        <span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span>
        <span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span><span>OMENG</span>
      </div>
    </div>

    <!-- SHOP-->
    <section class="shop-section">
      <div class="shop-container">

        <div class="shop-header">
          <div class="title-area">
            <h2>Let see My Shop</h2>
          </div>

          <a href="shop.php" class="more-btn">
            <span>Explore More</span>
            <svg class="arrow-icon" width="20" height="20" viewBox="0 0 24 24">
              <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" />
            </svg>
          </a>
        </div>

        <div class="shop-card-container">
            <?php 
            if ($result_shop && mysqli_num_rows($result_shop) > 0):
                while($row = mysqli_fetch_assoc($result_shop)): 
                    $uploadPath = __DIR__ . "/backend/assets/uploads/" . $row['gambar'];
                    $img_path = (file_exists($uploadPath)) ? "backend/assets/uploads/".$row['gambar'] : "frontend/images/".$row['gambar'];
                
                $clean_wa = preg_replace('/[^0-9]/', '', $row['link']);
                if (strpos($clean_wa, '0') === 0) { $clean_wa = '62' . substr($clean_wa, 1); }
                $message = urlencode("Halo Omeng Creations! Saya tertarik untuk memesan produk \"" . $row['judul'] . "\". Apakah masih tersedia?");
                $wa_link = "https://wa.me/" . $clean_wa . "?text=" . $message;
            ?>
            <a href="detail.php?id=<?php echo $row['id']; ?>" class="shop-card">
              <div class="card-image"><img src="<?php echo $img_path; ?>" alt="<?php echo $row['judul']; ?>" loading="lazy"></div>
              <div class="card-badges"><span class="badge"><?php echo $row['kategori']; ?></span></div>
              <div class="card-content">
                <h3><?php echo $row['judul']; ?></h3>
                <p><?php echo $row['deskripsi']; ?></p>
                <div class="card-footer">
                  <span class="date">Rp <?php echo number_format((float)$row['tanggal'], 0, ',', '.'); ?></span>
                  <span class="view-link">View Product</span>
                </div>
              </div>
            </a>
            <?php endwhile; 
            else: ?>
                <p style="text-align:center; width:100%; color: white;">Belum ada item shop yang ditampilkan.</p>
            <?php endif; ?>
        </div>
      </div>
    </section>


  </main>

  <?php include_once __DIR__ . '/frontend/includes/footer.php'; ?>

</body>

</html>