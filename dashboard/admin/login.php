<?php

session_start();
require_once(__DIR__ . '/../../config/dbConnection.php');

$loginError = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($email && $password) {
        $stmt = $conn->prepare("SELECT id_user, email, password, role FROM user WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                // cek role admin
                if ($user['role'] === 'admin') {
                    $_SESSION['user_id'] = $user['id_user'];
                    $_SESSION['email'] = $user['email'];
                    $_SESSION['role'] = $user['role'];
                    $_SESSION['LAST_ACTIVITY'] = time();
                    header("Location: dashboard.php");
                    exit;
                } else {
                    $loginError = "Email atau Password salah.";
                }
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="icon" href="../../img/logo.png" type="image/png">
    <link rel="stylesheet" href="../../css/style.css" />
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

            <!-- <p class="register-link">Belum punya akun? <a href="register.php">Daftar</a></p> -->
        </form>
    </div>

    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>

</html>
