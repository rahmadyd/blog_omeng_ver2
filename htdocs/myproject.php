<?php session_start(); ?>
<?php
include 'backend/config/database.php';

// Fetch Projects (Everything except Shop items)
$query_projects = "SELECT * FROM projects WHERE kategori NOT IN ('Merchandise', 'Digital Art', 'UI Component', 'Service') ORDER BY id DESC";
$result_projects = mysqli_query($conn, $query_projects);
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="frontend/images/logo-omeng.png" type="image/png">
  <title>My Project | Omeng Creations</title>
  <link rel="stylesheet" href="frontend/css/main.css?v=1.8">
  <script src="frontend/js/main.js?v=1.2" defer></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <?php include 'frontend/includes/header_meta.php'; ?>
</head>

<body>
  <?php include 'frontend/includes/navbar.php'; ?>

  <main>
    <section class="project-section" style="padding-top: 120px;">
      <div class="project-container">
        <div class="project-header">
          <div class="title-area">
            <h2 style="font-family: 'Bebas Neue', cursive; font-size: 3rem; color: white;">My Project Gallery</h2>
            <p style="color: rgba(255,255,255,0.7);">Koleksi karya dan proyek kreatif kami.</p>
          </div>
        </div>

        <div class="project-card-container">
          <?php if ($result_projects && mysqli_num_rows($result_projects) > 0): ?>
            <?php while($row = mysqli_fetch_assoc($result_projects)): 
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
                  <span class="view-link">View Details</span>
                </div>
              </div>
            </a>
            <?php endwhile; ?>
          <?php else: ?>
            <div class="empty-state">
              <p>Belum ada proyek yang ditampilkan.</p>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </section>
  </main>

  <?php include 'frontend/includes/footer.php'; ?>
</body>

</html>