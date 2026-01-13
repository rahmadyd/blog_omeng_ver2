<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: ../../login.php');
    exit;
}
include '../config/database.php';
include 'logger.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // Ambil info item dulu untuk dihapus dari server (opsional)
    $q_img = "SELECT gambar, judul FROM projects WHERE id = $id";
    $res_img = mysqli_query($conn, $q_img);
    $data_img = mysqli_fetch_assoc($res_img);
    
    if ($data_img) {
        $file_path = "../assets/uploads/" . $data_img['gambar'];
        if (file_exists($file_path)) {
            unlink($file_path);
        }
    }

    $query = "DELETE FROM projects WHERE id = $id";
    $tab = (isset($_GET['type']) && $_GET['type'] == 'shop') ? 'shop-section' : 'project-section';
    
    if (mysqli_query($conn, $query)) {
        $admin = $_SESSION['admin_username'] ?? 'unknown';
        $target_title = $data_img['judul'] ?? null;
        $details = "judul: " . ($target_title ?? '') ;
        log_action($conn, $admin, 'delete', 'projects', $id, $details);
        header("Location: ../../private_admin/index.php?success=deleted&tab=$tab");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
