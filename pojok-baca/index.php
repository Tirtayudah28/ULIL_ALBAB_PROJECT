<?php 
  include '../config/koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Pojok Baca</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
</head>
<body class="bg-gray-50">
<?php 
  include '../navbar.php';
?>  

  <!-- HERO -->
  <section class="pt-24 pb-8 bg-gradient-to-b from-white to-emerald-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex flex-col md:flex-row items-center gap-6">
        <div class="flex-1">
          <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold leading-tight">
            Pojok Baca: Nyaman, Ringan, dan Fokus ke Konten
          </h1>
          <p class="mt-3 text-slate-600">
            Jelajahi koleksi PDF, baca langsung, simpan untuk nanti, atau ajukan unggah buku (kurasi admin).
          </p>
          <div class="mt-5 flex gap-3">
            <button id="uploadBtn" class="btn-outline rounded-lg px-4 py-2 font-semibold">+ Upload Buku</button>
            <a href="#koleksi" class="btn-primary rounded-lg px-4 py-2 font-semibold">Lihat Koleksi</a>
          </div>
        </div>
        <div class="flex-1 w-full">
          <div class="rounded-2xl bg-white p-4 shadow-soft border">
            <div class="h-40 sm:h-56 bg-emerald-100 rounded-xl grid place-items-center">
              <span class="text-emerald-700 font-semibold">Preview area</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FILTERS -->
  <section class="pb-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="bg-white rounded-xl shadow-soft border p-4 flex flex-col lg:flex-row gap-3 items-start lg:items-center justify-between">
        <div class="flex-1 flex flex-col sm:flex-row gap-3">
          <div class="flex-1">
            <input id="searchInput" type="text" placeholder="Cari judul/penulis..." class="w-full border rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-300">
          </div>
          <select id="categorySelect" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-300">
            <option value="">Semua Kategori</option>
            <option>Al-Qur’an</option>
            <option>Sirah</option>
            <option>Self Improvement</option>
            <option>Ensiklopedia</option>
            <option>Wawasan</option>
          </select>
          <select id="sortSelect" class="border rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-emerald-300">
            <option value="new">Terbaru</option>
            <option value="title">Judul A–Z</option>
            <option value="popular">Terpopuler</option>
          </select>
        </div>
        <button id="clearFilter" class="px-4 py-2 rounded-lg border hover-bg-green">Reset</button>
      </div>
    </div>
  </section>

  <!-- GRID BUKU -->
  <section id="koleksi" class="pb-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div id="bookGrid" class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4 sm:gap-6"></div>
    </div>
  </section>

  <!-- DRAWER READER -->
  <div id="readerOverlay" class="fixed inset-0 bg-black/40 hidden z-50"></div>
  <!-- <aside id="readerDrawer" class="drawer fixed top-0 right-0 h-full w-full sm:w-[520px] bg-white z-50 shadow-2xl flex flex-col">
    <div class="h-16 border-b flex items-center justify-between px-4">
      <h3 id="readerTitle" class="font-bold text-lg truncate">Membaca…</h3>
      <button id="closeReader" class="p-2 rounded-lg hover-bg-green">✕</button>
    </div>
    <div class="flex-1 overflow-y-auto">
      <div class="p-4 space-y-4">
        <div class="aspect-[4/3] w-full bg-gray-100 rounded-lg overflow-hidden border">
          <iframe id="pdfFrame" src="" class="w-full h-full" title="PDF Preview"></iframe>
        </div>
        <div>
          <div class="flex items-center justify-between">
            <div class="text-sm text-gray-600" id="readerMeta">Kategori • Penulis</div>
            <div class="text-xs text-gray-500">Kemajuan baca</div>
          </div>
          <div class="w-full bg-gray-200 h-2 rounded-full mt-2">
            <div id="progressBar" class="h-2 rounded-full" style="width:30%; background:linear-gradient(90deg,var(--rb-green),var(--rb-orange))"></div>
          </div>
        </div>
        <div class="flex gap-2">
          <a id="downloadBtn" href="#" target="_blank" class="btn-outline rounded-lg px-4 py-2 font-semibold inline-flex items-center gap-2">
            ⬇️ Download
          </a>
          <button class="btn-primary rounded-lg px-4 py-2 font-semibold inline-flex items-center gap-2">🔖 Simpan</button>
          <button class="rounded-lg px-4 py-2 font-semibold border hover-bg-green">🔗 Bagikan</button>
        </div>
        <div>
          <h4 class="font-semibold mb-2">Deskripsi</h4>
          <p id="readerDesc" class="text-sm text-gray-700 leading-relaxed"></p>
        </div>
        <div>
          <h4 class="font-semibold mb-2">Terkait</h4>
          <div id="relatedWrap" class="grid grid-cols-3 gap-3"></div>
        </div>
      </div>
    </div>
  </aside> -->


  <!-- FOOTER SPACER -->
  <div class="h-10"></div>
  <?php 
    include '../footer.php';
  ?>  

  <script>

    /* =========================
       Mock auth gating Upload
    ==========================*/
    let isLoggedIn = false; // ganti dari server nanti
    document.getElementById('uploadBtn').addEventListener('click', ()=>{
      if(!isLoggedIn) openLogin();
      else alert('Form upload buku tampil (protected).');
    });

    /* =========================
       Data dummy & rendering grid
    ==========================*/
    const books = [
      {id:1, title:"Mushaf Madinah", author:"Tim LIPIA", category:"Al-Qur’an", cover:"https://picsum.photos/seed/quran/400/600", pdfUrl:"https://arxiv.org/pdf/2203.00001.pdf", desc:"Mushaf standar rasm Utsmani."},
      {id:2, title:"Sirah Nabawiyah", author:"Shafiyyurrahman", category:"Sirah", cover:"https://picsum.photos/seed/sirah/400/600", pdfUrl:"https://arxiv.org/pdf/2107.00001.pdf", desc:"Kisah perjalanan hidup Rasulullah."},
      {id:3, title:"Atomic Habits", author:"James Clear", category:"Self Improvement", cover:"https://picsum.photos/seed/atomic/400/600", pdfUrl:"https://arxiv.org/pdf/2001.00001.pdf", desc:"Bangun kebiasaan kecil berdampak besar."},
      {id:4, title:"Ensiklopedia Sains", author:"Tim Ensiklo", category:"Ensiklopedia", cover:"https://picsum.photos/seed/sains/400/600", pdfUrl:"https://arxiv.org/pdf/2401.00001.pdf", desc:"Ilmu pengetahuan populer untuk semua."},
      {id:5, title:"Geografi Global", author:"A. Kartono", category:"Wawasan", cover:"https://picsum.photos/seed/geo/400/600", pdfUrl:"https://arxiv.org/pdf/2303.00001.pdf", desc:"Memahami bumi dan penduduknya."},
      {id:6, title:"Mindset", author:"Carol Dweck", category:"Self Improvement", cover:"https://picsum.photos/seed/mind/400/600", pdfUrl:"https://arxiv.org/pdf/1906.00001.pdf", desc:"Growth vs fixed mindset."},
      {id:7, title:"Publikasi Komunitas", author:"RB Labs", category:"Wawasan", cover:"https://picsum.photos/seed/kom/400/600", pdfUrl:"https://arxiv.org/pdf/1805.00001.pdf", desc:"Kumpulan tulisan komunitas."},
      {id:8, title:"Kamus Mini", author:"Tim KBBI", category:"Ensiklopedia", cover:"https://picsum.photos/seed/kamus/400/600", pdfUrl:"https://arxiv.org/pdf/1704.00001.pdf", desc:"Istilah sehari-hari ringkas."},
      {id:9, title:"Sirah Ringkas", author:"Ibn Hisyam", category:"Sirah", cover:"https://picsum.photos/seed/hisyam/400/600", pdfUrl:"https://arxiv.org/pdf/1603.00001.pdf", desc:"Versi ringkas untuk pemula."},
      {id:10, title:"Kebiasaan 1%", author:"Anonim", category:"Self Improvement", cover:"https://picsum.photos/seed/one/400/600", pdfUrl:"https://arxiv.org/pdf/1502.00001.pdf", desc:"Iterasi kecil berkelanjutan."},
    ];

    const grid = document.getElementById('bookGrid');
    function cardHTML(b){
      return `
      <article class="group bg-white border rounded-xl overflow-hidden shadow-soft hover:shadow-xl transition">
        <button data-id="${b.id}" class="open-reader w-full text-left">
          <div class="aspect-[3/4] overflow-hidden bg-gray-100">
            <img src="${b.cover}" alt="${b.title}" class="w-full h-full object-cover group-hover:scale-[1.02] transition">
          </div>
          <div class="p-3">
            <h3 class="font-semibold leading-snug line-clamp-2">${b.title}</h3>
            <p class="text-sm text-gray-600">${b.author}</p>
            <div class="mt-2 inline-flex items-center gap-2 text-xs">
              <span class="px-2 py-1 rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">${b.category}</span>
            </div>
          </div>
        </button>
      </article>`;
    }
    function renderGrid(list){ grid.innerHTML = list.map(cardHTML).join(''); bindOpen(); }
    renderGrid(books);

    /* =========================
       Filter / Search / Sort
    ==========================*/
    const searchInput = document.getElementById('searchInput');
    const categorySelect = document.getElementById('categorySelect');
    const sortSelect = document.getElementById('sortSelect');
    const clearFilter = document.getElementById('clearFilter');

    function applyFilter(){
      let q = searchInput.value.trim().toLowerCase();
      let cat = categorySelect.value;
      let sort = sortSelect.value;
      let res = books.filter(b=>{
        const matchQ = !q || (b.title.toLowerCase().includes(q) || b.author.toLowerCase().includes(q));
        const matchC = !cat || b.category === cat;
        return matchQ && matchC;
      });
      if (sort === 'title') res.sort((a,b)=> a.title.localeCompare(b.title));
      if (sort === 'popular') res.sort((a,b)=> b.id - a.id); // dummy popularity
      if (sort === 'new') res.sort((a,b)=> b.id - a.id);
      renderGrid(res);
    }
    [searchInput, categorySelect, sortSelect].forEach(el=> el.addEventListener('input', applyFilter));
    clearFilter.addEventListener('click', ()=>{
      searchInput.value=''; categorySelect.value=''; sortSelect.value='new'; applyFilter();
    });

    /* =========================
       Reader Drawer
    ==========================*/
    const drawer = document.getElementById('readerDrawer');
    const overlay = document.getElementById('readerOverlay');
    const closeReader = document.getElementById('closeReader');
    const readerTitle = document.getElementById('readerTitle');
    const readerMeta = document.getElementById('readerMeta');
    const readerDesc = document.getElementById('readerDesc');
    const pdfFrame = document.getElementById('pdfFrame');
    const downloadBtn = document.getElementById('downloadBtn');
    const relatedWrap = document.getElementById('relatedWrap');

    function openReader(book){
      readerTitle.textContent = book.title;
      readerMeta.textContent = `${book.category} • ${book.author}`;
      readerDesc.textContent = book.desc || '';
      pdfFrame.src = book.pdfUrl;
      downloadBtn.href = book.pdfUrl;
      // related (same category)
      const rel = books.filter(b=> b.category === book.category && b.id !== book.id).slice(0,3);
      relatedWrap.innerHTML = rel.map(r => `
        <button data-id="${r.id}" class="open-reader text-left">
          <div class="aspect-[3/4] bg-gray-100 rounded overflow-hidden">
            <img src="${r.cover}" class="w-full h-full object-cover">
          </div>
          <p class="mt-1 text-xs font-semibold line-clamp-2">${r.title}</p>
        </button>`).join('');
      bindOpen(); // rebind for related
      overlay.classList.remove('hidden');
      drawer.classList.add('open');
      document.body.style.overflow='hidden';
    }
    function closeReaderFn(){
      overlay.classList.add('hidden');
      drawer.classList.remove('open');
      document.body.style.overflow='auto';
      setTimeout(()=> pdfFrame.src='', 250);
    }
    function bindOpen(){
      document.querySelectorAll('.open-reader').forEach(btn=>{
        btn.onclick = ()=>{
          const id = +btn.dataset.id;
          const book = books.find(b=> b.id===id);
          if(book) openReader(book);
        };
      });
    }
    closeReader.addEventListener('click', closeReaderFn);
    overlay.addEventListener('click', closeReaderFn);

  </script>
</body>
</html>
