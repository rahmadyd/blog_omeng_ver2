<?php session_start(); ?>
<?php
include 'backend/config/database.php';

// Fetch Projects
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
  <link rel="stylesheet" href="frontend/css/main.css?v=1.6">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <script src="frontend/js/main.js?v=1.1" defer></script>
  <?php include 'frontend/includes/header_meta.php'; ?>
</head>

<body>
  <?php include 'frontend/includes/navbar.php'; ?>

  <main>
    <section class="project-section">
      <div class="project-container">
        <div class="project-header">
          <div class="title-area">
            <h2>Let see My Project</h2>
          </div>
        </div>

          <?php if (mysqli_num_rows($result_projects) > 0): ?>
            ...
          <?php else: ?>
            <div class="empty-state">
              <p>Belum ada proyek yang ditampilkan.</p>
            </div>
          <?php endif; ?>
      </div>
    </section>
  </main>

  <?php include 'frontend/includes/footer.php'; ?>
</body>

</html>