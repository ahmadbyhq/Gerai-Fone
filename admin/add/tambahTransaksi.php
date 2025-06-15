<?php
require_once(__DIR__ . '/../../config/dbConnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_pelanggan = $_POST['id_pelanggan'];
    $produk_ids = $_POST['produk'];
    $jumlahs = $_POST['jumlah'];
    $status = $_POST['status_pembayaran'];
    $tanggal = date('Y-m-d');

    if (empty($id_pelanggan) || empty($produk_ids) || empty($jumlahs)) {
        die('Data tidak lengkap.');
    }

    // Hitung total harga dan simpan detail per produk
    $total = 0;
    $detail_items = [];

    foreach ($produk_ids as $i => $id_produk) {
        $jumlah = (int)$jumlahs[$i];
        $query = mysqli_query($conn, "SELECT harga_produk FROM produk WHERE id_produk = '$id_produk'");
        $data = mysqli_fetch_assoc($query);
        $harga_satuan = (int)$data['harga_produk'];
        $subtotal = $harga_satuan * $jumlah;
        $total += $subtotal;

        $detail_items[] = [
            'id_produk' => $id_produk,
            'jumlah' => $jumlah,
            'harga_satuan' => $harga_satuan,
            'subtotal' => $subtotal
        ];
    }

    // Simpan ke tabel transaksi
    $stmt = mysqli_prepare($conn, "INSERT INTO transaksi (id_pelanggan, tanggal_transaksi, total_harga, status_pembayaran) VALUES (?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, 'isis', $id_pelanggan, $tanggal, $total, $status);
    mysqli_stmt_execute($stmt);
    $id_transaksi = mysqli_insert_id($conn);

    // Simpan ke detail_transaksi lengkap
    $stmt_detail = mysqli_prepare($conn, "INSERT INTO detail_transaksi (id_transaksi, id_produk, jumlah, harga_satuan, subtotal) VALUES (?, ?, ?, ?, ?)");
    foreach ($detail_items as $item) {
        mysqli_stmt_bind_param($stmt_detail, 'iiiii', $id_transaksi, $item['id_produk'], $item['jumlah'], $item['harga_satuan'], $item['subtotal']);
        mysqli_stmt_execute($stmt_detail);
    }

    header("Location: ../../dashboard/admin/transaksi.php?success=1");
    exit;
} else {
    die('Metode tidak diizinkan.');
}
