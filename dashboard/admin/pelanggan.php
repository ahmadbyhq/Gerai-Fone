<?php
require_once(__DIR__ . '/../../config/dbConnection.php');
require_once(__DIR__ . '/../../authentication/auth.php');
$search = mysqli_real_escape_string($conn, $_GET['search'] ?? '');
$gender_filter = mysqli_real_escape_string($conn, $_GET['gender_filter'] ?? '');
$limit = 10;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

$sql = "SELECT * FROM user WHERE role = 'pelanggan'";
if ($search !== '') {
    $sql .= " AND nama LIKE '%$search%'";
}

if ($gender_filter !== '') {
    $sql .= " AND jenis_kelamin = '$gender_filter'";
}

$sqlCount = str_replace("SELECT *", "SELECT COUNT(*) as total", $sql);
$resultCount = mysqli_query($conn, $sqlCount);
$totalData = mysqli_fetch_assoc($resultCount)['total'];
$totalPages = ceil($totalData / $limit);

$sql .= " ORDER BY id_user LIMIT $limit OFFSET $offset";
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
                <a href="pelanggan.php" class="active"><ion-icon name="person-outline"></ion-icon>Pelanggan</a>
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
                <h2>Pelanggan</h2>
            </div>

            <div class="container-fluid sticky-top px-3 py-2 rounded-3 shadow bg-white" style="top: 70px; z-index: 999;">
                <div class="row gy-2 px-3 py-2 align-items-center">
                    <form method="GET" id="filterForm" class="row gx-2 align-items-center">
                        <!-- Input Cari Produk -->
                        <div class="col-md-5 my-0">
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

                        <!-- Dropdown Jenis Kelamin -->
                        <div class="col-md-3 my-0">
                            <select class="form-select p-2 border border-1 border-secondary" name="gender_filter" onchange="document.getElementById('filterForm').submit()">
                                <option value="">Semua Jenis Kelamin</option>
                                <option value="Laki-laki" <?= (($_GET['gender_filter'] ?? '') == 'Laki-laki') ? 'selected' : '' ?>>Laki-laki</option>
                                <option value="Perempuan" <?= (($_GET['gender_filter'] ?? '') == 'Perempuan') ? 'selected' : '' ?>>Perempuan</option>
                            </select>
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
                                <th>Email</th>
                                <th>Jenis Kelamin</th>
                                <th>Nomor HP</th>
                                <th>Alamat</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                        <?php if (mysqli_num_rows($query) > 0): ?>
                            <?php while($row = mysqli_fetch_assoc($query)): ?>
                                <tr>
                                    <td class="align-middle"><?= $no++ ?></td>
                                    <td class="text-start align-middle ps-4"><?= htmlspecialchars($row['nama']) ?></td>
                                    <td class="text-start align-middle ps-4"><?= htmlspecialchars($row['email']) ?></td>
                                    <td class="text-start align-middle ps-4"><?= htmlspecialchars($row['jenis_kelamin']) ?></td>
                                    <td class="text-start align-middle ps-4"><?= htmlspecialchars($row['no_hp']) ?></td>
                                    <td class="text-start align-middle ps-4"><?= htmlspecialchars($row['alamat']) ?></td>
                                    <td class='text-center align-middle'>
                                        <div class="d-flex justify-content-center align-items-center gap-2" style="min-height: 40px;">
                                            <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalEditPelanggan<?= $row['id_user'] ?>">
                                                <ion-icon name="create-outline"></ion-icon>
                                            </button>
                                            <a href='../../admin/delete/deletePelanggan.php?id=<?= $row['id_user'] ?>' onclick='return confirm("Yakin hapus pelanggan?")' class='btn btn-sm btn-outline-danger'>
                                                <ion-icon name="trash-outline"></ion-icon>
                                            </a>
                                        </div>

                                        <!-- Modal Edit -->
                                        <div class="modal fade" id="modalEditPelanggan<?= $row['id_user'] ?>" tabindex="-1">
                                            <div class="modal-dialog">
                                                <form method="POST" action="../../admin/update/updatePelanggan.php">
                                                    <input type="hidden" name="id_user" value="<?= $row['id_user'] ?>">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">Edit Pelanggan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="mb-3 text-start">
                                                                <label class="form-label text-start">Nama Pelanggan</label>
                                                                <input type="text" class="form-control" name="nama" value="<?= htmlspecialchars($row['nama']) ?>" required>
                                                            </div>
                                                            <div class="mb-3 text-start">
                                                                <label class="form-label text-start">Email</label>
                                                                <input type="email" class="form-control" name="email" value="<?= htmlspecialchars($row['email']) ?>" required>
                                                            </div>
                                                            <div class="mb-3 text-start">
                                                                <label class="form-label text-start">Jenis Kelamin</label>
                                                                <select class="form-select" name="jenis_kelamin" required>
                                                                    <option value="Laki-laki" <?= $row['jenis_kelamin'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                                                                    <option value="Perempuan" <?= $row['jenis_kelamin'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                                                                </select>
                                                            </div>
                                                            <div class="mb-3 text-start">
                                                                <label class="form-label text-start">No. HP</label>
                                                                <input type="text" class="form-control" name="no_hp" value="<?= htmlspecialchars($row['no_hp']) ?>" required>
                                                            </div>
                                                            <div class="mb-3 text-start">
                                                                <label class="form-label text-start">Alamat</label>
                                                                <textarea class="form-control" name="alamat" required><?= htmlspecialchars($row['alamat']) ?></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-secondary">Simpan</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5">Tidak ada data pelanggan.</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>

                    <?php if ($totalPages >= 1): ?>
                    <nav aria-label="Page navigation" class="mt-4">
                        <ul class="pagination justify-content-center align-items-center">

                            <!-- Previous Button -->
                            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
                                <a class="page-link  d-flex align-items-center justify-content-center" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">
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


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>
</html>
