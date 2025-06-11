<?php
require_once '../../config/dbConnection.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    // Hapus gambar dulu jika ada
    $gambarQuery = mysqli_query($conn, "SELECT nama_file FROM gambar_produk WHERE id_produk = $id");
    while ($gambar = mysqli_fetch_assoc($gambarQuery)) {
        $filePath = "../../upload/" . $gambar['nama_file'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }
    }
    mysqli_query($conn, "DELETE FROM gambar_produk WHERE id_produk = $id");

    // Hapus data produk
    $hapusProduk = mysqli_query($conn, "DELETE FROM produk WHERE id_produk = $id");

    if ($hapusProduk) {
        header("Location: ../../dashboard/admin/produk.php?pesan=hapus-sukses");
        exit;
    } else {
        echo "Gagal menghapus produk.";
    }
} else {
    echo "ID tidak valid.";
}
?>
