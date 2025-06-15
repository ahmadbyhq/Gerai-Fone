<?php
require_once(__DIR__ . '/../../config/dbConnection.php');
require_once(__DIR__ . '/../../authentication/auth.php');

// Total Pendapatan (dari semua transaksi)
$q1 = mysqli_query($conn, "SELECT SUM(total_harga) AS total_pendapatan FROM transaksi");
$dataPenjualan['total_pendapatan'] = mysqli_fetch_assoc($q1)['total_pendapatan'] ?? 0;

// Jumlah Transaksi
$q2 = mysqli_query($conn, "SELECT COUNT(*) AS jumlah_transaksi FROM transaksi");
$dataPenjualan['jumlah_transaksi'] = mysqli_fetch_assoc($q2)['jumlah_transaksi'] ?? 0;

// Produk Terjual (total semua item di transaksi_detail)
$q3 = mysqli_query($conn, "SELECT SUM(jumlah) AS total_produk FROM detail_transaksi");
$dataProdukTerjual['total_produk'] = mysqli_fetch_assoc($q3)['total_produk'] ?? 0;

// Jumlah Pelanggan Unik yang Pernah Bertransaksi
$q4 = mysqli_query($conn, "SELECT COUNT(DISTINCT id_pelanggan) AS jumlah_pelanggan FROM transaksi");
$dataPelanggan['jumlah_pelanggan'] = mysqli_fetch_assoc($q4)['jumlah_pelanggan'] ?? 0;

// Ambil 10 transaksi terbaru
$sqlTransaksi = "SELECT t.id_transaksi, p.nama_pelanggan, t.total_harga, t.tanggal_transaksi
                 FROM transaksi t 
                 JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan 
                 ORDER BY t.tanggal_transaksi DESC 
                 LIMIT 10";
$resultTransaksi = mysqli_query($conn, $sqlTransaksi);

// Ambil 3 produk terlaris
$sqlProdukTerlaris = "SELECT 
    p.nama_produk,
    p.harga_produk,
    SUM(dt.jumlah) AS total_terjual
FROM detail_transaksi dt
JOIN produk p ON dt.id_produk = p.id_produk
GROUP BY dt.id_produk, p.nama_produk, p.harga_produk
ORDER BY total_terjual DESC
LIMIT 3
";
$resultProdukTerlaris = mysqli_query($conn, $sqlProdukTerlaris);

// Ambil 3 pelanggan terbaru berdasarkan transaksi
$sqlPelangganBaru = "SELECT p.nama_pelanggan, MAX(t.tanggal_transaksi) AS tanggal_transaksi, 
       SUM(t.total_harga) AS total_harga
FROM transaksi t
JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
GROUP BY t.id_pelanggan
ORDER BY tanggal_transaksi DESC
LIMIT 3";
$resultPelangganBaru = mysqli_query($conn, $sqlPelangganBaru);

$pelangganBaruData = [];
while($row = mysqli_fetch_assoc($resultPelangganBaru)) {
    $pelangganBaruData[] = $row;
}

$no = 1;
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard - Geraifone</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="icon" href="../../img/logo.png" type="image/png">
    <link rel="stylesheet" href="../../css/dashboard.css" />
</head>
<body>

    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="../../img/logo.png" alt="Logo" class="logo-img">
                <span class="logo-text">Geraifone</span>
            </div>
            <nav>
                <a href="dashboard.php" class="active"><ion-icon name="grid-outline"></ion-icon> Dashboard</a>
                <a href="produk.php"><ion-icon name="bag-outline"></ion-icon> Produk</a>
                <a href="pelanggan.php"><ion-icon name="people-outline"></ion-icon> Pelanggan </a>
                <a href="transaksi.php"><ion-icon name="cart-outline"></ion-icon> Transaksi</a>
                <a href="laporan.php"><ion-icon name="time-outline"></ion-icon> Laporan Penjualan</a>
                <!-- <a href="headnews.php"><ion-icon name="images-outline"></ion-icon> Headnews</a> -->
            </nav>
            <form action="logout.php" method="post" onsubmit="return confirm('Yakin ingin logout?')" style="width: 100%;">
                <button type="submit" class="logout-btn"><ion-icon name="log-out-outline"></ion-icon>Logout</button>
            </form>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <h2>Dashboard</h2>
            </div>

            <div class="container-fluid px-4 mt-4">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-3">
                    <!-- Total Pendapatan -->
                    <div class="col">
                        <div class="cardLaporan">
                            <div class="cardLaporan-content">
                                <ion-icon name="cash-outline" class="cardLaporan-icon"></ion-icon>
                                <p class="cardLaporan-value">
                                    Rp <?= number_format($dataPenjualan['total_pendapatan'] ?? 0, 0, ',', '.') ?>
                                </p>
                            </div>
                            <div class="cardLaporan-label-area">Total Pendapatan</div>
                        </div>
                    </div>

                    <!-- Jumlah Penjualan -->
                    <div class="col">
                        <div class="cardLaporan">
                            <div class="cardLaporan-content">
                                <ion-icon name="cart-outline" class="cardLaporan-icon"></ion-icon>
                                <p class="cardLaporan-value">
                                    <?= $dataPenjualan['jumlah_transaksi'] ?? 0 ?> Transaksi
                                </p>
                            </div>
                            <div class="cardLaporan-label-area">Jumlah Penjualan</div>
                        </div>
                    </div>

                    <!-- Produk Terjual -->
                    <div class="col">
                        <div class="cardLaporan">
                            <div class="cardLaporan-content">
                                <ion-icon name="cube-outline" class="cardLaporan-icon"></ion-icon>
                                <p class="cardLaporan-value">
                                    <?= $dataProdukTerjual['total_produk'] ?? 0 ?> Item
                                </p>
                            </div>
                            <div class="cardLaporan-label-area">Produk Terjual</div>
                        </div>
                    </div>

                    <!-- Pelanggan yang Telah Membeli -->
                    <div class="col">
                        <div class="cardLaporan">
                            <div class="cardLaporan-content">
                                <ion-icon name="people-outline" class="cardLaporan-icon"></ion-icon>
                                <p class="cardLaporan-value">
                                    <?= $dataPelanggan['jumlah_pelanggan'] ?? 0 ?> Pelanggan
                                </p>
                            </div>
                            <div class="cardLaporan-label-area">Pelanggan Membeli</div>
                        </div>
                    </div>
                </div>
            </div>


             <div class="content-container px-4 my-5">
                <div class="table-responsive bg-white rounded-3 shadow p-4">
                    <h5 class="mb-3">10 Transaksi Terbaru</h5>
                    <table class="table align-middle table-striped table-hover table-bordered">
                        <thead class="table-secondary text-center">
                            <tr>
                                <th>No</th>
                                <th>ID Transaksi</th>
                                <th>Nama Pelanggan</th>
                                <th>Total</th>
                                <th>Tanggal</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php if (mysqli_num_rows($resultTransaksi) > 0): ?>
    <?php while ($row = mysqli_fetch_assoc($resultTransaksi)): ?>
                                <tr>
                                    <td class="text-center"><?= $no++ ?></td>
                                    <td class="text-center"><?= $row['id_transaksi'] ?></td>
                                    <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                    <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
                                    <td><?= date('d-m-Y H:i', strtotime($row['tanggal_transaksi'])) ?></td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr><td colspan="5" class="text-center">Tidak ada data transaksi.</td></tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

           <div class="row mt-4 px-4">
  <!-- Produk Terlaris -->
  <div class="col-md-6 mb-4">
    <div class="table-responsive bg-white rounded-3 shadow p-4 h-100">
      <h5 class="mb-3">Produk Terlaris</h5>
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-secondary text-center">
          <tr>
            <th>No</th>
            <th>Nama Produk</th>
            <th>Harga</th>
            <th>Terjual</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          mysqli_data_seek($resultProdukTerlaris, 0); // Reset pointer (jika sebelumnya sudah di-loop)
          while ($row = mysqli_fetch_assoc($resultProdukTerlaris)): ?>
            <tr>
              <td class="text-center"><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['nama_produk']) ?></td>
              <td>Rp <?= number_format($row['harga_produk'], 0, ',', '.') ?></td>
              <td class="text-center"><?= $row['total_terjual'] ?> unit</td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pelanggan Terbaru -->
  <div class="col-md-6 mb-4">
    <div class="table-responsive bg-white rounded-3 shadow p-4 h-100">
      <h5 class="mb-3">Pelanggan Terbaru</h5>
      <table class="table table-bordered table-hover align-middle">
        <thead class="table-secondary text-center">
          <tr>
            <th>No</th>
            <th>Nama Pelanggan</th>
            <th>Tanggal Transaksi</th>
            <th>Total Belanja</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $no = 1;
          foreach ($pelangganBaruData as $row): ?>
            <tr>
              <td class="text-center"><?= $no++ ?></td>
              <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
              <td class="text-center"><?= date('d M Y', strtotime($row['tanggal_transaksi'])) ?></td>
              <td>Rp <?= number_format($row['total_harga'], 0, ',', '.') ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

        </main>
    </div>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>
</html>
