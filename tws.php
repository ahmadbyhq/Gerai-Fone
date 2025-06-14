<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Geraifone - Beranda</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" />
    <link rel="stylesheet" href="/css/user.css" />
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg border-bottom py-2 fixed-top">
        <div class="container d-flex align-items-center justify-content-between">
            <!-- Logo -->
            <a class="navbar-brand fw-bold fs-4 d-flex align-items-center gap-4" href="index.php">
                <img src="img\logo.png" alt="Logo Geraifone" class="img-logo" />
                Geraifone
            </a>

            <!-- Menu -->
            <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
                <ul class="navbar-nav mb-2 mb-lg-0 gap-lg-5">
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="smartphone.php">Smartphone</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            Aksesoris
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="casing.php">Casing</a></li>
                            <li>
                                <a class="dropdown-item" href="charger.php">Charger</a>
                            </li>
                            <li><a class="dropdown-item" href="tws.php">TWS</a></li>
                            <li>
                                <a class="dropdown-item" href="powerbank.php">Power Bank</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="about.php">Tentang Kami</a>
                    </li>
                </ul>
            </div>

            <!-- Search & Icons -->
            <div class="d-flex align-items-center gap-5">
                <!-- Search -->
                <div class="input-group input-group-sm">
                    <span class="input-group-text bg-white border-end-0">
                        <ion-icon name="search-outline" class="icon"></ion-icon>
                    </span>
                    <input type="text" class="form-control border-start-0" placeholder="Cari Produk" />
                </div>

                <!-- Profile & Button -->
                <div class="d-flex align-items-center gap-5">
                    <a class="btn py-2" href="tentang-toko.php">Lihat Toko</a>
                    <a href="profile.php" class="text-dark fs-5 d-flex align-items-center">
                        <ion-icon name="person-outline" class="icon"></ion-icon>
                    </a>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->

    <!-- Produk Populer -->
    <section class="my-5 pt-5">
        <h4 class="text-center text-header fw-bold">TWS</h4>

        <div class="container">
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-5">

                <div class="col d-flex justify-content-center">
                    <div class="card product-card text-center">
                        <img src="img\moondrop_spacetravel.png" alt="Samsung S23 Ultra" />
                        <div class="d-flex justify-content-center gap-1 mt-2">
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                        </div>
                        <div class="card-body">
                            <h6>Moondrop Space Travel</h6>
                            <p>Rp 450.000</p>
                            <button class="btn">Tambah Keranjang</button>
                        </div>
                    </div>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="card product-card text-center">
                        <!-- Gambar Produk -->
                        <img src="img\soundcore_liberty2.png" alt="Samsung S23 Ultra" class="img-fluid" />
                        <div class="d-flex justify-content-center gap-1 mt-2">
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                        </div>
                        <div class="card-body">
                            <h6>Soundcore Liberty 2</h6>
                            <p>Rp 2.000.000</p>
                            <button class="btn">Tambah Keranjang</button>
                        </div>
                    </div>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="card product-card text-center">
                        <img src="img\moondrop_spacetravel.png" alt="Samsung S23 Ultra" />
                        <div class="d-flex justify-content-center gap-1 mt-2">
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                        </div>
                        <div class="card-body">
                            <h6>Moondrop Space Travel</h6>
                            <p>Rp 450.000</p>
                            <button class="btn">Tambah Keranjang</button>
                        </div>
                    </div>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="card product-card text-center">
                        <!-- Gambar Produk -->
                        <img src="img\soundcore_liberty2.png" alt="Samsung S23 Ultra" class="img-fluid" />
                        <div class="d-flex justify-content-center gap-1 mt-2">
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                        </div>
                        <div class="card-body">
                            <h6>Soundcore Liberty 2</h6>
                            <p>Rp 2.000.000</p>
                            <button class="btn">Tambah Keranjang</button>
                        </div>
                    </div>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="card product-card text-center">
                        <img src="img\jbl_tuneflex.png" alt="Samsung S23 Ultra" />
                        <div class="d-flex justify-content-center gap-1 mt-2">
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star-outline" class="star-icon"></ion-icon>
                        </div>
                        <div class="card-body">
                            <h6>JBL Tune Flex</h6>
                            <p>Rp 1.000.000</p>
                            <button class="btn">Tambah Keranjang</button>
                        </div>
                    </div>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="card product-card text-center">
                        <img src="img\jbl_tuneflex.png" alt="Samsung S23 Ultra" />
                        <div class="d-flex justify-content-center gap-1 mt-2">
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star-outline" class="star-icon"></ion-icon>
                        </div>
                        <div class="card-body">
                            <h6>JBL Tune Flex</h6>
                            <p>Rp 1.000.000</p>
                            <button class="btn">Tambah Keranjang</button>
                        </div>
                    </div>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="card product-card text-center">
                        <img src="img\galaxy_budspro.png" alt="Samsung S23 Ultra" />
                        <div class="d-flex justify-content-center gap-1 mt-2">
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                        </div>
                        <div class="card-body">
                            <h6>Galaxy Buds Pro 2</h6>
                            <p>Rp 2.100.000</p>
                            <button class="btn">Tambah Keranjang</button>
                        </div>
                    </div>
                </div>

                <div class="col d-flex justify-content-center">
                    <div class="card product-card text-center">
                        <img src="img\galaxy_budspro.png" alt="Samsung S23 Ultra" />
                        <div class="d-flex justify-content-center gap-1 mt-2">
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                            <ion-icon name="star" class="star-icon"></ion-icon>
                        </div>
                        <div class="card-body">
                            <h6>Galaxy Buds Pro 2</h6>
                            <p>Rp 2.100.000</p>
                            <button class="btn">Tambah Keranjang</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="mt-5">
        <!-- Footer Atas -->
        <div class="footer-bg text-dark">
            <div class="container px-4">
                <div class="row d-flex align-items-stretch justify-content-between py-5">
                    <!-- Geraifone -->
                    <div class="col-md-3">
                        <h6 class="fw-bold">Geraifone</h6>
                        <p>
                            Geraifone adalah sebuah marketplace website yang menjual
                            smartphone dan aksesoris smartphone.
                        </p>
                        <div class="d-flex gap-4 fs-5 footer-link">
                            <a href="#" title="Instagram">
                                <ion-icon name="logo-instagram" class="icon" size="large"></ion-icon>
                            </a>
                            <a href="#" title="Facebook">
                                <ion-icon name="logo-facebook" class="icon" size="large"></ion-icon>
                            </a>
                            <a href="#" title="GitHub">
                                <ion-icon name="logo-tiktok" class="icon" size="large"></ion-icon>
                            </a>
                        </div>
                    </div>

                    <!-- Quick Link -->
                    <div class="col-md-2 footer-link">
                        <h6 class="fw-bold">Quick Link</h6>
                        <ul class="list-unstyled">
                            <li><a href="smartphone.php">Smartphone</a></li>
                            <li><a href="casing.php">Casing</a></li>
                            <li><a href="charger.php">Charger</a></li>
                            <li><a href="powerbank.php">Power Bank</a></li>
                            <li><a href="tws.php">TWS</a></li>
                            <li><a href="tentang-toko.php">Lihat Toko</a></li>
                        </ul>
                    </div>

                    <!-- Saran -->
                    <div class="col-md-2 footer-link">
                        <h6 class="fw-bold">Hubungi Kami</h6>
                        <ul class="list-unstyled">
                            <li><a href="https://mail.google.com/mail/?view=cm&to=23081010134@student.upnjatim.ac.id"
                                    target="_blank">Email</a></li>
                            <li><a href="http://wa.me/6282230116388">WhatsApp</a></li>
                        </ul>
                    </div>

                    <!-- Hubungi Kami -->
                    <div class="col-md-2 footer-link">
                        <h6 class="fw-bold">Lainnya</h6>
                        <ul class="list-unstyled">
                            <li><a href="saran.php">Saran</a></li>
                            <li><a href="about.php">Tentang Kami</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bawah -->
        <div class="text-dark py-3 text-center small">
            <p class="mb-0">© 2025 Geraifone. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="js\script.js"></script>
</body>

</html>