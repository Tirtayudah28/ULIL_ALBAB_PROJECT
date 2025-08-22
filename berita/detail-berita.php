<?php
include '../config/koneksi.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Ambil data berita berdasarkan ID
$data = mysqli_query($koneksi, "SELECT * FROM berita WHERE id = $id");
$berita = mysqli_fetch_assoc($data);

if (!$berita) {
  echo "Berita tidak ditemukan.";
  exit;
}

// Tambah jumlah baca tanpa session
mysqli_query($koneksi, "UPDATE berita SET jumlah_dibaca = jumlah_dibaca + 1 WHERE id = $id");
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= htmlspecialchars($berita['judul']) ?> - ABI Foundation</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" rel="stylesheet" />
</head>
<body class="bg-white text-gray-800 font-sans">

<?php include '../navbar.php'; ?>

<!-- Gambar Utama -->
<div class="w-full max-w-full max-h-[500px] overflow-hidden">
  <img src="../images/berita/<?= htmlspecialchars($berita['gambar']) ?>" alt="<?= htmlspecialchars($berita['judul']) ?>" class="w-full h-auto max-h-[500px] object-cover">
</div>

<!-- Konten -->
<main class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 md:grid-cols-12 gap-8">
  <!-- Artikel -->
  <article class="md:col-span-8 space-y-6">
    <!-- Judul -->
    <h1 class="text-3xl md:text-4xl font-bold text-blue-900 leading-tight"><?= htmlspecialchars($berita['judul']) ?></h1>

    <!-- Info -->
    <div class="text-sm text-blue-600 flex flex-wrap gap-4 items-center">
      <span><i class="bi bi-calendar-event"></i> <?= date('d M Y', strtotime($berita['tanggal'])) ?></span>
      <span><i class="bi bi-person-circle"></i> <?= htmlspecialchars($berita['penulis']) ?></span>
      <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs"><i class="bi bi-tag"></i> <?= htmlspecialchars($berita['kategori']) ?></span>
      <span class="text-gray-500 text-xs flex items-center gap-1"><i class="bi bi-eye"></i> <?= (int)$berita['jumlah_dibaca'] ?> kali dibaca</span>
    </div>

    <!-- Isi -->
    <div class="text-lg text-gray-800 leading-relaxed whitespace-pre-line">
      <?= nl2br(htmlspecialchars($berita['isi_berita'])) ?>
    </div>

    <!-- Share -->
    <div class="mt-6 flex gap-3 items-center">
      <span class="text-sm text-gray-600">Bagikan:</span>
      <a href="https://api.whatsapp.com/send?text=<?= urlencode($berita['judul']) ?> - <?= urlencode('https://example.com/berita/detail-berita.php?id=' . $id) ?>" target="_blank" class="text-green-500 hover:text-green-600 text-xl"><i class="bi bi-whatsapp"></i></a>
      <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode('https://example.com/berita/detail-berita.php?id=' . $id) ?>" target="_blank" class="text-blue-600 hover:text-blue-700 text-xl"><i class="bi bi-facebook"></i></a>
    </div>

    <a href="index.php" class="inline-block mt-8 text-blue-600 hover:underline text-sm"><i class="bi bi-arrow-left"></i> Kembali ke daftar berita</a>
  </article>

  <!-- Sidebar -->
  <!-- Sidebar -->
<aside class="md:col-span-4 space-y-4">
  <h2 class="text-lg font-semibold text-blue-900 border-b pb-2">Berita Populer</h2>
  <div class="space-y-4 max-h-[500px] overflow-y-auto pr-2">
    <?php
    $berita_populer = mysqli_query($koneksi, "SELECT id, judul, tanggal, gambar FROM berita WHERE id != $id ORDER BY jumlah_dibaca DESC LIMIT 5");
    while ($b = mysqli_fetch_assoc($berita_populer)) {
      echo '
      <div class="flex gap-3 border-b pb-3">
        <img src="../images/berita/' . htmlspecialchars($b['gambar']) . '" alt="' . htmlspecialchars($b['judul']) . '" class="w-16 h-16 object-cover rounded">
        <div class="flex-1">
          <a href="detail-berita.php?id=' . $b['id'] . '" class="text-sm font-semibold text-blue-800 hover:underline block leading-tight">
            ' . htmlspecialchars($b['judul']) . '
          </a>
          <span class="text-xs text-gray-500"><i class="bi bi-calendar3"></i> ' . date('d M Y', strtotime($b['tanggal'])) . '</span>
        </div>
      </div>';
    }
    ?>
  </div>
</aside>

</main>

<?php include '../footer.php'; ?>

</body>
</html>
