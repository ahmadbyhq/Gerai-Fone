<?php
session_start();
require_once(__DIR__ . '/../../config/dbConnection.php');

$registerError = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = trim($_POST['nama']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validasi sederhana
    if (empty($nama) || empty($email) || empty($password)) {
        $registerError = "Semua field wajib diisi.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $registerError = "Format email tidak valid.";
    } elseif (strlen($password) < 6) {
        $registerError = "Password minimal 6 karakter.";
    } else {
        // Cek apakah email sudah terdaftar
        $check = $conn->prepare("SELECT id_user FROM user WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $checkResult = $check->get_result();

        if ($checkResult->num_rows > 0) {
            $registerError = "Email sudah terdaftar.";
        } else {
            // Hash password sebelum simpan
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Simpan user baru
            $stmt = $conn->prepare("INSERT INTO user (nama, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nama, $email, $hashedPassword);

            if ($stmt->execute()) {
                $_SESSION['user_id'] = $stmt->insert_id;
                $_SESSION['email'] = $email;
                $_SESSION['LAST_ACTIVITY'] = time();
                header("Location: dashboard.php");
                exit;
            } else {
                $registerError = "Gagal menyimpan data pengguna.";
            }

            $stmt->close();
        }

        $check->close();
    }
}
?>



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Geraifone - Register</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="icon" href="../../img/logo.png" type="image/png">
    <link rel="stylesheet" href="../../css/style.css" />
</head>

<body>

    <!-- Register Form -->
    <div class="container-register">
        <form class="register-form" method="POST" action="register.php" novalidate>
            <h2>Daftar</h2>

            <label for="registerName">Nama</label>
            <input type="text" name="nama" id="registerName" placeholder="Masukkan nama" required>

            <label for="registerEmail">Email</label>
            <input type="email" name="email" id="registerEmail" placeholder="Masukkan email" required>

            <label for="registerPassword">Password</label>
            <input type="password" name="password" id="registerPassword" placeholder="Masukkan password" required minlength="6">

            <?php if (!empty($registerError)) : ?>
                <p class="register-error"><?= $registerError ?></p>
            <?php endif; ?>
            
            <button type="submit">Daftar</button>

            <p class="login-link">Sudah punya akun? <a href="login.php">Login</a></p>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>

</html>
