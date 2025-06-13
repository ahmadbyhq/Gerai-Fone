<?php


// $host     = "srv1410.hstgr.io";
// $user     = "u725894752_admingeraifone";
// $password = "AdminGeraifone123";
// $dbname   = "u725894752_geraifone";

$host     = "srv1410.hstgr.io";
$user     = "u725894752_geraiFone";
$password = "Admingeraifone123;";
$dbname   = "u725894752_geraifone_rpl";

// Membuat koneksi ke database
$conn = new mysqli($host, $user, $password, $dbname);

// Cek apakah koneksi berhasil
if ($conn->connect_error) {
    die("Koneksi database gagal: " . $conn->connect_error);
}


$conn->set_charset("utf8mb4");
?>
