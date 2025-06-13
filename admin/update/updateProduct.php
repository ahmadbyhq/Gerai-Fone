<?php
include '../../config/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = (int)$_POST['id_produk'];
    $nama       = mysqli_real_escape_string($conn, $_POST['nama_produk']);
    $deskripsi  = mysqli_real_escape_string($conn, $_POST['deskripsi_produk']);
    $harga      = (int)$_POST['harga_produk'];
    $stok       = (int)$_POST['stok'];
    $idKategori = (int)$_POST['id_kategori'];

    // Update data dasar
    $sql = "UPDATE produk SET 
                nama_produk = '$nama',
                deskripsi_produk = '$deskripsi',
                harga_produk = $harga,
                stok = $stok,
                id_kategori = $idKategori
            WHERE id_produk = $id";
    mysqli_query($conn, $sql);

    // Jika ada gambar baru diupload
    // if (!empty($_FILES['gambar']['name'])) {
    //     $namaFile = basename($_FILES['gambar']['name']);
    //     $targetDir = "../../upload/";
    //     $targetFile = $targetDir . $namaFile;

    //     if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
    //         // Hapus gambar lama jika ada, atau update saja
    //         $cek = mysqli_query($conn, "SELECT * FROM gambar_produk WHERE id_produk = $id");
    //         if (mysqli_num_rows($cek) > 0) {
    //             mysqli_query($conn, "UPDATE gambar_produk SET nama_file = '$namaFile' WHERE id_produk = $id");
    //         } else {
    //             mysqli_query($conn, "INSERT INTO gambar_produk (id_produk, nama_file) VALUES ($id, '$namaFile')");
    //         }
    //     }
    // }

    if (!empty($_FILES['gambar']['name'])) {
    $extension = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
    $namaFileBaru = uniqid('img_') . '.' . $extension;

    $targetDir = "../../upload/";
    $targetFile = $targetDir . $namaFileBaru;

        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $targetFile)) {
            // Cek apakah gambar lama ada
            $cek = mysqli_query($conn, "SELECT * FROM gambar_produk WHERE id_produk = $id");
            if (mysqli_num_rows($cek) > 0) {
                $row = mysqli_fetch_assoc($cek);
                $oldFile = $targetDir . $row['nama_file'];
                if (file_exists($oldFile)) {
                    unlink($oldFile);
                }
                // Update record gambar
                mysqli_query($conn, "UPDATE gambar_produk SET nama_file = '$namaFileBaru' WHERE id_produk = $id");
            } else {
                // Insert baru
                mysqli_query($conn, "INSERT INTO gambar_produk (id_produk, nama_file) VALUES ($id, '$namaFileBaru')");
            }
        }
    }


    header("Location: ../../dashboard/admin/produk.php");
    exit;
}
