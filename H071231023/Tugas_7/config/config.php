<?php 
$host = "localhost";
$user = "root";
$pass = "";
$db = "db_praktikum7";

$conn = mysqli_connect($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Koneksi ke database GAGAL!");
}

?>