<?php
include "../koneksi.php";

if (isset($_POST['simpan'])) {

    $nama      = trim($_POST['nama']);
    $email     = trim($_POST['email']);
    $topik     = trim($_POST['topik']);
    $institusi = trim($_POST['institusi']);
    $no_hp     = trim($_POST['no_hp']);

    if (empty($nama) || empty($email) || empty($topik) || empty($institusi) || empty($no_hp)) {
        echo "<script>
                alert('Semua kolom form wajib diisi!');
                window.location.href = 'pembicara.php';
              </script>";
        exit;
    }

    mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS pembicara (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nama VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        topik VARCHAR(200) NOT NULL,
        institusi VARCHAR(100) NOT NULL,
        no_hp VARCHAR(20) NOT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )");

    $sql = "INSERT INTO pembicara (nama, email, topik, institusi, no_hp) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssss", $nama, $email, $topik, $institusi, $no_hp);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: pembicara.php?status=sukses");
            exit;
        } else {
            echo "Gagal menyimpan data pembicara: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal menyiapkan query: " . mysqli_error($koneksi);
    }

} else {
    header("Location: pembicara.php");
    exit;
}
