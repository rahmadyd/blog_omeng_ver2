<?php
require_once '../middleware/auth.php';
requireAdmin();
include '../config/database.php';
include 'logger.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $wa = mysqli_real_escape_string($conn, $_POST['wa_number']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);

    // Urusan Gambar (Security Hardening)
    $foto = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $file_size = $_FILES['gambar']['size'];
    $file_ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];

    // 1. Validasi Ekstensi
    if (!in_array($file_ext, $allowed_ext)) {
        die("Error: Ekstensi file tidak diizinkan!");
    }

    // 2. Validasi MIME Type
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $tmp);
    finfo_close($finfo);
    if (strpos($mime, 'image/') !== 0) {
        die("Error: File bukan merupakan gambar valid!");
    }

    // 3. Batasi Ukuran (5MB)
    if ($file_size > 5 * 1024 * 1024) {
        die("Error: Ukuran file terlalu besar!");
    }

    // 4. Rename File
    $new_filename = "shop_" . time() . "_" . uniqid() . "." . $file_ext;
    $target_path = "../assets/uploads/" . $new_filename;
    
    // Pindahkan foto ke folder uploads
    if (move_uploaded_file($tmp, $target_path)) {
        // Simpan ke database
        $query = "INSERT INTO projects (judul, deskripsi, kategori, gambar, tanggal, link) 
                  VALUES ('$nama', '$deskripsi', '$kategori', '$new_filename', '$harga', '$wa')";

        if (mysqli_query($conn, $query)) {
            $new_id = mysqli_insert_id($conn);
            $admin = getAdminUsername();
            log_action($conn, $admin, 'create', 'projects', $new_id, "nama: $nama, kategori: $kategori");
            header('Location: ../../admin_panel_omeng_secret/index.php?success=shop_added&tab=shop-section');
        } else {
            echo "Gagal Simpan Database: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal Upload Gambar";
    }
}
?>

