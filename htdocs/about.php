<?php session_start(); ?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="frontend/images/logo-omeng.png" type="image/png">
  <title>About Us | Omeng Creations</title>
  <link rel="stylesheet" href="frontend/css/main.css?v=1.6">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600;700&display=swap"
    rel="stylesheet">
  <script src="frontend/js/main.js" defer></script>
  <?php include 'frontend/includes/header_meta.php'; ?>
</head>

<body>
  <?php include 'frontend/includes/navbar.php'; ?>

  <main>
    <section class="project-section">
      <div class="project-container">
        <div class="project-header-about">
          <div class="title-area-about">
            <h2>About Us</h2>
          </div>

          <div class="about-content">
            <p class="description" style="color: #2d2d2d; line-height: 1.6; margin-bottom: 30px;">
              Rumah bagi asset visual berkualitas tinggi. Kami fokus menciptakan ilustrasi dan desain grafis yang unik
              untuk
              membantu kreator serta bisnis mempercantik proyek digital mereka melalui koleksi asset eksklusif.
            </p>

            <div class="mission-vision">
              <div class="item" style="background: rgba(0,0,0,0.05); padding: 25px; border-radius: 20px; color: #333;">
                <h3
                  style="font-family: 'Bebas Neue', cursive; font-size: 1.8rem; color: var(--color-primary-pink); margin-bottom: 10px;">
                  Creative Project</h3>
                <p>Menampilkan kurasi karya terbaik mulai dari branding hingga digital painting.</p>
              </div>

              <div class="item" style="background: rgba(0,0,0,0.05); padding: 25px; border-radius: 20px; color: #333;">
                <h3
                  style="font-family: 'Bebas Neue', cursive; font-size: 1.8rem; color: var(--color-primary-pink); margin-bottom: 10px;">
                  Digital Assets</h3>
                <p>Asset gambar siap pakai dengan lisensi komersial untuk kebutuhan desainmu.</p>
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