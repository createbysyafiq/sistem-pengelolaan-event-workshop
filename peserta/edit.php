<?php
// ==============================================================================
// MODUL PESERTA - HALAMAN EDIT PESERTA (EDIT.PHP)
// Penjelasan:
// File ini berfungsi untuk mengambil data satu peserta berdasarkan ID (melalui GET),
// lalu menampilkannya ke dalam formulir agar pengguna bisa mengedit nilainya.
// ==============================================================================

// 1. Panggil koneksi database
include "../koneksi.php";

// 2. Periksa apakah parameter 'id' ada di URL (contoh: edit.php?id=3)
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = (int) $_GET['id'];

// 3. Ambil data peserta yang ingin diedit menggunakan Prepared Statement
$sql = "SELECT * FROM peserta WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

// Jika ID tidak ditemukan di tabel peserta, kembalikan ke index.php
if (!$data) {
    header("Location: index.php");
    exit;
}

// 4. Ambil daftar tiket untuk pilihan dropdown
$query_tiket = mysqli_query($koneksi, "SELECT id, tipe_tiket, harga FROM tickets ORDER BY harga ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Peserta</title>
    <link rel="stylesheet" href="../tiket/style.css">
</head>
<body class="bg-gray-100 p-8 font-sans text-gray-800">

    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md border border-gray-100">
        <h2 class="text-xl font-bold mb-1 text-center">Edit Data Peserta</h2>
        <p class="text-xs text-gray-500 mb-6 text-center">Perbarui informasi data peserta lalu klik simpan</p>

        <!-- Form mengirim data ke proses_edit.php dengan metode POST -->
        <form action="proses_edit.php" method="POST" class="space-y-4">
            
            <!-- Input tersembunyi (hidden) untuk menyimpan ID peserta yang sedang diedit -->
            <input type="hidden" name="id" value="<?= $data['id']; ?>">

            <!-- Input Nama Lengkap -->
            <div>
                <label for="nama_lengkap" class="block font-semibold text-sm text-gray-700 mb-1">Nama Lengkap:</label>
                <input type="text" name="nama_lengkap" id="nama_lengkap" required 
                       value="<?= htmlspecialchars($data['nama_lengkap']); ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2">
            </div>

            <!-- Input Email -->
            <div>
                <label for="email" class="block font-semibold text-sm text-gray-700 mb-1">Email:</label>
                <input type="email" name="email" id="email" required 
                       value="<?= htmlspecialchars($data['email']); ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2">
            </div>

            <!-- Input Nomor HP -->
            <div>
                <label for="no_hp" class="block font-semibold text-sm text-gray-700 mb-1">Nomor HP / WhatsApp:</label>
                <input type="text" name="no_hp" id="no_hp" required 
                       value="<?= htmlspecialchars($data['no_hp']); ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2">
            </div>

            <!-- Input Institusi -->
            <div>
                <label for="institusi" class="block font-semibold text-sm text-gray-700 mb-1">Asal Institusi:</label>
                <input type="text" name="institusi" id="institusi" required 
                       value="<?= htmlspecialchars($data['institusi']); ?>"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2">
            </div>

            <!-- Dropdown Pilihan Tiket -->
            <div>
                <label for="id_tiket" class="block font-semibold text-sm text-gray-700 mb-1">Pilihan Tiket:</label>
                <select name="id_tiket" id="id_tiket" required 
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2">
                    <?php 
                    while ($tiket = mysqli_fetch_assoc($query_tiket)) {
                        // Tambahkan atribut 'selected' jika tiket ini sama dengan tiket peserta sebelumnya
                        $terpilih = ($tiket['id'] == $data['id_tiket']) ? 'selected' : '';
                        echo "<option value='{$tiket['id']}' {$terpilih}>";
                        echo htmlspecialchars($tiket['tipe_tiket']) . " - Rp " . number_format($tiket['harga'], 0, ',', '.');
                        echo "</option>";
                    }
                    ?>
                </select>
            </div>

            <!-- Tombol Simpan & Batal -->
            <div class="flex space-x-2 pt-2">
                <button type="submit" name="update" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-5 py-2 rounded-md shadow transition">
                    Simpan Perubahan
                </button>
                <a href="index.php" 
                   class="bg-gray-400 hover:bg-gray-500 text-white font-medium px-5 py-2 rounded-md inline-block transition">
                    Batal
                </a>
            </div>

        </form>
    </div>

</body>
</html>
