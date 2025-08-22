<?php include 'config/koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pojok Baca</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  <!-- Firebase SDK -->
  <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-app-compat.js"></script>
  <script src="https://www.gstatic.com/firebasejs/9.23.0/firebase-auth-compat.js"></script>

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
  </style>
</head>
<body class="bg-gray-50">

  <!-- Navbar -->
  <header id="navbar" class="navbar fixed top-0 left-0 w-full bg-white border-b border-gray-100 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="h-16 flex items-center justify-between">
        <!-- Logo -->
        <a href="../beranda/index.php" class="flex items-center gap-3 md:gap-4">
          <img src="<?= $base_url ?>image/logo.png" alt="Rumah Baca" class="h-16 md:h-20 w-auto object-contain">
        </a>

        <!-- Menu Desktop -->
        <nav class="hidden md:flex space-x-6 items-center font-bold text-gray-500">
          <a href="<?= $base_url ?>beranda" class="nav-link hover:text-green-600" data-key="home">Beranda</a>
          <a href="<?= $base_url ?>tentang-kami" class="nav-link hover:text-green-600" data-key="about">Tentang Kami</a>
          <a href="<?= $base_url ?>program" class="nav-link hover:text-green-600" data-key=" program">Program</a>
          <div class="relative group" id="mediaMenu">
            <button class="nav-link hover:text-green-600 flex items-center" data-key="media">
              Media
              <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
              </svg>
            </button>
            <div class="absolute hidden group-hover:block bg-white shadow-lg mt-2 rounded-lg py-2 w-40" id="mediaDropdown">
              <a href="<?= $base_url ?>berita" class="block px-4 py-2 hover:bg-green-100 hover:text-green-600" data-key="news">Berita</a>
              <a href="<?= $base_url ?>publikasi" class="block px-4 py-2 hover:bg-green-100 hover:text-green-600" data-key="publication">Publikasi</a>
            </div>
          </div>
          <a href="<?= $base_url ?>pojok-baca" class="nav-link hover:text-green-600" data-key="pojok">Pojok Baca</a>
          <a href="<?= $base_url ?>hubungi-kami" class="nav-link hover:text-green-600" data-key="contact">Hubungi Kami</a>
          <a href="<?= $base_url ?>donasi" class="btn-primary rounded-lg px-4 py-2 font-semibold shadow-soft" data-key="donate">Donasi</a>

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
      <a href="<?= $base_url ?>beranda" class="block py-2 font-semibold" data-key="home">Beranda</a>
      <a href="<?= $base_url ?>tentang-kami" class="block py-2 font-semibold" data-key="about">Tentang Kami</a>
      <a href="<?= $base_url ?>program" class="block py-2 font-semibold" data-key="program">Program</a>
      <details class="py-2">
        <summary class="cursor-pointer font-semibold" data-key="media">Media</summary>
        <a href="<?= $base_url ?>berita" class="block py-2 pl-4" data-key="news">Berita</a>
        <a href="<?= $base_url ?>publikasi" class="block py-2 pl-4" data-key="publication">Publikasi</a>
      </details>
      <a href="<?= $base_url ?>pojok-baca" class="block py-2 font-semibold" data-key="pojok">Pojok Baca</a>
      <a href="<?= $base_url ?>hubungi-kami" class="block py-2 font-semibold" data-key="contact">Hubungi Kami</a>
      <a href="<?= $base_url ?>donasi" class="block py-2 text-orange-600 font-bold" data-key="donation">Donasi</a>
      <div class="mt-6">
        <p class="text-sm text-gray-500 mb-2">Pilih Bahasa:</p>
        <a href="?lang=id" class="block py-1">🇮🇩 Indonesia</a>
        <a href="?lang=en" class="block py-1">🇬🇧 English</a>
      </div>
    </div>
  </header>

  <!-- POPUP LOGIN -->
  <div id="loginPopup" class="hidden fixed inset-0 bg-black/50 z-[60] items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-6 relative">
      <button id="closePopup" class="absolute top-3 right-3 p-2 rounded-lg hover-bg-green">✖</button>
      <h2 class="text-xl font-bold mb-1 text-[#0ea5a0]">Log in or Sign up</h2>
      <p class="text-sm text-gray-600 mb-4">Continue with</p>
      <div class="grid grid-cols-3 gap-3 mb-4">
        <button id="loginGoogle" class="border rounded-lg py-2 font-semibold hover-bg-green">G</button>
        <button id="loginFacebook" class="border rounded-lg py-2 font-semibold hover-bg-green">f</button>
        <button id="loginApple" class="border rounded-lg py-2 font-semibold hover-bg-green"></button>
      </div>
      <div class="flex items-center my-4">
        <hr class="flex-1 border-gray-300">
        <span class="px-3 text-gray-400 text-sm">Or</span>
        <hr class="flex-1 border-gray-300">
      </div>
      <input id="emailInput" type="email" placeholder="Email address" class="w-full border rounded-lg px-3 py-2 mb-3 focus:outline-none focus:ring-2 focus:ring-emerald-300">
      <button id="loginEmailBtn" class="w-full bg-amber-400 hover:bg-amber-500 py-2 rounded-lg font-bold">Continue</button>
      <p class="text-xs mt-3 text-gray-500">
        By signing up, I agree to <a href="#" class="text-[#f97316]">terms of use</a> and <a href="#" class="text-[#f97316]">privacy policy</a>.
      </p>
    </div>
  </div>

  <script src="translate.js"></script>
  <script>
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
  </script>
</body>
</html>
