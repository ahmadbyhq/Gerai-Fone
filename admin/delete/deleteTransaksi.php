<?php
require_once(__DIR__ . '/../../config/dbConnection.php');

if (isset($_GET['id'])) {
    $id_transaksi = (int)$_GET['id'];

    // Hapus detail transaksi terlebih dahulu
    $hapusDetail = mysqli_prepare($conn, "DELETE FROM detail_transaksi WHERE id_transaksi = ?");
    mysqli_stmt_bind_param($hapusDetail, 'i', $id_transaksi);
    mysqli_stmt_execute($hapusDetail);

    // Hapus transaksi utama
    $hapusTransaksi = mysqli_prepare($conn, "DELETE FROM transaksi WHERE id_transaksi = ?");
    mysqli_stmt_bind_param($hapusTransaksi, 'i', $id_transaksi);
    mysqli_stmt_execute($hapusTransaksi);

    // Kembali ke halaman transaksi
    header("Location: ../../dashboard/admin/transaksi.php?hapus=1");
    exit;
} else {
    echo "ID transaksi tidak ditemukan.";
}
