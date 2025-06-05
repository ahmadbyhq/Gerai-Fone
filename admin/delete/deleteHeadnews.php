<?php
require_once '../../config/dbconnection.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Ambil data path gambar
    $result = $conn->query("SELECT image_path FROM upload_gambar WHERE id = $id AND kategori = 'headnews'");
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $imagePath = $row['image_path'];

        // Hapus file fisik jika ada
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Hapus record database
        $conn->query("DELETE FROM upload_gambar WHERE id = $id AND kategori = 'headnews'");
    }
}

// Redirect kembali ke halaman headnews.php setelah hapus
header("Location: ../../dashboard/admin/headnews.php");
exit;
