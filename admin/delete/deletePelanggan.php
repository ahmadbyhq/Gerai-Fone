<?php
require_once(__DIR__ . '/../../config/dbConnection.php');

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];
    $stmt = $conn->prepare("DELETE FROM user WHERE id_user = ? AND role = 'pelanggan'");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header('Location: ../../dashboard/admin/pelanggan.php?deleted=1');
    } else {
        header('Location: ../../dashboard/admin/pelanggan.php?error=' . urlencode($stmt->error));
    }
    exit;
}

