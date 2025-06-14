<?php
require_once('../../config/dbConnection.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = (int) $_POST['id_user'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $jenis_kelamin = $_POST['jenis_kelamin'];
    $no_hp = $_POST['no_hp'];
    $alamat = $_POST['alamat'];

    $query = "UPDATE user SET 
                nama = '$nama', 
                email = '$email', 
                jenis_kelamin = '$jenis_kelamin', 
                no_hp = '$no_hp', 
                alamat = '$alamat' 
                WHERE id_user = $id";

    if (mysqli_query($conn, $query)) {
        header('Location: ../../dashboard/admin/pelanggan.php?updated=1');
        exit;
    } else {
        header('Location: ../../dashboard/admin/pelanggan.php?updated=0');
        exit;
    }
}
