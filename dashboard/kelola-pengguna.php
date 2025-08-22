<?php
session_start();
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kelola Pengguna - ABI Foundation</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body { font-family: 'Poppins', sans-serif; }
  </style>
</head>
<body class="bg-sky-50 text-gray-800">

<?php include '../navbar.php'; ?>

<div class="max-w-7xl mx-auto px-4 py-10 my-[10rem]" data-aos="fade-up">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-3xl font-bold text-blue-900">Kelola Pengguna</h1>
    <a href="register_admin.php" class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-lg shadow"><i class="bi bi-person-plus"></i> Tambah Pengguna</a>
  </div>

  <div class="overflow-x-auto rounded-xl shadow bg-white">
    <table class="min-w-full divide-y divide-gray-200">
      <thead class="bg-blue-900 text-white">
        <tr>
          <th class="px-6 py-3 text-left text-sm font-semibold">Nama</th>
          <th class="px-6 py-3 text-left text-sm font-semibold">Email</th>
          <th class="px-6 py-3 text-left text-sm font-semibold">Role</th>
          <th class="px-6 py-3 text-left text-sm font-semibold">Status</th>
          <th class="px-6 py-3 text-left text-sm font-semibold">Aksi</th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-100">
        <?php
        $users = mysqli_query($koneksi, "SELECT * FROM users_admin ORDER BY id DESC");
        while ($user = mysqli_fetch_assoc($users)) : ?>
        <tr class="hover:bg-gray-50">
          <td class="px-6 py-4"> <?= htmlspecialchars($user['nama']) ?> </td>
          <td class="px-6 py-4"> <?= htmlspecialchars($user['email']) ?> </td>
          <td class="px-6 py-4">
            <span class="inline-block px-2 py-1 text-xs rounded-full <?php echo $user['role'] === 'admin' ? 'bg-blue-200 text-blue-900' : 'bg-gray-200 text-gray-700'; ?>">
              <?= htmlspecialchars($user['role']) ?>
            </span>
          </td>
          <td class="px-6 py-4">
            <span class="inline-block px-2 py-1 text-xs rounded-full <?php echo $user['status'] === 'aktif' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'; ?>">
              <?= htmlspecialchars($user['status']) ?>
            </span>
          </td>
          <td class="px-6 py-4 space-x-2">
            <a href="edit-user.php?id=<?= $user['id'] ?>" class="text-blue-600 hover:text-blue-800"><i class="bi bi-pencil"></i></a>
            <a href="hapus-user.php?id=<?= $user['id'] ?>" onclick="return confirm('Yakin ingin menghapus pengguna ini?')" class="text-red-600 hover:text-red-800"><i class="bi bi-trash"></i></a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include '../footer.php'; ?>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>AOS.init({ duration: 1000, once: true });</script>
</body>
</html>
