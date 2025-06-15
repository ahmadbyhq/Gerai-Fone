<?php
require_once(__DIR__ . '/../../config/dbConnection.php');
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Transaksi - Geraifone</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="../../css/dashboard.css" />
  <link rel="icon" href="../../img/logo.png" type="image/png">
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
      <a href="pelanggan.php"><ion-icon name="albums-outline"></ion-icon> Pelanggan</a>
      <a href="transaksi.php" class="active"><ion-icon name="cart-outline"></ion-icon> Transaksi</a>
      <a href="laporan.php"><ion-icon name="time-outline"></ion-icon> Laporan Penjualan</a>
      <a href="headnews.php"><ion-icon name="images-outline"></ion-icon> Headnews</a>
    </nav>
    <form action="logout.php" method="post" onsubmit="return confirm('Yakin ingin logout?')">
      <button type="submit" class="logout-btn"><ion-icon name="log-out-outline"></ion-icon>Logout</button>
    </form>
  </aside>

  <main class="main-content">
    <div class="topbar">
      <h2>Transaksi</h2>
    </div>

    <div class="container-fluid sticky-top px-3 py-2 rounded-3 shadow bg-white" style="top: 70px; z-index: 999;">
      <form method="GET" class="row gx-2 align-items-center">
        <div class="col-md-10">
          <div class="input-group p-2">
            <span class="input-group-text bg-white border border-secondary">
              <ion-icon name="search-outline"></ion-icon>
            </span>
            <input type="text" class="form-control border border-secondary" name="search" placeholder="Cari berdasarkan nama pelanggan"
              value="<?= htmlspecialchars($_GET['search'] ?? '') ?>">
          </div>
        </div>
        <div class="col-md-2 text-end">
          <button type="button" class="btn btn-primary w-100 fw-semibold" data-bs-toggle="modal" data-bs-target="#tambahTransaksiModal">
            Tambah Transaksi
          </button>
        </div>
      </form>
    </div>

    <div class="content-container px-4 my-5">
      <div class="table-responsive rounded-3 shadow bg-white p-4">
        <table class="table table-striped table-hover table-bordered">
          <thead class="table-secondary text-center">
            <tr>
              <th>No</th>
              <th>Nama Pelanggan</th>
              <th>Produk</th>
              <th>Tanggal</th>
              <th>Total</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $search = mysqli_real_escape_string($conn, $_GET['search'] ?? '');
            $limit = 10;
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $offset = ($page - 1) * $limit;

            $sql = "SELECT t.id_transaksi, t.tanggal_transaksi, t.total_harga, t.status_pembayaran, 
                           p.nama_pelanggan, GROUP_CONCAT(pr.nama_produk SEPARATOR ', ') AS nama_produk
                    FROM transaksi t
                    JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
                    JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
                    JOIN produk pr ON dt.id_produk = pr.id_produk
                    WHERE p.nama_pelanggan LIKE '%$search%'
                    GROUP BY t.id_transaksi
                    ORDER BY t.id_transaksi DESC
                    LIMIT $limit OFFSET $offset";

            $countSql = "SELECT COUNT(DISTINCT t.id_transaksi) AS total
                         FROM transaksi t
                         JOIN pelanggan p ON t.id_pelanggan = p.id_pelanggan
                         WHERE p.nama_pelanggan LIKE '%$search%'";
            $total = mysqli_fetch_assoc(mysqli_query($conn, $countSql))['total'];
            $totalPages = ceil($total / $limit);

            $result = mysqli_query($conn, $sql);
            $no = $offset + 1;
            if (mysqli_num_rows($result) > 0):
              while ($row = mysqli_fetch_assoc($result)):
            ?>
              <tr>
                <td class="text-center"><?= $no++ ?></td>
                <td><?= htmlspecialchars($row['nama_pelanggan']) ?></td>
                <td><?= htmlspecialchars($row['nama_produk']) ?></td>
                <td><?= htmlspecialchars($row['tanggal_transaksi']) ?></td>
                <td class="text-center"><?= $row['total_harga'] ?></td>
                <td class="text-center"><?= $row['status_pembayaran'] ?></td>
                <td class="text-center">
                  <a href="#" class="btn btn-sm btn-outline-primary"><ion-icon name="eye-outline"></ion-icon></a>
                  <a href="#" class="btn btn-sm btn-outline-success"><ion-icon name="create-outline"></ion-icon></a>
                  <a href="#" class="btn btn-sm btn-outline-danger"><ion-icon name="trash-outline"></ion-icon></a>
                </td>
              </tr>
            <?php endwhile; else: ?>
              <tr><td colspan="7" class="text-center">Tidak ada data.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>

        <?php if ($totalPages > 1): ?>
        <nav class="mt-4">
          <ul class="pagination justify-content-center">
            <li class="page-item <?= ($page <= 1) ? 'disabled' : '' ?>">
              <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>">
                <ion-icon name="chevron-back-outline"></ion-icon>
              </a>
            </li>
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
              <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                <a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>">
                  <?= $i ?>
                </a>
              </li>
            <?php endfor; ?>
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
  </main>
</div>

<!-- Modal Tambah Transaksi -->
<div class="modal fade" id="tambahTransaksiModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <form method="POST" action="../../admin/add/tambahTransaksi.php">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah Transaksi</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label>Nama Pelanggan</label>
            <input type="text" name="nama_pelanggan" class="form-control" required>
          </div>
          <div id="produk-wrapper">
            <div class="row produk-item mb-2">
              <div class="col-7">
                <label>Produk</label>
                <select name="produk[]" class="form-select" required>
                  <option value="">-- Pilih Produk --</option>
                  <?php
                  $resultProduk = mysqli_query($conn, "SELECT id_produk, nama_produk FROM produk ORDER BY nama_produk ASC");
                  while ($rowProduk = mysqli_fetch_assoc($resultProduk)) {
                    echo '<option value="' . $rowProduk['id_produk'] . '">' . htmlspecialchars($rowProduk['nama_produk']) . '</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="col-4">
                <label>Jumlah</label>
                <input type="number" name="jumlah[]" class="form-control" required>
              </div>
              <div class="col-1 d-flex align-items-end">
                <button type="button" class="btn btn-success btn-sm add-produk">+</button>
              </div>
            </div>
          </div>
          <div class="mb-3 mt-3">
            <label>Status Pembayaran</label>
            <select name="status_pembayaran" class="form-select" required>
              <option value="dibayar">Dibayar</option>
              <option value="belum_dibayar">Belum Dibayar</option>
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Scripts -->
<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const wrapper = document.getElementById("produk-wrapper");

  wrapper.addEventListener("click", function(e) {
    if (e.target.classList.contains("add-produk")) {
      const item = e.target.closest(".produk-item");
      const clone = item.cloneNode(true);

      clone.querySelector("select").value = "";
      clone.querySelector("input").value = "";

      const btn = clone.querySelector(".add-produk");
      btn.classList.remove("btn-success", "add-produk");
      btn.classList.add("btn-danger", "remove-produk");
      btn.textContent = "-";

      wrapper.appendChild(clone);
    } else if (e.target.classList.contains("remove-produk")) {
      e.target.closest(".produk-item").remove();
    }
  });
});
</script>
</body>
</html>
