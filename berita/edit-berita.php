<?php
session_start();
include '../config/koneksi.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>alert('ID berita tidak ditemukan'); window.location.href='../dashboard';</script>";
    exit;
}

$query = "SELECT * FROM berita WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$berita = mysqli_fetch_assoc($result);

if (!$berita) {
    echo "<script>alert('Berita tidak ditemukan'); window.location.href='../dashboard';</script>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul    = mysqli_real_escape_string($koneksi, $_POST['judul']);
    $kategori = mysqli_real_escape_string($koneksi, $_POST['kategori']);
    $tanggal  = $_POST['tanggal'];
    $penulis  = mysqli_real_escape_string($koneksi, $_POST['penulis']);
    $excerpt  = mysqli_real_escape_string($koneksi, $_POST['excerpt']);
    $isi      = mysqli_real_escape_string($koneksi, $_POST['isi_berita']);

    // Handle upload gambar
   $gambarLama = $berita['gambar'];
    $gambarBaru = isset($_FILES['gambar']) && $_FILES['gambar']['error'] === 0 ? $_FILES['gambar']['name'] : '';
    $gambarPath = $gambarLama;

    if (!empty($gambarBaru)) {
    $tmp = $_FILES['gambar']['tmp_name'];
    $ext = pathinfo($gambarBaru, PATHINFO_EXTENSION);
    $namaBaru = uniqid() . '.' . $ext;
    $folder = '../images/berita/';
    
    // Validasi jenis gambar
    $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
    if (!in_array(strtolower($ext), $allowedExt)) {
        echo "<script>alert('Format gambar tidak didukung. Hanya jpg, jpeg, png, gif, webp.'); window.history.back();</script>";
        exit;
    }

    move_uploaded_file($tmp, $folder . $namaBaru);
    $gambarPath = $namaBaru;

    if ($gambarLama && file_exists($folder . $gambarLama)) {
        unlink($folder . $gambarLama);
    }
}


    $query = "UPDATE berita SET 
                judul='$judul', 
                kategori='$kategori', 
                tanggal='$tanggal', 
                penulis='$penulis', 
                excerpt='$excerpt', 
                isi_berita='$isi', 
                gambar='$gambarPath'
              WHERE id=$id";

    if (mysqli_query($koneksi, $query)) {
        echo "<script>alert('Berita berhasil diperbarui'); window.location.href='../dashboard';</script>";
    } else {
        echo "Gagal update berita: " . mysqli_error($koneksi);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Berita</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
  <link href="https://unpkg.com/tabler-icons@latest/iconfont/tabler-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/rippleui@1.12.1/dist/css/styles.css" />
</head>
<body>
<?php include '../navbar.php'; ?>

<div class="tagline-form mt-[8rem] p-8 flex flex-row justify-between">
  <div class="title text-[2rem] text-blue-800 font-bold">
    <h1>Edit Berita/Blog</h1>
  </div>
  <div class="button-kembali border shadow-lg p-3 rounded-xl font-bold text-[0.8rem] hover:bg-slate-50">
    <a href="../dashboard"><i class="bi bi-arrow-left"></i> Kembali ke halaman Dashboard</a>
  </div>
</div>

<section class="form px-8">
<div class="wrapper-form-berita w-full flex justify-center items-center border shadow-xl rounded-xl p-8 mt-[1rem]">
    <div class="form-body w-full">
    <form class="flex flex-wrap gap-4 w-full" method="post" enctype="multipart/form-data">
    <!-- Input Judul Berita - Penuh -->
  <div class="mb-3 w-full">
    <label for="judul" class="block text-sm font-bold text-gray-700">Judul Berita</label>
    <input
      type="text"
      id="judul"
      name="judul"
      class="input input-ghost-primary w-full !max-w-none border border-gray-300 px-3 py-2 mt-1"
      placeholder="Masukkan judul berita"
      value="<?= htmlspecialchars($berita['judul']) ?>"
      required
    />
  </div>

  <!-- Input Kategori - 50% -->
  <div class="mb-3 w-[49%]">
    <label for="kategori" class="block text-sm font-bold text-gray-700">Kategori</label>
    <input
      type="text"
      id="kategori"
      name="kategori"
      class="input input-ghost-primary w-[49%] !max-w-none border border-gray-300 px-3 py-2 mt-1"
      placeholder="Masukkan kategori"
      value="<?= htmlspecialchars($berita['kategori']) ?>"
      required
    />
  </div>

  <!-- Input Tanggal - 50% -->
  <div class="mb-3 w-[49%] ml-2" >
    <label for="tanggal" class="block text-sm font-bold text-gray-700">Tanggal Publikasi</label>
    <input
      type="date"
      id="tanggal"
      name="tanggal"
      class="input input-ghost-primary w-[49%] !max-w-none border border-gray-300 px-3 py-2 mt-1"
      value="<?= $berita['tanggal'] ?>"
      required
    />
  </div>

    <div class="mb-3 w-full">
        <label for="judul" class="block text-sm font-bold text-gray-700">Penulis</label>
        <input
        type="text"
        id="penulis"
        name="penulis"
        class="input input-ghost-primary w-full !max-w-none border border-gray-300 px-3 py-2 mt-1"
        value="<?= htmlspecialchars($berita['penulis']) ?>"
        placeholder="Masukkan Nama Penulis"
        
        required
        />
  </div>

    <div class="mb-3 w-full">
        <label for="excerpt" class="block text-sm font-bold text-gray-700">Kutipan Singkat (Excerpt)</label>
        <textarea
        id="excerpt"
        name="excerpt"
        class="textarea-ghost-primary textarea w-full !max-w-none px-3 py-2 mt-1"
        placeholder="Tulis kutipan singkat berita"
        rows="3"
        required
        ><?= htmlspecialchars($berita['excerpt']) ?></textarea>
    </div>

    <div class="mb-3 w-full">
        <label for="isi_berita" class="block text-sm font-bold text-gray-700">Isi Berita Lengkap</label>
        <textarea
        id="isi_berita"
        name="isi_berita"
        class="textarea-ghost-primary textarea w-full !max-w-none px-3 py-2 mt-1"
        placeholder="Tulis isi berita secara lengkap"
        rows="6"
        required
        ><?= htmlspecialchars($berita['isi_berita']) ?></textarea>
    </div>

    <div class="mb-3 w-full">
  <label for="gambar" class="block text-sm font-bold text-gray-700">Gambar Utama Berita</label>
  <div class="container-images w-full border-2 border-dashed p-4 rounded-xl flex items-center gap-4">
    
    <!-- Preview Gambar Lama -->
    <img id="preview" src="../images/berita/<?= $berita['gambar'] ?>" alt="Gambar Lama" class="w-24 h-24 object-cover rounded-md border" />

    <!-- Custom Input File -->
    <label for="gambar" class="cursor-pointer flex items-center gap-2 px-4 py-2 text-slate-700 border rounded-md hover:bg-slate-100 transition">
      <i class="bi bi-file-image"></i>
      <span id="label-text">Ganti Gambar</span>
    </label>

    <!-- Input File Hidden -->
    <input
      type="file"
      id="gambar"
      name="gambar"
      accept="image/*"
      class="hidden px-3 py-2 mt-1"
      onchange="previewGambar(event)"
    />
  </div>
</div>


    <div class="button-publis flex justify-end itmes-end w-full gap-2">
        <a href="../dashboard"><button type="button" class="btn btn-outline-primary">Batal</button></a>
        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
    </div>
    </form>
        </div>   
    </div>
</section>

<script>
AOS.init({ duration: 1000, once: true });
function previewGambar(event) {
  const file = event.target.files[0];
  const preview = document.getElementById('preview');
  const labelText = document.getElementById('label-text');

  if (file) {
    const reader = new FileReader();
    reader.onload = function(e) {
      preview.src = e.target.result;
      labelText.textContent = "Gambar Dipilih";
    };
    reader.readAsDataURL(file);
  }
}
</script>

<script src="../script.js"></script>
<script src="bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdn.tailwindcss.com"></script>
</body>
</html>
