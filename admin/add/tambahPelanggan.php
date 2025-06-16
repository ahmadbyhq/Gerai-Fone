<?php

require_once(__DIR__ . '/../../config/dbConnection.php');
require_once(__DIR__ . '/../../authentication/auth.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['tambah'])) {
    // Mendapatkan data dari form
    $nama_pelanggan = $_POST['nama_pelanggan'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    // Menyiapkan query untuk menambahkan data pelanggan
    $insertQuery = "INSERT INTO pelanggan (nama_pelanggan, no_hp, alamat) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param("sss", $nama_pelanggan, $no_hp, $alamat); // Mengikat parameter

    // Mengeksekusi query
    if ($stmt->execute()) {
        echo "<script>
                alert('Pelanggan berhasil ditambahkan!');
                window.location.href = '../../dashboard/admin/pelanggan.php';  // Redirect ke halaman pelanggan
              </script>";
    } else {
        echo "<script>
                alert('Gagal menambahkan pelanggan: " . $stmt->error . "');
                window.location.href = '../../dashboard/admin/pelanggan.php';  // Redirect ke halaman pelanggan
              </script>";
    }

    // Menutup prepared statement
    $stmt->close();
}
?>

<!-- Form Tambah Pelanggan -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Pelanggan</title>
</head>
<body>
    <h2>Tambah Pelanggan Baru</h2>
    <form method="post" action="">
        <label>Nama Pelanggan:</label><br>
        <input type="text" name="nama_pelanggan" required><br><br>

        <label>No. HP:</label><br>
        <input type="text" name="no_hp" required><br><br>

        <label>Alamat:</label><br>
        <textarea name="alamat" required></textarea><br><br>

        <button type="submit" name="tambah">Tambah</button>
    </form>
</body>
</html>
