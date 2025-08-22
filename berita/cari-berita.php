<?php
include '../config/koneksi.php';

$keyword = mysqli_real_escape_string($koneksi, $_GET['q'] ?? '');
$kategori = mysqli_real_escape_string($koneksi, $_GET['kategori'] ?? '');

$query = "SELECT * FROM berita WHERE 1";
if ($keyword !== '') $query .= " AND judul LIKE '%$keyword%'";
if ($kategori !== '') $query .= " AND kategori = '$kategori'";
$query .= " ORDER BY tanggal DESC";

$result = mysqli_query($koneksi, $query);

if (mysqli_num_rows($result) === 0) {
  echo '';
  exit;
}

while ($row = mysqli_fetch_assoc($result)) {
  $judul = htmlspecialchars($row['judul']);
  $kategori = htmlspecialchars($row['kategori']);
  $excerpt = htmlspecialchars($row['excerpt']);
  $tanggal = date('d M Y', strtotime($row['tanggal']));
  $gambar = htmlspecialchars($row['gambar']);
  $id = $row['id'];
  echo '
  <div class="bg-white rounded-lg shadow hover:shadow-lg transition">
    <img src="../images/berita/' . $gambar . '" alt="' . $judul . '" class="w-full h-48 object-cover rounded-t-lg">
    <div class="p-5">
      <span class="inline-block text-sm bg-blue-100 text-blue-800 px-3 py-1 rounded-full mb-2">' . $kategori . '</span>
      <h2 class="font-bold text-lg text-gray-800 mb-2">' . $judul . '</h2>
      <p class="text-gray-600 text-sm mb-3">' . $excerpt . '</p>
      <div class="text-sm text-gray-500 mb-3"><i class="bi bi-calendar-event"></i> ' . $tanggal . '</div>
      <a href="detail-berita.php?id=' . $id . '" class="text-blue-600 font-semibold hover:underline">Baca Selengkapnya <i class="bi bi-arrow-right"></i></a>
    </div>
  </div>';
}
?>
