<?php
require_once '../../config/dbConnection.php';

$nama_file = basename($_GET['nama_file']);
$id_produk = (int)$_GET['id_produk'];

$file_path = "../../upload/" . $nama_file;

// Hapus dari database
mysqli_query($conn, "DELETE FROM gambar_produk WHERE nama_file = '$nama_file' AND id_produk = $id_produk");

// Hapus file dari folder
if (file_exists($file_path)) {
    unlink($file_path);
}

header("Location: ../../dashboard/admin/produk.php?id=$id_produk&msg=deleted");
exit;
