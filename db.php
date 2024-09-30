<?php
// Koneksi ke database
$host = 'localhost';   // Ganti jika menggunakan server lain
$dbname = 'a2project';
$username = 'root';     // Ganti dengan username MySQL Anda
$password = '';         // Ganti dengan password MySQL Anda

// Buat koneksi
$db = new mysqli($host, $username, $password, $dbname);

// Cek koneksi
if ($db->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>