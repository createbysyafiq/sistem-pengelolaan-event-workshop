<?php 
include "../koneksi.php";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Pemesanan Tiket & Kategori</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-slate-100 min-h-screen py-10 px-4 font-sans text-gray-800">

    <div class="max-w-2xl mx-auto space-y-8">
        
        <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
            <h2 class="text-xl font-bold text-center text-gray-800 mb-6">Form Pengelolaan Tiket & Kategori</h2>
            
            <form action="proses_tambah.php" method="POST" class="space-y-4">
                
                <div>
                    <label for="tipe_tiket" class="block font-semibold text-sm text-gray-700 mb-1">Tipe Tiket:</label>
                    <select name="tipe_tiket" id="tipe_tiket" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black-500">
                        <option value="">-- Pilih Tipe --</option>
                        <option value="Early Bird">Early Bird (Diskon Khusus Awal)</option>
                        <option value="Regular">Regular (Tiket Standar)</option>
                        <option value="VIP">VIP (Akses Prioritas)</option>
                    </select>
                </div>

                <div>
                    <label for="harga" class="block font-semibold text-sm text-gray-700 mb-1">Harga (Rp):</label>
                    <input type="number" name="harga" id="harga" min="0" placeholder="Contoh: 100000" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black-500">
                </div>

                <div>
                    <label for="kuota" class="block font-semibold text-sm text-gray-700 mb-1">Kuota:</label>
                    <input type="number" name="kuota" id="kuota" min="1" placeholder="Contoh: 50" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black-500">
                </div>

                <div>
                    <label for="benefit" class="block font-semibold text-sm text-gray-700 mb-1">Benefit / Fasilitas:</label>
                    <textarea name="benefit" id="benefit" rows="3" placeholder="Sertifikat, Snack, Modul Workshop..." required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-black-500"></textarea>
                </div>

                <div class="text-center pt-2">
                    <button type="submit" name="simpan" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2.5 px-8 rounded-md shadow transition duration-200">
                        Simpan Tiket
                    </button>
                </div>

            </form>
        </div>

        <div class="bg-white p-8 rounded-xl shadow-md border border-gray-100">
            <h3 class="text-lg font-bold text-center text-gray-800 mb-5">Data Tiket & Kategori:</h3>
            
            <div class="overflow-x-auto">
                <table class="w-full border-collapse border border-gray-200 text-sm">
                    <thead>
                        <tr class="bg-blue-600 text-white font-semibold">
                            <th class="p-3 border border-blue-700 text-center">No</th>
                            <th class="p-3 border border-blue-700 text-center">Tipe Tiket</th>
                            <th class="p-3 border border-blue-700 text-center">Harga</th>
                            <th class="p-3 border border-blue-700 text-center">Kuota</th>
                            <th class="p-3 border border-blue-700 text-center">Benefit</th>
                            <th class="p-3 border border-blue-700 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $no = 1;
                        $query = mysqli_query($koneksi, "SELECT * FROM tickets ORDER BY id DESC");
                        
                        if (mysqli_num_rows($query) == 0) {
                            echo "<tr><td colspan='6' class='p-4 text-center text-gray-400 italic'>Belum ada data tiket.</td></tr>";
                        }

                        while ($row = mysqli_fetch_assoc($query)) {
                        ?>
                        <tr class="hover:bg-slate-50 border-b border-gray-200">
                            <td class="p-3 text-center"><?= $no++; ?></td>
                            <td class="p-3 font-semibold text-gray-800 text-center"><?= htmlspecialchars($row['tipe_tiket']); ?></td>
                            <td class="p-3 text-center">Rp <?= number_format($row['harga'], 0, ',', '.'); ?></td>
                            <td class="p-3 text-center"><?= $row['kuota']; ?></td>
                            <td class="p-3 text-left"><?= nl2br(htmlspecialchars($row['benefit'])); ?></td>
                            <td class="p-3 text-center space-x-2 whitespace-nowrap">
                                <a href="edit.php?id=<?= $row['id']; ?>" class="text-blue-600 hover:text-blue-800 font-medium">Edit</a>
                                <span class="text-gray-300">|</span>
                                <a href="hapus.php?id=<?= $row['id']; ?>" onclick="return confirm('Yakin ingin menghapus tiket ini?');" class="text-red-600 hover:text-red-800 font-medium">Hapus</a>
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
