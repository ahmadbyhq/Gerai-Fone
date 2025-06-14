<?php
require_once(__DIR__ . '/../../config/dbConnection.php');
require_once(__DIR__ . '/../../authentication/auth.php');
?>

<?php
$search = mysqli_real_escape_string($conn, $_GET['search'] ?? '');
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Query data utama
$sql = "SELECT * FROM pelanggan WHERE 1";

if ($search !== '') {
    $sql .= " AND nama_pelanggan LIKE '%$search%'";
}

// Hitung total data
$sqlCount = str_replace("SELECT *", "SELECT COUNT(*) as total", $sql);
$resultCount = mysqli_query($conn, $sqlCount);
$totalData = mysqli_fetch_assoc($resultCount)['total'];
$totalPages = ceil($totalData / $limit);

// Ambil data sesuai limit & offset
$sql .= " ORDER BY id_pelanggan DESC LIMIT $limit OFFSET $offset";
$query = mysqli_query($conn, $sql);

$no = $offset + 1;
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pelanggan - Geraifone</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
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
                <a href="dashboard.php"><ion-icon name="grid-outline"></ion-icon> Dashboard</a>
                <a href="produk.php"><ion-icon name="bag-outline"></ion-icon> Produk</a>
                <a href="pelanggan.php" class="active"><ion-icon name="albums-outline"></ion-icon> Pelanggan </a>
                <a href="transaksi.php"><ion-icon name="cart-outline"></ion-icon> Transaksi</a>
                <a href="logproduk.php"><ion-icon name="time-outline"></ion-icon> Riwayat Log Produk</a>
                <a href="headnews.php"><ion-icon name="images-outline"></ion-icon> Headnews</a>
            </nav>
            <form action="logout.php" method="post" onsubmit="return confirm('Yakin ingin logout?')" style="width: 100%;">
                <button type="submit" class="logout-btn"><ion-icon name="log-out-outline"></ion-icon>Logout</button>
            </form>
        </aside>

        <main class="main-content">
            <div class="topbar">
                <h2> Pelanggan </h2>
            </div>

            <div class="container-fluid sticky-top px-3 py-2 rounded-3 shadow bg-white" style="top: 70px; z-index: 999;">
                <div class="row gy-2 px-3 py-2 align-items-center">
                    <form method="GET" id="filterForm" class="row gx-2 align-items-center">

                        <!-- Input Cari Produk -->
                        <div class="col-md-10 my-0">
                            <div class="input-group p-2">
                                <span class="input-group-text bg-white p-2 border border-1 border-secondary">
                                    <ion-icon name="search-outline"></ion-icon>
                                </span>
                                <input type="text" class="form-control p-2 border border-1 border-secondary"
                                    id="searchInput"
                                    placeholder="Cari pelanggan" name="search"
                                    value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
                            </div>
                        </div>

                        <!-- Tombol Tambah Pelanggan -->
                        <div class="col-md-2 my-0 text-end">
                            <button type="button" class="btn primary-btn add-product-btn w-100 p-2 fw-semibold"
                                data-bs-toggle="modal" data-bs-target="#tambahPelangganModal">
                                Pelanggan Baru
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
                                <th>Nama Pelanggan</th>
                                <th>Nomor HP</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($query) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($query)): ?>
                                    <tr >
                                        <td class="text-center align-middle"><?= $no++ ?></td>
                                        <td class="textstart align-middle ps-4"><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                                        <td class="textstart align-midd ps-4"><?= htmlspecialchars($row['no_hp']) ?></td>
                                        <td class="textstart align-middle ps-4"><?= htmlspecialchars($row['alamat']) ?></td>
                                        <td class="text-center align-middle">
                                            <!-- Edit Button -->
                                             <button type="button" class="btn btn-sm btn-outline-primary me-1"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editPelangganModal"
                                                        onclick="fillEditModal(<?= $row['id_pelanggan']; ?>, '<?= addslashes($row['nama_pelanggan']); ?>', '<?= addslashes($row['no_hp']); ?>', '<?= addslashes($row['alamat']); ?>')">
                                                    <ion-icon name="create-outline"></ion-icon>
                                             </button>

                                            <!-- Hapus Button -->
                                            <a href="../../admin/delete/deletePelanggan.php?id=<?= $row['id_pelanggan']; ?>" 
                                            onclick="return confirm('Yakin ingin menghapus pelanggan?')" class="btn btn-sm btn-outline-danger">
                                                <ion-icon name="trash-outline"></ion-icon>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4">Tidak ada data pelanggan.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>

                    <?php if ($totalPages > 1): ?>
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center mt-4">

                            <!-- Previous Button -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">
                                    <ion-icon name="chevron-back-outline"></ion-icon>
                                </a>
                            </li>

                            <!-- Numbered Pages -->
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                                    <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                                        <?= $i ?>
                                    </a>
                                </li>
                            <?php endfor; ?>

                            <!-- Next Button -->
                            <li class="page-item <?= ($page >= $totalPages) ? 'disabled' : '' ?>">
                                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>">
                                    <ion-icon name="chevron-forward-outline"></ion-icon>
                                </a>
                                
                            </li>

                        </ul>
                    </nav>
                    <?php endif; ?>

                </div>
            </div>
            <!-- Modal Tambah Pelanggan -->
            <div class="modal fade" id="tambahPelangganModal" tabindex="-1" aria-labelledby="tambahPelangganLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <!-- Form mengarah ke tambahpelanggan.php -->
                    <form method="POST" action="../../admin/add/tambahPelanggan.php" enctype="multipart/form-data">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahPelangganLabel">Tambah Pelanggan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama_pelanggan" class="form-label">Nama Pelanggan</label>
                                    <input type="text" class="form-control" name="nama_pelanggan" required>
                                </div>
                                <div class="mb-3">
                                    <label for="no_hp" class="form-label">No. HP</label>
                                    <input type="text" class="form-control" name="no_hp" pattern="[0-9]{10,15}" required>
                                </div>
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" name="alamat" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="tambah" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>


                    <!-- Modal Edit Pelanggan -->
            <div class="modal fade" id="editPelangganModal" tabindex="-1" aria-labelledby="editPelangganLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <form method="POST" action="../../admin/update/updatePelanggan.php">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editPelangganLabel">Edit Pelanggan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Hidden field to pass the ID -->
                                <input type="hidden" name="id_pelanggan" id="editIdPelanggan">

                                <!-- Nama Pelanggan -->
                                <div class="mb-3">
                                    <label for="editNamaPelanggan" class="form-label">Nama Pelanggan</label>
                                    <input type="text" class="form-control" name="nama_pelanggan" id="editNamaPelanggan" required>
                                </div>

                                <!-- No HP -->
                                <div class="mb-3">
                                    <label for="editNoHp" class="form-label">No. HP</label>
                                    <input type="text" class="form-control" name="no_hp" id="editNoHp" required>
                                </div>

                                <!-- Alamat -->
                                <div class="mb-3">
                                    <label for="editAlamat" class="form-label">Alamat</label>
                                    <textarea class="form-control" name="alamat" id="editAlamat" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="update" class="btn btn-success">Simpan Perubahan</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </main>
    </div>

    <script>
    function fillEditModal(id, nama, noHp, alamat) {
        document.getElementById('editIdPelanggan').value = id;
        document.getElementById('editNamaPelanggan').value = nama;
        document.getElementById('editNoHp').value = noHp;
        document.getElementById('editAlamat').value = alamat;
    }</script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>
</html>
