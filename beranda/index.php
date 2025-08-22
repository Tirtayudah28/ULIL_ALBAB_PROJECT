<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Rumah Baca Ulil Albab — Beranda</title>
  <meta name="description" content="Rumah Baca Ulil Albab — Program literasi, rumah baca komunitas, donasi buku & kegiatan edukatif." />
  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- AOS (Animate on Scroll) -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

  <!-- Icons (Heroicons) -->
  <script src="https://unpkg.com/feather-icons"></script>

  <style>
    :root{
      --rb-green: #0f7a54;
      --rb-orange: #ff7a18;
      --rb-dark: #0f172a;
    }
    html, body {
      margin: 0;
      padding: 0;
    }

    /* pulse-dot style */
      .pulse-dot {
    width: 16px;
    height: 16px;
    background-color: #f97316; /* orange */
    border-radius: 50%;
    position: relative;
    box-shadow: 0 0 0 rgba(249,115,22, 0.4);
    animation: pulse 2s infinite;
  }
  @keyframes pulse {
    0% { box-shadow: 0 0 0 0 rgba(249,115,22, 0.6); }
    70% { box-shadow: 0 0 0 12px rgba(249,115,22, 0); }
    100% { box-shadow: 0 0 0 0 rgba(249,115,22, 0); }
  }
  </style>

</head>
<body>

<?php 
  include '../navbar.php';
?>

  <!-- HERO -->
<main>
<!-- HERO SECTION FULL RESPONSIVE -->
<section class="relative h-[80vh] md:h-[90vh] overflow-x-hidden ">
  <!-- Background image -->
  <img src="<?= $base_url ?>image/hero-picture.jpg"
       alt="Anak-anak belajar bersama"
       class="absolute inset-0 w-full h-full object-cover z-0" />

  <!-- Gradient overlay -->
  <div class="absolute inset-0 bg-gradient-to-r from-[var(--rb-green)]/85 via-[var(--rb-green)]/60 to-transparent z-10"></div>

  <!-- Subtle pattern overlay -->
  <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10 z-20"></div>

  <!-- Main content -->
  <div class="relative z-30 w-full h-full flex flex-col md:flex-row items-center justify-center md:justify-between px-6 sm:px-8 lg:px-12">
    
    <!-- Left Text Content -->
    <div class="max-w-lg md:max-w-2xl text-white will-animate" data-aos="fade-right" data-aos-delay="150">
      <span class="inline-block bg-white/20 px-4 py-1 rounded-full text-sm tracking-wide shadow">
        📚 Program Rumah Baca
      </span>
      <h1 class="mt-6 text-3xl sm:text-4xl md:text-6xl font-extrabold leading-tight drop-shadow-lg">
        Rumah Baca <span class="text-orange-300">Ulil Albab</span>
      </h1>
      <p class="mt-4 text-base sm:text-lg text-white/90 leading-relaxed">
        Membangun budaya baca — ruang belajar, ruang bermain, ruang berbagi pengetahuan untuk anak dan keluarga.
      </p>
      <div class="mt-6 flex gap-4 flex-wrap">
        <a href="#pojokbaca"
           class="rounded-full bg-white text-[var(--rb-green)] px-6 sm:px-7 py-3 font-semibold shadow-lg hover:scale-105 hover:shadow-xl transition-transform duration-300">
           Mulai Membaca
        </a>
        <a href="#programs"
           class="rounded-full border border-white/60 px-6 sm:px-7 py-3 font-semibold hover:bg-white/10 hover:border-white transition">
           Lihat Program
        </a>
      </div>
    </div>

    <!-- Right Decorative Image -->
    <div class="hidden md:flex relative will-animate" data-aos="fade-left" data-aos-delay="300">
      <div class="absolute -top-10 -left-10 w-60 sm:w-72 h-60 sm:h-72 rounded-full bg-orange-400/20 blur-3xl animate-pulse"></div>
      <img src="https://images.unsplash.com/photo-1596495577886-d920f1fb7238?q=80&w=400&auto=format&fit=crop"
           alt="Buku dekoratif"
           class="relative w-48 sm:w-60 rounded-xl shadow-2xl transform hover:rotate-2 hover:scale-105 transition duration-500">
    </div>

  </div>

  <!-- Floating small elements -->
  <div class="absolute top-10 right-6 sm:right-10 w-10 h-10 bg-white/20 rounded-full animate-bounce z-20"></div>
  <div class="absolute bottom-16 left-6 sm:left-12 w-6 h-6 bg-orange-300/30 rounded-full animate-ping z-20"></div>
</section>


<!-- WHY / MENGAPA (DIBUAT MIRIP ABOUT US DENGAN 2 GAMBAR) -->
<section id="about" class="py-20 bg-gradient-to-b from-white to-emerald-50">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col-reverse lg:flex-row gap-12 items-center">
    
    <!-- Bagian Teks -->
    <div class="will-animate lg:order-2" data-aos="fade-right">
      <h2 class="text-3xl md:text-4xl font-bold text-[var(--rb-green)] mb-6">
        Mengapa Rumah Baca Ulil Albab?
      </h2>
      <p class="text-slate-700 leading-relaxed mb-6">
        Rumah Baca hadir sebagai ruang belajar bersama untuk anak-anak, remaja, hingga masyarakat umum. 
        Kami percaya bahwa <span class="font-semibold text-[var(--rb-orange)]">literasi adalah kunci</span> 
        menuju masa depan yang lebih baik. 
      </p>
      <p class="text-slate-700 leading-relaxed mb-6">
        Dengan menyediakan akses bacaan, program terstruktur, dan dukungan komunitas, 
        kami membangun generasi pembelajar seumur hidup yang penuh rasa ingin tahu, 
        kreatif, dan peduli terhadap lingkungannya.
      </p>

      <!-- Highlight / poin penting -->
      <div class="grid sm:grid-cols-2 gap-4 mt-6">
        <div class="bg-white shadow rounded-xl p-4 flex items-start gap-3">
          <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-emerald-100 text-[var(--rb-green)] text-lg">📚</div>
          <div>
            <h3 class="font-semibold">Akses Bacaan</h3>
            <p class="text-sm text-slate-600">Perpustakaan mini dengan koleksi buku edukatif & cerita anak.</p>
          </div>
        </div>
        <div class="bg-white shadow rounded-xl p-4 flex items-start gap-3">
          <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-orange-100 text-[var(--rb-orange)] text-lg">👩‍🏫</div>
          <div>
            <h3 class="font-semibold">Program Literasi</h3>
            <p class="text-sm text-slate-600">Kegiatan membaca, menulis, bercerita & pengembangan digital.</p>
          </div>
        </div>
        <div class="bg-white shadow rounded-xl p-4 flex items-start gap-3">
          <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-emerald-100 text-[var(--rb-green)] text-lg">🤝</div>
          <div>
            <h3 class="font-semibold">Komunitas Relawan</h3>
            <p class="text-sm text-slate-600">Kolaborasi relawan, sekolah, & komunitas setempat.</p>
          </div>
        </div>
        <div class="bg-white shadow rounded-xl p-4 flex items-start gap-3">
          <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-orange-100 text-[var(--rb-orange)] text-lg">🌱</div>
          <div>
            <h3 class="font-semibold">Masa Depan Hijau</h3>
            <p class="text-sm text-slate-600">Menanamkan nilai peduli lingkungan sejak dini.</p>
          </div>
        </div>
      </div>

      <!-- Statistik berbentuk balon -->
      <div class="grid grid-cols-2 sm:grid-cols-4 gap-6 mt-12">
        <div class="flex flex-col items-center">
          <div class="w-24 h-24 rounded-full bg-emerald-100 flex flex-col justify-center items-center shadow-md relative">
            <span class="text-3xl">📖</span>
            <h3 class="text-lg font-bold text-[var(--rb-green)] counter" data-target="1500">0</h3>
          </div>
          <p class="mt-2 text-sm text-slate-600">Buku Tersedia</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="w-24 h-24 rounded-full bg-orange-100 flex flex-col justify-center items-center shadow-md relative">
            <img src="../image/children.png" alt="" srcset="" class="w-12 h-12">
            <h3 class="text-lg font-bold text-[var(--rb-orange)] counter" data-target="500">0</h3>
          </div>
          <p class="mt-2 text-sm text-slate-600">Anak Terbantu</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="w-24 h-24 rounded-full bg-emerald-100 flex flex-col justify-center items-center shadow-md relative">
            <img src="../image/volunteer.png" alt="" srcset="" class="w-12 h-12">
            <h3 class="text-lg font-bold text-[var(--rb-green)] counter" data-target="120">0</h3>
          </div>
          <p class="mt-2 text-sm text-slate-600">Relawan Aktif</p>
        </div>
        <div class="flex flex-col items-center">
          <div class="w-24 h-24 rounded-full bg-orange-100 flex flex-col justify-center items-center shadow-md relative">
            <img src="../image/school.png" alt="" srcset="" class="w-12 h-12">
            <h3 class="text-lg font-bold text-[var(--rb-orange)] counter" data-target="20">0</h3>
          </div>
          <p class="mt-2 text-sm text-slate-600">Sekolah Mitra</p>
        </div>
      </div>
    </div>

    <!-- Bagian Gambar -->
    <div class="relative will-animate lg:order-1 flex justify-center lg:justify-end" data-aos="fade-left">
      <!-- Gambar besar -->
      <div class="relative w-[18rem] h-[12rem] md:w-[25rem] md:h-[16rem] lg:w-[27rem] lg:h-[19rem]">
        <img 
          src="../image/tentang-kami.jpg" 
          alt="Anak-anak belajar bersama"
          class="rounded-2xl shadow-xl object-cover w-full h-full"
        >
      </div>

      <!-- Gambar kecil (overlay) -->
      <div class="absolute -bottom-8 -left-8 w-[15rem] h-[10rem] rotate-40 border-4 border-white rounded-xl shadow-lg">
        <img 
          src="../image/tentang-kami2.jpg" 
          alt="Suasana membaca"
          class="rounded-xl object-cover w-full h-full "
        >
      </div>
    </div>
  </div>
</section>


<!-- PROGRAMS -->
<section id="programs" class="py-20 bg-gradient-to-b from-emerald-50 via-white to-white relative overflow-hidden">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
    
    <!-- Header -->
    <div class="text-center mb-16 will-animate" data-aos="fade-up">
      <h2 class="text-3xl md:text-4xl font-bold text-[var(--rb-green)]">Program Unggulan</h2>
      <p class="mt-3 text-slate-600 text-lg">Kegiatan inti yang kami jalankan di Rumah Baca untuk membangun budaya literasi.</p>
    </div>

    <!-- Cards -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">
      
      <!-- Card 1 -->
      <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition-transform hover:-translate-y-2 will-animate" data-aos="zoom-in" data-aos-delay="50">
        <div class="w-16 h-16 flex items-center justify-center rounded-full bg-gradient-to-br from-emerald-100 to-emerald-50 text-[var(--rb-green)] mb-5 transition-transform group-hover:scale-110">
          <!-- Book Icon -->
          <img src="../image/book-club.png" alt="" srcset="" class="w-8 h-8">
        </div>
        <h3 class="font-semibold text-xl text-slate-800">Klub Baca Anak</h3>
        <p class="text-slate-600 mt-3 leading-relaxed">Sesi membaca interaktif, diskusi cerita, dan permainan literasi yang menyenangkan.</p>
      </div>

      <!-- Card 2 -->
      <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition-transform hover:-translate-y-2 will-animate" data-aos="zoom-in" data-aos-delay="120">
        <div class="w-16 h-16 flex items-center justify-center rounded-full bg-gradient-to-br from-orange-100 to-orange-50 text-orange-500 mb-5 transition-transform group-hover:scale-110">
          <!-- Pencil Icon -->
        <img src="../image/study-group.png" alt="" srcset="" class="w-8 h-8">
        </div>
        <h3 class="font-semibold text-xl text-slate-800">Kelas Literasi & Menulis</h3>
        <p class="text-slate-600 mt-3 leading-relaxed">Belajar membaca, menulis kreatif, dan mengasah imajinasi dengan modul interaktif.</p>
      </div>

      <!-- Card 3 -->
      <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition-transform hover:-translate-y-2 will-animate" data-aos="zoom-in" data-aos-delay="190">
        <div class="w-16 h-16 flex items-center justify-center rounded-full bg-gradient-to-br from-emerald-100 to-emerald-50 text-[var(--rb-green)] mb-5 transition-transform group-hover:scale-110">
          <!-- Book open Icon -->
          <img src="../image/donation.png" alt="" srcset="" class="w-10 h-10">
        </div>
        <h3 class="font-semibold text-xl text-slate-800">Gerakan Donasi Buku</h3>
        <p class="text-slate-600 mt-3 leading-relaxed">Mengumpulkan dan menyalurkan buku ke daerah yang membutuhkan untuk membuka akses ilmu.</p>
      </div>

      <!-- Card 4 -->
      <div class="bg-white p-8 rounded-2xl shadow-md hover:shadow-xl transition-transform hover:-translate-y-2 will-animate" data-aos="zoom-in" data-aos-delay="260">
        <div class="w-16 h-16 flex items-center justify-center rounded-full bg-gradient-to-br from-orange-100 to-orange-50 text-orange-500 mb-5 transition-transform group-hover:scale-110">
          <!-- Users Icon -->
          <img src="../image/volunteer.png" alt="" srcset="" class="w-8 h-8">
        </div>
        <h3 class="font-semibold text-xl text-slate-800">Pelatihan Relawan</h3>
        <p class="text-slate-600 mt-3 leading-relaxed">Meningkatkan kapasitas relawan agar mampu mendampingi anak-anak dengan optimal.</p>
      </div>

    </div>
  </div>
</section>

<!-- SEBARAN (peta pulau) -->
<section class="relative py-20 bg-gradient-to-b from-[var(--rb-green)]/10 via-white to-white">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Heading -->
    <div class="text-center mb-12 will-animate" data-aos="fade-up">
      <h2 class="text-3xl md:text-4xl font-extrabold text-[var(--rb-green)]">Sebaran Rumah Baca</h2>
      <div class="mt-3 w-16 h-1 mx-auto bg-[var(--rb-orange)] rounded-full"></div>
      <p class="mt-4 text-slate-600 max-w-2xl mx-auto">
        Jaringan Rumah Baca tersebar di berbagai kota di Indonesia. 
        Klik titik pada peta untuk melihat informasi singkat.
      </p>
    </div>

    <!-- Map container -->
    <div class="relative max-w-5xl mx-auto will-animate" data-aos="zoom-in">
      <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-xl p-4 border border-slate-200">
        <div class="relative">
          <img src="https://upload.wikimedia.org/wikipedia/commons/9/9f/Indonesia_location_map.svg" 
               alt="Peta Indonesia" 
               class="w-full rounded-xl animate-fadeIn">

          <!-- marker template -->
          <div class="absolute top-[32%] left-[54%] group">
            <button class="pulse-dot"></button>
            <div class="absolute left-8 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 
                        transition-all duration-300 transform group-hover:translate-x-2 
                        bg-white text-sm text-slate-700 shadow-lg border rounded-lg px-4 py-2">
              <span class="font-semibold text-[var(--rb-green)]">Jakarta</span><br>
              Rumah Baca Jakarta
            </div>
          </div>

          <div class="absolute top-[46%] left-[49%] group">
            <button class="pulse-dot"></button>
            <div class="absolute left-8 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 
                        transition-all duration-300 transform group-hover:translate-x-2 
                        bg-white text-sm text-slate-700 shadow-lg border rounded-lg px-4 py-2">
              <span class="font-semibold text-[var(--rb-green)]">Bandung</span><br>
              Rumah Baca Bandung
            </div>
          </div>

          <div class="absolute top-[55%] left-[35%] group">
            <button class="pulse-dot"></button>
            <div class="absolute left-8 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 
                        transition-all duration-300 transform group-hover:translate-x-2 
                        bg-white text-sm text-slate-700 shadow-lg border rounded-lg px-4 py-2">
              <span class="font-semibold text-[var(--rb-green)]">Yogyakarta</span><br>
              Rumah Baca Yogyakarta
            </div>
          </div>

          <div class="absolute top-[24%] left-[70%] group">
            <button class="pulse-dot"></button>
            <div class="absolute left-8 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 
                        transition-all duration-300 transform group-hover:translate-x-2 
                        bg-white text-sm text-slate-700 shadow-lg border rounded-lg px-4 py-2">
              <span class="font-semibold text-[var(--rb-green)]">Medan</span><br>
              Rumah Baca Medan
            </div>
          </div>

          <div class="absolute top-[68%] left-[72%] group">
            <button class="pulse-dot"></button>
            <div class="absolute left-8 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 
                        transition-all duration-300 transform group-hover:translate-x-2 
                        bg-white text-sm text-slate-700 shadow-lg border rounded-lg px-4 py-2">
              <span class="font-semibold text-[var(--rb-green)]">Makassar</span><br>
              Rumah Baca Makassar
            </div>
          </div>

          <div class="absolute top-[78%] left-[85%] group">
            <button class="pulse-dot"></button>
            <div class="absolute left-8 top-1/2 -translate-y-1/2 opacity-0 group-hover:opacity-100 
                        transition-all duration-300 transform group-hover:translate-x-2 
                        bg-white text-sm text-slate-700 shadow-lg border rounded-lg px-4 py-2">
              <span class="font-semibold text-[var(--rb-green)]">Kupang</span><br>
              Rumah Baca Kupang
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>

  <!-- NEWS -->
<section id="news" class="py-20 bg-gradient-to-b from-emerald-50 to-white relative">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 will-animate" data-aos="fade-up">
      <div>
        <h2 class="text-3xl md:text-4xl font-extrabold text-[var(--rb-green)]">Berita Terbaru</h2>
        <p class="text-slate-600 mt-1">Ikuti perkembangan kegiatan, capaian, dan inspirasi terbaru dari Rumah Baca.</p>
      </div>
      <a href="#publications" class="inline-flex items-center gap-2 border border-[var(--rb-green)] text-[var(--rb-green)] px-5 py-2 rounded-full font-medium hover:bg-[var(--rb-green)] hover:text-white transition">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
        </svg>
        Arsip
      </a>
    </div>

    <!-- Grid -->
    <div class="mt-12 grid gap-8 md:grid-cols-3">
      
      <!-- Featured News (lebih besar) -->
      <article class="md:col-span-2 relative group rounded-2xl overflow-hidden shadow-lg will-animate" data-aos="fade-up" data-aos-delay="60">
        <img src="https://images.unsplash.com/photo-1529156069898-49953e39b3ac?q=80&w=1200&auto=format&fit=crop" alt="Kegiatan" class="w-full h-80 object-cover transition-transform duration-500 group-hover:scale-105">
        <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent"></div>
        <div class="absolute bottom-6 left-6 text-white">
          <span class="text-xs opacity-80">Kegiatan • 12 Agu 2025</span>
          <h3 class="mt-2 text-2xl font-bold">Peluncuran Rumah Baca Baru</h3>
          <p class="mt-2 max-w-lg text-sm opacity-90">Peresmian titik baru bersama relawan & mitra.</p>
          <a class="mt-3 inline-block px-4 py-2 bg-[var(--rb-green)] rounded-full text-white text-sm font-medium hover:bg-emerald-700 transition" href="#">Baca selengkapnya</a>
        </div>
      </article>

      <!-- 2 small news -->
      <div class="space-y-6">
        <article class="rounded-xl overflow-hidden shadow hover:shadow-lg transition group will-animate" data-aos="fade-up" data-aos-delay="120">
          <img src="https://images.unsplash.com/photo-1513475382585-d06e58bcb0ea?q=80&w=1200&auto=format&fit=crop" alt="Donasi" class="w-full h-44 object-cover transition-transform duration-500 group-hover:scale-105">
          <div class="p-4">
            <span class="text-xs text-slate-500">Donasi • 02 Agu 2025</span>
            <h3 class="mt-2 font-semibold">1.200 Buku Tersalurkan</h3>
            <p class="mt-2 text-sm text-slate-600">Distribusi ke beberapa titik prioritas.</p>
            <a class="mt-3 inline-block text-[var(--rb-green)] font-semibold hover:underline" href="#">Baca selengkapnya</a>
          </div>
        </article>

        <article class="rounded-xl overflow-hidden shadow hover:shadow-lg transition group will-animate" data-aos="fade-up" data-aos-delay="180">
          <img src="https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?q=80&w=1200&auto=format&fit=crop" alt="Workshop" class="w-full h-44 object-cover transition-transform duration-500 group-hover:scale-105">
          <div class="p-4">
            <span class="text-xs text-slate-500">Pelatihan • 27 Jul 2025</span>
            <h3 class="mt-2 font-semibold">Workshop Fasilitator Relawan</h3>
            <p class="mt-2 text-sm text-slate-600">Pembekalan metode fasilitasi literasi anak.</p>
            <a class="mt-3 inline-block text-[var(--rb-green)] font-semibold hover:underline" href="#">Baca selengkapnya</a>
          </div>
        </article>
      </div>

    </div>
  </div>
</section>

<!-- DONATION CTA -->
<section id="donate" class="relative py-24 bg-gradient-to-r from-[var(--rb-green)] to-[#0c6b4a] text-white overflow-hidden">
  <!-- Background image overlay with real people -->
  <div class="absolute inset-0">
    <img src="../image/donasi-picture.jpg" 
         alt="Anak-anak membaca bersama" 
         class="w-full h-full object-cover opacity-40">
    <div class="absolute inset-0 bg-gradient-to-b from-black/60 to-black/30"></div>
  </div>

  <div class="relative max-w-5xl mx-auto px-6 text-center will-animate" data-aos="fade-up">
    <h2 class="text-3xl md:text-4xl font-extrabold mb-4">
      🌱 Dukung Rumah Baca — Selamatkan Masa Depan 📚
    </h2>
    <p class="text-lg text-slate-100/90 max-w-3xl mx-auto">
      Setiap donasi Anda, baik berupa buku maupun dana, 
      adalah investasi nyata bagi generasi penerus bangsa. 
      Bersama kita bisa membuka akses literasi untuk lebih banyak anak-anak Indonesia.
    </p>

    <!-- Impact stats -->
    <div class="mt-10 grid grid-cols-1 sm:grid-cols-3 gap-6 text-center">
      <div class="p-6 bg-white/10 rounded-2xl backdrop-blur-md will-animate" data-aos="zoom-in" data-aos-delay="100">
        <h3 class="text-3xl font-bold text-[var(--rb-orange)]">1200+</h3>
        <p class="text-sm">Buku Terkumpul</p>
      </div>
      <div class="p-6 bg-white/10 rounded-2xl backdrop-blur-md will-animate" data-aos="zoom-in" data-aos-delay="200">
        <h3 class="text-3xl font-bold text-[var(--rb-orange)]">30+</h3>
        <p class="text-sm">Rumah Baca Aktif</p>
      </div>
      <div class="p-6 bg-white/10 rounded-2xl backdrop-blur-md will-animate" data-aos="zoom-in" data-aos-delay="300">
        <h3 class="text-3xl font-bold text-[var(--rb-orange)]">5000+</h3>
        <p class="text-sm">Anak Terbantu</p>
      </div>
    </div>

    <!-- CTA Buttons -->
    <div class="mt-12 flex flex-wrap justify-center gap-4">
      <a href="#donation-form" 
         class="rounded-full bg-[var(--rb-orange)] px-8 py-4 font-semibold text-white shadow-lg shadow-orange-500/30 hover:scale-105 transition-transform">
         💳 Donasi Sekarang
      </a>
      <a href="#pojokbaca" 
         class="rounded-full border border-white/40 px-8 py-4 font-semibold bg-white/10 backdrop-blur hover:bg-white/20 transition">
         📖 Donasikan Buku
      </a>
    </div>
  </div>
</section>


<!-- VIDEO SECTION -->
<section id="galeri" class="relative py-20 bg-gradient-to-b from-white to-slate-50">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
    
    <!-- Heading -->
    <div class="mb-10 will-animate" data-aos="fade-up">
      <h2 class="text-3xl md:text-4xl font-bold text-[var(--rb-green)]">Galeri Kegiatan</h2>
      <p class="mt-2 text-slate-600">Kegiatan inspiratif dari Rumah Baca dalam bentuk video dokumentasi.</p>
    </div>

    <!-- Local Video -->
    <div class="relative rounded-2xl overflow-hidden shadow-2xl will-animate" data-aos="zoom-in">
      <video 
        class="w-full h-[500px] rounded-2xl object-cover"
        autoplay
        muted
        loop
        playsinline
      >
        <source src="../image/video-rumahbaca.mp4" type="video/mp4" />
        Browser kamu tidak mendukung video HTML5.
      </video>

      <div class="absolute bottom-4 right-4 bg-black/50 text-white text-sm px-3 py-1 rounded-full">
        Klik video untuk Play/Pause
      </div>
    </div>
  </div>
</section>



  </main>

<?php 
  include '../footer.php';
?>

  <style>
  /* Sembunyikan dropdown Alpine sebelum siap */
  [x-cloak] { display: none !important; }
  </style>

  <script src="<?= $base_url ?>translate.js"></script>
  <!-- YouTube API -->
  <script src="https://www.youtube.com/iframe_api"></script>
  <script src="https://unpkg.com/alpinejs" defer></script>
  <script>
    // init AOS
    AOS.init({ duration: 700, once: true });

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

    // simple "will-animate" reveal fallback (for browsers without AOS immediate triggering)
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

    // small accessibility: close modal with Esc
    document.addEventListener('keydown', (e)=>{
      if(e.key === 'Escape') closeReader();
    });

    // feather icons replacement (if present)
    try{ feather.replace(); }catch(e){}

    let player;
    function onYouTubeIframeAPIReady() {
      player = new YT.Player('ytPlayer', {
        events: {
          'onReady': function(event) {
            event.target.playVideo();
          }
        }
      });
    }

    // Klik iframe wrapper untuk play/pause
    document.getElementById("ytPlayer").addEventListener("click", function () {
      if (player.getPlayerState() === YT.PlayerState.PLAYING) {
        player.pauseVideo();
      } else {
        player.playVideo();
      }
    });
  </script>

  <!-- Script animasi counter -->
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const counters = document.querySelectorAll(".counter");
      const speed = 200; // kecepatan animasi

      const animateCounters = () => {
        counters.forEach(counter => {
          const updateCount = () => {
            const target = +counter.getAttribute("data-target");
            const count = +counter.innerText;
            const increment = Math.ceil(target / speed);

            if (count < target) {
              counter.innerText = count + increment;
              setTimeout(updateCount, 20);
            } else {
              counter.innerText = target;
            }
          };
          updateCount();
        });
      };

      // Jalankan animasi saat muncul di layar
      const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            animateCounters();
          }
        });
      }, { threshold: 0.5 });

      counters.forEach(counter => {
        observer.observe(counter);
      });
    });
  </script>
  </body>
  </html>
