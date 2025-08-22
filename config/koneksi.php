<?php
// KONFIGURASI DATABASE UNTUK HOSTING (AwardSpace)
$db_host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "rumah-baca";

$conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

// CEK KONEKSI
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// DETEKSI PROTOKOL (http atau https)
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';

// HOST saat ini, misal: localhost atau abi-foundation.atwebpages.com
$host = $_SERVER['HTTP_HOST'];

// AUTO BASE URL
if ($host === 'localhost') {
    // Untuk development lokal
    $base_url = $protocol . '://' . $host . '/ULIL_ALBAB_PROJECT/';
} else {
    // Untuk hosting online — ambil dari host otomatis
    $base_url = $protocol . '://' . $host . '/';
}
?>
