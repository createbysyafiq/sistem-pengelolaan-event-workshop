<?php
// ==============================================================================
// MODUL PESERTA - PROSES EDIT PESERTA (PROSES_EDIT.PHP)
// Penjelasan:
// File ini memproses pembaruan data yang dikirim dari form edit.php lewat POST,
// lalu mengeksekusi perintah SQL UPDATE ke database.
// ==============================================================================

// 1. Panggil koneksi database
include "../koneksi.php";

// 2. Periksa apakah tombol submit 'update' ditekan
if (isset($_POST['update'])) {

    // 3. Tangkap data dari form
    $id           = (int) $_POST['id'];
    $nama_lengkap = trim($_POST['nama_lengkap']);
    $email        = trim($_POST['email']);
    $no_hp        = trim($_POST['no_hp']);
    $institusi    = trim($_POST['institusi']);
    $id_tiket     = (int) $_POST['id_tiket'];

    // 4. Validasi sederhana
    if (empty($id) || empty($nama_lengkap) || empty($email) || empty($no_hp) || empty($institusi) || empty($id_tiket)) {
        echo "<script>
                alert('Semua kolom wajib diisi!');
                window.location.href = 'edit.php?id=$id';
              </script>";
        exit;
    }

    // 5. Query UPDATE dengan Prepared Statement
    $sql = "UPDATE peserta SET nama_lengkap = ?, email = ?, no_hp = ?, institusi = ?, id_tiket = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        // "ssssii" = 4 string (nama, email, no_hp, institusi) dan 2 integer (id_tiket, id)
        mysqli_stmt_bind_param($stmt, "ssssii", $nama_lengkap, $email, $no_hp, $institusi, $id_tiket, $id);

        if (mysqli_stmt_execute($stmt)) {
            // Berhasil diperbarui, kembali ke index.php
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
