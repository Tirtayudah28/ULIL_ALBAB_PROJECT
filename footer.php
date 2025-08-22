<?php 
    include 'config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer</title>
     <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- AOS (Animate on Scroll) -->
  <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

  <!-- Icons (Heroicons) -->
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    :root {
      --rb-green: #15803d;
      --rb-orange: #f97316;
    }
    .animate-spin-slow {
        animation: spin 6s linear infinite;
    }

      .perspective {
        perspective: 1000px;
    }
    .preserve-3d {
        transform-style: preserve-3d;
    }
    .rotate-y-180 {
        transform: rotateY(180deg);
    }
    .backface-hidden {
        backface-visibility: hidden;
    }
  </style>
</head>
<body>
      <!-- FOOTER (expanded) -->
<footer class="bg-[var(--rb-green)] text-white pt-12 pb-8">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-8">
      <!-- About -->
      <div>
        <div class="flex items-center gap-3">
           <img src="<?= $base_url ?>image/logo.png" alt="Rumah Baca" class="h-16 md:h-20 w-auto object-contain">
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
      <div>Didesain dengan ♥ oleh Tim Ulil Albab — tema: hijau & oranye.</div>
    </div>
  </div>
</footer>


  <!-- Simple Reader Modal (demo) -->
  <div id="readerModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/60 p-4">
    <div class="bg-white rounded-2xl max-w-3xl w-full overflow-hidden">
      <div class="flex items-center justify-between px-4 py-3 border-b">
        <div id="readerTitle" class="font-semibold">Judul Buku</div>
        <button onclick="closeReader()" class="text-slate-600 hover:text-slate-900" aria-label="Tutup">✕</button>
      </div>
      <div class="p-6">
        <p class="text-slate-700">Demo membaca — konten buku akan muncul di sini. Untuk versi produksi kita bisa integrasikan PDF viewer atau sistem CMS untuk isi buku digital.</p>
      </div>
    </div>
  </div>

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
</body>
</html>