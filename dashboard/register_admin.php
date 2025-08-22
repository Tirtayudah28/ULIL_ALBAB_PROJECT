<?php
session_start();
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Pengguna</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet" />
</head>
<body class="bg-sky-50">
<?php include '../navbar.php'; ?>

<div class="max-w-xl mx-auto mt-[10rem] mb-16 bg-white p-8 shadow-lg rounded-xl border border-blue-100 relative">
  <div class="absolute top-4 right-4">
    <a href="../dashboard/" class="text-sm text-blue-600 hover:underline flex items-center">
      <i class="bi bi-arrow-left mr-1"></i> Kembali ke Dashboard
    </a>
  </div>

  <h1 class="text-2xl font-bold text-blue-800 py-4 mb-6 text-center">Form Registrasi Pengguna</h1>

  <?php if (isset($_SESSION['error'])): ?>
    <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
      <?= $_SESSION['error']; unset($_SESSION['error']); ?>
    </div>
  <?php endif; ?>
  <?php if (isset($_SESSION['sukses'])): ?>
    <div class="bg-green-100 border border-green-400 text-green-700 p-3 rounded mb-4">
      <?= $_SESSION['sukses']; unset($_SESSION['sukses']); ?>
    </div>
  <?php endif; ?>

  <form action="proses_register.php" method="POST" enctype="multipart/form-data" class="space-y-4">

    <div>
      <label for="nama" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
      <input type="text" id="nama" name="nama" placeholder="Masukkan Nama" required class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-200">
    </div>

    <div>
      <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
      <input type="email" id="email" name="email" placeholder="Masukkan Email" required class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-200">
    </div>

    <div>
      <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
      <input type="password" id="password" name="password" placeholder="Masukkan Password" required class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-200">
    </div>

    <div>
      <label for="role" class="block text-sm font-semibold text-gray-700">Role</label>
      <select id="role" name="role" required class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-200">
        <option value="">-- Pilih Role --</option>
        <option value="admin">Admin</option>
        <option value="editor">Editor</option>
      </select>
    </div>

    <div>
  <label for="foto" class="block text-sm font-semibold text-gray-700">Foto Pengguna</label>

  <!-- Preview Gambar -->
  <div class="mb-2">
    <img id="previewFoto" 
         src="https://via.placeholder.com/96?text=Foto" 
         alt="Preview Foto" 
         class="w-24 h-24 object-cover rounded-full border" />
  </div>

  <!-- Input File -->
  <input type="file" id="foto" name="foto" accept="image/*"
         class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-200">
</div>


    <div class="text-end pt-4">
      <button type="submit" class="border hover:bg-blue-900 text-blue-900 hover:text-white font-bold px-6 py-2 rounded-md shadow-md transition">Daftar</button>
    </div>

  </form>
</div>

<?php include '../footer.php'; ?>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 1000, once: true });</script>
<script>
  document.getElementById('foto').addEventListener('change', function (event) {
    const [file] = event.target.files;
    if (file) {
      const preview = document.getElementById('previewFoto');
      preview.src = URL.createObjectURL(file);
    }
  });
</script>
</body>
</html>
