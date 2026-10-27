CRUD DATA BARANG - PHP Native + MySQLi

File halaman:
- register.php
- login.php
- dashboard.php
- tambah.php (tambah dan edit)
- laporan.php

File pendukung:
- logout.php
- config/koneksi.php
- database.sql

Cara menjalankan:
1. Ekstrak folder ini ke C:\laragon\www\crud-barang-simple
2. Jalankan Apache dan MySQL.
3. Import database.sql lewat phpMyAdmin.
4. Buka http://localhost/crud-barang-simple/register.php
5. Daftar, lalu login.

Koneksi default:
localhost, user root, password kosong, database db_barang.
Ubah config/koneksi.php jika pengaturan MySQL berbeda.

Catatan:
- Menggunakan MySQLi procedural, bukan PDO.
- CSS mengarah ke ./src/output.css, sesuaikan dengan Tailwind build yang sudah kamu pakai.
- Laporan dapat dicetak / disimpan PDF dari dialog print browser.
- Kode dibuat untuk latihan lokal; untuk aplikasi publik, gunakan prepared statements untuk semua query dan proteksi CSRF.
