<?php 

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_event_workshop";
// Matikan exception bawaan PHP 8 agar bisa mencoba port 3306 dan 3315 secara berurutan
mysqli_report(MYSQLI_REPORT_OFF);

// 1. Coba port normal 3306 (standar XAMPP komputer teman)
$koneksi = @mysqli_connect($host, $user, $pass, $db, 3306);

// 2. Jika gagal, coba port 3315 (port Laragon komputer Anda)
if (!$koneksi) {
    $koneksi = @mysqli_connect($host, $user, $pass, $db, 3315);
}

// Kembalikan pelaporan error ke normal
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!$koneksi) {
    die("Koneksi database gagal! Pastikan MySQL sudah di-START dan database 'db_event_workshop' sudah dibuat di phpMyAdmin.");
}