<?php
session_start();
include './config/config.php';

// Inisialisasi array untuk menampung pesan error dan status sukses
$errors = [];
$success = false;

// Memproses permintaan jika form disubmit melalui metode POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Mendapatkan input username dan password dari form
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $role = 'mahasiswa';  // Menentukan peran default pengguna sebagai mahasiswa

    // Validasi untuk memastikan username tidak kosong
    if (empty($username)) {
        $errors[] = "Username tidak boleh kosong";
    } elseif (strlen($username) < 4) {
        $errors[] = "Username minimal 4 karakter";
    } else {
        // Memeriksa apakah username sudah digunakan di database
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        if ($stmt->get_result()->num_rows > 0) {
            $errors[] = "Username sudah digunakan";
        }
    }

     // Validasi untuk memastikan password tidak kosong dan minimal 6 karakter
    if (empty($password)) {
        $errors[] = "Password tidak boleh kosong";
    } elseif (strlen($password) < 6) {
        $errors[] = "Password minimal 6 karakter";
    } elseif ($password !== $confirm_password) {// Memastikan password dan konfirmasi password cocok
        $errors[] = "Konfirmasi password tidak cocok";
    }

    // Memeriksa apakah ada error
    if (empty($errors)) {
        // Mengenkripsi password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        // Menyimpan data pengguna baru ke database
        $stmt = $conn->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $hashed_password, $role);
        // Menentukan status sukses jika data berhasil disimpan
        if ($stmt->execute()) {
            $success = true;
        } else {
            $errors[] = "Terjadi kesalahan saat mendaftar. Silakan coba lagi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Sistem Informasi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .password-requirements {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 0.25rem;
        }
        body {
            background: url('assets/img/unhas.webp') center/cover no-repeat;
            filter: none;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .card {
            background: rgba(0,0,0,0.5);
            border: none;
            border-radius: 25px;
            backdrop-filter: blur(0px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.19), 0 6px 6px rgba(0,0,0,0.23);
        }
        .card-header {
            background: #9B3922;
            border-radius: 15px 15px 0 0;
            padding: 20px;
        }
        .btn-primary {
            background: #9B3922;
            border: none;
            padding: 12px;
        }
        .btn-primary:hover {
            background: #481E14;
            transform: translateY(-1px);
            box-shadow: 0 7px 14px rgba(0,0,0,0.1), 0 3px 6px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header text-white text-center">
                        <h4>Register Akun Baru</h4>
                    </div>
                    <div class="card-body">
                        <!-- Menampilkan pesan sukses jika registrasi berhasil -->
                        <?php if ($success): ?>
                            <div class="alert alert-success">
                                Registrasi berhasil! Silakan <a href="login.php">login disini</a>.
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?php echo htmlspecialchars($error); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- Formulir pendaftaran pengguna -->
                        <?php if (!$success): ?>
                            <form method="POST" action="" class="needs-validation" novalidate>
                                <div class="mb-3">
                                    <label for="username" class="form-label text-white">Username</label>
                                    <input type="text" class="form-control" id="username" name="username" 
                                           value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                                           required minlength="4">
                                    <div class="password-requirements">
                                        Username minimal 4 karakter
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="password " class="form-label text-white">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required minlength="6">
                                    <div class="password-requirements">
                                        Password minimal 6 karakter
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label text-white">Konfirmasi Password</label>
                                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                                </div>
                                
                                <div class="d-grid gap-2">
                                    <button type="submit" class="btn btn-primary">Register</button>
                                </div>
                            </form>
                        <?php endif; ?>
                        
                        <div class="mt-3 text-center text-white">
                            <p>Sudah punya akun? <a href="login.php">Login disini</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms)
                .forEach(function (form) {
                    form.addEventListener('submit', function (event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }
                        form.classList.add('was-validated')
                    }, false)
                })
        })()

        document.getElementById('confirm_password').addEventListener('input', function() {
            if (this.value !== document.getElementById('password').value) {
                this.setCustomValidity('Passwords do not match');
            } else {
                this.setCustomValidity('');
            }
        });
    </script>
</body>
</html>