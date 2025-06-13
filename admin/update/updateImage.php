<?php
require_once '../../config/dbConnection.php';

$id_produk = (int)$_POST['id_produk'];
$old_file  = basename($_POST['old_file']);
$new_image = $_FILES['new_image'];
$upload_dir = "../../upload/";

if ($new_image['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($new_image['name'], PATHINFO_EXTENSION);
    $new_filename = uniqid() . '.' . $ext;
    $new_path = $upload_dir . $new_filename;

    // Simpan file baru
    if (move_uploaded_file($new_image['tmp_name'], $new_path)) {
        // Update DB
        mysqli_query($conn, "UPDATE gambar_produk SET nama_file = '$new_filename' WHERE nama_file = '$old_file' AND id_produk = $id_produk");

        // Hapus file lama
        $old_path = $upload_dir . $old_file;
        if (file_exists($old_path)) {
            unlink($old_path);
        }
    }
}

header("Location: ../../dashboard/admin/produk.php?id=$id_produk&msg=updated");
exit;
