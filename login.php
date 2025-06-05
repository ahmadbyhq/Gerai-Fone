<?php
session_start();
require_once 'config/dbConnection.php';

$loginError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email && $password) {
        $stmt = $conn->prepare("SELECT id_user, email, password FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            // Verifikasi password hash
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id_user'];
                $_SESSION['email'] = $user['email'];
                header("Location: dashboard.php");
                exit;
            } else {
                $loginError = "Password salah.";
            }
        } else {
            $loginError = "Email tidak ditemukan.";
        }
        $stmt->close();
    } else {
        $loginError = "Semua field harus diisi.";
    }
}
?>



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Geraifone - Login</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" />
    <link rel="icon" href="img/logo.png" type="image/png">
    <link rel="stylesheet" href="css/style.css" />
</head>

<body>

    <div class="container-login">
        <form method="POST" class="login-form">
            <h2>Masuk</h2>

            <label for="loginEmail">Email</label>
            <input type="email" id="loginEmail" name="email" placeholder="Masukkan email" required />

            <label for="loginPassword">Password</label>
            <input type="password" id="loginPassword" name="password" placeholder="Masukkan password" required minlength="6" />

            <?php if (!empty($loginError)): ?>
                <p class="login-error"><?php echo htmlspecialchars($loginError); ?></p>
            <?php endif; ?>
            
            <button type="submit">Masuk</button>

            <p class="register-link">Belum punya akun? <a href="register.php">Daftar</a></p>
        </form>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>

</html>
