<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geraifone</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .kategori-icon {
            width: 80px;
            height: 80px;
            object-fit: contain;
            margin-bottom: 10px;
        }
        .card img {
            object-fit: contain;
            height: 200px;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">Geraifone</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="#">Beranda</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Smartphone</a></li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Aksesoris</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Charger</a></li>
                        <li><a class="dropdown-item" href="#">Casing</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="#">Tentang Kami</a></li>
            </ul>
            <form class="d-flex me-2">
                <input class="form-control me-2" type="search" placeholder="Cari Produk">
            </form>
            <a href="#" class="me-3"><i class="bi bi-person"></i></a>
            <a href="#"><i class="bi bi-cart"></i></a>
        </div>
    </div>
</nav>

<!-- Carousel -->
<div id="mainCarousel" class="carousel slide bg-light" data-bs-ride="carousel">
    <div class="carousel-inner text-center">
        <div class="carousel-item active py-5">
            <div class="container d-flex flex-column align-items-center">
                <h2 class="fw-bold">Galaxy S24 Ultra</h2>
                <p>Rasakan Kekuatan Galaxy AI</p>
                <a href="#" class="btn btn-secondary mb-3">Beli Sekarang</a>
                <img src="https://via.placeholder.com/200x400" alt="Galaxy S24" class="img-fluid">
            </div>
        </div>
    </div>
</div>

<!-- Kategori Produk -->
<section class="py-5 text-center">
    <div class="container">
        <h4 class="mb-4 fw-bold">Kategori Produk</h4>
        <div class="row justify-content-center">
            <?php
                $kategori = ['Casing', 'Charger', 'Smartphone', 'TWS', 'Power Bank'];
                foreach ($kategori as $item) {
                    echo '<div class="col-4 col-md-2 mb-3">';
                    echo '<img src="https://via.placeholder.com/80" class="kategori-icon rounded-circle bg-light">';
                    echo '<p>' . $item . '</p>';
                    echo '</div>';
                }
            ?>
        </div>
    </div>
</section>

<!-- Promo Charger -->
<section class="py-5 bg-light text-center">
    <div class="container d-flex flex-column flex-md-row justify-content-around gap-3">
        <div class="p-4 bg-white rounded shadow">
            <p class="text-primary">Hemat hingga 25%</p>
            <h5>Charger & Kabel</h5>
            <a href="#" class="btn btn-secondary">Beli Sekarang</a>
        </div>
        <div class="p-4 bg-white rounded shadow">
            <p class="text-primary">Hemat hingga 25%</p>
            <h5>Charger & Kabel</h5>
            <a href="#" class="btn btn-secondary">Beli Sekarang</a>
        </div>
    </div>
</section>

<!-- Produk Populer -->
<section class="py-5">
    <div class="container">
        <h5 class="fw-bold text-center mb-4">Produk Populer</h5>
        <div class="row row-cols-2 row-cols-md-4 g-4">
            <?php
                for ($i = 0; $i < 4; $i++) {
                    echo '<div class="col">';
                    echo '<div class="card h-100 text-center">';
                    echo '<img src="https://via.placeholder.com/200x200" class="card-img-top">';
                    echo '<div class="card-body">';
                    echo '<p class="mb-1">Samsung S24 Ultra 8/256 Black</p>';
                    echo '<p class="fw-bold text-primary">Rp 20.000.000</p>';
                    echo '<a href="#" class="btn btn-primary btn-sm">Tambah ke keranjang</a>';
                    echo '</div></div></div>';
                }
            ?>
        </div>
    </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
