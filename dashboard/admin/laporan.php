<?php
require_once(__DIR__ . '/../../config/dbConnection.php');
require_once(__DIR__ . '/../../authentication/auth.php');
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Laporan Penjualan - Geraifone</title>
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
                <a href="dashboard.php"><ion-icon name="grid-outline"></ion-icon> Dashboard</a>
                <a href="produk.php"><ion-icon name="bag-outline"></ion-icon> Produk</a>
                <a href="pelanggan.php"><ion-icon name="people-outline"></ion-icon> Pelanggan </a>
                <a href="transaksi.php"><ion-icon name="cart-outline"></ion-icon> Transaksi</a>
                <a href="laporan.php"  class="active"><ion-icon name="time-outline"></ion-icon> Laporan Penjualan</a>
                <!-- <a href="headnews.php"><ion-icon name="images-outline"></ion-icon> Headnews</a> -->
            </nav>
            <form action="logout.php" method="post" onsubmit="return confirm('Yakin ingin logout?')" style="width: 100%;">
                <button type="submit" class="logout-btn"><ion-icon name="log-out-outline"></ion-icon>Logout</button>
            </form>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <h2>Laporan Penjualan</h2>
            </div>

            <?php
            // Ambil tanggal mulai dan akhir sebelum form ditampilkan
            $tanggalMulai = $_GET['tanggal_mulai'] ?? date('Y-m-01');
            $tanggalAkhir = $_GET['tanggal_akhir'] ?? date('Y-m-d');

            $dataTanggal = [];
            $dataPendapatan = [];

            $queryGrafik = "
                SELECT DATE(tanggal_transaksi) AS tanggal, SUM(total_harga) AS total
                FROM transaksi
                WHERE DATE(tanggal_transaksi) BETWEEN '$tanggalMulai' AND '$tanggalAkhir'
                AND status_pembayaran = 'Dibayar'
                GROUP BY DATE(tanggal_transaksi)
                ORDER BY tanggal ASC
            ";

            $resultGrafik = mysqli_query($conn, $queryGrafik);
            while ($row = mysqli_fetch_assoc($resultGrafik)) {
                $dataTanggal[] = $row['tanggal'];
                $dataPendapatan[] = $row['total'];
            }

            // Total penjualan
            $queryPenjualan = "
                SELECT COUNT(*) AS jumlah_transaksi, SUM(total_harga) AS total_pendapatan
                FROM transaksi
                WHERE DATE(tanggal_transaksi) BETWEEN '$tanggalMulai' AND '$tanggalAkhir'
                AND status_pembayaran = 'Dibayar'
            ";
            $resultPenjualan = mysqli_query($conn, $queryPenjualan);
            $dataPenjualan = mysqli_fetch_assoc($resultPenjualan);

            // Total produk terjual
            $queryProdukTerjual = "
                SELECT SUM(dt.jumlah) AS total_produk
                FROM detail_transaksi dt
                JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
                WHERE DATE(t.tanggal_transaksi) BETWEEN '$tanggalMulai' AND '$tanggalAkhir'
                AND t.status_pembayaran = 'Dibayar'
            ";
            $resultProdukTerjual = mysqli_query($conn, $queryProdukTerjual);
            $dataProdukTerjual = mysqli_fetch_assoc($resultProdukTerjual);

            // Pelanggan aktif
            $queryPelangganAktif = "
                SELECT COUNT(DISTINCT id_pelanggan) AS pelanggan_aktif
                FROM transaksi
                WHERE DATE(tanggal_transaksi) BETWEEN '$tanggalMulai' AND '$tanggalAkhir'
                AND status_pembayaran = 'Dibayar'
            ";
            $resultPelangganAktif = mysqli_query($conn, $queryPelangganAktif);
            $dataPelangganAktif = mysqli_fetch_assoc($resultPelangganAktif);

            // --- LOGIKA PAGINASI BARU UNTUK TABEL PRODUK TERLARIS ---
            $limit = 5; // Jumlah item per halaman
            $page = isset($_GET['page_produk']) ? (int)$_GET['page_produk'] : 1; // Menggunakan 'page_produk' untuk menghindari konflik dengan paginasi lain jika ada
            $offset = ($page - 1) * $limit;

            // Query untuk menghitung total produk terjual (tanpa limit)
            $queryCountProdukTerjualDetail = "
                SELECT COUNT(DISTINCT p.id_produk) AS total_rows
                FROM detail_transaksi dt
                JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
                JOIN produk p ON dt.id_produk = p.id_produk
                WHERE DATE(t.tanggal_transaksi) BETWEEN '$tanggalMulai' AND '$tanggalAkhir'
                AND t.status_pembayaran = 'Dibayar'
            ";
            $resultCountProdukTerjualDetail = mysqli_query($conn, $queryCountProdukTerjualDetail);
            $rowCountProdukTerjualDetail = mysqli_fetch_assoc($resultCountProdukTerjualDetail);
            $totalProdukRows = $rowCountProdukTerjualDetail['total_rows'];

            // Hitung total halaman
            $totalPagesProduk = ceil($totalProdukRows / $limit);

            // Pastikan halaman tidak kurang dari 1 atau lebih dari total halaman
            if ($page < 1) {
                $page = 1;
            }
            if ($page > $totalPagesProduk && $totalPagesProduk > 0) {
                $page = $totalPagesProduk;
            } elseif ($totalPagesProduk == 0) { // Jika tidak ada data sama sekali
                $page = 1;
            }


            // Produk terlaris (dengan LIMIT dan OFFSET)
            $queryProdukTerjualDetail = "
                SELECT
                    p.nama_produk,
                    SUM(dt.jumlah) AS jumlah_terjual,
                    SUM(dt.subtotal) AS total_pendapatan
                FROM detail_transaksi dt
                JOIN transaksi t ON dt.id_transaksi = t.id_transaksi
                JOIN produk p ON dt.id_produk = p.id_produk
                WHERE DATE(t.tanggal_transaksi) BETWEEN '$tanggalMulai' AND '$tanggalAkhir'
                AND t.status_pembayaran = 'Dibayar'
                GROUP BY dt.id_produk
                ORDER BY jumlah_terjual DESC
                LIMIT $limit OFFSET $offset
            ";
            $resultProdukTerjualDetail = mysqli_query($conn, $queryProdukTerjualDetail);

            ?>

            <div class="container-fluid sticky-top px-3 py-2 rounded-3 shadow bg-white" style="top: 70px; z-index: 999;">
                <div class="row gy-2 px-3 py-2 align-items-center">
                    <form method="GET" class="row gx-2 align-items-end">

                        <!-- Label & Input Tanggal Mulai -->
                        <div class="col-md-5">
                            <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border border-1 border-secondary">
                                    <ion-icon name="calendar-outline"></ion-icon>
                                </span>
                                <input type="date" class="form-control border border-1 border-secondary"
                                    id="tanggal_mulai" name="tanggal_mulai"
                                    value="<?= htmlspecialchars($_GET['tanggal_mulai'] ?? date('Y-m-01')) ?>">
                            </div>
                        </div>

                        <!-- Label & Input Tanggal Akhir -->
                        <div class="col-md-5">
                            <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border border-1 border-secondary">
                                    <ion-icon name="calendar-outline"></ion-icon>
                                </span>
                                <input type="date" class="form-control border border-1 border-secondary"
                                    id="tanggal_akhir" name="tanggal_akhir"
                                    value="<?= htmlspecialchars($_GET['tanggal_akhir'] ?? date('Y-m-d')) ?>">
                            </div>
                        </div>

                        <!-- Tombol Terapkan Filter -->
                        <div class="col-md-2 d-grid">
                            <label class="form-label invisible">Terapkan</label> <!-- untuk jaga perataan -->
                            <button type="submit" class="btn primary-btn add-product-btn w-100 p-2 fw-semibold">
                                Terapkan Filter
                            </button>
                        </div>
                    </form>
                </div>
            </div>

                    <div class="container-fluid px-4 mt-5">
                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 mt-4 mb-2 g-3">
                            <div class="col">
                                <div class="cardLaporan">
                                    <div class="cardLaporan-content">
                                        <ion-icon name="cash-outline" class="cardLaporan-icon"></ion-icon>
                                        <p class="cardLaporan-value">Rp <?= number_format($dataPenjualan['total_pendapatan'] ?? 0, 0, ',', '.') ?></p>
                                    </div>
                                    <div class="cardLaporan-label-area">
                                        Total Pendapatan
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="cardLaporan">
                                    <div class="cardLaporan-content">
                                        <ion-icon name="cart-outline" class="cardLaporan-icon"></ion-icon>
                                        <p class="cardLaporan-value"><?= $dataPenjualan['jumlah_transaksi'] ?> Transaksi</p>
                                    </div>
                                    <div class="cardLaporan-label-area">
                                        Jumlah Penjualan
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="cardLaporan">
                                    <div class="cardLaporan-content">
                                        <ion-icon name="cube-outline" class="cardLaporan-icon"></ion-icon>
                                        <p class="cardLaporan-value"><?= $dataProdukTerjual['total_produk'] ?? 0 ?> Item</p>
                                    </div>
                                    <div class="cardLaporan-label-area">
                                        Produk Terjual
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="cardLaporan">
                                    <div class="cardLaporan-content">
                                        <ion-icon name="people-outline" class="cardLaporan-icon"></ion-icon>
                                        <p class="cardLaporan-value"><?= $dataPelangganAktif['pelanggan_aktif'] ?? 0 ?> Orang</p>
                                    </div>
                                    <div class="cardLaporan-label-area">
                                        Pelanggan Aktif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <!-- Card Penjualan Produk -->
                <div class="content-container px-4 my-5">
                    <div class="table-responsive rounded-3 overflow-hidden bg-white p-4">
                        <h5 class="mb-3">Penjualan Produk</h5>
                        <table class="table align-middle table-striped table-hover table-bordered">
                            <thead class="table-secondary text-center align-middle">
                                <tr>
                                    <th style="width: 5%;">No</th>
                                    <th>Nama Produk</th>
                                    <th style="width: 15%;">Jumlah Terjual</th>
                                    <th style="width: 20%;">Total Pendapatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // Hitung nomor urut awal untuk halaman saat ini
                                $no_urut_awal = ($page - 1) * $limit + 1;
                                if (mysqli_num_rows($resultProdukTerjualDetail) > 0):
                                    $no = $no_urut_awal;
                                    while ($row = mysqli_fetch_assoc($resultProdukTerjualDetail)): ?>
                                        <tr>
                                            <td><?= $no++ ?></td>
                                            <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                                            <td class="text-center"><?= $row['jumlah_terjual'] ?></td>
                                            <td>Rp <?= number_format($row['total_pendapatan'], 0, ',', '.') ?></td>
                                        </tr>
                                    <?php endwhile;
                                else: ?>
                                    <tr><td colspan="4" class="text-center">Tidak ada produk terjual dalam periode ini.</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>

                        <?php if ($totalPagesProduk >= 1): ?> <nav aria-label="Page navigation for products">
                                <ul class="pagination justify-content-center mt-4">

                                    <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                        <a class="page-link d-flex align-items-center justify-content-center"
                                        href="?<?= http_build_query(array_merge($_GET, ['page_produk' => $page - 1])) ?>">
                                            <ion-icon name="chevron-back-outline"></ion-icon>
                                        </a>
                                    </li>

                                    <?php for ($i = 1; $i <= $totalPagesProduk; $i++): ?>
                                        <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                                            <a class="page-link d-flex align-items-center justify-content-center"
                                            href="?<?= http_build_query(array_merge($_GET, ['page_produk' => $i])) ?>">
                                                <?= $i ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>

                                    <li class="page-item <?= ($page >= $totalPagesProduk) ? 'disabled' : '' ?>">
                                        <a class="page-link d-flex align-items-center justify-content-center"
                                        href="?<?= http_build_query(array_merge($_GET, ['page_produk' => $page + 1])) ?>">
                                            <ion-icon name="chevron-forward-outline"></ion-icon>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        <?php endif; ?>
                    </div>
                 </div>
            
                <!-- Grafik Penjualan -->
                <!-- <div class="container-fluid px-4">
                    <div class="card shadow-sm mb-4 mt-5">
                        <h5 class="mb-3 ">Grafik Penjualan Harian</h5>
                        <canvas id="grafikPenjualan" height="150px" width="100%"></canvas>
                    </div>
                </div> -->
        </main>
    </div>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('grafikPenjualan').getContext('2d');

        const chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?= json_encode($dataTanggal) ?>,
                datasets: [{
                    label: 'Pendapatan (Rp)',
                    data: <?= json_encode($dataPendapatan) ?>,
                    fill: true,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 2,
                    tension: 0.3
                }]
            },
            options: {
                scales: {
                    y: {
                        ticks: {
                            callback: function(value) {
                                return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                            }
                        },
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>
</html>
