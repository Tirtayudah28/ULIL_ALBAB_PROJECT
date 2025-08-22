<?php
session_start();
include '../config/koneksi.php';

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $stmt = $koneksi->prepare("SELECT * FROM users_admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        if (password_verify($password, $user['password'])) {
            if ($user['status'] !== 'aktif') {
                $_SESSION['error'] = "Akun Anda nonaktif. Hubungi admin.";
                header("Location: index.php");
                exit;
            }

            $_SESSION['login'] = true;
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];

            header("Location: ../dashboard/index.php?pesan=login_berhasil");
            exit;
        } else {
            $_SESSION['error'] = "Password salah.";
            header("Location: index.php");
            exit;
        }
    } else {
        $_SESSION['error'] = "Email tidak ditemukan.";
        header("Location: index.php");
        exit;
    }
}
?>
