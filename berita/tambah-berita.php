<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Berita</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />   
    <link href="https://unpkg.com/tabler-icons@latest/iconfont/tabler-icons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/rippleui@1.12.1/dist/css/styles.css"
    />

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Poppins:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
      rel="stylesheet"
    />
</head>
<body>
    <?php 
        include '../navbar.php';
    ?>

 <div class="tagline-form mt-[8rem] p-8 flex flex-row justify-between">
            <div class="title text-[2rem] text-blue-800 font-bold">
                <h1 class="">Tambah Berita/Blog Baru</h1>
            </div>
            <div class="button-kembali border shadow-lg p-3 rounded-xl font-bold text-[0.8rem] hover:bg-slate-50">
                <a href="../dashboard/index.php"><i class="bi bi-arrow-left"></i> Kembali ke halaman Dashboard</a>
            </div>
        </div>
<section class="form px-8">
<div class="wrapper-form-berita w-full flex justify-center items-center border shadow-xl rounded-xl p-8 mt-[1rem]">
    <div class="form-body w-full">
    <form class="flex flex-wrap gap-4 w-full" action="proses-tambah-berita.php" method="post" enctype="multipart/form-data">
    <!-- Input Judul Berita - Penuh -->
  <div class="mb-3 w-full">
    <label for="judul" class="block text-sm font-bold text-gray-700">Judul Berita</label>
    <input
      type="text"
      id="judul"
      name="judul"
      class="input input-ghost-primary w-full !max-w-none border border-gray-300 px-3 py-2 mt-1"
      placeholder="Masukkan judul berita"
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
        ></textarea>
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
        ></textarea>
    </div>

    <div class="mb-3 w-full">
        <label for="gambar" class="block text-sm font-bold text-gray-700">Gambar Utama Berita</label>
        <div class="container-images w-full border-2 border-dashed p-4 rounded-xl flex items-center gap-4">
        
        <!-- Preview Gambar -->
        <img id="preview" src="" alt="Preview" class="w-24 h-24 object-cover rounded-md border hidden" />
        
     <!-- Custom Input File -->
            <label for="gambar" class="cursor-pointer flex items-center gap-2 px-4 py-2 text-slate-700 border rounded-md hover:bg-slate-100 transition">
            <i class="bi bi-file-image"></i>
            <span id="label-text">Upload Gambar</span>
            </label>
        
        <!-- Input File Hidden -->
        <input
            type="file"
            id="gambar"
            name="gambar"
            accept="image/*"
            class="hidden px-3 py-2 mt-1"
            onchange="previewGambar(event)"
            required
        />
        </div>
    </div>

    <div class="button-publis flex justify-end itmes-end w-full gap-2">
        <a href="../dashboard"><button type="reset" class="btn btn-outline-primary">Batal</button></a>
        <button type="submit" class="btn btn-primary">Publikasikan</button>
    </div>
    </form>

        </div>   
    </div>
</section>

<script>
     AOS.init({
        duration: 1000, // default durasi animasi
        once: true      // hanya animasi sekali
      });

       function previewGambar(event) {
    const file = event.target.files[0];
    const preview = document.getElementById('preview');
    const labelText = document.getElementById('label-text');

    if (file) {
      const reader = new FileReader();
      reader.onload = function(e) {
        preview.src = e.target.result;
        preview.classList.remove('hidden');
        labelText.textContent = "Ganti Gambar";
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