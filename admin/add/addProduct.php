<?php
require_once(__DIR__ . '/../../config/dbConnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama      = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $idKategori = (int) $_POST['id_kategori'];
    $harga     = (int) $_POST['harga_produk'];
    $stok      = (int) $_POST['stok'];
    $gambarName = '';
    if (isset($_FILES['gambar_produk']) && $_FILES['gambar_produk']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../upload/';
        if (isset($_FILES['gambar_produk']) && $_FILES['gambar_produk']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../../upload/';
        $originalName = $_FILES['gambar_produk']['name'];
        $ext = pathinfo($originalName, PATHINFO_EXTENSION);
        $uniqueName = uniqid('img_', true) . '.' . $ext;
        $uniqueName = preg_replace('/[^a-zA-Z0-9_\.-]/', '', $uniqueName);
        $uploadPath = $uploadDir . $uniqueName;

        if (move_uploaded_file($_FILES['gambar_produk']['tmp_name'], $uploadPath)) {
            $gambarName = $uniqueName;
        }
    }

        $uploadPath = $uploadDir . $gambarName;

        move_uploaded_file($_FILES['gambar_produk']['tmp_name'], $uploadPath);
    }

    // Simpan produk
    $insert = mysqli_query($conn, "
        INSERT INTO produk (nama_produk, id_kategori, harga_produk, stok)
        VALUES ('$nama', $idKategori, $harga, $stok)
    ");

    if ($insert) {
        $idProdukBaru = mysqli_insert_id($conn);

        // Simpan gambar jika berhasil upload
        if ($gambarName !== '') {
            $stmt = mysqli_prepare($conn, "INSERT INTO gambar_produk (id_produk, nama_file) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "is", $idProdukBaru, $gambarName);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        }

        header('Location: ../../dashboard/admin/produk.php?status=sukses');
        exit;
    } else {
        echo "Gagal menambahkan produk.";
    }
}
