CREATE DATABASE IF NOT EXISTS db_barang;
USE db_barang;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS barang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(30) NOT NULL UNIQUE,
    nama VARCHAR(150) NOT NULL,
    kategori VARCHAR(100) NOT NULL,
    harga DECIMAL(12,2) NOT NULL DEFAULT 0,
    stok INT NOT NULL DEFAULT 0
);

INSERT IGNORE INTO barang (kode, nama, kategori, harga, stok) VALUES
('BRG001', 'Buku Tulis', 'Alat Tulis', 5000, 30),
('BRG002', 'Pulpen Hitam', 'Alat Tulis', 3000, 50),
('BRG003', 'Mouse USB', 'Elektronik', 45000, 12);
