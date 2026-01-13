<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    exit('Unauthorized');
}
include '../config/database.php';
include 'logger.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $type = $_POST['type'];
    $judul = mysqli_real_escape_string($conn, $_POST['judul']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $kategori = mysqli_real_escape_string($conn, $_POST['kategori']);
    $tanggal = mysqli_real_escape_string($conn, $_POST['tanggal']);
    $link = isset($_POST['link']) ? mysqli_real_escape_string($conn, $_POST['link']) : '';

    $update_image = false;
    $new_filename = "";

    // Handle Image Upload if exists
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
        $foto = $_FILES['gambar']['name'];
        $tmp = $_FILES['gambar']['tmp_name'];
        $file_size = $_FILES['gambar']['size'];
        $file_ext = strtolower(pathinfo($foto, PATHINFO_EXTENSION));
        $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];

        if (in_array($file_ext, $allowed_ext) && $file_size <= 5 * 1024 * 1024) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $tmp);
            finfo_close($finfo);

            if (strpos($mime, 'image/') === 0) {
                // Delete old image
                $q_old = "SELECT gambar FROM projects WHERE id = $id";
                $res_old = mysqli_query($conn, $q_old);
                $old_data = mysqli_fetch_assoc($res_old);
                if ($old_data && file_exists("../assets/uploads/" . $old_data['gambar'])) {
                    unlink("../assets/uploads/" . $old_data['gambar']);
                }

                $new_filename = ($type == 'shop' ? 'shop_' : 'project_') . time() . "_" . uniqid() . "." . $file_ext;
                if (move_uploaded_file($tmp, "../assets/uploads/" . $new_filename)) {
                    $update_image = true;
                }
            }
        }
    }

    if ($update_image) {
        $query = "UPDATE projects SET judul='$judul', deskripsi='$deskripsi', kategori='$kategori', tanggal='$tanggal', link='$link', gambar='$new_filename' WHERE id=$id";
    } else {
        $query = "UPDATE projects SET judul='$judul', deskripsi='$deskripsi', kategori='$kategori', tanggal='$tanggal', link='$link' WHERE id=$id";
    }

    $tab = ($type == 'shop') ? 'shop-section' : 'project-section';
    if (mysqli_query($conn, $query)) {
        $admin = $_SESSION['admin_username'] ?? 'unknown';
        $details = "judul:$judul, kategori:$kategori, tanggal:$tanggal";
        if ($update_image) $details .= ", gambar:$new_filename";
        log_action($conn, $admin, 'update', 'projects', $id, $details);
        header("Location: ../../private_admin/index.php?success=updated&tab=$tab");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
