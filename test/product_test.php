<?php
require_once(__DIR__ . '/../config/dbConnection.php');
require_once(__DIR__ . '/../authentication/auth.php');
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Produk - Geraifone</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="icon" href="../img/logo.png" type="image/png">
    <link rel="stylesheet" href="../css/dashboard.css" />
</head>

<body>

    <div class="dashboard-container">
        <aside class="sidebar">
            <div class="sidebar-header">
                <img src="\img\logo.png" alt="Logo" class="logo-img">
                <span class="logo-text">Geraifone</span>
            </div>
            <nav>
                <a href="dashboard.php">
                    <ion-icon name="grid-outline"></ion-icon> Dashboard
                </a>
                <a href="produk.php" class="active">
                    <ion-icon name="bag-outline"></ion-icon> Produk
                </a>
                <a href="kategoriProduk.php">
                    <ion-icon name="albums-outline"></ion-icon> Kategori Produk
                </a>
                <a href="transaksi.php">
                    <ion-icon name="cart-outline"></ion-icon> Transaksi
                </a>
                <a href="logproduk.php">
                    <ion-icon name="time-outline"></ion-icon> Riwayat Log Produk
                </a>
                <a href="headnews.php">
                    <ion-icon name="images-outline"></ion-icon> Headnews
                </a>
            </nav>
            <form action="logout.php" method="post" onsubmit="return confirm('Yakin ingin logout?')"
                style="width: 100%;">
                <button type="submit" class="logout-btn">
                    <ion-icon name="log-out-outline"></ion-icon>Logout
                </button>
            </form>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <h2>Produk</h2>
            </div>

            <div class="content-container px-4 py-4">
                <div class="container-fluid my-4 rounded-3 shadow bg-white">
                    <div class="row g-4 px-3 py-3 align-items-center">
                        <form method="GET" id="filterForm" class="row g-4 px-3 py-3 align-items-center">
                            <!-- Input Cari Produk -->
                            <div class="col-md-4 my-0">
                                <div class="input-group p-2">
                                    <span class="input-group-text bg-white border border-1 border-secondary">
                                        <ion-icon name="search-outline"></ion-icon>
                                    </span>
                                    <input type="text" class="form-control border border-1 border-secondary"
                                        placeholder="Cari produk" name="search"
                                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                                </div>
                            </div>

                            <!-- Dropdown Kategori dari DB -->
                            <div class="col-md-3 my-0">
                                <select class="form-select p-2 fw-semibold border border-1 border-secondary"
                                    name="kategori"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <option value="">Semua Kategori</option>
                                    <?php
                                    $resultKategori = mysqli_query($conn, "SELECT kategori FROM kategori_produk ORDER BY kategori ASC");
                                    $kategoriDipilih = $_GET['kategori'] ?? '';
                                    while ($rowKategori = mysqli_fetch_assoc($resultKategori)) {
                                        $kategoriOption = htmlspecialchars($rowKategori['kategori']);
                                        $selected = ($kategoriDipilih === $kategoriOption) ? 'selected' : '';
                                        echo "<option value='$kategoriOption' $selected>$kategoriOption</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Dropdown Status -->
                            <div class="col-md-3 my-0">
                                <select class="form-select p-2 fw-semibold border border-1 border-secondary"
                                    name="status"
                                    onchange="document.getElementById('filterForm').submit()">
                                    <?php
                                    $statusOptions = [
                                        '' => 'Semua Status',
                                        'tersedia' => 'Tersedia',
                                        'menipis' => 'Menipis',
                                        'habis' => 'Habis',
                                    ];
                                    $statusDipilih = $_GET['status'] ?? '';
                                    foreach ($statusOptions as $value => $label) {
                                        $selected = ($statusDipilih === $value) ? 'selected' : '';
                                        echo "<option value='$value' $selected>$label</option>";
                                    }
                                    ?>
                                </select>
                            </div>

                            <!-- Tombol Tambah Produk -->
                            <div class="col-md-2 my-0 text-end">
                                <a href="../../admin/add/addProduct.php"
                                    class="btn primary-btn add-product-btn w-100 p-2 fw-semibold">
                                    Tambah Produk
                                </a>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="table-responsive rounded-3 overflow-hidden shadow bg-white">
                    <table class="table align-middle table-striped table-hover table-bordered">
                        <thead class="table-secondary text-center align-middle">
                            <tr>
                                <th>Nama Produk</th>
                                <!-- <th>Gambar Produk</th> -->
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            // require_once 'config/dbConnection.php';

                            $search   = mysqli_real_escape_string($conn, $_GET['search'] ?? '');
                            $kategori = mysqli_real_escape_string($conn, $_GET['kategori'] ?? '');
                            $status   = $_GET['status'] ?? '';

                            $sql = "
                                SELECT produk.*, kategori_produk.kategori 
                                FROM produk 
                                LEFT JOIN kategori_produk ON produk.id_kategori = kategori_produk.id_kategori
                                WHERE 1
                            ";

                            if ($search !== '') {
                                $sql .= " AND produk.nama_produk LIKE '%$search%'";
                            }
                            if ($kategori !== '') {
                                $sql .= " AND kategori_produk.kategori = '$kategori'";
                            }
                            if ($status !== '') {
                                if ($status === 'habis') {
                                    $sql .= " AND produk.stok = 0";
                                } elseif ($status === 'menipis') {
                                    $sql .= " AND produk.stok > 0 AND produk.stok < 5";
                                } elseif ($status === 'tersedia') {
                                    $sql .= " AND produk.stok >= 5";
                                }
                            }

                            $query = mysqli_query($conn, $sql);


                            while($row = mysqli_fetch_assoc($query)) {
                                // Ambil data
                                $namaProduk = htmlspecialchars($row['nama_produk']);
                                $idProduk   = (int)$row['id_produk'];
                                $kategori   = htmlspecialchars($row['kategori'] ?? 'Lainnya');
                                $harga      = number_format($row['harga_produk'], 0, ',', '.');
                                $stok       = (int)$row['stok'];
                                $gambar     = htmlspecialchars($row['gambar_produk']);

                                // Tentukan status
                                if ($stok <= 0) {
                                    $status = "<span class='badge bg-danger'>Habis</span>";
                                } elseif ($stok < 5) {
                                    $status = "<span class='badge bg-warning text-dark'>Menipis</span>";
                                } else {
                                    $status = "<span class='badge bg-success'>Tersedia</span>";
                                }

                                // Path gambar
                                $gambarPath = "../../upload/" . ($gambar ?: "device.png");

                                echo "
                                <tr>
                                    <td class='text-start align-middle'>
                                        <img src='$gambarPath' alt='$namaProduk'
                                            style='width:50px; height:50px; object-fit:contain; margin-right:20px; margin-left:20px; cursor:pointer;'
                                            data-bs-toggle='modal'
                                            data-bs-target='#imageModal'
                                            onclick=\"document.getElementById('modalImage').src='$gambarPath'\">

                                        <div class='d-inline-block align-middle'>
                                            <div class='fw-semibold'>$namaProduk</div>
                                        </div>
                                    </td>
                                    <td class='align-middle'>$kategori</td>
                                    <td class='align-middle'>Rp $harga</td>
                                    <td class='align-middle'>$stok</td>
                                    <td class='align-middle'>$status</td>
                                    <td class='align-middle'>
                                        <a href='../../admin/update/updateProduct.php?id=$idProduk' class='btn btn-sm btn-outline-primary me-1'>
                                            <ion-icon name='create-outline'></ion-icon>
                                        </a>
                                        <a href='../../admin/delete/deleteProduct.php?id=$idProduk' onclick='return confirm(\"Yakin hapus produk?\")' class='btn btn-sm btn-outline-danger'>
                                            <ion-icon name='trash-outline'></ion-icon>
                                        </a>
                                    </td>
                                </tr>";
                            }

                            ?>
                        </tbody>
                    </table>
                </div>

            </div>


        </main>
    </div>

    <!-- Modal Gambar -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center">
                    <img id="modalImage" src="" alt="Preview" class="img-fluid">
                </div>
            </div>
        </div>
    </div>



    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js"
        integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous">
    </script>
</body>

</html>