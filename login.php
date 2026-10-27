<?php
session_start();
include "config/koneksi.php";

$pesan = "";

if (isset($_POST["login"])) {
    $email = mysqli_real_escape_string($koneksi, $_POST["email"]);
    $password = $_POST["password"];

    $query = mysqli_query($koneksi, "SELECT * FROM users WHERE email='$email'");
    $user = mysqli_fetch_assoc($query);

    if ($user && password_verify($password, $user["password"])) {
        session_regenerate_id(true);
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["nama"] = $user["nama"];
        header("Location: dashboard.php");
        exit;
    } else {
        $pesan = "Email atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="./src/output.css">
</head>
<body class="min-h-screen bg-slate-50 flex items-center justify-center p-4 text-slate-800">
    <main class="w-full max-w-md rounded-xl bg-white p-6 shadow border border-slate-200">
        <h1 class="text-2xl font-bold mb-1">Login Admin</h1>
        <p class="text-sm text-slate-500 mb-5">Masuk untuk mengelola barang.</p>
        <?php if ($pesan != ""): ?><p class="mb-3 text-sm text-red-600"><?= htmlspecialchars($pesan) ?></p><?php endif; ?>
        <form method="POST" class="space-y-4">
            <input class="w-full rounded-lg border p-2" type="email" name="email" placeholder="Email" required>
            <input class="w-full rounded-lg border p-2" type="password" name="password" placeholder="Password" required>
            <button class="w-full rounded-lg bg-blue-700 p-2 font-semibold text-white" type="submit" name="login">Login</button>
        </form>
        <p class="mt-4 text-sm">Belum punya akun? <a class="text-blue-700 underline" href="register.php">Registrasi</a></p>
    </main>
</body>
</html>
