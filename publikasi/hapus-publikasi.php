<?php
include '../config/koneksi.php';
session_start();

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>alert('ID tidak ditemukan.'); window.history.back();</script>";
    exit;
}

// Hapus dari database
$query = "DELETE FROM publikasi WHERE id = $id";
if (mysqli_query($koneksi, $query)) {
    echo "<script>alert('Berita berhasil dihapus.'); window.location.href='../dashboard';</script>";
} else {
    echo "<script>alert('Gagal menghapus berita.'); window.history.back();</script>";
}
?>
