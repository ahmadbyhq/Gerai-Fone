<?php
// Memuat koneksi database dan autentikasi
require_once(__DIR__ . '/../../config/dbConnection.php');  // Pastikan koneksi database sudah dimuat
require_once(__DIR__ . '/../../authentication/auth.php');  // Pastikan autentikasi sudah dimuat

// Mengecek apakah parameter 'id' ada di URL
if (isset($_POST['id_pelanggan']) && is_numeric($_POST['id_pelanggan'])) {
    // Mendapatkan ID pelanggan yang akan diperbarui
    $id_pelanggan = $_POST['id_pelanggan'];

    // Mengecek apakah form sudah disubmit (POST)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update'])) {
        // Mendapatkan data dari form
        $nama_pelanggan = $_POST['nama_pelanggan'];
        $no_hp = $_POST['no_hp'];
        $alamat = $_POST['alamat'];

        // Menyiapkan query untuk memperbarui data pelanggan
        $updateQuery = "UPDATE pelanggan SET nama_pelanggan = ?, no_hp = ?, alamat = ? WHERE id_pelanggan = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param("sssi", $nama_pelanggan, $no_hp, $alamat, $id_pelanggan); // Mengikat parameter

        // Mengeksekusi query
        if ($stmt->execute()) {
            // Jika berhasil, arahkan ke halaman pelanggan.php
            echo "<script>
                    alert('Pelanggan berhasil diperbarui!');
                    window.location.href = '../../dashboard/admin/pelanggan.php';  
                  </script>";
        } else {
            // Jika gagal memperbarui data, tampilkan pesan error
            echo "<script>
                    alert('Gagal memperbarui pelanggan: " . $stmt->error . "');
                    window.location.href = '../../dashboard/admin/pelanggan.php';  
                  </script>";
        }

        // Menutup prepared statement
        $stmt->close();
    }
} else {
    // Jika parameter 'id' tidak ada atau tidak valid
    echo "<script>
            alert('ID pelanggan tidak valid!');
            window.location.href = '../../dashboard/admin/pelanggan.php';  
          </script>";
    exit;
}
?>
