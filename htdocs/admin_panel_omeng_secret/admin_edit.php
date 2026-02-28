<?php
require_once '../backend/middleware/auth.php';
requireAdmin();
include '../backend/config/database.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$type = isset($_GET['type']) ? $_GET['type'] : 'project';

// Fetch item data
$query = "SELECT * FROM projects WHERE id = $id";
$result = mysqli_query($conn, $query);
$item = mysqli_fetch_assoc($result);

if (!$item) {
    die("Item tidak ditemukan.");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Item | Omeng Creations</title>
    <link rel="stylesheet" href="../frontend/css/main.css?v=1.3">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <style>
        .edit-container { max-width: 800px; margin: 40px auto; padding: 40px; background: #fff; border-radius: 24px; box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
        .edit-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 2px solid var(--color-primary-pink); padding-bottom: 15px; }
        .current-image { width: 200px; border-radius: 12px; margin-top: 10px; display: block; border: 1px solid #ddd; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
    </style>
</head>
<body>
    <?php include '../frontend/includes/navbar.php'; ?>
    <main>
        <section class="admin-section">
            <div class="edit-container">
                <div class="edit-header">
                    <h2>Edit <?= ($type == 'shop') ? 'Shop Item' : 'Project' ?></h2>
                    <a href="index.php?tab=<?= ($type == 'shop') ? 'shop-section' : 'project-section' ?>" class="btn">Kembali</a>
                </div>

                <form action="../backend/admin/update_item.php" method="POST" enctype="multipart/form-data" class="admin-form">
                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                    <input type="hidden" name="type" value="<?= $type ?>">

                    <div class="form-group">
                        <label>Judul / Nama Barang</label>
                        <input type="text" name="judul" value="<?= htmlspecialchars($item['judul']) ?>" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label>Kategori</label>
                            <select name="kategori">
                                <?php if ($type == 'project'): ?>
                                    <option value="Design" <?= $item['kategori'] == 'Design' ? 'selected' : '' ?>>Design</option>
                                    <option value="Ilustrator" <?= $item['kategori'] == 'Ilustrator' ? 'selected' : '' ?>>Ilustrator</option>
                                <?php else: ?>
                                    <option value="Merchandise" <?= $item['kategori'] == 'Merchandise' ? 'selected' : '' ?>>Merchandise</option>
                                    <option value="Digital Art" <?= $item['kategori'] == 'Digital Art' ? 'selected' : '' ?>>Digital Art</option>
                                    <option value="UI Component" <?= $item['kategori'] == 'UI Component' ? 'selected' : '' ?>>UI Component</option>
                                    <option value="Service" <?= $item['kategori'] == 'Service' ? 'selected' : '' ?>>Service</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label><?= ($type == 'shop') ? 'Harga Label' : 'Tanggal' ?></label>
                            <input type="text" name="tanggal" value="<?= htmlspecialchars($item['tanggal']) ?>">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" rows="4"><?= htmlspecialchars($item['deskripsi']) ?></textarea>
                    </div>

                    <?php if ($type == 'shop'): ?>
                        <div class="form-group">
                            <label>WhatsApp Number (e.g. 0812...)</label>
                            <input type="text" name="link" value="<?= htmlspecialchars($item['link']) ?>">
                        </div>
                    <?php endif; ?>

                    <div class="form-group">
                        <label>Ganti Gambar (Biarkan kosong jika tidak ingin ganti)</label>
                        <input type="file" name="gambar">
                        <?php 
                            $img_path = (file_exists("../backend/assets/uploads/".$item['gambar'])) ? "../backend/assets/uploads/".$item['gambar'] : "../frontend/images/".$item['gambar'];
                        ?>
                        <img src="<?= $img_path ?>" class="current-image" alt="Pratinjau">
                    </div>

                    <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 1.1rem; margin-top: 20px;">Simpan Perubahan</button>
                </form>
            </div>
        </section>
    </main>
    <footer><div class="container"><p>&copy; 2025 Rahmad. All rights reserved.</p></div></footer>
</body>
</html>
