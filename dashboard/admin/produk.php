<?php
require_once(__DIR__ . '/../../config/dbConnection.php');
require_once(__DIR__ . '/../../authentication/auth.php');
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
    <link rel="icon" href="../../img/logo.png" type="image/png">
    <link rel="stylesheet" href="../../css/dashboard.css" />
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
                <a href="pelanggan.php">
                    <ion-icon name="albums-outline"></ion-icon> Pelanggan
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

            <div class="container-fluid sticky-top px-3 py-2 rounded-3 shadow bg-white" style="top: 70px; z-index: 999;">
                    <div class="row gy-2 px-3 py-2 align-items-center">
                        <form method="GET" id="filterForm" class="row gx-2 align-items-center">
                            <!-- Input Cari Produk -->
                            <div class="col-md-4 my-0">
                                <div class="input-group p-2">
                                    <span class="input-group-text bg-white p-2 border border-1 border-secondary">
                                        <ion-icon name="search-outline"></ion-icon>
                                    </span>
                                    <input type="text" class="form-control p-2 border border-1 border-secondary"
                                        placeholder="Cari produk" name="search"
                                        value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                                </div>
                            </div>

                            <!-- Dropdown Kategori dari DB -->
                            <div class="col-md-3 my-0">
                                <select class="form-select p-2 fw-semibold border border-1 border-secondary"
                                    name="kategori" onchange="document.getElementById('filterForm').submit()">
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
                                    name="status" onchange="document.getElementById('filterForm').submit()">
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
                                <button type="button" class="btn primary-btn add-product-btn w-100 p-2 fw-semibold"
                                    data-bs-toggle="modal" data-bs-target="#modalTambahProduk">
                                    Tambah Produk
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            <div class="content-container px-4 my-5">
                <div class="table-responsive rounded-3 overflow-hidden shadow bg-white p-4">
                    <table class="table align-middle table-striped table-hover table-bordered">
                        <thead class="table-secondary text-center align-middle">
                            <tr>
                                <th>No</th>
                                <th>Nama Produk</th>
                                <th>Gambar Produk</th>
                                <th>Kategori</th>
                                <th>Harga</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <?php
                            $search   = mysqli_real_escape_string($conn, $_GET['search'] ?? '');
                            $kategori = mysqli_real_escape_string($conn, $_GET['kategori'] ?? '');
                            $status   = $_GET['status'] ?? '';
                            $limit = 5;
                            $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
                            $offset = ($page - 1) * $limit;

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

                            // Hitung total data untuk paginasi
                            $sqlCount = str_replace("SELECT produk.*, kategori_produk.kategori", "SELECT COUNT(*) as total", $sql);
                            $resultCount = mysqli_query($conn, $sqlCount);
                            $totalData = mysqli_fetch_assoc($resultCount)['total'];
                            $totalPages = ceil($totalData / $limit);

                            // Tambahkan LIMIT OFFSET
                            $sql .= " LIMIT $limit OFFSET $offset";

                            $query = mysqli_query($conn, $sql);
                            $no = $offset + 1;

                            while($row = mysqli_fetch_assoc($query)) {
                                // Ambil data
                                $namaProduk = htmlspecialchars($row['nama_produk']);
                                $idProduk   = (int)$row['id_produk'];
                                $kategori   = htmlspecialchars($row['kategori'] ?? 'Lainnya');
                                $harga      = number_format($row['harga_produk'], 0, ',', '.');
                                $stok       = (int)$row['stok'];
                                $gambarPath = "../../upload/devices.png";
                                $gambarQuery = mysqli_query($conn, "SELECT nama_file FROM gambar_produk WHERE id_produk = $idProduk");
                                if ($gambarQuery && $g = mysqli_fetch_assoc($gambarQuery)) {
                                    $gambarPath = "../../upload/" . htmlspecialchars($g['nama_file']);
                                }

                                // Tentukan status produk
                                if ($stok <= 0) {
                                    $status = "<span class='badge bg-danger'>Habis</span>";
                                } elseif ($stok < 5) {
                                    $status = "<span class='badge bg-warning text-dark'>Menipis</span>";
                                } else {
                                    $status = "<span class='badge bg-success'>Tersedia</span>";
                                }

                                echo "
                                <tr>
                                    <td class='align-middle'>$no</td>
                                    <td class='text-start align-middle'>
                                        <div class='fw-semibold ps-4'>$namaProduk</div>
                                    </td>

                                    <td class='text-center align-middle'>
                                        <img src='$gambarPath' alt='$namaProduk'
                                            style='width:50px; height:50px; object-fit:contain; cursor:pointer; margin: 3px; padding: 5px; border: 1px solid #000000; border-radius: 2px;'
                                            data-bs-toggle='modal'
                                            data-bs-target='#imageModal'
                                            onclick=\"document.getElementById('modalImage').src='$gambarPath'\">
                                    </td>
                                    <td class='align-middle'>$kategori</td>
                                    <td class='text-start align-middle ps-4'>Rp $harga</td>
                                    <td class='align-middle'>$stok</td>
                                    <td class='align-middle'>$status</td>
                                    <td class='align-middle'>
                                        <button 
                                            type='button' 
                                            class='btn btn-sm btn-outline-primary me-1'
                                            data-bs-toggle='modal'
                                            data-bs-target='#modalEditProduk$idProduk'>
                                            <ion-icon name='create-outline'></ion-icon>
                                        </button>

                                        <a href='../../admin/delete/deleteProduct.php?id=$idProduk' onclick='return confirm(\"Yakin hapus produk?\")' class='btn btn-sm btn-outline-danger'>
                                            <ion-icon name='trash-outline'></ion-icon>
                                        </a>
                                    </td>
                                </tr>
                                <!-- Modal Edit Produk -->
                                <div class='modal fade' id='modalEditProduk$idProduk' tabindex='-1' aria-labelledby='modalLabel$idProduk' aria-hidden='true'>
                                    <div class='modal-dialog'>
                                        <form method='POST' enctype='multipart/form-data' action='../../admin/update/updateProduct.php'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h5 class='modal-title' id='modalLabel$idProduk'>Edit Produk</h5>
                                                    <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Tutup'></button>
                                                </div>
                                                <div class='modal-body'>
                                                    <input type='hidden' name='id_produk' value='$idProduk'>
                                                    <div class='mb-3'>
                                                        <label>Nama Produk</label>
                                                        <input type='text' class='form-control' name='nama_produk' value='$namaProduk' required>
                                                    </div>
                                                    <div class='mb-3'>
                                                        <label>Harga</label>
                                                        <input type='number' class='form-control' name='harga_produk' value='{$row['harga_produk']}' required>
                                                    </div>
                                                    <div class='mb-3'>
                                                        <label>Stok</label>
                                                        <input type='number' class='form-control' name='stok' value='$stok' required>
                                                    </div>
                                                    <div class='mb-3'>
                                                        <label>Kategori</label>
                                                        <select name='id_kategori' class='form-select'>";
                                                            $kategoriResult = mysqli_query($conn, "SELECT * FROM kategori_produk");
                                                            while ($kat = mysqli_fetch_assoc($kategoriResult)) {
                                                                $selected = ($kat['kategori'] === $kategori) ? 'selected' : '';
                                                                echo "<option value='{$kat['id_kategori']}' $selected>{$kat['kategori']}</option>";
                                                            }
                                                    echo "</select>
                                                    </div>
                                                    <div class='mb-3'>
                                                        <label>Ganti Gambar (opsional)</label>
                                                        <input type='file' class='form-control' name='gambar'>
                                                    </div>
                                                </div>
                                                <div class='modal-footer'>
                                                    <button type='submit' class='btn btn-secondary'>Simpan</button>
                                                    <button type='button' class='btn btn-danger' data-bs-dismiss='modal'>Batal</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>";
                                $no++;
                            }

                            ?>
                        </tbody>
                    </table>

                    <?php if ($totalPages >= 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mt-4">

                            <!-- Previous Button -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link d-flex align-items-center justify-content-center" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">
                                    <ion-icon name="chevron-back-outline"></ion-icon>
                                </a>
                            </li>

                            <!-- Numbered Pages -->
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                                    <a class="page-link d-flex align-items-center justify-content-center" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next Button -->
                            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                <a class="page-link d-flex align-items-center justify-content-center" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">
                                    <ion-icon name="chevron-forward-outline"></ion-icon>
                                </a>
                                
                            </li>

                        </ul>
                    </nav>
                    <?php endif; ?>

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

    <!-- Modal Tambah Produk -->
    <div class="modal fade" id="modalTambahProduk" tabindex="-1" aria-labelledby="modalTambahProdukLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <form action="../../admin/add/addProduct.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTambahProdukLabel">Tambah Produk</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama_produk" class="form-label">Nama Produk</label>
                            <input type="text" class="form-control" name="nama_produk" id="nama_produk" required>
                        </div>

                        <div class="mb-3">
                            <label for="kategori" class="form-label">Kategori</label>
                            <select class="form-select" name="id_kategori" id="kategori" required>
                                <option value="">Pilih Kategori</option>
                                <?php
                                $kategoriResult = mysqli_query($conn, "SELECT id_kategori, kategori FROM kategori_produk");
                                while ($kat = mysqli_fetch_assoc($kategoriResult)) {
                                    $idKat = $kat['id_kategori'];
                                    $namaKat = htmlspecialchars($kat['kategori']);
                                    echo "<option value='$idKat'>$namaKat</option>";
                                }
                                ?>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="harga_produk" class="form-label">Harga Produk</label>
                            <input type="number" class="form-control" name="harga_produk" id="harga_produk" required>
                        </div>

                        <div class="mb-3">
                            <label for="stok" class="form-label">Stok</label>
                            <input type="number" class="form-control" name="stok" id="stok" required>
                        </div>

                        <div class="mb-3">
                            <label for="gambar_produk" class="form-label">Gambar Produk</label>
                            <input type="file" class="form-control" name="gambar_produk" id="gambar_produk"
                                accept="image/*" required>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-secondary">Tambah Produk</button>
                    </div>
                </form>
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
