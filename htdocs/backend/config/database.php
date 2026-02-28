<?php
// KONFIGURASI DATABASE INFINITYFREE

$host = "sql113.infinityfree.com"; // Lihat di MySQL Databases
$user = "if0_40892324";         // Username database
$pass = "C910VaTe2UUHq";           // Password database (bukan password akun InfinityFree)
$db   = "if0_40892324_omeng";       // Nama database

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>