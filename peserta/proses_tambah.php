<?php
// ==============================================================================
// MODUL PESERTA - PROSES TAMBAH PESERTA (PROSES_TAMBAH.PHP)
// Penjelasan:
// File ini tidak menampilkan tampilan HTML, melainkan memproses data yang
// dikirim dari form index.php lewat method POST, lalu menyimpannya ke database.
// ==============================================================================

// 1. Panggil koneksi database
include "../koneksi.php";

// 2. Periksa apakah tombol submit bernama 'simpan' ditekan
if (isset($_POST['simpan'])) {

    // 3. Tangkap data dari form input index.php
    $nama_lengkap = trim($_POST['nama_lengkap']);
    $email        = trim($_POST['email']);
    $no_hp        = trim($_POST['no_hp']);
    $institusi    = trim($_POST['institusi']);
    $id_tiket     = (int) $_POST['id_tiket'];

    // 4. Validasi sederhana: pastikan tidak ada kolom yang kosong
    if (empty($nama_lengkap) || empty($email) || empty($no_hp) || empty($institusi) || empty($id_tiket)) {
        echo "<script>
                alert('Semua kolom formulir wajib diisi!');
                window.location.href = 'index.php';
              </script>";
        exit;
    }

    // 5. Siapkan query SQL menggunakan Prepared Statement (Aman dari SQL Injection)
    // Tanda tanya (?) adalah placeholder untuk data yang akan dimasukkan
    $sql = "INSERT INTO peserta (nama_lengkap, email, no_hp, institusi, id_tiket) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        // "ssssi" berarti 4 string (s) dan 1 integer (i)
        mysqli_stmt_bind_param($stmt, "ssssi", $nama_lengkap, $email, $no_hp, $institusi, $id_tiket);

        // Eksekusi query ke database
        if (mysqli_stmt_execute($stmt)) {
            // Jika berhasil disimpan, redirect kembali ke index.php dengan notifikasi sukses
            header("Location: index.php?status=sukses");
            exit;
        } else {
            // Jika eksekusi gagal, tampilkan pesan error
            echo "Gagal menyimpan data peserta: " . mysqli_stmt_error($stmt);
        }

        // Tutup statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal menyiapkan query database: " . mysqli_error($koneksi);
    }

} else {
    // Jika file ini diakses langsung tanpa lewat form submit, kembalikan ke index.php
    header("Location: index.php");
    exit;
}
