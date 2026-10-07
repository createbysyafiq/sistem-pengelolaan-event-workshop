<?php

include "../koneksi.php";

if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: pembicara.php");
    exit;
}

$id = (int) $_GET['id'];

$sql = "SELECT * FROM pembicara WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: pembicara.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Pembicara</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <div id="pembicara">
        <h1>Edit Data Pembicara</h1>
        <p>Ubah informasi data pembicara di bawah ini lalu klik Simpan Perubahan</p>

        <!-- Form Edit Pembicara -->
        <form action="proses_edit.php" method="POST">
            <!-- Hidden Input ID -->
            <input type="hidden" name="id" value="<?= $data['id']; ?>">

            <div class="form-group">
                <label for="nama">Nama Pembicara:</label>
                <input type="text" name="nama" id="nama" value="<?= htmlspecialchars($data['nama']); ?>" required>
            </div>

            <div class="form-group">
                <label for="email">Email Pembicara:</label>
                <input type="email" name="email" id="email" value="<?= htmlspecialchars($data['email']); ?>" required>
            </div>

            <div class="form-group">
                <label for="topik">Topik / Materi:</label>
                <input type="text" name="topik" id="topik" value="<?= htmlspecialchars($data['topik']); ?>" required>
            </div>

            <div class="form-group">
                <label for="institusi">Asal Institusi:</label>
                <input type="text" name="institusi" id="institusi" value="<?= htmlspecialchars($data['institusi']); ?>" required>
            </div>

            <div class="form-group">
                <label for="no_hp">Nomor HP / WA:</label>
                <input type="text" name="no_hp" id="no_hp" value="<?= htmlspecialchars($data['no_hp']); ?>" required>
            </div>

            <div class="btn-container">
                <button type="submit" name="update">Simpan Perubahan</button>
                <a href="pembicara.php" class="btn-cancel">Batal</a>
            </div>
        </form>
    </div>

</body>
</html>
