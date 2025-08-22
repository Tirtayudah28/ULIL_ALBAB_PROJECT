<?php
session_start();
include '../config/koneksi.php'; // Pastikan file ini sudah ada

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data dari form
    $judul     = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $kategori  = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $tanggal   = $_POST['tanggal'];
    $penulis   = mysqli_real_escape_string($koneksi, $_POST['penulis']);
    $excerpt   = mysqli_real_escape_string($koneksi, $_POST['excerpt']);
    $isi       = mysqli_real_escape_string($koneksi, $_POST['isi_berita']);

    // Proses upload gambar
    $gambar        = $_FILES['gambar']['name'];
    $gambar_tmp    = $_FILES['gambar']['tmp_name'];
    $gambar_folder = '../images/berita/' . $gambar;

    // Validasi ekstensi
    $allowed_ext = ['jpg', 'jpeg', 'png', 'webp'];
    $file_ext = strtolower(pathinfo($gambar, PATHINFO_EXTENSION));

    if (!in_array($file_ext, $allowed_ext)) {
        echo "<script>alert('Format gambar tidak didukung!'); window.history.back();</script>";
        exit;
    }

    // Upload gambar
    if (move_uploaded_file($gambar_tmp, $gambar_folder)) {
        // Simpan ke database
        $query = "INSERT INTO berita (judul, kategori, tanggal, penulis, excerpt, isi_berita, gambar) 
                  VALUES ('$judul', '$kategori', '$tanggal', '$penulis', '$excerpt', '$isi', '$gambar')";

        if (mysqli_query($koneksi, $query)) {
            echo "<script>alert('Berita berhasil ditambahkan!'); window.location.href='../dashboard/index.php';</script>";
        } else {
            echo "<script>alert('Gagal menyimpan berita!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Gagal mengupload gambar!'); window.history.back();</script>";
    }
} else {
    echo "<script>alert('Metode tidak diizinkan!'); window.history.back();</script>";
}
?>
