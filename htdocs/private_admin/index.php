<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
include '../backend/config/database.php';

// Ambil data untuk Manage Projects (Asumsi kategory selain 'Merchandise', 'Digital Art', 'UI Component', 'Service')
$query_projects = "SELECT * FROM projects WHERE kategori NOT IN ('Merchandise', 'Digital Art', 'UI Component', 'Service') ORDER BY id DESC";
$result_projects = mysqli_query($conn, $query_projects);

// Ambil data untuk Manage Shop
$query_shop = "SELECT * FROM projects WHERE kategori IN ('Merchandise', 'Digital Art', 'UI Component', 'Service') ORDER BY id DESC";
$result_shop = mysqli_query($conn, $query_shop);

// Ambil data Feedback
try {
    $result_feedback = mysqli_query($conn, "SELECT * FROM feedback ORDER BY created_at DESC");
} catch (Exception $e) {
    $result_feedback = false;
}

// --- STATISTIK ---
// Total Pengunjung
$total_visitors = 0;
try {
    $res_visitor = mysqli_query($conn, "SELECT total_views FROM visitor_counter WHERE id = 1");
    if ($res_visitor) {
        $visitor_data = mysqli_fetch_assoc($res_visitor);
        $total_visitors = $visitor_data['total_views'] ?? 0;
    }
} catch (Exception $e) {
    $total_visitors = 0;
}

// Total Projects
$res_count_proj = mysqli_query($conn, "SELECT COUNT(*) as total FROM projects WHERE kategori NOT IN ('Merchandise', 'Digital Art', 'UI Component', 'Service')");
$total_projects = mysqli_fetch_assoc($res_count_proj)['total'] ?? 0;

// Total Shop
$res_count_shop = mysqli_query($conn, "SELECT COUNT(*) as total FROM projects WHERE kategori IN ('Merchandise', 'Digital Art', 'UI Component', 'Service')");
$total_shop = mysqli_fetch_assoc($res_count_shop)['total'] ?? 0;

// Fetch current site settings for Site Settings tab
$wa_query = "SELECT setting_value FROM site_settings WHERE setting_key = 'wa_number' LIMIT 1";
$wa_result = mysqli_query($conn, $wa_query);
$wa_data = mysqli_fetch_assoc($wa_result);
$current_wa = $wa_data['setting_value'] ?? '6285777145179';

$title_query = "SELECT setting_value FROM site_settings WHERE setting_key = 'site_title' LIMIT 1";
$title_result = mysqli_query($conn, $title_query);
$title_data = mysqli_fetch_assoc($title_result);
$current_title = $title_data['setting_value'] ?? 'Omeng Creations';

$desc_query = "SELECT setting_value FROM site_settings WHERE setting_key = 'site_description' LIMIT 1";
$desc_result = mysqli_query($conn, $desc_query);
$desc_data = mysqli_fetch_assoc($desc_result);
$current_desc = $desc_data['setting_value'] ?? 'Ruang digital untuk merayakan seni kontras.';

// Fetch recent logs for admin (shows latest 200) if table exists
$res_logs = false;
try {
    $check_logs = mysqli_query($conn, "SHOW TABLES LIKE 'logs'");
    if ($check_logs && mysqli_num_rows($check_logs) > 0) {
        $res_logs = mysqli_query($conn, "SELECT * FROM logs ORDER BY created_at DESC LIMIT 200");
    }
} catch (Exception $e) {
    $res_logs = false;
}

// --- TAB PERSISTENCE ---
$active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'project-section';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Omeng Creations</title>
    <link rel="icon" href="../frontend/images/logo-omeng.png" type="image/png">
    <script src="../frontend/js/main.js" defer></script>
    <link rel="stylesheet" href="../frontend/css/main.css?v=1.7">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .manage-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
        }
        .manage-table th, .manage-table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            color: #333;
        }
        .manage-table th {
            background: rgba(0,0,0,0.05);
            font-weight: 600;
            color: #333;
        }
        .btn-delete {
            background: #ff4757;
            color: #fff;
            padding: 8px 12px;
            border-radius: 6px;
            font-size: 0.8rem;
            text-decoration: none;
            transition: background 0.3s;
        }
        .btn-delete:hover {
            background: #ff6b81;
        }
        .logout-link {
            float: right;
            color: var(--color-accent);
            text-decoration: none;
            font-weight: bold;
            margin-top: 10px;
        }
        /* Stats Cards */
        .admin-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: #fff;
            padding: 20px;
            border-radius: 16px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .stat-card .icon {
            background: var(--color-primary-pink);
            color: var(--color-accent);
            padding: 12px;
            border-radius: 12px;
        }
        .stat-card .info h4 { margin: 0; font-size: 0.8rem; color: #666; text-transform: uppercase; }
        .stat-card .info p { margin: 0; font-size: 1.5rem; font-weight: 700; color: #000; }
        
        /* Enhanced Button Styles */
        .btn-submit {
            background: var(--color-accent);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: 8px;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 105, 180, 0.3);
        }
        .btn-submit:hover {
            background: var(--color-primary-pink);
            color: #000;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 105, 180, 0.4);
        }
        .btn-submit:active {
            transform: translateY(0);
        }
    </style>
</head>
<body>
    <?php include '../frontend/includes/navbar.php'; ?>
<main>
    <section class="admin-section">
        <div class="admin-container">
            <div class="admin-header">
                <h2>Omeng Admin Dashboard</h2>
                <p>Kelola konten website kamu di bawah ini.</p>
                
                <?php if (isset($_GET['success'])): ?>
                    <div style="background: #27ae60; color: white; padding: 15px; border-radius: 12px; margin-top: 20px; font-weight: 600;">
                        <?php 
                            if($_GET['success'] == 'project_added') echo "Proyek berhasil ditambahkan!";
                            if($_GET['success'] == 'shop_added') echo "Item toko berhasil ditambahkan!";
                            if($_GET['success'] == 'deleted') echo "Item berhasil dihapus!";
                            if($_GET['success'] == 'updated') echo "Data berhasil diperbarui!";
                        ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Stats Bar -->
            <div class="admin-stats-grid">
                <div class="stat-card">
                    <div class="icon"><span class="material-icons">visibility</span></div>
                    <div class="info"><h4>Total Visitors</h4><p><?= number_format($total_visitors) ?></p></div>
                </div>
                <div class="stat-card">
                    <div class="icon"><span class="material-icons">folder</span></div>
                    <div class="info"><h4>Total Projects</h4><p><?= $total_projects ?></p></div>
                </div>
                <div class="stat-card">
                    <div class="icon"><span class="material-icons">shopping_bag</span></div>
                    <div class="info"><h4>Total Shop</h4><p><?= $total_shop ?></p></div>
                </div>
            </div>

            <!-- Tab Navigation -->
            <div class="admin-tabs">
                <button class="tab-btn <?= ($active_tab == 'project-section') ? 'active' : '' ?>" onclick="switchTab('project-section', event)">Projects</button>
                <button class="tab-btn <?= ($active_tab == 'shop-section') ? 'active' : '' ?>" onclick="switchTab('shop-section', event)">Shop</button>
                <button class="tab-btn <?= ($active_tab == 'feedback-section') ? 'active' : '' ?>" onclick="switchTab('feedback-section', event)">Feedback</button>
                <button class="tab-btn <?= ($active_tab == 'site-settings-section') ? 'active' : '' ?>" onclick="switchTab('site-settings-section', event)">Site Settings</button>
                <button class="tab-btn <?= ($active_tab == 'logs-section') ? 'active' : '' ?>" onclick="switchTab('logs-section', event)">Logs</button>
            </div>

            <!-- Project Section -->
            <div id="project-section" class="form-content <?= ($active_tab == 'project-section') ? 'active' : '' ?>">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                    <div>
                        <h3>Add New Project</h3>
                        <form action="../backend/admin/proses_tambah.php" method="POST" enctype="multipart/form-data" class="admin-form">
                            <div class="form-group"><label>Judul</label><input type="text" name="judul" required></div>
                            <div class="form-group"><label>Kategori</label>
                                <select name="kategori">
                                    <option value="Design">Design</option>
                                    <option value="Ilustrator">Ilustrator</option>
                                </select>
                            </div>
                            <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi" rows="3"></textarea></div>
                            <div class="form-group"><label>Tanggal</label><input type="text" name="tanggal" placeholder="e.g. 12 Jan 2025"></div>
                            <div class="form-group"><label>Gambar</label><input type="file" name="gambar" required></div>
                            <button type="submit" class="btn btn-primary btn-upload">Upload Project</button>
                        </form>
                    </div>
                    <div>
                        <h3>Manage Projects</h3>
                        <table class="manage-table">
                            <thead><tr><th>Judul</th><th>Aksi</th></tr></thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result_projects)): ?>
                                <tr>
                                    <td><?= $row['judul'] ?></td>
                                    <td>
                                        <a href="admin_edit.php?id=<?= $row['id'] ?>&type=project" class="btn" style="background: var(--color-accent); color: #fff; padding: 8px 12px; border-radius: 6px; font-size: 0.8rem; text-decoration: none; margin-right: 5px;">Edit</a>
                                        <a href="../backend/admin/delete_item.php?id=<?= $row['id'] ?>&type=project" class="btn-delete" onclick="return confirm('Yakin ingin menghapus?')">Delete</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Shop Section -->
            <div id="shop-section" class="form-content <?= ($active_tab == 'shop-section') ? 'active' : '' ?>">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px;">
                    <div>
                        <h3>Add Shop Item</h3>
                        <form action="../backend/admin/proses_tambah_shop.php" method="POST" enctype="multipart/form-data" class="admin-form">
                            <div class="form-group"><label>Nama Barang</label><input type="text" name="nama" required></div>
                            <div class="form-group"><label>Kategori</label>
                                <select name="kategori">
                                    <option value="Merchandise">Merchandise</option>
                                    <option value="Digital Art">Digital Art</option>
                                    <option value="UI Component">UI Component</option>
                                    <option value="Service">Service</option>
                                </select>
                            </div>
                            <div class="form-group"><label>Harga Label</label><input type="text" name="harga"></div>
                            <div class="form-group"><label>WhatsApp</label><input type="text" name="wa_number"></div>
                            <div class="form-group"><label>Deskripsi</label><textarea name="deskripsi" rows="3"></textarea></div>
                            <div class="form-group"><label>Gambar</label><input type="file" name="gambar" required></div>
                            <button type="submit" class="btn btn-primary btn-upload">Upload to Shop</button>
                        </form>
                    </div>
                    <div>
                        <h3>Manage Shop</h3>
                        <table class="manage-table">
                            <thead><tr><th>Nama</th><th>Aksi</th></tr></thead>
                            <tbody>
                                <?php while($row = mysqli_fetch_assoc($result_shop)): ?>
                                <tr>
                                    <td><?= $row['judul'] ?></td>
                                    <td>
                                        <a href="admin_edit.php?id=<?= $row['id'] ?>&type=shop" class="btn" style="background: var(--color-accent); color: #fff; padding: 8px 12px; border-radius: 6px; font-size: 0.8rem; text-decoration: none; margin-right: 5px;">Edit</a>
                                        <a href="../backend/admin/delete_item.php?id=<?= $row['id'] ?>&type=shop" class="btn-delete" onclick="return confirm('Yakin ingin menghapus?')">Delete</a>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Feedback Section -->
            <div id="feedback-section" class="form-content <?= ($active_tab == 'feedback-section') ? 'active' : '' ?>">
                <h3>Visitor Feedback</h3>
                
                <!-- Filter Form -->
                <div style="background: white; padding: 20px; border-radius: 12px; margin-bottom: 20px; display: flex; gap: 15px; align-items: end;">
                    <div style="flex: 1;">
                        <label style="display: block; color: #333; font-weight: 600; margin-bottom: 8px;">Filter Bulan</label>
                        <select id="filterMonth" style="width: 100%; padding: 10px; border: 2px solid rgba(0,0,0,0.1); border-radius: 8px; font-family: 'Poppins', sans-serif;">
                            <option value="">Semua Bulan</option>
                            <option value="01">Januari</option>
                            <option value="02">Februari</option>
                            <option value="03">Maret</option>
                            <option value="04">April</option>
                            <option value="05">Mei</option>
                            <option value="06">Juni</option>
                            <option value="07">Juli</option>
                            <option value="08">Agustus</option>
                            <option value="09">September</option>
                            <option value="10">Oktober</option>
                            <option value="11">November</option>
                            <option value="12">Desember</option>
                        </select>
                    </div>
                    <div style="flex: 1;">
                        <label style="display: block; color: #333; font-weight: 600; margin-bottom: 8px;">Filter Tahun</label>
                        <select id="filterYear" style="width: 100%; padding: 10px; border: 2px solid rgba(0,0,0,0.1); border-radius: 8px; font-family: 'Poppins', sans-serif;">
                            <option value="">Semua Tahun</option>
                            <?php
                            $currentYear = date('Y');
                            for ($y = $currentYear; $y >= $currentYear - 5; $y--) {
                                echo "<option value='$y'>$y</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button onclick="applyFeedbackFilter()" class="btn-submit" style="margin: 0;">Terapkan</button>
                    <button onclick="resetFeedbackFilter()" style="padding: 10px 20px; background: #ddd; color: #333; border: none; border-radius: 8px; cursor: pointer; font-weight: 600;">Reset</button>
                </div>

                <table class="manage-table">
                    <thead><tr><th>Tanggal</th><th>Nama</th><th>Pesan</th></tr></thead>
                    <tbody id="feedbackTableBody">
                        <?php if ($result_feedback): ?>
                            <?php while($row = mysqli_fetch_assoc($result_feedback)): ?>
                            <tr data-date="<?= $row['created_at'] ?>">
                                <td style="font-size: 0.8rem; color: #666;"><?= date('d M Y', strtotime($row['created_at'])) ?></td>
                                <td><strong><?= htmlspecialchars($row['nama']) ?></strong></td>
                                <td><?= nl2br(htmlspecialchars($row['pesan'])) ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr id="noDataRow"><td colspan="3" style="text-align: center; padding: 20px;">Tabel feedback belum tersedia. Silakan cek database.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <!-- Site Settings Section -->
            <div id="site-settings-section" class="form-content <?= ($active_tab == 'site-settings-section') ? 'active' : '' ?>">
                <h3>Site Settings</h3>
                
                <?php if (isset($_GET['success'])): ?>
                    <div style="background: #27ae60; color: white; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
                        <?php 
                            if($_GET['success'] == 'password_changed') echo "✓ Password berhasil diubah!";
                            if($_GET['success'] == 'wa_updated') echo "✓ Nomor WhatsApp berhasil diperbarui!";
                            if($_GET['success'] == 'site_info_updated') echo "✓ Informasi website berhasil diperbarui!";
                        ?>
                    </div>
                <?php endif; ?>
                
                <?php if (isset($_GET['error'])): ?>
                    <div style="background: #e74c3c; color: white; padding: 15px; border-radius: 12px; margin-bottom: 20px; font-weight: 600;">
                        <?php 
                            if($_GET['error'] == 'password_mismatch') echo "✗ Password baru tidak cocok!";
                            if($_GET['error'] == 'wrong_password') echo "✗ Password lama salah!";
                        ?>
                    </div>
                <?php endif; ?>

                <div style="display: grid; grid-template-columns: 1fr; gap: 30px;">
                    <!-- Change Password -->
                    <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <h4 style="color: var(--color-primary-pink); margin-bottom: 20px;">Ganti Password Admin</h4>
                        <form method="POST" action="../backend/admin/update_settings.php" class="admin-form">
                            <input type="hidden" name="action" value="change_password">
                            <div class="form-group">
                                <label>Password Lama</label>
                                <input type="password" name="current_password" required>
                            </div>
                            <div class="form-group">
                                <label>Password Baru</label>
                                <input type="password" name="new_password" required minlength="8">
                            </div>
                            <div class="form-group">
                                <label>Konfirmasi Password Baru</label>
                                <input type="password" name="confirm_password" required minlength="8">
                            </div>
                            <button type="submit" class="btn-submit">Update Password</button>
                        </form>
                    </div>

                    <!-- WhatsApp Number -->
                    <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <h4 style="color: var(--color-primary-pink); margin-bottom: 20px;">Nomor WhatsApp</h4>
                        <form method="POST" action="../backend/admin/update_settings.php" class="admin-form">
                            <input type="hidden" name="action" value="update_wa">
                            <div class="form-group">
                                <label>Nomor WhatsApp (untuk tombol Order Now)</label>
                                <input type="text" name="wa_number" value="<?= htmlspecialchars($current_wa ?? '6285777145179') ?>" required placeholder="628xxxxxxxxxx">
                                <small style="color: #666; display: block; margin-top: 5px;">Format: 628xxxxxxxxxx (tanpa +)</small>
                            </div>
                            <button type="submit" class="btn-submit">Update Nomor WA</button>
                        </form>
                    </div>

                    <!-- Site Info -->
                    <div style="background: white; padding: 30px; border-radius: 16px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
                        <h4 style="color: var(--color-primary-pink); margin-bottom: 20px;">Informasi Website</h4>
                        <form method="POST" action="../backend/admin/update_settings.php" class="admin-form">
                            <input type="hidden" name="action" value="update_site_info">
                            <div class="form-group">
                                <label>Judul Website</label>
                                <input type="text" name="site_title" value="<?= htmlspecialchars($current_title ?? 'Omeng Creations') ?>" required>
                            </div>
                            <div class="form-group">
                                <label>Deskripsi Website</label>
                                <textarea name="site_description" required style="min-height: 80px;"><?= htmlspecialchars($current_desc ?? 'Ruang digital untuk merayakan seni kontras.') ?></textarea>
                            </div>
                            <button type="submit" class="btn-submit">Update Info Website</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Logs Section -->
            <div id="logs-section" class="form-content <?= ($active_tab == 'logs-section') ? 'active' : '' ?>">
                <h3>Admin Logs</h3>
                <table class="manage-table">
                    <thead><tr><th>Tanggal</th><th>Admin</th><th>Aksi</th><th>Target</th><th>Details</th><th>IP</th></tr></thead>
                    <tbody>
                        <?php if ($res_logs): ?>
                            <?php while($log = mysqli_fetch_assoc($res_logs)): ?>
                            <tr>
                                <td style="font-size:0.9rem;color:#666;"><?= date('d M Y H:i', strtotime($log['created_at'])) ?></td>
                                <td><?= htmlspecialchars($log['admin_username']) ?></td>
                                <td><?= htmlspecialchars($log['action_type']) ?></td>
                                <td><?= htmlspecialchars($log['target_table']) . ' ' . htmlspecialchars($log['target_id']) ?></td>
                                <td style="max-width:400px; white-space:pre-wrap;"><?= htmlspecialchars($log['details']) ?></td>
                                <td><?= htmlspecialchars($log['ip_address']) ?></td>
                            </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="6" style="text-align:center; padding:20px;">Belum ada log.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    <script>
        function switchTab(tabId, event) {
            document.querySelectorAll('.form-content').forEach(c => c.classList.remove('active'));
            document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
            event.currentTarget.classList.add('active');
        }

        function applyFeedbackFilter() {
            const month = document.getElementById('filterMonth').value;
            const year = document.getElementById('filterYear').value;
            const rows = document.querySelectorAll('#feedbackTableBody tr[data-date]');
            let visibleCount = 0;

            rows.forEach(row => {
                const dateStr = row.getAttribute('data-date');
                const date = new Date(dateStr);
                const rowMonth = String(date.getMonth() + 1).padStart(2, '0');
                const rowYear = String(date.getFullYear());

                let show = true;
                if (month && rowMonth !== month) show = false;
                if (year && rowYear !== year) show = false;

                row.style.display = show ? '' : 'none';
                if (show) visibleCount++;
            });

            // Show/hide no data message
            const noDataRow = document.getElementById('noDataRow');
            if (noDataRow) {
                noDataRow.style.display = visibleCount === 0 ? '' : 'none';
            }
        }

        function resetFeedbackFilter() {
            document.getElementById('filterMonth').value = '';
            document.getElementById('filterYear').value = '';
            const rows = document.querySelectorAll('#feedbackTableBody tr');
            rows.forEach(row => row.style.display = '');
        }
    </script>
</main>
<footer><div class="container"><p>&copy; 2025 Rahmad. All rights reserved.</p></div></footer>
</body>
</html>
