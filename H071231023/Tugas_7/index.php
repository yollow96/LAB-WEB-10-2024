<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'db_praktikum7';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
include './config/config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Menangani proses tambah data
if (isset($_POST['add'])) {
    if ($_SESSION['role'] == 'admin') {
        $name = $_POST['name'];
        $nim = $_POST['nim'];
        $studyProgram = $_POST['studyProgram'];
        
        $query = "INSERT INTO students (name, nim, studyProgram) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $name, $nim, $studyProgram);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Data mahasiswa berhasil ditambahkan";
        } else {
            $_SESSION['message'] = "Gagal menambahkan data mahasiswa";
        }
        header("Location: index.php");
        exit();
    }
}

// Menangani proses update data
if (isset($_POST['update'])) {
    if ($_SESSION['role'] == 'admin') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $nim = $_POST['nim'];
        $studyProgram = $_POST['studyProgram'];
        
        $query = "UPDATE students SET name=?, nim=?, studyProgram=? WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssi", $name, $nim, $studyProgram, $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Data mahasiswa berhasil diupdate";
        } else {
            $_SESSION['message'] = "Gagal mengupdate data mahasiswa";
        }
        header("Location: index.php");
        exit();
    }
}

// Menangani proses hapus data
if (isset($_GET['delete'])) {
    if ($_SESSION['role'] == 'admin') {
        $id = $_GET['delete'];
        
        $query = "DELETE FROM students WHERE id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $id);
        
        if ($stmt->execute()) {
            $_SESSION['message'] = "Data mahasiswa berhasil dihapus";
        } else {
            $_SESSION['message'] = "Gagal menghapus data mahasiswa";
        }
        header("Location: index.php");
        exit();
    }
}

// Menangani pencarian data
$search = isset($_GET['search']) ? $_GET['search'] : '';
if ($search != '') {
    $result = $conn->query("SELECT * FROM students WHERE name LIKE '%$search%' OR nim LIKE '%$search%' OR studyProgram LIKE '%$search%' ORDER BY id");
} else {
    $result = $conn->query("SELECT * FROM students ORDER BY id ASC");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Informasi Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #481E14;
            --secondary-color: #9B3922;
        }
        
        body {
            background: url('assets/img/unhas.webp') center/cover no-repeat;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        .navbar {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
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
        
        .card-title {
            color: var(--primary-color);
            font-weight: 600;
            margin: 0;
        }

        .modal-header{
            background: #9B3922 !important;

        }
        
        .btn-primary {
            background: var(--primary-color);
            border: none;
            padding: 0.5rem 1.5rem;
            transition: all 0.3s;
        }
        
        .btn-primary:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .table {
            margin-bottom: 0;
            background: rgba(0,0,0,0.5);
            border-radius: 15px;
            overflow: hidden;
        }
        
        .table thead th {
            border-bottom: 2px solid #dee2e6;
            background-color: rgba(255,255,255,0.1);
            color: #f8f9fa;
            font-weight: 600;
        }
        
        .table td {
            vertical-align: middle;
            background-color: rgba(255,255,255,0.1);
            color: #f8f9fa;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
        
        .form-control {
            border-radius: 8px;
            padding: 0.75rem;
            border: 1px solid #dee2e6;
        }
        
        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(37,99,235,0.2);
            border-color: var(--primary-color);
        }
        
        .modal-content {
            border-radius: 15px;
            border: none;
        }
        
        .modal-header {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-radius: 15px 15px 0 0;
            border-bottom: none;
        }
        
        .action-buttons {
            display: flex;
            gap: 0.5rem;
        }
        
        .btn-action {
            padding: 0.4rem 1rem;
            border-radius: 6px;
        }
        
        .welcome-badge {
            background: rgba(255,255,255,0.1);
            padding: 0.5rem 1rem;
            border-radius: 20px;
        }

        .footer {
            margin-top: auto;
        }

        .search-bar {
            max-width: 300px;
        }

    </style>
</head>
<body>
        <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark sticky-top no-print">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="#">
                <i class="fas fa-graduation-cap me-2"></i>
                Sistem Informasi Mahasiswa
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-3">
                        <span class="nav-link welcome-badge">
                            <i class="fas fa-user me-2"></i>
                            <?php echo htmlspecialchars($_SESSION['username']); ?> 
                            (<?php echo htmlspecialchars($_SESSION['role']); ?>)
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">
                            <i class="fas fa-sign-out-alt me-1"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Konten utama -->
    <div class="container my-5">
        <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show no-print" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php 
                echo $_SESSION['message']; 
                unset($_SESSION['message']);
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <!-- Form input data mahasiswa untuk admin -->
        <?php endif; ?>
        <?php if ($_SESSION['role'] == 'admin'): ?>
        <div class="card mb-5 no-print">
            <div class="card-header">
                <h5 class="card-title text-white">
                    <i class="fas fa-user-plus me-2 text-white"></i>
                    Input Data Mahasiswa
                </h5>
            </div>
            <!-- Tabel data mahasiswa -->
            <div class="card-body p-4">
                <form action="" method="POST" class="row g-3">
                    <div class="col-md-4">
                        <label for="name" class="form-label text-white">Nama</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="col-md-4">
                        <label for="nim" class="form-label text-white">NIM</label>
                        <input type="text" class="form-control" id="nim" name="nim" required>
                    </div>
                    <div class="col-md-4">
                        <label for="studyProgram" class="form-label text-white">Program Studi</label>
                        <input type="text" class="form-control" id="studyProgram" name="studyProgram" required>
                    </div>
                    <div class="col-12">
                        <button type="submit" name="add" class="btn btn-primary">
                            <i class="fas fa-plus-circle me-2"></i>Tambah Data
                        </button>
                    </div>
                </form>
            </div>
        </div>
        <?php endif; ?>

        <!-- Student Data Table -->
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title text-white">
                    <i class="fas fa-list me-2 text-white"></i>Data Mahasiswa</h5>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover" id="studentTable">
                        <thead>
                            <tr>
                                <th class="px-4">No</th>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Program Studi</th>
                                <?php if ($_SESSION['role'] == 'admin'): ?>
                                <th class="px-4 no-print">Aksi</th>
                                <?php endif; ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $no = 1;
                            while ($row = $result->fetch_assoc()):
                            ?>
                            <tr>
                                <td class="px-4"><?= $no++ ?></td>
                                <td><?= htmlspecialchars($row['name']) ?></td>
                                <td><?= htmlspecialchars($row['nim']) ?></td>
                                <td><?= htmlspecialchars($row['studyProgram']) ?></td>
                                <?php if ($_SESSION['role'] == 'admin'): ?>
                                <td class="px-4 no-print">
                                    <div class="action-buttons">
                                        <button type="button" class="btn btn-warning btn-action" 
                                                data-bs-toggle="modal" data-bs-target="#editModal<?= $row['id'] ?>">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <a href="?delete=<?= $row['id'] ?>" 
                                           class="btn btn-danger btn-action"
                                           onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </td>
                                <?php endif; ?>
                            </tr>

                            <?php if ($_SESSION['role'] == 'admin'): ?>
                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal<?= $row['id'] ?>" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">
                                                <i class="fas fa-edit me-2"></i>
                                                Edit Data Mahasiswa
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body p-4">
                                            <form action="" method="POST">
                                                <input type="hidden" name="id" value="<?= $row['id'] ?>">
                                                <div class="mb-3">
                                                    <label for="edit_name" class="form-label">Nama</label>
                                                    <input type="text" class="form-control" id="edit_name" 
                                                           name="name" value="<?= htmlspecialchars($row['name']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_nim" class="form-label">NIM</label>
                                                    <input type="text" class="form-control" id="edit_nim" 
                                                           name="nim" value="<?= htmlspecialchars($row['nim']) ?>" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="edit_studyProgram" class="form-label">Program Studi</label>
                                                    <input type="text" class="form-control" id="edit_studyProgram" 
                                                           name="studyProgram" value="<?= htmlspecialchars($row['studyProgram']) ?>" required>
                                                </div>
                                                <button type="submit" name="update" class="btn btn-primary">Simpan Perubahan</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>