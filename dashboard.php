<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (isset($_POST["hapus"])) {
    $id = (int) $_POST["id"];
    mysqli_query($koneksi, "DELETE FROM barang WHERE id=$id");
    header("Location: dashboard.php");
    exit;
}

$cari = "";
if (isset($_GET["cari"])) {
    $cari = mysqli_real_escape_string($koneksi, $_GET["cari"]);
}

$query = mysqli_query($koneksi, "SELECT * FROM barang
    WHERE kode LIKE '%$cari%' OR nama LIKE '%$cari%' OR kategori LIKE '%$cari%'
    ORDER BY id DESC");

$jumlah = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah FROM barang"));
$stok = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COALESCE(SUM(stok), 0) AS total FROM barang"));
$nilai = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COALESCE(SUM(harga * stok), 0) AS total FROM barang"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Data Barang</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
<header class="border-b bg-white">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-3 px-4 py-4">
        <a href="dashboard.php" class="text-lg font-bold">Data Barang</a>
        <nav class="flex flex-wrap gap-4 text-sm">
            <a class="font-semibold text-blue-700" href="dashboard.php">Dashboard</a>
            <a href="tambah.php">Tambah Barang</a>
            <a href="laporan.php">Laporan</a>
            <span class="text-slate-500"><?= htmlspecialchars($_SESSION["nama"]) ?></span>
            <a href="logout.php">Logout</a>
        </nav>
    </div>
</header>

<main class="mx-auto max-w-6xl px-4 py-8">
    <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Dashboard Admin</h1>
            <p class="mt-1 text-sm text-slate-500">Kelola data barang.</p>
        </div>
        <a href="tambah.php" class="rounded-lg bg-blue-700 px-4 py-2 text-white">+ Tambah Barang</a>
    </div>

    <section class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-xl border bg-white p-5"><p class="text-sm text-slate-500">Jumlah barang</p><p class="mt-2 text-2xl font-bold"><?= $jumlah["jumlah"] ?></p></div>
        <div class="rounded-xl border bg-white p-5"><p class="text-sm text-slate-500">Total stok</p><p class="mt-2 text-2xl font-bold"><?= $stok["total"] ?></p></div>
        <div class="rounded-xl border bg-white p-5"><p class="text-sm text-slate-500">Total nilai stok</p><p class="mt-2 text-2xl font-bold">Rp <?= number_format($nilai["total"], 0, ",", ".") ?></p></div>
    </section>

    <section class="overflow-hidden rounded-xl border bg-white">
        <div class="flex flex-wrap items-center justify-between gap-3 border-b p-4">
            <h2 class="font-semibold">Tabel Data Barang</h2>
            <form method="GET" class="flex gap-2">
                <input class="min-w-0 rounded-lg border px-3 py-2 text-sm" type="text" name="cari" placeholder="Cari barang..." value="<?= htmlspecialchars($cari) ?>">
                <button class="rounded-lg border px-4 py-2 text-sm">Cari</button>
            </form>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[650px] text-left text-sm">
                <thead class="bg-slate-100">
                    <tr>
                        <th class="p-3">Kode</th><th class="p-3">Nama</th><th class="p-3">Kategori</th><th class="p-3">Harga</th><th class="p-3">Stok</th><th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                <?php if (mysqli_num_rows($query) == 0): ?>
                    <tr><td colspan="6" class="p-6 text-center text-slate-500">Data barang belum ada.</td></tr>
                <?php endif; ?>
                <?php while ($row = mysqli_fetch_assoc($query)): ?>
                    <tr>
                        <td class="p-3"><?= htmlspecialchars($row["kode"]) ?></td>
                        <td class="p-3"><?= htmlspecialchars($row["nama"]) ?></td>
                        <td class="p-3"><?= htmlspecialchars($row["kategori"]) ?></td>
                        <td class="p-3">Rp <?= number_format($row["harga"], 0, ",", ".") ?></td>
                        <td class="p-3"><?= $row["stok"] ?></td>
                        <td class="p-3">
                            <div class="flex gap-3">
                                <a class="text-blue-700" href="tambah.php?id=<?= $row["id"] ?>">Edit</a>
                                <form method="POST" onsubmit="return confirm('Yakin hapus barang ini?')">
                                    <input type="hidden" name="id" value="<?= $row["id"] ?>">
                                    <button class="text-red-700" type="submit" name="hapus">Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </section>
</main>
</body>
</html>
