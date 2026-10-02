<?php
include "../koneksi.php";

if(isset($_POST['simpan'])) {
    $tipe_tiket = $_POST['tipe_tiket'];
    $harga =$_POST['harga'];
    $kuota = $_POST['kuota'];
    $benefit = $_POST['benefit'];

    $sql = "INSERT INTO tickets (tipe_tiket, harga, kuota, benefit) VALUES (?, ?, ?,?)";
    $stmt = mysqli_prepare($koneksi, $sql);

       if ($stmt) {
        // "siis" -> string, integer, integer, string
        mysqli_stmt_bind_param($stmt, "siis", $tipe_tiket, $harga, $kuota, $benefit);

        if (mysqli_stmt_execute($stmt)) {
            // Berhasil simpan, kembali ke tabel tiket
            header("Location: index.php?status=sukses");
            exit;
        } else {
            echo "Gagal eksekusi query: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal menyiapkan statement: " . mysqli_error($koneksi);
    }

} else {
    // Jika ada yang akses langsung URL tanpa submit form
    header("Location: index.php");
    exit;
}
