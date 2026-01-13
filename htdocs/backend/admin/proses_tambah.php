<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    exit('Unauthorized');
}
include '../config/database.php';
include 'logger.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);

    // Urusan Gambar (Security Hardening)
    $foto = $_FILES['gambar']['name'];
    $tmp = $_FILES['gambar']['tmp_name'];
    $file_size = $_FILES['gambar']['size'];
    $file_ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
    $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];

    // 1. Validasi Ekstensi
    if (!in_array($file_ext, $allowed_ext)) {
        die("Error: Ekstensi file tidak diizinkan! (Hanya JPG, PNG, WEBP)");
    }

    // 2. Validasi MIME Type (Cek apakah benar-benar gambar)
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $tmp);
    finfo_close($finfo);
    if (strpos($mime, 'image/') !== 0) {
        die("Error: File bukan merupakan gambar valid!");
    }

    // 3. Batasi Ukuran (Misal 5MB)
    if ($file_size > 5 * 1024 * 1024) {
        die("Error: Ukuran file terlalu besar! (Maksimal 5MB)");
    }

    // 4. Rename File agar unik (Mencegah serangan execution)
    $new_filename = "project_" . time() . "_" . uniqid() . "." . $file_ext;
    $target_path = "../assets/uploads/" . $new_filename;
    
    // Pindahkan foto ke folder uploads
    if (move_uploaded_file($tmp, $target_path)) {
        // Simpan ke database
        $query = "INSERT INTO projects (judul, deskripsi, kategori, gambar, tanggal) 
                  VALUES ('$judul', '$deskripsi', '$kategori', '$new_filename', '$tanggal')";

        if (mysqli_query($conn, $query)) {
            $new_id = mysqli_insert_id($conn);
            $admin = $_SESSION['admin_username'] ?? 'unknown';
            log_action($conn, $admin, 'create', 'projects', $new_id, "judul: $judul");
            header('Location: ../../private_admin/index.php?success=project_added&tab=project-section');
        } else {
            echo "Gagal Simpan Database: " . mysqli_error($conn);
        }
    } else {
        echo "Gagal Upload Gambar";
    }
}
?>
