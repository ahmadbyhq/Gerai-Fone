<?php
// Memuat koneksi database dan autentikasi
require_once(__DIR__ . '/../../config/dbConnection.php');  // Pastikan koneksi database sudah dimuat
require_once(__DIR__ . '/../../authentication/auth.php');  // Pastikan autentikasi sudah dimuat

// Mengecek apakah parameter 'id' ada di URL
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    // Mendapatkan ID pelanggan yang akan dihapus
    $id_pelanggan = $_GET['id'];

    // Menyiapkan query untuk menghapus pelanggan berdasarkan ID
    $deleteQuery = "DELETE FROM pelanggan WHERE id_pelanggan = ?";
    
    // Menyiapkan statement
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $id_pelanggan);  // Mengikat parameter ID sebagai integer
    
    // Mengeksekusi query
    if ($stmt->execute()) {
        // Jika berhasil, redirect ke halaman pelanggan dengan pesan sukses
        echo "<script>
                alert('Pelanggan berhasil dihapus!');
                window.location.href = '../../dashboard/admin/pelanggan.php';  // Mengarahkan kembali ke halaman pelanggan
              </script>";
    } else {
        // Jika gagal menghapus, tampilkan pesan error
        echo "<script>
                alert('Gagal menghapus pelanggan: " . $stmt->error . "');
                window.location.href = '../../dashboard/admin/pelanggan.php';  // Kembali ke halaman pelanggan
              </script>";
    }

    // Menutup prepared statement
    $stmt->close();
} else {
    // Jika parameter 'id' tidak valid, redirect ke halaman pelanggan
    echo "<script>
            alert('ID pelanggan tidak valid!');
            window.location.href = 'pelanggan.php';  // Kembali ke halaman pelanggan
          </script>";
}
?>
