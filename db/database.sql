-- Membuat tabel user
CREATE TABLE user (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL
);

-- Membuat tabel kategori_produk
CREATE TABLE kategori_produk (
    id_kategori INT AUTO_INCREMENT PRIMARY KEY,
    kategori VARCHAR(100) NOT NULL
);

-- Membuat tabel produk
CREATE TABLE produk (
    id_produk INT AUTO_INCREMENT PRIMARY KEY,
    nama_produk VARCHAR(100) NOT NULL,
    stok INT NOT NULL,
    harga_produk DECIMAL(10, 2) NOT NULL,
    id_kategori INT,
    FOREIGN KEY (id_kategori) REFERENCES kategori_produk(id_kategori)
        ON DELETE CASCADE
);

-- Membuat tabel pelanggan
CREATE TABLE pelanggan (
    id_pelanggan INT AUTO_INCREMENT PRIMARY KEY,
    nama_pelanggan CHAR(25),
    no_hp VARCHAR(15),
    alamat TEXT
);

-- Membuat tabel transaksi
CREATE TABLE transaksi (
    id_transaksi INT AUTO_INCREMENT PRIMARY KEY,
    tanggal_transaksi DATETIME DEFAULT CURRENT_TIMESTAMP,
    id_pelanggan INT,
    total_harga DECIMAL(10,2),
    status_pembayaran ENUM('Belum Dibayar', 'Dibayar') DEFAULT 'Belum Dibayar',
    FOREIGN KEY (id_pelanggan) REFERENCES pelanggan(id_pelanggan)
        ON DELETE SET NULL
);

-- Membuat tabel detail transaksi
CREATE TABLE detail_transaksi (
    id_detail INT AUTO_INCREMENT PRIMARY KEY,
    id_transaksi INT,
    id_produk INT,
    jumlah INT NOT NULL,
    harga_satuan DECIMAL(10,2) NOT NULL,
    subtotal DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (id_transaksi) REFERENCES transaksi(id_transaksi)
        ON DELETE CASCADE,
    FOREIGN KEY (id_produk) REFERENCES produk(id_produk)
        ON DELETE SET NULL
);




INSERT INTO user (nama, email, password) VALUES
('Admin Geraifone1', 'admin1@geraifone.com', 'admin123'), 
('Ahmad', 'ahmad@geraifone.com', 'ahmad123'),
('Hamba Allah', 'staff1@geraifone.com', 'staff123');


INSERT INTO kategori_produk (kategori) VALUES
('Smartphone'),
('TWS'),
('Charger'),
('Casing'),
('Power Bank');


