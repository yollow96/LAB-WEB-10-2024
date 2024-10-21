<?php
// Mulai session
session_start();

// Array of users
$users = [
    [
        'email' => 'admin@gmail.com',
        'username' => 'adminxxx',
        'name' => 'Admin',
        'password' => password_hash('admin123', PASSWORD_DEFAULT),
    ],
    [
        'email' => 'nanda@gmail.com',
        'username' => 'nanda_aja',
        'name' => 'Wd. Ananda Lesmono',
        'password' => password_hash('nanda123', PASSWORD_DEFAULT),
        'gender' => 'Female',
        'faculty' => 'MIPA',
        'batch' => '2021',
    ],
    [
        'email' => 'arif@gmail.com',
        'username' => 'arif_nich',
        'name' => 'Muhammad Arief',
        'password' => password_hash('arief123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Hukum',
        'batch' => '2021',
    ],
    [
        'email' => 'eka@gmail.com',
        'username' => 'eka59',
        'name' => 'Eka Hanny',
        'password' => password_hash('eka123', PASSWORD_DEFAULT),
        'gender' => 'Female',
        'faculty' => 'Keperawatan',
        'batch' => '2021',
    ],
    [
        'email' => 'adnan@gmail.com',
        'username' => 'adnan72',
        'name' => 'Adnan',
        'password' => password_hash('adnan123', PASSWORD_DEFAULT),
        'gender' => 'Male',
        'faculty' => 'Teknik',
        'batch' => '2020',
    ],
];

// Fungsi untuk autentikasi user
function authenticate($email_or_username, $password) {
    global $users;
    foreach ($users as $user) {
        // Jika email atau username sama dan password benar, maka return user
        if (($user['email'] === $email_or_username || $user['username'] === $email_or_username) && password_verify($password, $user['password'])) {
            return $user;
        }
    }
    // Jika tidak ada user yang sesuai, maka return null
    return null;
}

// Fungsi untuk mengecek apakah user sudah login atau belum
function is_logged_in() {
    return isset($_SESSION['user']);
}

// Fungsi untuk meminta user login dulu jika belum login
function require_login() {
    if (!is_logged_in()) {
        header('Location: login.php');
        exit();
    }
}

// Fungsi untuk mengecek apakah user yang sedang login adalah admin atau tidak
function is_admin() {
    return is_logged_in() && $_SESSION['user']['email'] === 'admin@gmail.com';
}
?>
