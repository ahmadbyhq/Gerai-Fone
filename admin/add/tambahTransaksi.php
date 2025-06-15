<?php
require_once(__DIR__ . '/../../config/dbConnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pelanggan = $_POST['id_pelanggan'];
    $produk_ids = $_POST['produk'];
    $jumlahs = $_POST['jumlah'];
    $status = $_POST['status_pembayaran'];
    $tanggal = date('Y-m-d');

    // Validasi awal
    if (empty($id_pelanggan) || empty($produk_ids) || empty($jumlahs)) {
        die('Data tidak lengkap.');
    }

    // Hitung total harga
    $total = 0;
    foreach ($produk_ids as $i => $id_produk) {
        $jumlah = (int)$jumlahs[$i];
        $query = mysqli_query($conn, "SELECT harga_produk FROM produk WHERE id_produk = '$id_produk'");
        $data = mysqli_fetch_assoc($query);
        $harga = (int)$data['harga_produk'];
        $total += $harga * $jumlah;
    }

    // Simpan transaksi
    $stmt = mysqli_prepare($conn, "INSERT INTO transaksi (id_pelanggan, tanggal_transaksi, total_harga, status_pembayaran) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'isis', $id_pelanggan, $tanggal, $total, $status);
    mysqli_stmt_execute($stmt);
    $id_transaksi = mysqli_insert_id($conn);

    // Simpan detail produk
    $stmt_detail = mysqli_prepare($conn, "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah) VALUES (?, ?, ?)");
    foreach ($produk_ids as $i => $id_produk) {
        $jumlah = (int)$jumlahs[$i];
        mysqli_stmt_bind_param($stmt_detail, 'iii', $id_transaksi, $id_produk, $jumlah);
        mysqli_stmt_execute($stmt_detail);
    }

    // Redirect balik ke transaksi
    header("Location: ../../dashboard/admin/transaksi.php?success=1");
    exit;
} else {
    die('Metode tidak diizinkan.');
}
