<?php
require_once '../../config/dbConnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idProduk = (int)($_POST['id_produk'] ?? 0);

    // Validasi
    if ($idProduk <= 0 || !isset($_FILES['gambar']) || $_FILES['gambar']['error'] !== UPLOAD_ERR_OK) {
        $errorAddGambar = "Data tidak lengkap atau format salah.";
        exit;
    }

    // Proses Upload
    $uploadDir = __DIR__ . '/../../upload/';
    $originalName = $_FILES['gambar']['name'];
    $ext = pathinfo($originalName, PATHINFO_EXTENSION);
    $uniqueName = uniqid('img_', true) . '.' . $ext;
    $uniqueName = preg_replace('/[^a-zA-Z0-9_\.-]/', '', $uniqueName);
    $uploadPath = $uploadDir . $uniqueName;

    if (move_uploaded_file($_FILES['gambar']['tmp_name'], $uploadPath)) {
        // Simpan ke database
        $stmt = $conn->prepare("INSERT INTO gambar_produk (id_produk, nama_file) VALUES (?, ?)");
        $stmt->bind_param("is", $idProduk, $uniqueName);
        if ($stmt->execute()) {
            header("Location: ../../dashboard/admin/produk.php?success=1");
            exit;
        } else {
            $errorAddGambar = "Gagal simpan ke database.";
            header("Location: ../../dashboard/admin/produk.php?error=" . urlencode($errorAddGambar));
            exit;
        }
    } else {
        $errorAddGambar = "Upload gagal.";
        header("Location: ../../dashboard/admin/produk.php?error=" . urlencode($errorAddGambar));
        exit;
    }
} else {
    $errorAddGambar = "Metode tidak diizinkan.";
    header("Location: ../../dashboard/admin/produk.php?error=" . urlencode($errorAddGambar));
    exit;
}
?>
