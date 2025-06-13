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
  <link rel="icon" type="image/png" href="/img/logo.png" />
</head>

<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg border-bottom py-3 fixed-top">
    <div class="container d-flex align-items-center justify-content-between">
      <!-- Logo -->
      <a class="navbar-brand fw-bold fs-4 d-flex align-items-center gap-4" href="index.html">
        <img src="img\logo.png" alt="Logo Geraifone" class="img-logo" />
        Geraifone
      </a>

      <!-- Menu -->
      <div class="collapse navbar-collapse justify-content-center" id="mainNavbar">
        <ul class="navbar-nav mb-2 mb-lg-0 gap-lg-5">
          <li class="nav-item">
            <a class="nav-link active" href="index.html">Beranda</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="smartphone.html">Smartphone</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              Aksesoris
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="casing.html">Casing</a></li>
              <li>
                <a class="dropdown-item" href="charger.html">Charger</a>
              </li>
              <li><a class="dropdown-item" href="tws.html">TWS</a></li>
              <li>
                <a class="dropdown-item" href="powerbank.html">Power Bank</a>
              </li>
            </ul>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="about.html">Tentang Kami</a>
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

        <!-- Button -->
        <div>
          <a class="btn btn-outline-primary py-2" href="tentang-toko.html">Lihat Toko</a>
        </div>

      </div>
    </div>
  </nav>
  <!-- Navbar End -->


  <!-- carousel -->
  <div id="carouselExampleIndicators" class="carousel slide mt-5" data-bs-ride="carousel">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
        aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
        aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
        aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active text-left py-5">
        <div class="container d-flex align-items-center justify-content-around">
          <div>
            <h2 class="fw-bold">Galaxy S24 Ultra</h2>
            <p>Rasakan Kekuatan Galaxy AI</p>
            <a class="btn" href="#">Beli Sekarang</a>
          </div>
          <img src="img/samsung s24.png" alt="Galaxy S24" />
        </div>
      </div>
      <div class="carousel-item text-left py-5">
        <div class="container d-flex align-items-center justify-content-around">
          <div>
            <h2 class="fw-bold">Galaxy S24 Ultra</h2>
            <p>Rasakan Kekuatan Galaxy AI</p>
            <a class="btn" href="#">Beli Sekarang</a>
          </div>
          <img src="img/samsung_s24_green.png" alt="Galaxy S24" />
        </div>
      </div>
      <div class="carousel-item text-left py-5">
        <div class="container d-flex align-items-center justify-content-around">
          <div>
            <h2 class="fw-bold">Galaxy S24 Ultra</h2>
            <p>Rasakan Kekuatan Galaxy AI</p>
            <a class="btn" href="#">Beli Sekarang</a>
          </div>
          <img src="img/samsung_s24_orange.png" alt="Galaxy S24" />
        </div>
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
      title="Previous Slide" data-bs-slide="prev">
      <ion-icon class="icon-control" name="chevron-back-outline" size="large"></ion-icon>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" title="Next Slide"
      data-bs-slide="next">
      <ion-icon class="icon-control" name="chevron-forward-outline" size="large"></ion-icon>
    </button>
  </div>

  <!-- Kategori Produk -->
  <section class="container text-center justify-content-center my-5">
    <h4 class="fw-bold m-5">Kategori Produk</h4>
    <div class="d-flex justify-content-around flex-wrap gap-5">
      <div class="kategori-icon text-center">
        <a href="casing.html">
          <div class="circle-bg">
            <img src="img/casing_kategori.png" alt="Casing" />
          </div>
        </a>
        <p class="fw-bold">Casing</p>
      </div>

      <div class="kategori-icon text-center">
        <a href="charger.html">
          <div class="circle-bg">
            <img src="img/charger_kategori.png" alt="Casing" />
          </div>
        </a>
        <p class="fw-bold">Charger</p>
      </div>

      <div class="kategori-icon text-center">
        <a href="smartphone.html">
          <div class="circle-bg">
            <img src="img/hp_kategori.png" alt="Casing" />
          </div>
        </a>
        <p class="fw-bold">Smartphone</p>
      </div>

      <div class="kategori-icon text-center">
        <a href="tws.html">
          <div class="circle-bg">
            <img src="img/tws_kategori.png" alt="Casing" />
          </div>
        </a>
        <p class="fw-bold">TWS</p>
      </div>

      <div class="kategori-icon text-center">
        <a href="powerbank.html">
          <div class="circle-bg">
            <img src="img/pb_kategori.png" alt="Casing" />
          </div>
        </a>
        <p class="fw-bold">Power Bank</p>
      </div>
    </div>
  </section>

  <!-- Produk Populer -->
  <section class="container my-5">
    <h4 class="text-center m-5 fw-bold">Produk Populer</h4>

    <div class="container">
      <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-5">

        <div class="col d-flex justify-content-center">
          <div class="card product-card text-center">
            <img src="img\moondrop_spacetravel.png" alt="Samsung S23 Ultra" />
            <div class="d-flex justify-content-center gap-1 mt-2">
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star-outline" class="star-icon"></ion-icon>
              <ion-icon name="star-outline" class="star-icon"></ion-icon>
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
            <img src="img\robot_25w.png" alt="Samsung S23 Ultra" />
            <div class="d-flex justify-content-center gap-1 mt-2">
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
            </div>
            <div class="card-body">
              <h6>Kepala Charger Robot 25 Watt</h6>
              <p>Rp 150.000</p>
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
            <img src="img\samsung_s24_green.png" alt="Samsung S23 Ultra" />
            <div class="d-flex justify-content-center gap-1 mt-2">
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
            </div>
            <div class="card-body">
              <h6>Samsung S24 Ultra 12/512 Titanium Green</h6>
              <p>Rp 25.000.000</p>
              <button class="btn">Tambah Keranjang</button>
            </div>
          </div>
        </div>

        <div class="col d-flex justify-content-center">
          <div class="card product-card text-center">
            <img src="img\fabric_S24.png" alt="Samsung S23 Ultra" />
            <div class="d-flex justify-content-center gap-1 mt-2">
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
            </div>
            <div class="card-body">
              <h6>S24 Case Fabric - Gray</h6>
              <p>Rp 120.000</p>
              <button class="btn">Tambah Keranjang</button>
            </div>
          </div>
        </div>

        <div class="col d-flex justify-content-center">
          <div class="card product-card text-center">
            <img src="img\samsung s24.png" alt="Samsung S23 Ultra" />
            <div class="d-flex justify-content-center gap-1 mt-2">
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
            </div>
            <div class="card-body">
              <h6>Samsung S24 Ultra 12/512 Titanium Violet</h6>
              <p>Rp 25.000.000</p>
              <button class="btn">Tambah Keranjang</button>
            </div>
          </div>
        </div>

        <div class="col d-flex justify-content-center">
          <div class="card product-card text-center">
            <img src="img\samsung_s24_orange.png" alt="Samsung S23 Ultra" />
            <div class="d-flex justify-content-center gap-1 mt-2">
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
            </div>
            <div class="card-body">
              <h6>Samsung S24 Ultra 8/256 Titanium Orange</h6>
              <p>Rp 20.000.000</p>
              <button class="btn">Tambah Keranjang</button>
            </div>
          </div>
        </div>

        <div class="col d-flex justify-content-center">
          <div class="card product-card text-center">
            <img src="img\anker_pb.png" alt="Samsung S23 Ultra" />
            <div class="d-flex justify-content-center gap-1 mt-2">
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
              <ion-icon name="star" class="star-icon"></ion-icon>
            </div>
            <div class="card-body">
              <h6>Anker Power Bank 5000 mAh</h6>
              <p>Rp 100.000</p>
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
                <ion-icon name="logo-github" class="icon" size="large"></ion-icon>
              </a>
              <a href="#" title="WhatsApp">
                <ion-icon name="logo-whatsapp" class="icon" size="large"></ion-icon>
              </a>
            </div>
          </div>

          <!-- Quick Link -->
          <div class="col-md-2 footer-link">
            <h6 class="fw-bold">Quick Link</h6>
            <ul class="list-unstyled">
              <li><a href="smartphone.html">Smartphone</a></li>
              <li><a href="casing.html">Casing</a></li>
              <li><a href="charger.html">Charger</a></li>
              <li><a href="powerbank.html">Power Bank</a></li>
              <li><a href="tws.html">TWS</a></li>
              <li><a href="about.html">Tentang Kami</a></li>
            </ul>
          </div>

          <!-- Kebijakan -->
          <div class="col-md-2 footer-link">
            <h6 class="fw-bold">Kebijakan</h6>
            <ul class="list-unstyled">
              <li><a href="#">Syarat dan Ketentuan</a></li>
              <li><a href="#">Kebijakan Privasi</a></li>
              <li><a href="report.html">Laporkan</a></li>
            </ul>
          </div>

          <!-- Hubungi Kami -->
          <div class="col-md-2 footer-link">
            <h6 class="fw-bold">Hubungi Kami</h6>
            <p>
              <a href="#">Kirim Pesan<br />08199029834</a>
            </p>
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