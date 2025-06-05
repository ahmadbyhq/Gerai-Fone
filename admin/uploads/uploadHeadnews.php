<?php
session_start();
require_once '../../config/dbconnection.php';

$success = '';
$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Folder khusus headnews
    $folder = "headnews";
    $lokasiUp = "../../img/collectionImg/$folder/";

    // Buat folder kalau belum ada
    if (!file_exists($lokasiUp)) {
        mkdir($lokasiUp, 0777, true);
    }

    // Ambil nama file baru (unik berdasarkan waktu)
    $namaFile = time() . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $lokasiUp . $namaFile;
    $link = !empty($_POST["link"]) ? $_POST["link"] : null;
    $kategori = "headnews"; // fokus kategori headnews

    // Upload file
    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Simpan data ke database
        $stmt = $conn->prepare("INSERT INTO upload_gambar (kategori, image_path, link_url) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $kategori, $targetFile, $link);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            $success = "Gambar berhasil diupload!";
        } else {
            $error = "Gagal menyimpan data ke database.";
        }
    } else {
        $error = "Gagal mengunggah gambar.";
    }

    // Redirect ke headnews.php dengan pesan
    header("Location: ../../dashboard/admin/headnews.php?success=" . urlencode($success) . "&error=" . urlencode($error));
    exit;
}
?>
