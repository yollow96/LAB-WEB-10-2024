<?php
session_start();
include './config/config.php';

// Fungsi untuk membuat akun admin jika belum ada
function setupAdmin($conn) {       
    // Memeriksa apakah akun admin sudah ada
    $check = $conn->query("SELECT * FROM users WHERE username = 'admin'");
    
    // Jika belum ada akun admin, buat akun dengan kredensial default
    if ($check->num_rows == 0) {
        $admin_username = 'admin';
        $admin_password = 'admin123';
        $hashed_password = password_hash($admin_password, PASSWORD_DEFAULT);
        $role = 'admin';
        
        // Menyiapkan pernyataan SQL untuk memasukkan pengguna admin baru
        $query = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $admin_username, $hashed_password, $role);
        $stmt->execute();
        
        // Mengembalikan kredensial admin untuk ditampilkan di halaman login
        return [
            'username' => $admin_username,
            'password' => $admin_password
        ];
    }
    return null;
}

// Memanggil fungsi setupAdmin untuk membuat admin jika dibutuhkan
$adminCreated = setupAdmin($conn);

if(isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$error = '';
$success = '';

if ($adminCreated) {
    $success = "User admin berhasil dibuat! Username: {$adminCreated['username']}, Password: {$adminCreated['password']}";
}

// Menangani pengiriman formulir login
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = $_POST['password'];
   
    // Memeriksa apakah ada field yang kosong
    if(empty($username) || empty($password)) {
        $error = "Silakan isi username dan password";
    } else {
        // Menyiapkan pernyataan SQL untuk mengambil data pengguna
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
       
        // Verifikasi pengguna dan password jika pengguna ditemukan
        if ($result->num_rows == 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: index.php");
                exit();
            } else {
                $error = "Password salah!";
            }
        } else {
            $error = "Username tidak ditemukan!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"  content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Informasi Mahasiswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
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
        .form-control {
            border-radius: 10px;
            padding: 12px;
        }
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(46, 106, 244, 0.2);
        }
        .password-container {
            position: relative;
        }
        .password-toggle {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6c757d;
            z-index: 10;
        }
        .alert {
            border-radius: 10px;
        }
        .register-link {
            color: #9B3922;
            text-decoration: none;
            font-weight: 500;
        }
        .register-link:hover {
            color: #481E14;
            text-decoration: underline;
        }
        .animated {
            animation: fadeIn 0.5s ease-in;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow animated">
                    <div class="card-header">
                        <div class="d-flex justify-content-center align-items-center mb-0">
                            <img src="assets/img/logounhas.png" width="50" height="50" class="me-2">
                            <h4 class="card-title text-white mb-0">LOGIN</h4>
                        </div>
                    </div>
                    <div class="card-body p-4">
                        <?php if(!empty($error)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <?php echo $error; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(!empty($success)): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                <?php echo $success; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>
                       
                        <!-- Formulir login -->
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                            <div class="mb-4">
                                <label for="username" class="form-label text-white">
                                    <i class="fas fa-user me-2"></i>Username
                                </label>
                                <input type="text" class="form-control" id="username" name="username" 
                                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                                       required placeholder="Masukkan username">
                            </div>
                            <div class="mb-4">
                                <label for="password" class="form-label  text-white">
                                    <i class="fas fa-lock me-2"></i>Password
                                </label>
                                <div class="password-container">
                                    <input type="password" class="form-control" id="password" name="password" 
                                           required placeholder="Masukkan password">
                                    <span class="password-toggle" onclick="togglePassword()">
                                        <i class="far fa-eye" id="toggleIcon"></i>
                                    </span>
                                </div>
                            </div>
                            <div class="d-grid gap-2 mb-4">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-sign-in-alt me-2"></i>Login
                                </button>
                            </div>
                        </form>
                        <div class="text-center  text-white">
                            <p class="mb-0">Belum punya akun? 
                                <a href="register.php" class="register-link">
                                    <i class="fas fa-user-plus me-1"></i>Daftar disini
                                </a>
                            </p>
                            <?php if($adminCreated): ?>
                            <div class="alert alert-info mt-3">
                                <small>
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Info:</strong> Akun admin telah dibuat otomatis.<br>
                                    Gunakan kredensial di atas untuk login sebagai admin.
                                </small>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Password Toggle Script -->
    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            // Mengubah visibilitas password
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>