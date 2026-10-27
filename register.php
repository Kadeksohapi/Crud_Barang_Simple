<?php
session_start();
include "config/koneksi.php";

$pesan = "";

if (isset($_POST["daftar"])) {
    $nama = mysqli_real_escape_string($koneksi, $_POST["nama"]);
    $email = mysqli_real_escape_string($koneksi, $_POST["email"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

    $cek = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");

    if (mysqli_num_rows($cek) > 0) {
        $pesan = "Email sudah terdaftar.";
    } else {
        $query = "INSERT INTO users (nama, email, password)
                  VALUES ('$nama', '$email', '$password')";

        if (mysqli_query($koneksi, $query)) {
            header("Location: login.php");
            exit;
        } else {
            $pesan = "Registrasi gagal.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-4 text-slate-800">
    <main class="w-full max-w-md rounded-xl bg-white p-6 shadow border border-slate-200">
        <h1 class="text-2xl font-bold mb-1">Registrasi</h1>
        <p class="text-sm text-slate-500 mb-5">Buat akun untuk masuk.</p>
        <?php if ($pesan != ""): ?><p class="mb-3 text-sm text-red-600"><?= htmlspecialchars($pesan) ?></p><?php endif; ?>
        <form method="POST" class="space-y-4">
            <input class="w-full rounded-lg border p-2" type="text" name="nama" placeholder="Nama" required>
            <input class="w-full rounded-lg border p-2" type="email" name="email" placeholder="Email" required>
            <input class="w-full rounded-lg border p-2" type="password" name="password" placeholder="Password (minimal 8 karakter)" minlength="8" required>
            <button class="w-full rounded-lg bg-blue-700 p-2 font-semibold text-white" type="submit" name="daftar">Daftar</button>
        </form>
        <p class="mt-4 text-sm">Sudah punya akun? <a class="text-blue-700 underline" href="login.php">Login</a></p>
    </main>
</body>
</html>
