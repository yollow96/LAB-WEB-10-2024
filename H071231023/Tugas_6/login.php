<?php
require_once 'config.php'; // Memasukkan file konfigurasi (misalnya, koneksi database).

if (is_logged_in()) { // Memeriksa apakah pengguna sudah login.
    header('Location: dashboard.php'); // Jika ya, alihkan ke halaman dashboard.
    exit(); // Menghentikan skrip agar kode selanjutnya tidak dijalankan.
}

$error = ''; // Inisialisasi variabel untuk menyimpan pesan kesalahan.

if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Memeriksa apakah form telah dikirim.
    $email_or_username = $_POST['email_or_username']; // Mengambil input email/username.
    $password = $_POST['password']; // Mengambil input password.
    
    $user = authenticate($email_or_username, $password); // Autentikasi pengguna.

    if ($user) { // Jika autentikasi berhasil:
        $_SESSION['user'] = $user; // Simpan data pengguna di sesi.
        header('Location: dashboard.php'); // Alihkan ke halaman dashboard.
        exit();
    } else {
        $error = 'Email/username atau password tidak valid'; // Jika gagal, set pesan kesalahan.
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* CSS untuk styling halaman login */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f0f0f0;
        }
        .login-container {
            background-color: white;
            padding: 40px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #4285f4;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #357ae8;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .register-link {
            text-align: center;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>LOGIN</h2>
        <?php if ($error): ?>
            <p class="error"><?php echo $error; ?></p> <!-- Menampilkan pesan kesalahan jika ada -->
        <?php endif; ?>
        <form method="POST">
            <label for="email_or_username">Email atau Username</label>
            <input type="text" id="email_or_username" name="email_or_username" required>
            
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            
            <input type="submit" value="Submit">
        </form>
        <div class="register-link">
            <a href="#">Belum punya akun? Daftar di sini.</a>
        </div>
    </div>
</body>
</html>
