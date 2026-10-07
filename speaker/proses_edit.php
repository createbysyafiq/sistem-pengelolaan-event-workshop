<?php
include "../koneksi.php";

if (isset($_POST['update'])) {
    $id        = (int) $_POST['id'];
    $nama      = trim($_POST['nama']);
    $email     = trim($_POST['email']);
    $topik     = trim($_POST['topik']);
    $institusi = trim($_POST['institusi']);
    $no_hp     = trim($_POST['no_hp']);

    if (empty($id) || empty($nama) || empty($email) || empty($topik) || empty($institusi) || empty($no_hp)) {
        echo "<script>
                alert('Semua kolom form wajib diisi!');
                window.location.href = 'edit.php?id=" . $id . "';
              </script>";
        exit;
    }

    $sql = "UPDATE pembicara SET nama = ?, email = ?, topik = ?, institusi = ?, no_hp = ? WHERE id = ?";
    $stmt = mysqli_prepare($koneksi, $sql);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "sssssi", $nama, $email, $topik, $institusi, $no_hp, $id);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: pembicara.php?status=updated");
            exit;
        } else {
            echo "Gagal mengupdate data pembicara: " . mysqli_stmt_error($stmt);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Gagal menyiapkan query update: " . mysqli_error($koneksi);
    }

} else {
    header("Location: pembicara.php");
    exit;
}
