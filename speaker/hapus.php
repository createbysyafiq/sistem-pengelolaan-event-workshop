<?php
include "../koneksi.php";

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = (int) $_GET['id'];

    $sql = "DELETE FROM pembicara WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: pembicara.php?status=deleted");
            exit;
        } else {
            echo "Gagal menghapus data pembicara: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal menyiapkan query hapus: " . mysqli_error($koneksi);
    }
} else {
    header("Location: pembicara.php");
    exit;
}
