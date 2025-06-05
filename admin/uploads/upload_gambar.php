<?php
session_start();
require_once '../../config/dbconnection.php';
require_once '../../authentication/auth.php';

$success = $error = '';

// Ambil parameter dari URL
$kategori = isset($_GET['kategori']) ? $_GET['kategori'] : 'umum';  // default: 'umum'
$redirect = isset($_GET['redirect']) ? $_GET['redirect'] : null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $folder = isset($_GET['folder']) ? $_GET['folder'] : 'tidak_berkategori';
    $lokasiUp = "../../img/collectionImg/$folder/";
    
    
    if (!file_exists($lokasiUp)) {
        mkdir($lokasiUp, 0777, true);
    }

    $namaFile = time() . "_" . basename($_FILES["image"]["name"]);
    $targetFile = $lokasiUp . $namaFile;
    $link = !empty($_POST["link"]) ? $_POST["link"] : null;

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        $stmt = $conn->prepare("INSERT INTO upload_gambar (kategori, image_path, link_url) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $kategori, $targetFile, $link);
        $stmt->execute();

        if ($redirect) {
            header("Location: $redirect?success=" . urlencode($success));
            exit;
        }
    } else {
        $error = "Gagal mengunggah gambar.";
    }
}
?>
