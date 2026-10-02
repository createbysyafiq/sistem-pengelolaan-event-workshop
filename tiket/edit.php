<?php
include "../koneksi.php";

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

$sql = "SELECT * FROM tickets WHERE id = ?";
$stmt = mysqli_prepare($koneksi, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Tiket - Modul C</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="bg-gray-100 p-8">

    <div class="max-w-xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-xl font-bold mb-4">Edit Data Tiket</h2>

        <form action="proses_edit.php" method="POST">
            <input type="hidden" name="id" value="<?= $data['id']; ?>">

            <div class="mb-4">
                <label>Tipe Tiket:</label><br>
                <select name="tipe_tiket" required class="w-full border p-2 rounded">
                    <option value="Early Bird" <?= ($data['tipe_tiket'] == 'Early Bird') ? 'selected' : ''; ?>>Early Bird</option>
                    <option value="Regular" <?= ($data['tipe_tiket'] == 'Regular') ? 'selected' : ''; ?>>Regular</option>
                    <option value="VIP" <?= ($data['tipe_tiket'] == 'VIP') ? 'selected' : ''; ?>>VIP</option>
                </select>
            </div>

            <div class="mb-4">
                <label>Harga (Rp):</label><br>
                <input type="number" name="harga" value="<?= $data['harga']; ?>" required class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label>Kuota:</label><br>
                <input type="number" name="kuota" value="<?= $data['kuota']; ?>" required class="w-full border p-2 rounded">
            </div>

            <div class="mb-4">
                <label>Benefit:</label><br>
                <textarea name="benefit" rows="3" required class="w-full border p-2 rounded"><?= htmlspecialchars($data['benefit']); ?></textarea>
            </div>

            <div class="flex space-x-2">
                <button type="submit" name="update" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Perubahan</button>
                <a href="index.php" class="bg-gray-400 text-white px-4 py-2 rounded inline-block">Batal</a>
            </div>
        </form>
    </div>

</body>
</html>
