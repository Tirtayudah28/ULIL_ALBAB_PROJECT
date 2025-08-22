<?php 
session_start();
include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Hubungi Kami - Rumah Baca</title>

<!-- Icon & CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
<link rel="stylesheet" href="../main.css" />
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<link href="https://unpkg.com/tabler-icons@latest/iconfont/tabler-icons.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
:root {
  --rb-green: #15803d;
  --rb-orange: #f97316;
}

/* Utility */
.text-rb-green { color: var(--rb-green); }
.text-rb-orange { color: var(--rb-orange); }
.text-gradient { background: linear-gradient(90deg, var(--rb-green), var(--rb-orange)); -webkit-background-clip: text; color: transparent; }
.bg-rb-green { background-color: var(--rb-green); }
.bg-rb-orange { background-color: var(--rb-orange); }

/* Button */
.btn-kirim {
  background: var(--rb-green);
  color: white;
  padding: 0.6rem 1.5rem;
  border-radius: 0.5rem;
  font-weight: 600;
  transition: all 0.3s ease-in-out;
}
.btn-kirim:hover {
  background: var(--rb-orange);
  transform: translateY(-2px);
  box-shadow: 0 6px 14px rgba(0,0,0,0.15);
}

/* Floating Label */
.floating-input {
  position: relative;
}
.floating-input input,
.floating-input textarea {
  border: 1px solid #d1d5db;
  border-radius: 0.5rem;
  padding: 1rem 1rem 0.5rem;
  width: 100%;
  font-size: 0.95rem;
  transition: all 0.3s;
}
.floating-input label {
  position: absolute;
  top: 1rem;
  left: 1rem;
  color: #6b7280;
  font-size: 0.9rem;
  transition: 0.2s ease all;
  pointer-events: none;
}
.floating-input input:focus + label,
.floating-input input:not(:placeholder-shown) + label,
.floating-input textarea:focus + label,
.floating-input textarea:not(:placeholder-shown) + label {
  top: 0.4rem;
  left: 0.9rem;
  font-size: 0.75rem;
  color: var(--rb-orange);
}
.floating-input input:focus, .floating-input textarea:focus {
  border-color: var(--rb-orange);
  box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
}

/* Map */
#mapid {
  border: 5px solid var(--rb-green);
  border-radius: 0.75rem;
}

/* Card hover */
.card-hover {
  transition: all 0.3s;
}
.card-hover:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.15);
}

/* Toast */
.toast {
  position: fixed;
  top: 1rem;
  right: 1rem;
  background: var(--rb-green);
  color: white;
  padding: 1rem 1.5rem;
  border-radius: 0.5rem;
  display: none;
  z-index: 9999;
}

/* FAB WhatsApp */
.fab-wa {
  position: fixed;
  bottom: 20px;
  right: 20px;
  background: #25d366;
  color: white;
  padding: 14px 16px;
  border-radius: 50%;
  font-size: 1.8rem;
  box-shadow: 0 4px 10px rgba(0,0,0,0.2);
  transition: transform 0.3s;
  z-index: 999;
}
.fab-wa:hover { transform: scale(1.1); }
</style>
</head>
<body class="font-poppins bg-gray-50">

<!-- Navbar -->
<?php include '../navbar.php'; ?>

<!-- Toast Notification -->
<div id="toast" class="toast">✅ Pesan berhasil dikirim!</div>

<!-- Header -->
<section class="bg-rb-green bg-[url('https://transparenttextures.com/patterns/cubes.png')] text-white py-24 px-6 text-center relative overflow-hidden">
  <div data-aos="fade-up" class="relative z-10">
    <i class="bi bi-chat-dots text-6xl mb-4 animate-bounce"></i>
    <h1 class="text-4xl sm:text-5xl font-bold mb-4 text-gradient">Hubungi Kami</h1>
    <p class="max-w-2xl mx-auto text-white/90 text-lg">Kami siap mendengar pertanyaan, saran, atau peluang kolaborasi dari Anda.</p>
  </div>
</section>

<!-- Form & Info -->
<section class="py-16 px-6 sm:px-12 lg:px-20">
  <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-12">

    <!-- Form -->
    <div class="bg-white shadow-lg rounded-xl p-8 card-hover" data-aos="fade-right">
      <h2 class="text-2xl font-bold text-rb-green mb-6">Kirim Pesan</h2>
      <form id="contactForm" class="space-y-6" action="" method="post">
        
        <!-- Nama -->
        <div class="relative">
          <input type="text" id="nama" required
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-rb-green focus:outline-none peer placeholder-transparent" 
            placeholder="Nama Lengkap">
          <label for="nama" 
            class="absolute left-3 -top-2.5 text-sm text-rb-green bg-white px-1 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base">
            Nama Lengkap
          </label>
        </div>

        <!-- Email -->
        <div class="relative">
          <input type="email" id="email" required
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-rb-green focus:outline-none peer placeholder-transparent" 
            placeholder="Alamat Email">
          <label for="email" 
            class="absolute left-3 -top-2.5 text-sm text-rb-green bg-white px-1 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base">
            Alamat Email
          </label>
        </div>

        <!-- Subjek -->
        <div class="relative">
          <input type="text" id="subjek"
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-rb-green focus:outline-none peer placeholder-transparent" 
            placeholder="Subjek">
          <label for="subjek" 
            class="absolute left-3 -top-2.5 text-sm text-rb-green bg-white px-1 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base">
            Subjek (Opsional)
          </label>
        </div>

        <!-- Pesan -->
        <div class="relative">
          <textarea id="pesan" rows="5" required
            class="w-full px-4 py-3 border rounded-lg focus:ring-2 focus:ring-rb-green focus:outline-none peer placeholder-transparent"></textarea>
          <label for="pesan" 
            class="absolute left-3 -top-2.5 text-sm text-rb-green bg-white px-1 transition-all peer-placeholder-shown:top-3 peer-placeholder-shown:text-gray-400 peer-placeholder-shown:text-base">
            Pesan Anda
          </label>
        </div>

        <!-- Tombol -->
        <button type="submit" 
          class="w-full bg-rb-green hover:bg-rb-orange text-white font-semibold py-3 rounded-lg transition duration-300 flex items-center justify-center gap-2">
          Kirim Pesan <i class="bi bi-send"></i>
        </button>
      </form>
    </div>

    <!-- Info Kontak -->
    <div class="max-w-3xl mx-auto" data-aos="fade-left">
      <h2 class="text-3xl font-bold text-center text-gradient mb-12">Informasi Kontak</h2>

      <div class="space-y-6">
        <!-- Alamat -->
        <div class="bg-white shadow-md rounded-xl p-6 flex items-start gap-4 card-hover">
          <i class="bi bi-geo-alt text-rb-green text-3xl"></i>
          <div>
            <h3 class="font-semibold text-rb-green mb-1">Alamat Kantor</h3>
            <p class="text-gray-600">Jl. Brigjend Katamso, Kp. Baru, Kec. Medan Maimun, Kota Medan, Sumatera Utara 20158</p>
          </div>
        </div>

        <!-- Telepon -->
        <div class="bg-white shadow-md rounded-xl p-6 flex items-start gap-4 card-hover">
          <i class="bi bi-telephone text-rb-green text-3xl"></i>
          <div>
            <h3 class="font-semibold text-rb-green mb-1">Telepon</h3>
            <p class="text-gray-600">+62 813 7696 5858</p>
          </div>
        </div>

        <!-- Instagram -->
        <div class="bg-white shadow-md rounded-xl p-6 flex items-start gap-4 card-hover">
          <i class="bi bi-instagram text-rb-green text-3xl"></i>
          <div>
            <h3 class="font-semibold text-rb-green mb-1">Instagram</h3>
            <p class="text-gray-600">@lazulilalbab</p>
          </div>
        </div>

        <!-- Jam Operasional -->
        <div class="bg-white shadow-md rounded-xl p-6 flex items-start gap-4 card-hover">
          <i class="bi bi-clock text-rb-green text-3xl"></i>
          <div>
            <h3 class="font-semibold text-rb-green mb-1">Jam Operasional</h3>
            <p class="text-gray-600">Senin - Sabtu: 08.00 - 17.00</p>
          </div>
        </div>

        <!-- Media Sosial -->
        <div class="bg-white shadow-md rounded-xl p-6 flex items-start gap-4 card-hover">
          <i class="bi bi-share text-rb-green text-3xl"></i>
          <div>
            <h3 class="font-semibold text-rb-green mb-2">Ikuti Kami</h3>
            <div class="flex gap-5 text-xl">
              <a href="#" class="text-rb-orange hover:text-rb-green transition"><i class="bi bi-facebook"></i></a>
              <a href="#" class="text-rb-orange hover:text-rb-green transition"><i class="bi bi-instagram"></i></a>
              <a href="#" class="text-rb-orange hover:text-rb-green transition"><i class="bi bi-youtube"></i></a>
            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</section>


<!-- Map -->
<section class="py-16 px-6 sm:px-12 lg:px-0">
  <div class="max-w-5xl mx-auto bg-white rounded-2xl shadow-lg px-6 sm:px-12 py-10 text-center card-hover">
    <h2 class="text-3xl font-bold text-gradient mb-4">Temukan Lokasi Kami</h2>
    <p class="text-gray-600 mb-8">
      No. 11, Jl. Brigjend Katamso, Kp. Baru, Kec. Medan Maimun, Kota Medan, Sumatera Utara 20158
    </p>
    <div id="mapid" class="w-full h-[300px] sm:h-[400px] lg:h-[500px]"></div>
  </div>
</section>

<!-- FAB WhatsApp -->
<a href="https://wa.me/6281376965858" target="_blank" class="fab-wa"><i class="bi bi-whatsapp"></i></a>

<?php include '../footer.php'; ?>

<script src="<?= $base_url ?>translate.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 1000, once: true });

// Toast
function showToast(msg) {
  const toast = document.getElementById("toast");
  toast.innerText = msg;
  toast.style.display = "block";
  setTimeout(() => toast.style.display = "none", 4000);
}

// Form validation & fake submit
document.getElementById("contactForm").addEventListener("submit", function(e){
  e.preventDefault();
  const email = document.getElementById("email").value;
  const pesan = document.getElementById("pesan").value;
  if(!email.includes("@") || pesan.trim() === ""){
    alert("Harap isi email valid dan pesan!");
    return;
  }
  showToast("✅ Pesan berhasil dikirim!");
  this.reset();
});

// Inisialisasi Peta dengan custom marker
const map = L.map('mapid').setView([3.580495, 98.684048], 16);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap' }).addTo(map);

const customIcon = L.icon({
  iconUrl: 'https://cdn-icons-png.flaticon.com/512/29/29302.png',
  iconSize: [40, 40],
  iconAnchor: [20, 40],
  popupAnchor: [0, -35]
});

L.marker([3.580495, 98.684048], {icon: customIcon}).addTo(map)
  .bindPopup('<strong>Rumah Baca</strong><br>No. 11, Jl. Brigjend Katamso, Kp. Baru, Kec. Medan Maimun<br><a href="https://maps.google.com/?q=3.580495,98.684048" target="_blank" class="text-rb-orange">Buka di Google Maps</a>')
  .openPopup();
</script>
