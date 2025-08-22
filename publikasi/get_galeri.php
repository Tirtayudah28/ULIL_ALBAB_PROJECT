<?php
include '../config/koneksi.php';

$kategori = $_GET['kategori'] ?? 'Semua';

if ($kategori === 'Semua') {
    $query = "SELECT * FROM publikasi ORDER BY id DESC";
} else {
    $kategori = mysqli_real_escape_string($koneksi, $kategori);
    $query = "SELECT * FROM publikasi WHERE kategori='$kategori' ORDER BY id DESC";
}

$result = mysqli_query($koneksi, $query);

while ($row = mysqli_fetch_assoc($result)) :
?>
  <div class="relative group cursor-pointer aspect-square overflow-hidden rounded-md shadow"
       onclick="showImageModal('../images/publikasi/<?= $row['gambar'] ?>', '<?= $row['judul_gambar'] ?>', '<?= $row['deskripsi'] ?>')">
    <img src="../images/publikasi/<?= $row['gambar'] ?>" alt="<?= $row['judul_gambar'] ?>" class="w-full h-full object-cover transition-all duration-300">
    <div class="absolute inset-0 flex flex-col justify-center items-center pointer-events-none">
      <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 border-4 border-dashed border-white w-10 h-10 md:w-10 md:h-10 mb-1"></div>
      <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-opacity-80 text-white font-bold px-2 py-1 rounded text-sm mt-1">
        <?= htmlspecialchars($row['judul_gambar']) ?>
      </div>
    </div>
  </div>
<?php endwhile; ?>
