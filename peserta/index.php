<?php 
// ==============================================================================
// MODUL PESERTA - HALAMAN UTAMA (INDEX.PHP)
// Penjelasan:
// File ini berfungsi untuk:
// 1. Menampilkan formulir pendaftaran peserta baru (CREATE).
// 2. Menampilkan tabel daftar peserta yang sudah terdaftar di database (READ).
// ==============================================================================

// 1. Hubungkan file ini ke database melalui file koneksi.php
include "../koneksi.php";

// 2. Ambil data tipe tiket dari tabel 'tickets' untuk pilihan dropdown di form
$query_tiket = mysqli_query($koneksi, "SELECT id, tipe_tiket, harga FROM tickets ORDER BY harga ASC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran & Pengelolaan Peserta</title>
    <!-- Memakai stylesheet Tailwind yang sudah ada di modul tiket -->
    <link rel="stylesheet" href="../tiket/style.css">
</head>
<body class="bg-slate-100 min-h-screen py-10 px-4 font-sans text-gray-800">

    <div class="max-w-4xl mx-auto space-y-8">

        <!-- =================================================================== -->
        <!-- NOTIFIKASI / STATUS PESAN (Feedback ke pengguna jika proses berhasil) -->
        <!-- =================================================================== -->
        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'sukses'): ?>
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg text-sm text-center shadow">
                    ✅ <strong>Berhasil!</strong> Data peserta baru berhasil didaftarkan.
                </div>
            <?php elseif ($_GET['status'] == 'update_sukses'): ?>
                <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded-lg text-sm text-center shadow">
                    ✏️ <strong>Berhasil!</strong> Data peserta berhasil diperbarui.
                </div>
            <?php elseif ($_GET['status'] == 'hapus_sukses'): ?>
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg text-sm text-center shadow">
                    🗑️ <strong>Berhasil!</strong> Data peserta telah dihapus dari sistem.
                </div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- =================================================================== -->
        <!-- BAGIAN 1: FORMULIR TAMBAH DATA PESERTA (CREATE)                    -->
        <!-- =================================================================== -->
        <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
            <h2 class="text-xl font-bold text-center text-gray-800 mb-2">Formulir Pendaftaran Peserta</h2>
            <p class="text-xs text-gray-500 text-center mb-6">Silakan isi data peserta workshop/event di bawah ini</p>
            
            <!-- Form mengirim data ke file proses_tambah.php menggunakan metode POST -->
            <form action="proses_tambah.php" method="POST" class="space-y-4">
                
                <!-- Input: Nama Lengkap -->
                <div>
                    <label for="nama_lengkap" class="block font-semibold text-sm text-gray-700 mb-1">Nama Lengkap:</label>
                    <input type="text" name="nama_lengkap" id="nama_lengkap" placeholder="Contoh: Budi Santoso" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2">
                </div>

                <!-- Input: Email -->
                <div>
                    <label for="email" class="block font-semibold text-sm text-gray-700 mb-1">Alamat Email:</label>
                    <input type="email" name="email" id="email" placeholder="Contoh: budi@gmail.com" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2">
                </div>

                <!-- Input: Nomor HP / WhatsApp -->
                <div>
                    <label for="no_hp" class="block font-semibold text-sm text-gray-700 mb-1">Nomor HP / WhatsApp:</label>
                    <input type="text" name="no_hp" id="no_hp" placeholder="Contoh: 081234567890" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2">
                </div>

                <!-- Input: Asal Institusi / Instansi -->
                <div>
                    <label for="institusi" class="block font-semibold text-sm text-gray-700 mb-1">Asal Institusi / Universitas / Sekolah:</label>
                    <input type="text" name="institusi" id="institusi" placeholder="Contoh: Universitas Indonesia" required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2">
                </div>

                <!-- Input: Pilihan Tiket (Dropdown dinamis dari tabel tickets) -->
                <div>
                    <label for="id_tiket" class="block font-semibold text-sm text-gray-700 mb-1">Pilih Jenis Tiket:</label>
                    <select name="id_tiket" id="id_tiket" required 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2">
                        <option value="">-- Pilih Tiket Yang Diikuti --</option>
                        <?php 
                        // Menampilkan setiap baris tiket yang ada di database
                        if (mysqli_num_rows($query_tiket) > 0) {
                            while ($tiket = mysqli_fetch_assoc($query_tiket)) {
                                echo "<option value='{$tiket['id']}'>";
                                echo htmlspecialchars($tiket['tipe_tiket']) . " - Rp " . number_format($tiket['harga'], 0, ',', '.');
                                echo "</option>";
                            }
                        } else {
                            echo "<option value='' disabled>Belum ada tiket tersedia (isi modul tiket dulu)</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Tombol Submit Form -->
                <div class="text-center pt-3">
                    <button type="submit" name="simpan" 
                            class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-8 rounded-md shadow transition duration-200">
                        Daftarkan Peserta
                    </button>
                </div>

            </form>
        </div>

        <!-- =================================================================== -->
        <!-- BAGIAN 2: TABEL DAFTAR PESERTA TERDAFTAR (READ)                     -->
        <!-- =================================================================== -->
        <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
            <h3 class="text-lg font-bold text-center text-gray-800 mb-5">Daftar Peserta Terdaftar</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-200 text-sm">
                    <thead>
                        <tr class="bg-blue-600 text-white font-semibold">
                            <th class="p-3 border border-blue-700 text-center">No</th>
                            <th class="p-3 border border-blue-700 text-left">Nama Lengkap</th>
                            <th class="p-3 border border-blue-700 text-left">Email & Kontak</th>
                            <th class="p-3 border border-blue-700 text-left">Institusi</th>
                            <th class="p-3 border border-blue-700 text-center">Jenis Tiket</th>
                            <th class="p-3 border border-blue-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        // Query mengambil data peserta dan menggabungkan (JOIN) dengan tabel tickets
                        // agar kita bisa menampilkan nama tipe tiket dan harganya
                        $sql_peserta = "SELECT peserta.*, tickets.tipe_tiket, tickets.harga 
                                        FROM peserta 
                                        LEFT JOIN tickets ON peserta.id_tiket = tickets.id 
                                        ORDER BY peserta.id DESC";
                        $query_peserta = mysqli_query($koneksi, $sql_peserta);
                        
                        // Periksa apakah tabel peserta masih kosong
                        if (mysqli_num_rows($query_peserta) == 0) {
                            echo "<tr><td colspan='6' class='p-4 text-center text-gray-400 italic'>Belum ada data peserta yang terdaftar.</td></tr>";
                        }

                        // Loop menampilkan baris demi baris data peserta
                        while ($row = mysqli_fetch_assoc($query_peserta)) {
                        ?>
                        <tr class="hover:bg-slate-50 border-b border-gray-200">
                            <!-- Nomor Urut -->
                            <td class="p-3 text-center"><?= $no++; ?></td>
                            
                            <!-- Nama Lengkap -->
                            <td class="p-3 font-semibold text-gray-800">
                                <?= htmlspecialchars($row['nama_lengkap']); ?>
                            </td>

                            <!-- Kontak Peserta -->
                            <td class="p-3 text-gray-600">
                                <div>📧 <?= htmlspecialchars($row['email']); ?></div>
                                <div class="text-xs text-gray-500">📱 <?= htmlspecialchars($row['no_hp']); ?></div>
                            </td>

                            <!-- Institusi -->
                            <td class="p-3 text-gray-700">
                                <?= htmlspecialchars($row['institusi']); ?>
                            </td>

                            <!-- Tiket Yang Dipilih -->
                            <td class="p-3 text-center">
                                <?php if ($row['tipe_tiket']): ?>
                                    <span class="inline-block bg-blue-100 text-blue-800 text-xs px-2.5 py-1 rounded-full font-semibold">
                                        <?= htmlspecialchars($row['tipe_tiket']); ?>
                                    </span>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Rp <?= number_format($row['harga'], 0, ',', '.'); ?>
                                    </div>
                                <?php else: ?>
                                    <span class="text-gray-400 italic text-xs">Tiket tidak ditemukan</span>
                                <?php endif; ?>
                            </td>

                            <!-- Tombol Aksi (Edit & Hapus) -->
                            <td class="p-3 text-center space-x-2 whitespace-nowrap">
                                <a href="edit.php?id=<?= $row['id']; ?>" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <span class="text-gray-300">|</span>
                                <a href="hapus.php?id=<?= $row['id']; ?>" 
                                   onclick="return confirm('Apakah Anda yakin ingin menghapus data peserta <?= addslashes($row['nama_lengkap']); ?>?');" 
                                   class="text-red-600 hover:text-red-800 font-medium">Hapus</a>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</body>
</html>
