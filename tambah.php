<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$id = isset($_GET["id"]) ? (int) $_GET["id"] : 0;
$kode = $nama = $kategori = $harga = $stok = "";
$pesan = "";

if ($id > 0) {
    $data = mysqli_query($koneksi, "SELECT * FROM barang WHERE id=$id");
    $barang = mysqli_fetch_assoc($data);
    if ($barang) {
        $kode = $barang["kode"];
        $nama = $barang["nama"];
        $kategori = $barang["kategori"];
        $harga = $barang["harga"];
        $stok = $barang["stok"];
    } else {
        header("Location: dashboard.php");
        exit;
    }
}

if (isset($_POST["simpan"])) {
    $kode = mysqli_real_escape_string($koneksi, trim($_POST["kode"]));
    $nama = mysqli_real_escape_string($koneksi, trim($_POST["nama"]));
    $kategori = mysqli_real_escape_string($koneksi, trim($_POST["kategori"]));
    $harga = (float) $_POST["harga"];
    $stok = (int) $_POST["stok"];

    if ($kode == "" || $nama == "" || $kategori == "" || $harga < 0 || $stok < 0) {
        $pesan = "Semua kolom harus diisi dengan benar.";
    } else {
        if ($id > 0) {
            $sql = "UPDATE barang SET kode='$kode', nama='$nama', kategori='$kategori', harga=$harga, stok=$stok WHERE id=$id";
        } else {
            $sql = "INSERT INTO barang (kode, nama, kategori, harga, stok) VALUES ('$kode', '$nama', '$kategori', $harga, $stok)";
        }

        if (mysqli_query($koneksi, $sql)) {
            header("Location: dashboard.php");
            exit;
        } else {
            $pesan = "Gagal menyimpan. Pastikan kode barang belum digunakan.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $id > 0 ? "Edit" : "Tambah" ?> Barang</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
<header class="border-b bg-white">
    <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4">
        <a href="dashboard.php" class="text-lg font-bold">Data Barang</a>
        <nav class="flex gap-4 text-sm"><a href="dashboard.php">Dashboard</a><a href="laporan.php">Laporan</a></nav>
    </div>
</header>
<main class="mx-auto max-w-2xl px-4 py-8">
    <a class="text-sm text-blue-700" href="dashboard.php">&larr; Kembali</a>
    <section class="mt-4 rounded-xl border bg-white p-6">
        <h1 class="mb-1 text-2xl font-bold"><?= $id > 0 ? "Edit Barang" : "Tambah Barang" ?></h1>
        <p class="mb-5 text-sm text-slate-500">Isi data barang di bawah ini.</p>
        <?php if ($pesan != ""): ?><p class="mb-4 text-sm text-red-600"><?= htmlspecialchars($pesan) ?></p><?php endif; ?>
        <form method="POST" class="space-y-4">
            <label class="block text-sm font-medium">Kode barang
                <input class="mt-1 w-full rounded-lg border p-2" type="text" name="kode" value="<?= htmlspecialchars($kode) ?>" required>
            </label>
            <label class="block text-sm font-medium">Nama barang
                <input class="mt-1 w-full rounded-lg border p-2" type="text" name="nama" value="<?= htmlspecialchars($nama) ?>" required>
            </label>
            <label class="block text-sm font-medium">Kategori
                <input class="mt-1 w-full rounded-lg border p-2" type="text" name="kategori" value="<?= htmlspecialchars($kategori) ?>" required>
            </label>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <label class="block text-sm font-medium">Harga
                    <input class="mt-1 w-full rounded-lg border p-2" type="number" name="harga" min="0" step="0.01" value="<?= htmlspecialchars((string)$harga) ?>" required>
                </label>
                <label class="block text-sm font-medium">Stok
                    <input class="mt-1 w-full rounded-lg border p-2" type="number" name="stok" min="0" step="1" value="<?= htmlspecialchars((string)$stok) ?>" required>
                </label>
            </div>
            <div class="flex gap-3 pt-2">
                <button class="rounded-lg bg-blue-700 px-5 py-2 text-white" type="submit" name="simpan">Simpan</button>
                <a class="rounded-lg border px-5 py-2" href="dashboard.php">Batal</a>
            </div>
        </form>
    </section>
</main>
</body>
</html>
