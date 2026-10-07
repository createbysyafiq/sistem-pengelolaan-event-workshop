<?php 
// Panggil koneksi database
include "../koneksi.php";

// Buat tabel pembicara otomatis jika belum ada di database
mysqli_query($koneksi, "CREATE TABLE IF NOT EXISTS pembicara (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    topik VARCHAR(200) NOT NULL,
    institusi VARCHAR(100) NOT NULL,
    no_hp VARCHAR(20) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Data Pembicara & Daftar Pembicara</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div id="pembicara">
        <h1>Form Data Pembicara</h1>
        <p>Isi formulir di bawah ini untuk menambahkan data pembicara baru</p>

        <?php if (isset($_GET['status'])): ?>
            <?php if ($_GET['status'] == 'sukses'): ?>
                <div class="alert alert-success">Data pembicara berhasil disimpan!</div>
            <?php elseif ($_GET['status'] == 'updated'): ?>
                <div class="alert alert-success">Data pembicara berhasil diperbarui!</div>
            <?php elseif ($_GET['status'] == 'deleted'): ?>
                <div class="alert alert-success">Data pembicara berhasil dihapus!</div>
            <?php elseif ($_GET['status'] == 'gagal'): ?>
                <div class="alert alert-danger">Terjadi kesalahan saat memproses data.</div>
            <?php endif; ?>
        <?php endif; ?>

        <!-- Form Tambah Pembicara -->
        <form action="proses_tambah.php" method="POST">
            <div class="form-group">
                <label for="nama">Nama Pembicara:</label>
                <input type="text" name="nama" id="nama" placeholder="Masukkan nama lengkap" required>
            </div>

            <div class="form-group">
                <label for="email">Email Pembicara:</label>
                <input type="email" name="email" id="email" placeholder="contoh@email.com" required>
            </div>

            <div class="form-group">
                <label for="topik">Topik / Materi:</label>
                <input type="text" name="topik" id="topik" placeholder="Topik materi yang dibawakan" required>
            </div>

            <div class="form-group">
                <label for="institusi">Asal Institusi:</label>
                <input type="text" name="institusi" id="institusi" placeholder="Universitas / Instansi / Perusahaan" required>
            </div>

            <div class="form-group">
                <label for="no_hp">Nomor HP / WA:</label>
                <input type="text" name="no_hp" id="no_hp" placeholder="08xxxxxxxxxx" required>
            </div>

            <div class="btn-container">
                <button type="submit" name="simpan">Submit Data</button>
            </div>
        </form>

        <!-- Tabel Data Pembicara -->
        <h2 class="table-title">Daftar Data Pembicara</h2>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">Nama Pembicara</th>
                        <th style="width: 20%;">Email</th>
                        <th style="width: 20%;">Topik / Materi</th>
                        <th style="width: 15%;">Institusi</th>
                        <th style="width: 10%;">No. HP</th>
                        <th style="width: 10%;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $no = 1;
                    $query = mysqli_query($koneksi, "SELECT * FROM pembicara ORDER BY id DESC");

                    if (mysqli_num_rows($query) == 0) {
                        echo "<tr><td colspan='7' style='text-align: center; color: #888; padding: 15px;'>Belum ada data pembicara. Silakan isi form di atas.</td></tr>";
                    } else {
                        while ($row = mysqli_fetch_assoc($query)) {
                    ?>
                        <tr>
                            <td style="text-align: center;"><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama']); ?></td>
                            <td><?= htmlspecialchars($row['email']); ?></td>
                            <td><?= htmlspecialchars($row['topik']); ?></td>
                            <td><?= htmlspecialchars($row['institusi']); ?></td>
                            <td style="text-align: center;"><?= htmlspecialchars($row['no_hp']); ?></td>
                            <td style="text-align: center; white-space: nowrap;">
                                <a href="edit.php?id=<?= $row['id']; ?>" class="btn-edit">Edit</a>
                                <a href="hapus.php?id=<?= $row['id']; ?>" class="btn-delete" onclick="return confirm('Apakah Anda yakin ingin menghapus data pembicara ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php 
                        }
                    } 
                    ?>
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
