<?php
// ==============================================================================
// MODUL PESERTA - PROSES HAPUS PESERTA (HAPUS.PHP)
// Penjelasan:
// File ini menangkap parameter 'id' dari URL melalui metode GET (contoh: hapus.php?id=3),
// lalu menghapus data baris tersebut dari tabel 'peserta' di database.
// ==============================================================================

// 1. Panggil koneksi database
include "../koneksi.php";

// 2. Periksa apakah parameter 'id' dikirimkan lewat URL
if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // 3. Siapkan query DELETE menggunakan Prepared Statement
    $sql = "DELETE FROM peserta WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        // "i" berarti tipe data parameter adalah integer (angka ID)
        mysqli_stmt_bind_param($stmt, "i", $id);

        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil dihapus, redirect kembali ke index.php dengan notifikasi
            header("Location: index.php?status=hapus_sukses");
            exit;
        } else {
            echo "Gagal menghapus data: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal menyiapkan statement: " . mysqli_error($koneksi);
    }

} else {
    // Jika tidak ada ID, kembalikan ke index.php
    header("Location: index.php");
    exit;
}
