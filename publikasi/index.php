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
 body { font-family: 'Poppins', sans-serif; color:#0f172a; }
    .navbar{ transition: top .4s ease; }
    .nav-link{ position:relative; }
    .nav-link:after{
      content:""; position:absolute; left:0; bottom:-6px; height:2px; width:0;
      background:linear-gradient(90deg,#0ea5a0,#f97316); transition:width .25s;
    }
    .nav-link:hover:after{ width:100%; }
    .btn-primary{ background:linear-gradient(90deg,#f97316,#fb923c); color:#fff; }
    .btn-primary:hover{ filter:brightness(.95); }
    .hover-green:hover{ color:#0ea5a0; }
    .hover-bg-green:hover{ background:rgba(14,165,160,.08); }
    .hover-bg-orange:hover{ background:#fed7aa; }

    :root{
      --rb-green: #0f7a54;
      --rb-orange: #ff7a18;
      --rb-dark: #0f172a;
    }
    html, body {
      margin: 0;
      padding: 0;
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
  <!-- Navbar -->
  <header id="navbar" class="navbar fixed top-0 left-0 w-full bg-white border-b border-gray-100 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="h-16 flex items-center justify-between">
        <!-- Logo -->
        <a href="index.html" class="flex items-center gap-3 md:gap-4">
          <img src="../image/logo.png" alt="Rumah Baca" class="h-16 md:h-20 w-auto object-contain">
        </a>

        <!-- Menu Desktop -->
        <nav class="hidden md:flex space-x-6 items-center font-bold text-gray-500">
          <a href="../index.html" class="nav-link hover:text-green-600" data-key="home">Beranda</a>
          <a href="../tentang-kami/index.html" class="nav-link hover:text-green-600" data-key="about">Tentang Kami</a>
          <a href="../program/index.html" class="nav-link hover:text-green-600" data-key=" program">Program</a>
          <div class="relative group" id="mediaMenu">
            <button class="nav-link hover:text-green-600 flex items-center" data-key="media">
              Media
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="absolute hidden group-hover:block bg-white shadow-lg mt-2 rounded-lg py-2 w-40" id="mediaDropdown">
              <a href="../berita/index.html" class="block px-4 py-2 hover:bg-green-100 hover:text-green-600" data-key="news">Berita</a>
              <a href="../publikasi/index.html" class="block px-4 py-2 hover:bg-green-100 hover:text-green-600" data-key="publication">Publikasi</a>
            </div>
          </div>
          <a href="../pojok-baca/index.html" class="nav-link hover:text-green-600" data-key="pojok">Pojok Baca</a>
          <a href="../hubungi-kami/index.html" class="nav-link hover:text-green-600" data-key="contact">Hubungi Kami</a>
          <a href="../donasi/index.html" class="btn-primary rounded-lg px-4 py-2 font-semibold shadow-soft" data-key="donate">Donasi</a>

          <!-- Bahasa -->
          <div class="relative" id="langMenu">
            <button class="nav-link hover-green flex items-center gap-1">
              ID
              <svg class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                <path stroke-linecap="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
              </svg>
            </button>
            <div class="absolute right-0 mt-3 w-40 rounded-xl bg-white border shadow-lg py-2 hidden" id="langDropdown">
              <a href="?lang=id" class="block px-4 py-2 hover:bg-green-100">🇮🇩 Indonesia</a>
              <a href="?lang=en" class="block px-4 py-2 hover:bg-green-100">🇬🇧 English</a>
            </div>
          </div>

          <!-- Profile/Login -->
          <div class="relative">
            <button id="profileBtn" class="w-9 h-9 rounded-full bg-gray-200 flex items-center justify-center hover:ring-2 ring-offset-2 ring-[#0ea5a0]">
              <svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/>
              </svg>
            </button>
            <!-- Dropdown user -->
            <div id="profileDropdown" class="absolute right-0 mt-2 w-48 bg-white border shadow-lg rounded-lg py-2 hidden">
              <a href="#" id="myProfile" class="block px-4 py-2 hover:bg-green-100" data-key="profile">Profil Saya</a>
              <a href="#" id="uploadBook" class="block px-4 py-2 hover:bg-green-100" data-key="upload">Upload Buku</a>
              <a href="#" id="logoutBtn" class="block px-4 py-2 hover:bg-green-100 text-red-500 font-semibold" data-key="logout">Logout</a>
            </div>
          </div>

        </nav>

        <!-- Hamburger Mobile -->
        <div class="flex items-center md:hidden">
          <button id="hamburger" class="focus:outline-none">
            <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="fixed top-0 right-0 w-64 h-full bg-white shadow-lg hidden flex-col p-6 z-40">
      <button id="closeMenu" class="self-end mb-6">✖</button>
      <a href="../index.php" class="block py-2 font-semibold" data-key="home">Beranda</a>
      <a href="../tentang-kami/index.html" class="block py-2 font-semibold" data-key="about">Tentang Kami</a>
      <a href="../program/index.html" class="block py-2 font-semibold" data-key="program">Program</a>
      <details class="py-2">
        <summary class="cursor-pointer font-semibold" data-key="media">Media</summary>
        <a href="../berita/index.html" class="block py-2 pl-4" data-key="news">Berita</a>
        <a href="../publikasi/index.html" class="block py-2 pl-4" data-key="publication">Publikasi</a>
      </details>
      <a href="../pojok-baca/index.html" class="block py-2 font-semibold" data-key="pojok">Pojok Baca</a>
      <a href="../hubungi-kami/index.html" class="block py-2 font-semibold" data-key="contact">Hubungi Kami</a>
      <a href="../donasi/index.html" class="block py-2 text-orange-600 font-bold" data-key="donation">Donasi</a>
      <div class="mt-6">
        <p class="text-sm text-gray-500 mb-2">Pilih Bahasa:</p>
        <a href="?lang=id" class="block py-1">🇮🇩 Indonesia</a>
        <a href="?lang=en" class="block py-1">🇬🇧 English</a>
      </div>
    </div>
  </header>
    

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

        <!-- FOOTER (expanded) -->
<footer class="bg-[var(--rb-green)] text-white pt-12 pb-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
      <!-- About -->
      <div>
        <div class="flex items-center gap-3">
           <img src="../image/logo.png" alt="Rumah Baca" class="h-16 md:h-20 w-auto object-contain">
          <div>
            <div class="font-semibold text-lg">Rumah Baca Ulil Albab</div>
            <div class="text-sm text-emerald-100">Membangun generasi literasi.</div>
          </div>
        </div>
        <p class="mt-4 text-emerald-100/90 text-sm">Ruang aman untuk membaca, berdiskusi, dan berkarya—didukung relawan & komunitas.</p>
      </div>

      <!-- Quick links -->
      <div>
        <div class="font-semibold mb-3">Tautan</div>
        <ul class="space-y-2 text-emerald-100/90 text-sm">
          <li><a href="#" class="hover:underline">Beranda</a></li>
          <li><a href="#about" class="hover:underline">Tentang Kami</a></li>
          <li><a href="#programs" class="hover:underline">Program</a></li>
          <li><a href="#pojokbaca" class="hover:underline">Pojok Baca</a></li>
          <li><a href="#news" class="hover:underline">Berita</a></li>
        </ul>
      </div>

      <!-- Donasi info -->
      <div>
        <div class="font-semibold mb-3">Donasi</div>
        <div class="text-emerald-100/90 text-sm space-y-2">
          <div>Bank BCA — 123-456-7890 (a.n. Yayasan Ulil Albab)</div>
          <div>Bank Mandiri — 987-654-3210 (a.n. Rumah Baca Ulil Albab)</div>
          <div class="mt-3">Scan QRIS:</div>
          <div class="mt-2">
            <img src="https://via.placeholder.com/140x140.png?text=QRIS" alt="QRIS Donasi" class="rounded-md border">
          </div>
        </div>
      </div>

      <!-- Newsletter & social -->
      <div>
        <div class="font-semibold mb-3">Newsletter</div>
        <p class="text-emerald-100/90 text-sm">Dapatkan kabar kegiatan & jadwal donasi rutin.</p>
        <form class="mt-3 flex flex-col sm:flex-row gap-2">
          <input type="email" placeholder="Email kamu" class="w-full rounded-lg px-3 py-2 text-slate-800" />
          <button class="rounded-lg bg-[var(--rb-orange)] px-4 py-2 font-semibold">Berlangganan</button>
        </form>

        <div class="mt-4 flex flex-wrap gap-3 text-emerald-100">
          <a href="#" class="hover:text-white">Facebook</a>
          <a href="#" class="hover:text-white">Instagram</a>
          <a href="#" class="hover:text-white">YouTube</a>
          <a href="#" class="hover:text-white">LinkedIn</a>
        </div>
      </div>
    </div>

    <div class="mt-10 border-t border-white/20 pt-6 flex flex-col md:flex-row items-center justify-between gap-3 text-emerald-100/90 text-sm">
      <div>© 2025 Rumah Baca Ulil Albab. Semua hak dilindungi.</div>
      <div>Didesain dengan ♥ oleh Tim Rumah Baca Ulil Albab — tema: hijau & oranye.</div>
    </div>
  </div>
</footer>

<script src="../translate.js"></script>
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
    // Firebase config
    const firebaseConfig = {
      apiKey: "YOUR_API_KEY",
      authDomain: "YOUR_PROJECT_ID.firebaseapp.com",
      projectId: "YOUR_PROJECT_ID",
      storageBucket: "YOUR_PROJECT_ID.appspot.com",
      messagingSenderId: "YOUR_SENDER_ID",
      appId: "YOUR_APP_ID"
    };
    firebase.initializeApp(firebaseConfig);
    const auth = firebase.auth();

    // Navbar scroll hide/show
    let lastScroll = 0;
    const navbar = document.getElementById('navbar');
    window.addEventListener('scroll', () => {
      let currentScroll = window.pageYOffset;
      if (currentScroll > lastScroll) navbar.style.top = "-80px";
      else navbar.style.top = "0";
      lastScroll = currentScroll;
    });

    // Mobile menu
    const hamburger = document.getElementById('hamburger');
    const mobileMenu = document.getElementById('mobileMenu');
    const closeMenu = document.getElementById('closeMenu');
    hamburger.addEventListener('click', () => { mobileMenu.classList.remove('hidden'); mobileMenu.classList.add('show'); });
    closeMenu.addEventListener('click', () => { mobileMenu.classList.add('hidden'); mobileMenu.classList.remove('show'); });

    // Popup login
    const profileBtn = document.getElementById('profileBtn');
    const loginPopup = document.getElementById('loginPopup');
    const closePopup = document.getElementById('closePopup');
    profileBtn.addEventListener('click', () => { loginPopup.classList.remove('hidden'); loginPopup.classList.add('flex'); });
    closePopup.addEventListener('click', () => { loginPopup.classList.add('hidden'); loginPopup.classList.remove('flex'); });

    // Dropdown menus
    document.getElementById('mediaMenu').addEventListener('click', () => { document.getElementById('mediaDropdown').classList.toggle('hidden'); });
    document.getElementById('langMenu').addEventListener('click', () => { document.getElementById('langDropdown').classList.toggle('hidden'); });

    // Firebase Social Login
    document.getElementById('loginGoogle').addEventListener('click', () => {
      const provider = new firebase.auth.GoogleAuthProvider();
      auth.signInWithPopup(provider).then(result => {
        loginPopup.classList.add('hidden');
      }).catch(console.error);
    });

    document.getElementById('loginFacebook').addEventListener('click', () => {
      const provider = new firebase.auth.FacebookAuthProvider();
      auth.signInWithPopup(provider).then(result => { loginPopup.classList.add('hidden'); }).catch(console.error);
    });

    document.getElementById('loginApple').addEventListener('click', () => {
      const provider = new firebase.auth.OAuthProvider('apple.com');
      auth.signInWithPopup(provider).then(result => { loginPopup.classList.add('hidden'); }).catch(console.error);
    });

    // Login Email
    document.getElementById('loginEmailBtn').addEventListener('click', () => {
      const email = document.getElementById('emailInput').value;
      auth.sendSignInLinkToEmail(email, {
        url: window.location.href,
        handleCodeInApp: true
      }).then(() => {
        window.localStorage.setItem('emailForSignIn', email);
        alert("Cek email untuk verifikasi login.");
      }).catch(console.error);
    });

    // Update Navbar setelah login
    const profileDropdown = document.getElementById('profileDropdown');
    auth.onAuthStateChanged(user => {
      if(user){
        profileBtn.innerHTML = `<img src="${user.photoURL || 'default-avatar.png'}" class="w-9 h-9 rounded-full"/>`;
        profileBtn.addEventListener('click', ()=>{ profileDropdown.classList.toggle('hidden'); });
      } else {
        profileBtn.innerHTML = `<svg class="w-6 h-6 text-gray-600" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.7 0 5-2.3 5-5s-2.3-5-5-5-5 2.3-5 5 2.3 5 5 5zm0 2c-3.3 0-10 1.7-10 5v3h20v-3c0-3.3-6.7-5-10-5z"/></svg>`;
      }
    });

    // Logout
    document.getElementById('logoutBtn').addEventListener('click', () => {
      auth.signOut().then(()=>{ location.reload(); });
    });

    // mobile menu toggle
    const mobileBtn = document.getElementById('mobileBtn');
    const mobilePanel = document.getElementById('mobilePanel');
    mobileBtn?.addEventListener('click', () => {
      if (mobilePanel.classList.contains('hidden')) {
        mobilePanel.classList.remove('hidden');
        mobilePanel.classList.add('animate-slide-down');
      } else {
        mobilePanel.classList.add('hidden');
        mobilePanel.classList.remove('animate-slide-down');
      }
    });

    document.addEventListener('DOMContentLoaded', () => {
      const els = document.querySelectorAll('.will-animate');
      els.forEach((el, idx) => {
        setTimeout(() => el.classList.add('show'), idx * 90);
      });
    });

    // Reader modal
    function openReader(title){
      document.getElementById('readerTitle').textContent = title;
      document.getElementById('readerModal').classList.remove('hidden');
      document.getElementById('readerModal').classList.add('flex');
    }
    function closeReader(){
      document.getElementById('readerModal').classList.add('hidden');
      document.getElementById('readerModal').classList.remove('flex');
    }
</script>
</body>
</html>
