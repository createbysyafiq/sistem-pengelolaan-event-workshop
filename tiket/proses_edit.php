<?php
include "../koneksi.php";

if (isset($_POST['update'])) {

    $id         = $_POST['id'];
    $tipe_tiket = $_POST['tipe_tiket'];
    $harga      = $_POST['harga'];
    $kuota      = $_POST['kuota'];
    $benefit    = $_POST['benefit'];

    $sql = "UPDATE tickets SET tipe_tiket = ?, harga = ?, kuota = ?, benefit = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "siisi", $tipe_tiket, $harga, $kuota, $benefit, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: index.php?status=update_sukses");
            exit;
        } else {
            echo "Gagal mengupdate data: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal menyiapkan statement: " . mysqli_error($koneksi);
    }

} else {
    header("Location: index.php");
    exit;
}
