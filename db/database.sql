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


