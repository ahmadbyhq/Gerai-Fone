<?php
require_once '../../config/dbConnection.php';

$success = isset($_GET['success']) ? $_GET['success'] : '';
$error = isset($_GET['error']) ? $_GET['error'] : '';

// PAGINASI
$limit = 5;
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Ambil total data dari kategori 'carousel'
$totalQuery = $conn->query("SELECT COUNT(*) AS total FROM upload_gambar WHERE kategori = 'carousel'");
$totalData = $totalQuery->fetch_assoc()['total'];
$totalPages = ceil($totalData / $limit);

// Ambil data dengan filter kategori carousel
$result = $conn->query("SELECT * FROM upload_gambar WHERE kategori = 'carousel' ORDER BY created_at DESC LIMIT $limit OFFSET $offset");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kelola Carousel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2 class="mb-4">Dashboard Carousel</h2>

    <?php if ($success): ?>
        <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
    <?php elseif ($error): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <!-- Form Upload -->
    <form action="upload_gambar.php?folder=collectionImg/carousel&table=upload_gambar&kategori=carousel&redirect=carousel.php" method="POST" enctype="multipart/form-data" class="mb-4">
        <div class="mb-3">
            <label for="image" class="form-label">Gambar Carousel</label>
            <input type="file" name="image" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="link" class="form-label">Link (opsional)</label>
            <input type="url" name="link" class="form-control" placeholder="https://contoh.com">
        </div>
        <button type="submit" class="btn btn-primary">Upload</button>
    </form>

    <!-- Tabel Data -->
    <h4>Daftar Carousel</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Gambar</th>
                <th>Link</th>
                <th>Tanggal Upload</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><img src="<?= htmlspecialchars($row['image_path']) ?>" width="100" style="object-fit: cover;"></td>
                    <td>
                        <?php if (!empty($row['link_url'])): ?>
                            <a href="<?= htmlspecialchars($row['link_url']) ?>" target="_blank"><?= htmlspecialchars($row['link_url']) ?></a>
                        <?php else: ?>
                            <em class="text-muted">Tidak ada link</em>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($row['created_at']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <!-- Pagination -->
    <nav>
        <ul class="pagination">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <li class="page-item <?= ($i === $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </nav>
</body>
</html>
