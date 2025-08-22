<?php 
session_start();
include '../config/koneksi.php'; // koneksi DB

$query = "SELECT * FROM publikasi ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);

// Ambil kategori unik
$kategoriQuery = "SELECT DISTINCT kategori FROM publikasi ORDER BY kategori ASC";
$kategoriResult = mysqli_query($koneksi, $kategoriQuery);

$kategoriAktif = isset($_GET['kategori']) ? $_GET['kategori'] : 'Semua';

if ($kategoriAktif === 'Semua') {
    $query = "SELECT * FROM publikasi ORDER BY id DESC";
} else {
    $kategoriSafe = mysqli_real_escape_string($koneksi, $kategoriAktif);
    $query = "SELECT * FROM publikasi WHERE kategori='$kategoriSafe' ORDER BY id DESC";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Galeri Publikasi</title>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
<link rel="stylesheet" href="publikasi.css" />
<link rel="stylesheet" href="../main.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link href="https://unpkg.com/tabler-icons@latest/iconfont/tabler-icons.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/rippleui@1.12.1/dist/css/styles.css" />
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />

<style>
:root {
    --rb-green: #15803d;
    --rb-orange: #f97316;
}

/* Reset */
* { box-sizing: border-box; }
html, body { overflow-x: hidden; }

/* Tombol kategori */
.btn-kategori {
    transition: all 0.3s ease;
    cursor: pointer;
    font-weight: 500;
}

.btn-kategori.default {
    background-color: white;
    color: #686767;
}

.btn-kategori.default:hover {
    background-color: var(--rb-green);
    color: white;
}

.btn-kategori.active {
    background-color: var(--rb-green);
    color: white;
}

.btn-kategori.active:hover {
    background-color: var(--rb-orange);
    color: white;
}
</style>
</head>
<body>

<?php include '../navbar.php'; ?>

<section class="relative bg-[url('https://transparenttextures.com/patterns/cubes.png')] bg-[var(--rb-green)] text-white text-center py-28 px-2 overflow-hidden">
    <div class="text flex justify-center items-center flex-col w-full">
        <i class="bi bi-image block animate-bounce" data-aos="fade-down" data-aos-delay="600"></i>
        <h1 data-aos="fade-up" data-aos-delay="600">Galeri Publikasi</h1>
        <p data-aos="fade-up" data-aos-delay="600">Dokumentasi visual berbagai kegiatan dan program inspiratif dari RUMAH BACA</p>
    </div>
</section>

<div class="kategori" data-aos="zoom-in" data-aos-delay="600">
  <div class="menu-kategori flex gap-2" id="kategoriFilter">
    <button data-kategori="Semua" class="btn-kategori active px-4 py-2 rounded shadow text-center">Semua</button>
    <?php while ($row = mysqli_fetch_assoc($kategoriResult)) : ?>
      <button data-kategori="<?= htmlspecialchars($row['kategori']) ?>" 
              class="btn-kategori default py-2 px-2 rounded shadow text-center">
        <?= htmlspecialchars($row['kategori']) ?>
      </button>
    <?php endwhile; ?>
  </div>
</div>

<!-- Galeri Grid -->
<div id="galeriContainer" class="grid grid-cols-3 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-4 gap-4 px-4 py-12 mt-[1rem]">
  <?php while ($row = mysqli_fetch_assoc($result)) : ?>
    <div class="galeri-item relative group cursor-pointer aspect-square overflow-hidden rounded-md shadow transition-all duration-300"
      data-kategori="<?= htmlspecialchars($row['kategori']) ?>"
      onclick="showImageModal('../images/publikasi/<?= $row['gambar'] ?>', '<?= $row['judul_gambar'] ?>', '<?= $row['deskripsi'] ?>')">
      <img src="../images/publikasi/<?= $row['gambar'] ?>" alt="<?= $row['judul_gambar'] ?>" class="w-full h-full object-cover">
      <div class="absolute inset-0 flex flex-col justify-center items-center pointer-events-none">
        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 border-4 border-dashed border-white w-10 h-10 mb-1"></div>
        <div class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 text-white font-bold text-sm">
          <?= htmlspecialchars($row['judul_gambar']) ?>
        </div>
      </div>
    </div>
  <?php endwhile; ?>
</div>

<!-- Modal tampil gambar -->
<div id="imageModal" class="fixed inset-0 z-50 flex justify-center items-center pointer-events-none">
  <div id="modalContent" class="relative bg-white p-4 rounded shadow-lg max-w-lg w-full scale-0 transition-transform duration-300 text-center">
    <button onclick="closeImageModal()" class="absolute top-2 right-2 text-gray-800 hover:text-red-500 text-3xl font-bold">
      <i class="bi bi-x-lg"></i>
    </button>
    <img id="modalImage" src="" class="w-full h-auto rounded mb-4" />
    <h2 id="modalTitle" class="text-lg font-bold mb-2"></h2>
    <p id="modalDesc" class="text-gray-600 text-sm"></p>
  </div>
</div>

<?php include '../footer.php'; ?>

<script src="<?= $base_url ?>translate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="publikasi.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
<script>
AOS.init({ duration: 1000, once: true });

function showImageModal(src, title, desc) {
  const modal = document.getElementById('imageModal');
  const content = document.getElementById('modalContent');
  document.getElementById('modalImage').src = src;
  document.getElementById('modalTitle').textContent = title;
  document.getElementById('modalDesc').textContent = desc;
  modal.classList.remove('pointer-events-none');
  content.classList.remove('scale-0');
  content.classList.add('scale-100');

  modal.onclick = function(e) {
    if(!content.contains(e.target)) closeImageModal();
  };
}

function closeImageModal() {
  const modal = document.getElementById('imageModal');
  const content = document.getElementById('modalContent');
  content.classList.remove('scale-100');
  content.classList.add('scale-0');
  setTimeout(() => { modal.classList.add('pointer-events-none'); }, 300);
}

// Tombol kategori
const btnKategori = document.querySelectorAll('.btn-kategori');
const items = document.querySelectorAll('.galeri-item');

btnKategori.forEach(button => {
  button.addEventListener('click', () => {
    btnKategori.forEach(btn => { btn.classList.remove('active'); btn.classList.add('default'); });
    button.classList.add('active'); button.classList.remove('default');

    const kategori = button.dataset.kategori;

    items.forEach(item => {
      if (kategori === "Semua" || item.dataset.kategori === kategori) item.classList.remove('hidden');
      else item.classList.add('hidden');
    });

    // Fetch data dari get_galeri.php
    fetch(`get_galeri.php?kategori=${encodeURIComponent(kategori)}`)
      .then(res => res.text())
      .then(data => { document.getElementById('galeriContainer').innerHTML = data; });
  });
});
</script>
</body>
</html>
