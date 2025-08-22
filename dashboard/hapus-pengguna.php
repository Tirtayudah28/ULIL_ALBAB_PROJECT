<?php
session_start();
include '../config/koneksi.php';

if (isset($_GET['id'])) {
    $id = (int) $_GET['id'];

    // Ambil nama file foto dari database
    $stmtFoto = $koneksi->prepare("SELECT foto FROM users_admin WHERE id = ?");
    $stmtFoto->bind_param("i", $id);
    $stmtFoto->execute();
    $stmtFoto->bind_result($foto);
    $stmtFoto->fetch();
    $stmtFoto->close();

    // Hapus data pengguna dari database
    $stmtHapus = $koneksi->prepare("DELETE FROM users_admin WHERE id = ?");
    $stmtHapus->bind_param("i", $id);

    if ($stmtHapus->execute()) {
        // Hapus foto dari folder jika ada dan bukan default
        if (!empty($foto) && file_exists("../images/foto_pengguna/$foto")) {
            unlink("../images/foto_pengguna/$foto");
        }

        $_SESSION['sukses'] = "Pengguna berhasil dihapus.";
    } else {
        $_SESSION['error'] = "Gagal menghapus pengguna.";
    }

    $stmtHapus->close();
} else {
    $_SESSION['error'] = "ID pengguna tidak valid.";
}

header("Location: kelola-pengguna.php");
exit;
?>
