<?php
require_once(__DIR__ . '/../../config/dbConnection.php');

if (isset($_GET['id'])) {
    $id_transaksi = (int)$_GET['id'];

    // Ambil status pembayaran terlebih dahulu
    $statusQuery = "SELECT status_pembayaran FROM transaksi WHERE id_transaksi = ?";
    $statusStmt = mysqli_prepare($conn, $statusQuery);
    mysqli_stmt_bind_param($statusStmt, 'i', $id_transaksi);
    mysqli_stmt_execute($statusStmt);
    $statusResult = mysqli_stmt_get_result($statusStmt);
    $statusData = mysqli_fetch_assoc($statusResult);

    if ($statusData && strtolower($statusData['status_pembayaran']) === 'dibayar') {
        // Ambil semua produk dan jumlah dalam transaksi
        $detailQuery = "SELECT id_produk, jumlah FROM detail_transaksi WHERE id_transaksi = ?";
        $detailStmt = mysqli_prepare($conn, $detailQuery);
        mysqli_stmt_bind_param($detailStmt, 'i', $id_transaksi);
        mysqli_stmt_execute($detailStmt);
        $resultDetail = mysqli_stmt_get_result($detailStmt);

        // Tambahkan kembali stok untuk setiap produk
        while ($row = mysqli_fetch_assoc($resultDetail)) {
            $id_produk = $row['id_produk'];
            $jumlah = $row['jumlah'];

            $updateStok = mysqli_prepare($conn, "UPDATE produk SET stok = stok + ? WHERE id_produk = ?");
            mysqli_stmt_bind_param($updateStok, 'ii', $jumlah, $id_produk);
            mysqli_stmt_execute($updateStok);
        }
    }

    // Hapus detail transaksi
    $hapusDetail = mysqli_prepare($conn, "DELETE FROM detail_transaksi WHERE id_transaksi = ?");
    mysqli_stmt_bind_param($hapusDetail, 'i', $id_transaksi);
    mysqli_stmt_execute($hapusDetail);

    // Hapus transaksi utama
    $hapusTransaksi = mysqli_prepare($conn, "DELETE FROM transaksi WHERE id_transaksi = ?");
    mysqli_stmt_bind_param($hapusTransaksi, 'i', $id_transaksi);
    mysqli_stmt_execute($hapusTransaksi);

    // Redirect
    header("Location: ../../dashboard/admin/transaksi.php?hapus=1");
    exit;
} else {
    echo "ID transaksi tidak ditemukan.";
}
