<?php
include '../../config/dbConnection.php';

$id_transaksi = $_POST['id_transaksi'];
$produk = $_POST['produk'];
$jumlah = $_POST['jumlah'];

// Hapus detail transaksi lama
mysqli_query($conn, "DELETE FROM detail_transaksi WHERE id_transaksi = $id_transaksi");

// Masukkan ulang detail transaksi
for ($i = 0; $i < count($produk); $i++) {
    $id_produk = $produk[$i];
    $qty = $jumlah[$i];

    mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah) VALUES ($id_transaksi, $id_produk, $qty)");
}

header("Location: ../../dashboard/admin/transaksi.php");
exit;
