<?php 

$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_event_workshop";
$port = "3315";


$koneksi = mysqli_connect($host, $user, $pass, $db, $port);

if (!$koneksi) {
    die("koneksi database gagal: " . mysqli_connect_error());
}