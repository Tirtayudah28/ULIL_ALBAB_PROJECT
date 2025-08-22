<?php
session_start();
include '../config/koneksi.php';

// Ambil data pengguna berdasarkan ID
if (!isset($_GET['id'])) {
  header('Location: kelola-pengguna.php');
  exit;
}

$id = intval($_GET['id']);
$query = $koneksi->prepare("SELECT * FROM users_admin WHERE id = ?");
$query->bind_param('i', $id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows !== 1) {
  header('Location: kelola-pengguna.php');
  exit;
}

$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pengguna</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet" />
</head>
<body class="bg-sky-50">
<?php include '../navbar.php'; ?>

<div class="max-w-2xl mx-auto mt-[10rem] mb-16 bg-white p-8 shadow-lg rounded-xl border border-blue-100">
  <h1 class="text-2xl font-bold text-blue-800 mb-6 text-center">Edit Data Pengguna</h1>
  <form action="proses_edit_user.php" method="POST" enctype="multipart/form-data" class="space-y-4">
    <input type="hidden" name="id" value="<?= $user['id'] ?>">

    <div>
      <label for="nama" class="block text-sm font-semibold text-gray-700">Nama Lengkap</label>
      <input type="text" id="nama" name="nama" required value="<?= htmlspecialchars($user['nama']) ?>" class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-200">
    </div>

    <div>
      <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
      <input type="email" id="email" name="email" required value="<?= htmlspecialchars($user['email']) ?>" class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-200">
    </div>

    <div>
      <label for="role" class="block text-sm font-semibold text-gray-700">Role</label>
      <select id="role" name="role" class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-200">
        <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="editor" <?= $user['role'] === 'editor' ? 'selected' : '' ?>>Editor</option>
      </select>
    </div>

    <div>
      <label for="status" class="block text-sm font-semibold text-gray-700">Status</label>
      <select id="status" name="status" class="w-full px-3 py-2 border rounded-md focus:ring focus:ring-blue-200">
        <option value="aktif" <?= $user['status'] === 'aktif' ? 'selected' : '' ?>>Aktif</option>
        <option value="nonaktif" <?= $user['status'] === 'nonaktif' ? 'selected' : '' ?>>Nonaktif</option>
      </select>
    </div>

<div>
  <label for="foto" class="block text-sm font-semibold text-gray-700">Foto (opsional)</label>
  
  <!-- Preview Foto Lama -->
  <div class="mb-2">
    <img id="previewFoto" 
         src="<?= !empty($user['foto']) ? '../images/foto_pengguna/' . $user['foto'] : 'https://via.placeholder.com/96?text=Foto' ?>" 
         alt="Foto Pengguna" 
         class="w-24 h-24 object-cover rounded-full border" />
  </div>

  <!-- Input File dengan Label Placeholder -->
  <label for="foto" class="block cursor-pointer bg-white border border-gray-300 text-gray-600 py-2 px-3 rounded-md w-full text-sm hover:bg-gray-50 transition">
    Masukkan foto anda
    <input type="file" id="foto" name="foto" accept="image/*" class="hidden">
  </label>
</div>


    <div class="pt-4 text-end">
      <a href="kelola-pengguna.php" class="inline-block bg-gray-200 text-gray-700 hover:bg-gray-300 px-4 py-2 rounded-md mr-2">Batal</a>
      <button type="submit" class="border-2 border-blue-900 text-blue-900 font-bold hover:text-white px-4 py-2 rounded-md hover:bg-blue-800">Simpan Perubahan</button>
    </div>
  </form>
</div>

<?php include '../footer.php'; ?>
</body>
</html>
