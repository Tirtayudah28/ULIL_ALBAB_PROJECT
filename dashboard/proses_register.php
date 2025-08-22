<?php 
session_start();
include '../config/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama     = trim($_POST['nama']);
    $email    = trim($_POST['email']);
    $password = $_POST['password'];
    $role     = $_POST['role'] ?? 'admin';
    $waktu_sekarang = date('Y-m-d H:i:s');

    // Validasi input
    if (empty($nama) || empty($email) || empty($password)) {
        $_SESSION['error'] = "Semua field wajib diisi.";
        header('Location: register_admin.php');
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Email tidak valid.";
        header('Location: register_admin.php');
        exit;
    }

    // Cek apakah email sudah digunakan
    $stmt = $koneksi->prepare("SELECT id FROM users_admin WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $_SESSION['error'] = "Email sudah terdaftar.";
        header('Location: register_admin.php');
        exit;
    }
    $stmt->close();

    // Proses foto jika diupload
    $foto_nama = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_nama = uniqid('user_', true) . '.' . strtolower($ext);
        $target_dir = '../images/foto_pengguna/';
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        move_uploaded_file($_FILES['foto']['tmp_name'], $target_dir . $foto_nama);
    }

    // Hash password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Simpan ke database
    $stmt = $koneksi->prepare("INSERT INTO users_admin (nama, email, password, role, foto, status, dibuat_pada, diperbarui_pada) 
                               VALUES (?, ?, ?, ?, ?, 'aktif', ?, ?)");
    $stmt->bind_param("sssssss", $nama, $email, $password_hash, $role, $foto_nama, $waktu_sekarang, $waktu_sekarang);

    if ($stmt->execute()) {
        $_SESSION['sukses'] = "Registrasi berhasil.";
        header('Location: kelola-pengguna.php');
    } else {
        $_SESSION['error'] = "Terjadi kesalahan. Coba lagi.";
        header('Location: register_admin.php');
    }

    $stmt->close();
    $koneksi->close();
} else {
    header('Location: register_admin.php');
    exit;
}
?>
