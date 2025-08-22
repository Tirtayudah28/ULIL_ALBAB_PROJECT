<?php
session_start();
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = $_POST['id'];
    $role   = $_POST['role'];
    $status = $_POST['status'];

    // Ambil nama file lama dari database
    $getFoto = $koneksi->prepare("SELECT foto FROM users_admin WHERE id = ?");
    $getFoto->bind_param('i', $id);
    $getFoto->execute();
    $getFoto->bind_result($foto_lama);
    $getFoto->fetch();
    $getFoto->close();

    // Cek jika ada upload foto baru
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $namaFileBaru = uniqid() . '_' . basename($_FILES['foto']['name']);
        $targetPath = '../images/foto_pengguna/' . $namaFileBaru;

        // Validasi ekstensi file
        $allowed_ext = ['jpg', 'jpeg', 'png', 'gif'];
        $ext = strtolower(pathinfo($namaFileBaru, PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed_ext)) {
            $_SESSION['error'] = "Format foto tidak valid. Gunakan JPG/PNG/GIF.";
            header("Location: edit-pengguna.php?id=$id");
            exit;
        }

        if (move_uploaded_file($_FILES['foto']['tmp_name'], $targetPath)) {
            // Hapus foto lama jika ada dan bukan default
            if (!empty($foto_lama) && file_exists("../images/foto_pengguna/$foto_lama")) {
                unlink("../images/foto_pengguna/$foto_lama");
            }

            // Update data + foto baru
            $stmt = $koneksi->prepare("UPDATE users_admin SET role=?, status=?, foto=?, diperbarui_pada=NOW() WHERE id=?");
            $stmt->bind_param("sssi", $role, $status, $namaFileBaru, $id);
        } else {
            $_SESSION['error'] = "Gagal upload foto baru.";
            header("Location: edit-pengguna.php?id=$id");
            exit;
        }
    } else {
        // Update tanpa ubah foto
        $stmt = $koneksi->prepare("UPDATE users_admin SET role=?, status=?, diperbarui_pada=NOW() WHERE id=?");
        $stmt->bind_param("ssi", $role, $status, $id);
    }

    if ($stmt->execute()) {
        $_SESSION['sukses'] = "Data pengguna berhasil diperbarui.";
    } else {
        $_SESSION['error'] = "Gagal menyimpan perubahan.";
    }

    $stmt->close();
    $koneksi->close();

    header("Location: kelola-pengguna.php");
    exit;
} else {
    header("Location: kelola-pengguna.php");
    exit;
}
?>
