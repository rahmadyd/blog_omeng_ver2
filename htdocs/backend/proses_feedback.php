<?php
include 'config/database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $pesan = mysqli_real_escape_string($conn, $_POST['pesan']);

    if (!empty($nama) && !empty($pesan)) {
        $query = "INSERT INTO feedback (nama, pesan) VALUES ('$nama', '$pesan')";
        if (mysqli_query($conn, $query)) {
            header('Location: ../frontend/html/feedback.php?success=1');
        } else {
            header('Location: ../frontend/html/feedback.php?error=1');
        }
    } else {
        header('Location: ../frontend/html/feedback.php?error=empty');
    }
}
?>
