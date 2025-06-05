<?php
require_once 'config/dbConnection.php';
require_once 'authentication/auth.php';
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Log Produk - Geraifone</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" />
    <link rel="icon" href="img/logo.png" type="image/png">
    <link rel="stylesheet" href="css/dashboard.css" />
</head>
<body>

    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="img\logo.png" alt="Logo" class="logo-img">
                <span class="logo-text">Geraifone</span>
            </div>
            <nav>
                <a href="dashboard.php"><ion-icon name="grid-outline"></ion-icon> Dashboard</a>
                <a href="produk.php"><ion-icon name="bag-outline"></ion-icon> Produk</a>
                <a href="kategoriProduk.php"><ion-icon name="albums-outline"></ion-icon> Kategori Produk</a>
                <a href="transaksi.php"><ion-icon name="cart-outline"></ion-icon> Transaksi</a>
                <a href="logproduk.php"  class="active"><ion-icon name="time-outline"></ion-icon> Riwayat Log Produk</a>
            </nav>
            <form action="logout.php" method="post" onsubmit="return confirm('Yakin ingin logout?')" style="width: 100%;">
                <button type="submit" class="logout-btn"><ion-icon name="log-out-outline"></ion-icon>Logout</button>
            </form>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <h2>Riwayat Log Produk</h2>
            </div>
        </main>
    </div>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>
