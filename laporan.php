<?php
session_start();
include "config/koneksi.php";

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

$query = mysqli_query($koneksi, "SELECT * FROM barang ORDER BY nama ASC");
$total = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT COUNT(*) AS jumlah, COALESCE(SUM(stok), 0) AS stok, COALESCE(SUM(harga * stok), 0) AS nilai FROM barang"));
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Barang</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="min-h-screen bg-slate-50 text-slate-800">
<header class="border-b bg-white print:hidden">
    <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-3 px-4 py-4">
        <a href="dashboard.php" class="text-lg font-bold">Data Barang</a>
        <nav class="flex gap-4 text-sm"><a href="dashboard.php">Dashboard</a><a href="tambah.php">Tambah Barang</a><a class="font-semibold text-blue-700" href="laporan.php">Laporan</a></nav>
    </div>
</header>
<main class="mx-auto max-w-6xl px-4 py-8">
    <div class="mb-6 flex flex-wrap items-end justify-between gap-3">
        <div><h1 class="text-2xl font-bold">Laporan Barang</h1><p class="mt-1 text-sm text-slate-500">Tanggal: <?= date("d-m-Y") ?></p></div>
        <button onclick="window.print()" class="rounded-lg bg-blue-700 px-4 py-2 text-white print:hidden">Cetak / Simpan PDF</button>
    </div>
    <section class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-3">
        <div class="rounded-xl border bg-white p-5"><p class="text-sm text-slate-500">Jumlah barang</p><p class="mt-2 text-2xl font-bold"><?= $total["jumlah"] ?></p></div>
        <div class="rounded-xl border bg-white p-5"><p class="text-sm text-slate-500">Total stok</p><p class="mt-2 text-2xl font-bold"><?= $total["stok"] ?></p></div>
        <div class="rounded-xl border bg-white p-5"><p class="text-sm text-slate-500">Total nilai stok</p><p class="mt-2 text-2xl font-bold">Rp <?= number_format($total["nilai"], 0, ",", ".") ?></p></div>
    </section>
    <section class="overflow-x-auto rounded-xl border bg-white">
        <table class="w-full min-w-[650px] text-left text-sm">
            <thead class="bg-slate-100"><tr><th class="p-3">Kode</th><th class="p-3">Nama</th><th class="p-3">Kategori</th><th class="p-3">Harga</th><th class="p-3">Stok</th><th class="p-3">Nilai stok</th></tr></thead>
            <tbody class="divide-y">
            <?php if (mysqli_num_rows($query) == 0): ?><tr><td colspan="6" class="p-6 text-center">Belum ada data.</td></tr><?php endif; ?>
            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                <tr>
                    <td class="p-3"><?= htmlspecialchars($row["kode"]) ?></td>
                    <td class="p-3"><?= htmlspecialchars($row["nama"]) ?></td>
                    <td class="p-3"><?= htmlspecialchars($row["kategori"]) ?></td>
                    <td class="p-3">Rp <?= number_format($row["harga"], 0, ",", ".") ?></td>
                    <td class="p-3"><?= $row["stok"] ?></td>
                    <td class="p-3">Rp <?= number_format($row["harga"] * $row["stok"], 0, ",", ".") ?></td>
                </tr>
            <?php endwhile; ?>
            </tbody>
        </table>
    </section>
</main>
</body>
</html>
