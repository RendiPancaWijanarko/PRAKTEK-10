<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "db_penjualan";

// Membuat koneksi
$koneksi = new mysqli($servername, $username, $password, $database);

// Memeriksa koneksi
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

mysqli_set_charset($koneksi, "utf8");
?>
