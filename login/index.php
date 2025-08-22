<?php 
  session_start();
  include '../config/koneksi.php';
?>

<?php if (isset($_GET['pesan']) && $_GET['pesan'] === 'belum_login') : ?>
  <div id="alertLogin" class="w-full bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 animate__animated animate__fadeInDown text-center" role="alert">
    <strong>Oops!</strong> Anda harus login terlebih dahulu.
  </div>
<?php endif; ?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login Admin - ABI Foundation</title>

  <!-- Tailwind + Icons -->
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="https://unpkg.com/tabler-icons@latest/iconfont/tabler-icons.min.css" rel="stylesheet" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&family=Poppins&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>
<body class="bg-sky-50 min-h-screen flex flex-col">

<?php include '../navbar.php'; ?>

<!-- Login Form -->
<div class="flex-grow flex items-center justify-center px-4 py-20 mt-[5rem]">
  <div class="w-full max-w-md bg-white shadow-xl rounded-xl p-8 space-y-6" data-aos="zoom-in" data-aos-delay="100">
    <div class="text-center">
      <h1 class="text-3xl font-bold text-green-700 mb-1">RUMAH BACA</h1>
      <p class="text-sm text-stone-500">Masukkan kredensial akun admin Anda</p>
    </div>

    <form action="proses-login.php" method="POST" class="space-y-4">
  <div>
    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
    <input type="email" name="email" id="email" required
           class="w-full border px-3 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-green-300" />
  </div>

  <div class="relative">
    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
    <input type="password" name="password" id="password" required
           class="w-full border px-3 py-2 pr-10 rounded-md focus:outline-none focus:ring-2 focus:ring-green-300" />
    <button type="button" onclick="togglePassword()" class="absolute right-3 top-9 text-gray-500 hover:text-green-700">
      <i id="icon-eye" class="bi bi-eye"></i>
    </button>
  </div>

  <button type="submit" name="login"
          class="w-full border-2 border-green-800 hover:text-white hover:bg-green-800 text-green-800 py-2 rounded-md font-bold">
    LOGIN
  </button>
</form>

  </div>
</div>

<!-- Footer -->
<?php 
  include '../footer.php';
?>

<!-- Scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script>
  AOS.init({ duration: 1000, once: true });

  setTimeout(() => {
    const alertBox = document.getElementById('alertLogin');
    if (alertBox) {
      alertBox.style.transition = 'opacity 0.6s ease';
      alertBox.style.opacity = '0';
      setTimeout(() => alertBox.remove(), 600);
    }
  }, 4000);

  function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.getElementById("icon-eye");
    if (input.type === "password") {
      input.type = "text";
      icon.classList.remove("bi-eye");
      icon.classList.add("bi-eye-slash");
    } else {
      input.type = "password";
      icon.classList.remove("bi-eye-slash");
      icon.classList.add("bi-eye");
    }
  }
</script>

</body>
</html>
