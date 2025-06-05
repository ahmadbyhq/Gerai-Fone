<?php
require_once '../../config/dbConnection.php';

// Pagination
$limit = 5;
$currentPage = isset($_GET['p']) ? (int) $_GET['p'] : 1;
if ($currentPage < 1) $currentPage = 1;
$offset = ($currentPage - 1) * $limit;

// Total data untuk pagination
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM upload_gambar WHERE kategori = 'headnews'");
$totalData = $totalQuery->fetch_assoc()['total'];
$totalPages = ceil($totalData / $limit);

// Ambil data headnews
$resultheadnews = $conn->query("SELECT * FROM upload_gambar WHERE kategori = 'headnews' ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Kelola headnews - Geraifone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="../../css/dashboard.css" />
    <link rel="icon" href="../../img/logo.png" type="image/png">
    <style>

    .content-area {
        margin-left: 10px; 
        padding: 30px;
    }
</style>
</head>
<body>

<div class="dashboard-container">
    <aside class="sidebar">
        <div class="sidebar-header">
            <img src="../../img/logo.png" alt="Logo" class="logo-img" />
            <span class="logo-text">Geraifone</span>
        </div>
        <nav>
            <a href="../../dashboard.php"><ion-icon name="grid-outline"></ion-icon> Dashboard</a>
            <a href="../../produk.php"><ion-icon name="bag-outline"></ion-icon> Produk</a>
            <a href="../../kategoriProduk.php"><ion-icon name="albums-outline"></ion-icon> Kategori Produk</a>
            <a href="../../transaksi.php"><ion-icon name="cart-outline"></ion-icon> Transaksi</a>
            <a href="../../logproduk.php"><ion-icon name="time-outline"></ion-icon> Riwayat Log Produk</a>
            <a href="#" class="active"><ion-icon name="images-outline"></ion-icon> Headnews</a>
        </nav>
        <form action="../../logout.php" method="post" onsubmit="return confirm('Yakin ingin logout?')" style="width: 100%;">
            <button type="submit" class="logout-btn"><ion-icon name="log-out-outline"></ion-icon>Logout</button>
        </form>
    </aside>

    <main class="main-content">
        <div class="topbar">
            <h2>Kelola Headnews</h2>
        </div>

        <div class="content-area">
            <form action="../../admin/uploads/uploadHeadnews.php" method="POST" enctype="multipart/form-data" class="mb-4">
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar</label>
                    <input type="file" name="image" class="form-control" required />
                </div>
                <div class="mb-3">
                    <label for="link" class="form-label">Link (opsional)</label>
                    <input type="url" name="link" class="form-control" placeholder="masukkan link" />
                </div>
                <button type="submit" class="btn btn-primary">Upload</button>
            </form>

            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Link</th>
                        <th>Tanggal Upload</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $resultheadnews->fetch_assoc()): ?>
                        <tr>
                            <td><img src="<?= htmlspecialchars($row['image_path']) ?>" width="100" style="object-fit:cover" /></td>
                            <td>
                                <?php if (!empty($row['link_url'])): ?>
                                    <a href="<?= htmlspecialchars($row['link_url']) ?>" target="_blank"><?= htmlspecialchars($row['link_url']) ?></a>
                                <?php else: ?>
                                    <span class="text-muted">Tidak ada link</span>
                                <?php endif; ?>
                            </td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td>
                                <a href="../../admin/delete/deleteHeadnews.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin hapus item ini?');">Hapus</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>

            <nav>
                <ul class="pagination">
                    <?php for ($i=1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?= ($i === $currentPage) ? 'active' : '' ?>">
                            <a class="page-link" href="headnews.php?p=<?= $i ?>"><?= $i ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        </div>
    </main>
</div>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" crossorigin="anonymous"></script>

</body>
</html>
