<?php
include '../../config/dbConnection.php';

$id_transaksi = $_POST['id_transaksi'];
$produk = $_POST['produk'];
$jumlah = $_POST['jumlah'];

// Ambil status pembayaran
$statusQuery = mysqli_query($conn, "SELECT status_pembayaran FROM transaksi WHERE id_transaksi = $id_transaksi");
$status = mysqli_fetch_assoc($statusQuery)['status_pembayaran'];

// Jika status "Dibayar", kembalikan stok dari detail lama
if (strtolower($status) === 'dibayar') {
    $oldDetail = mysqli_query($conn, "SELECT id_produk, jumlah FROM detail_transaksi WHERE id_transaksi = $id_transaksi");
    while ($row = mysqli_fetch_assoc($oldDetail)) {
        $id_produk = $row['id_produk'];
        $qty = $row['jumlah'];
        mysqli_query($conn, "UPDATE produk SET stok = stok + $qty WHERE id_produk = $id_produk");
    }
}

// Hapus detail transaksi lama
mysqli_query($conn, "DELETE FROM detail_transaksi WHERE id_transaksi = $id_transaksi");

// Masukkan ulang detail transaksi
for ($i = 0; $i < count($produk); $i++) {
    $id_produk = (int)$produk[$i];
    $qty = (int)$jumlah[$i];

    mysqli_query($conn, "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah) VALUES ($id_transaksi, $id_produk, $qty)");

    // Kurangi stok jika status pembayaran "Dibayar"
    if (strtolower($status) === 'dibayar') {
        mysqli_query($conn, "UPDATE produk SET stok = stok - $qty WHERE id_produk = $id_produk");
    }
}

header("Location: ../../dashboard/admin/transaksi.php?edit=1");
exit;
