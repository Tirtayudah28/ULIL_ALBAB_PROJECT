<?php
// donasi.php
session_start();
include '../config/koneksi.php'; // $conn = mysqli connection

// ------ CONFIG ------
$allowedMime = ['image/jpeg','image/png','image/webp','application/pdf'];
$maxUpload   = 2 * 1024 * 1024; // 2MB
$uploadDir   = __DIR__ . "/uploads/bukti"; // make sure folder exists & writable
if (!is_dir($uploadDir)) { @mkdir($uploadDir, 0755, true); }

// CSRF
if (empty($_SESSION['csrf'])) { $_SESSION['csrf'] = bin2hex(random_bytes(32)); }

// Helpers
function rupiah($n){ return "Rp " . number_format((float)$n,0,',','.'); }
function clean($s){ return trim(strip_tags($s ?? '')); }

// Handle Submit
$notice = null; $errors = [];
if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['csrf']) && hash_equals($_SESSION['csrf'], $_POST['csrf'])) {
  $nama      = clean($_POST['nama'] ?? '');
  $email     = clean($_POST['email'] ?? '');
  $pesan     = clean($_POST['pesan'] ?? '');
  $is_public = isset($_POST['tampilkan_nama']) ? 1 : 0;

  // Nominal: pilih preset atau custom
  $preset = clean($_POST['preset'] ?? '');
  $custom = (int)preg_replace('/\D/','', $_POST['custom'] ?? '0');
  $nominal = 0;
  if ($preset !== '') { $nominal = (int)$preset; }
  if ($custom > 0) { $nominal = $custom; } // custom override
  if ($nominal <= 0) $errors[] = "Nominal donasi belum diisi.";

  // Metode bayar
  $metode  = clean($_POST['metode'] ?? ''); // bank | ewallet
  $channel = clean($_POST['channel'] ?? ''); // BCA/BRI/Mandiri/OVO/GOPAY/DANA
  if (!in_array($metode, ['bank','ewallet'])) $errors[] = "Metode pembayaran tidak valid.";

  // Nama minimal
  if ($nama === '') $errors[] = "Nama wajib diisi.";

  // Upload bukti (opsional, tapi kalau ada harus valid)
  $proofPath = null;
  if (!empty($_FILES['bukti']['name'])) {
    if ($_FILES['bukti']['error'] === UPLOAD_ERR_OK) {
      if ($_FILES['bukti']['size'] > $maxUpload) $errors[] = "Ukuran bukti max 2MB.";
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime  = finfo_file($finfo, $_FILES['bukti']['tmp_name']);
      finfo_close($finfo);
      if (!in_array($mime, $allowedMime)) $errors[] = "Tipe file bukti harus JPG/PNG/WebP/PDF.";
      if (!$errors) {
        $ext = pathinfo($_FILES['bukti']['name'], PATHINFO_EXTENSION);
        $fname = 'proof_'.date('Ymd_His').'_'.bin2hex(random_bytes(4)).'.'.strtolower($ext);
        $dest  = $uploadDir . '/' . $fname;
        if (move_uploaded_file($_FILES['bukti']['tmp_name'], $dest)) {
          $proofPath = 'uploads/bukti/'.$fname;
        } else {
          $errors[] = "Gagal menyimpan bukti pembayaran.";
        }
      }
    } else {
      $errors[] = "Upload bukti gagal (kode: ".$_FILES['bukti']['error'].").";
    }
  }

  if (!$errors) {
    // Insert DB
    $stmt = $conn->prepare("INSERT INTO donations (name,email,amount,method,channel,message,proof_path,is_public,created_at) VALUES (?,?,?,?,?,?,?,?,NOW())");
    $stmt->bind_param("ssissssi", $nama, $email, $nominal, $metode, $channel, $pesan, $proofPath, $is_public);
    if ($stmt->execute()) {
      $notice = "Terima kasih! Donasi Anda telah tercatat.";
    } else {
      $errors[] = "Terjadi kesalahan menyimpan data. Silakan coba lagi.";
    }
    $stmt->close();
  }
} elseif ($_SERVER['REQUEST_METHOD']==='POST') {
  $errors[] = "Sesi tidak valid, refresh halaman lalu coba lagi.";
}

// Pagination for donor wall
$perPage = 10;
$page = max(1, (int)($_GET['page'] ?? 1));
$offset = ($page-1)*$perPage;
$total = 0;
$resTotal = $conn->query("SELECT COUNT(*) as c FROM donations");
if ($resTotal) { $total = (int)$resTotal->fetch_assoc()['c']; $resTotal->close(); }
$pages = max(1, ceil($total / $perPage));

$donors = [];
$sql = "SELECT id, name, amount, method, channel, is_public, created_at FROM donations ORDER BY created_at DESC LIMIT $perPage OFFSET $offset";
$res = $conn->query($sql);
if ($res) { while($r = $res->fetch_assoc()){ $donors[] = $r; } $res->close(); }
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Donasi - Rumah Baca</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css" />
<link rel="stylesheet" href="../main.css" />
<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>
:root{ --rb-green:#15803d; --rb-orange:#f97316; }
.text-gradient{ background:linear-gradient(90deg,var(--rb-green),var(--rb-orange)); -webkit-background-clip:text; color:transparent;}
.bg-rb-green{ background:var(--rb-green); } .bg-rb-orange{ background:var(--rb-orange); }
.card{ background:#fff; border-radius:1rem; box-shadow:0 10px 24px rgba(0,0,0,.08); }
.card-hover{ transition:.25s; } .card-hover:hover{ transform:translateY(-4px); box-shadow:0 16px 30px rgba(0,0,0,.12);}
.badge{ display:inline-block; padding:.35rem .6rem; border-radius:999px; font-size:.8rem; background:#f3f4f6; }
.btn{ display:inline-flex; align-items:center; gap:.5rem; justify-content:center; padding:.9rem 1.1rem; border-radius:.75rem; font-weight:700; transition:.25s; }
.btn-primary{ background:var(--rb-green); color:#fff; } .btn-primary:hover{ background:var(--rb-orange);}
.btn-outline{ border:1px solid #e5e7eb; background:#fff; } .btn-outline:hover{ border-color:var(--rb-orange); color:var(--rb-orange); }
.input, .select, .textarea{ width:100%; border:1px solid #d1d5db; border-radius:.75rem; padding:.8rem 1rem; outline:none; transition:.2s;}
.input:focus, .select:focus, .textarea:focus{ border-color:var(--rb-orange); box-shadow:0 0 0 3px rgba(249,115,22,.15);}
.grid-presets .opt{ border:1px solid #e5e7eb; border-radius:.9rem; padding:1rem; text-align:center; cursor:pointer; user-select:none;}
.grid-presets .opt.active{ border-color:var(--rb-orange); background:#fff7ed;}
.tab{ border:1px solid #e5e7eb; border-radius:.9rem; overflow:hidden; display:flex; }
.tab a{ flex:1; text-align:center; padding:.8rem 1rem; font-weight:600; border-right:1px solid #e5e7eb; }
.tab a:last-child{ border-right:none; }
.tab a.active{ background:#fff7ed; color:var(--rb-orange); }
.proof-hint{ font-size:.85rem; color:#6b7280; }
.donor-item{ display:flex; align-items:center; justify-content:space-between; padding:1rem; border-bottom:1px dashed #e5e7eb; }
.avatar{ width:36px; height:36px; border-radius:999px; background:#e5f7ec; display:inline-flex; align-items:center; justify-content:center; color:var(--rb-green); font-weight:700;}
.pagination a{ padding:.5rem .8rem; border:1px solid #e5e7eb; border-radius:.6rem; margin-right:.4rem; }
.pagination a.active{ background:var(--rb-green); color:#fff; border-color:var(--rb-green);}
</style>
</head>
<body class="font-poppins bg-gray-50">

<?php include '../navbar.php'; ?>

<!-- HERO -->
<section class="text-white text-center py-20 px-6 bg-rb-green relative overflow-hidden">
  <div class="max-w-4xl mx-auto relative z-10">
    <h1 class="text-4xl sm:text-5xl font-bold mb-4">Bersama Wujudkan Akses Baca untuk Semua</h1>
    <p class="text-white/90 text-lg">Donasi Anda mendukung buku, ruang baca, dan program literasi bagi anak-anak.</p>
  </div>
</section>

<!-- CONTENT -->
<section class="py-14 px-6 sm:px-10 lg:px-20">
  <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-10">

    <!-- LEFT: Donasi Form -->
    <div class="card p-8 card-hover" data-aos="fade-right">
      <h2 class="text-2xl font-bold text-gradient mb-6">Pilih Nominal & Metode Pembayaran</h2>

      <!-- Notice / Errors -->
      <?php if($notice): ?>
        <div class="mb-6 p-4 rounded-lg bg-green-50 text-green-700 border border-green-200">
          <?= htmlspecialchars($notice) ?>
        </div>
      <?php endif; ?>
      <?php if($errors): ?>
        <div class="mb-6 p-4 rounded-lg bg-red-50 text-red-700 border border-red-200">
          <ul class="list-disc ml-5">
          <?php foreach($errors as $e): ?>
            <li><?= htmlspecialchars($e) ?></li>
          <?php endforeach; ?>
          </ul>
        </div>
      <?php endif; ?>

      <form action="" method="post" enctype="multipart/form-data" id="donasiForm" class="space-y-6">
        <input type="hidden" name="csrf" value="<?= htmlspecialchars($_SESSION['csrf']) ?>">

        <!-- Preset amounts -->
        <div>
          <p class="font-semibold mb-3">Donasi Cepat</p>
          <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 grid-presets" id="presetGroup">
            <?php
              $presets = [50000,100000,250000,500000];
              foreach($presets as $p): ?>
              <div class="opt" data-value="<?= $p ?>"><?= rupiah($p) ?></div>
            <?php endforeach; ?>
          </div>
          <input type="hidden" name="preset" id="presetInput" value="">
        </div>

        <!-- Custom amount -->
        <div>
          <label class="font-semibold mb-2 inline-block">Nominal Lain</label>
          <div class="flex gap-3">
            <input type="text" inputmode="numeric" name="custom" id="customAmount" class="input" placeholder="Contoh: 150000">
            <button type="button" id="btnUseCustom" class="btn btn-outline">Pakai Nominal Ini</button>
          </div>
          <p class="proof-hint mt-2">Isi hanya angka. Jika diisi, ini akan menimpa pilihan preset.</p>
        </div>

        <!-- Donor info -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <div>
            <label class="font-semibold mb-2 inline-block">Nama</label>
            <input type="text" class="input" name="nama" required placeholder="Nama lengkap">
          </div>
          <div>
            <label class="font-semibold mb-2 inline-block">Email (opsional)</label>
            <input type="email" class="input" name="email" placeholder="email@anda.com">
          </div>
        </div>
        <div>
          <label class="font-semibold mb-2 inline-block">Pesan (opsional)</label>
          <textarea name="pesan" class="textarea" rows="3" placeholder="Tulis doa/dukungan singkat..."></textarea>
        </div>
        <div class="flex items-center gap-2">
          <input type="checkbox" id="tampilkan_nama" name="tampilkan_nama" checked>
          <label for="tampilkan_nama">Tampilkan nama pada daftar donatur</label>
        </div>

        <!-- Payment tabs -->
        <div>
          <p class="font-semibold mb-2">Pilih Metode Pembayaran</p>
          <div class="tab mb-4" id="payTabs">
            <a href="#" data-tab="bank" class="active">Transfer Bank</a>
            <a href="#" data-tab="ewallet">E-Wallet</a>
          </div>

          <input type="hidden" name="metode" id="metodeInput" value="bank">
          <input type="hidden" name="channel" id="channelInput" value="BCA">

          <!-- BANK -->
          <div id="tab_bank" class="space-y-3">
            <div class="flex items-center justify-between p-4 border rounded-lg">
              <div>
                <p class="font-semibold">BCA</p>
                <p class="text-sm text-gray-600">No. Rekening: <strong>1234567890</strong> a.n. Rumah Baca</p>
              </div>
              <button type="button" class="btn btn-outline choose-channel" data-method="bank" data-channel="BCA">Pilih</button>
            </div>
            <div class="flex items-center justify-between p-4 border rounded-lg">
              <div>
                <p class="font-semibold">BRI</p>
                <p class="text-sm text-gray-600">No. Rekening: <strong>9876543210</strong> a.n. Rumah Baca</p>
              </div>
              <button type="button" class="btn btn-outline choose-channel" data-method="bank" data-channel="BRI">Pilih</button>
            </div>
            <div class="flex items-center justify-between p-4 border rounded-lg">
              <div>
                <p class="font-semibold">Mandiri</p>
                <p class="text-sm text-gray-600">No. Rekening: <strong>1122334455</strong> a.n. Rumah Baca</p>
              </div>
              <button type="button" class="btn btn-outline choose-channel" data-method="bank" data-channel="Mandiri">Pilih</button>
            </div>
          </div>

          <!-- EWALLET -->
          <div id="tab_ewallet" class="space-y-3" style="display:none;">
            <div class="flex items-center justify-between p-4 border rounded-lg">
              <div>
                <p class="font-semibold">OVO</p>
                <p class="text-sm text-gray-600">No. HP: <strong>08xx-xxxx-xxxx</strong></p>
              </div>
              <button type="button" class="btn btn-outline choose-channel" data-method="ewallet" data-channel="OVO">Pilih</button>
            </div>
            <div class="flex items-center justify-between p-4 border rounded-lg">
              <div>
                <p class="font-semibold">GoPay</p>
                <p class="text-sm text-gray-600">No. HP: <strong>08xx-xxxx-xxxx</strong></p>
              </div>
              <button type="button" class="btn btn-outline choose-channel" data-method="ewallet" data-channel="GOPAY">Pilih</button>
            </div>
            <div class="flex items-center justify-between p-4 border rounded-lg">
              <div>
                <p class="font-semibold">Dana</p>
                <p class="text-sm text-gray-600">No. HP: <strong>08xx-xxxx-xxxx</strong></p>
              </div>
              <button type="button" class="btn btn-outline choose-channel" data-method="ewallet" data-channel="DANA">Pilih</button>
            </div>
          </div>
        </div>

        <!-- Upload proof -->
        <div>
          <label class="font-semibold mb-2 inline-block">Upload Bukti Pembayaran (opsional)</label>
          <input type="file" class="input" name="bukti" accept=".jpg,.jpeg,.png,.webp,.pdf">
          <p class="proof-hint mt-1">Format: JPG/PNG/WebP/PDF, maks 2MB.</p>
        </div>

        <button type="submit" class="btn btn-primary w-full">
          <i class="bi bi-heart-fill"></i> Konfirmasi Donasi
        </button>
      </form>
    </div>

    <!-- RIGHT: Donor Wall -->
    <div class="space-y-6">
      <div class="card p-8 card-hover" data-aos="fade-left">
        <h3 class="text-2xl font-bold text-gradient mb-2">Total Dukungan</h3>
        <?php
          $sum = 0; $rs = $conn->query("SELECT SUM(amount) as s FROM donations");
          if ($rs) { $sum = (int)($rs->fetch_assoc()['s'] ?? 0); $rs->close(); }
        ?>
        <p class="text-3xl font-extrabold"><?= rupiah($sum) ?></p>
        <p class="text-gray-600 mt-1">Terima kasih atas kepedulian Anda.</p>
      </div>

      <div class="card p-8 card-hover" data-aos="fade-left" data-aos-delay="100">
        <h3 class="text-2xl font-bold text-gradient mb-6">Daftar Donatur</h3>

        <?php if(!$donors): ?>
          <p class="text-gray-600">Belum ada donasi. Jadilah yang pertama! 💚</p>
        <?php else: ?>
          <div class="divide-y">
            <?php foreach($donors as $d): 
              $displayName = $d['is_public'] ? $d['name'] : 'Anonim';
              $initial = mb_strtoupper(mb_substr($displayName,0,1));
              $method = strtoupper($d['method']) === 'BANK' ? 'Bank' : 'E-Wallet';
            ?>
            <div class="donor-item">
              <div class="flex items-center gap-3">
                <span class="avatar"><?= htmlspecialchars($initial) ?></span>
                <div>
                  <p class="font-semibold"><?= htmlspecialchars($displayName) ?></p>
                  <p class="text-sm text-gray-500"><?= htmlspecialchars($method.' • '.$d['channel']) ?></p>
                </div>
              </div>
              <div class="text-right">
                <p class="font-bold"><?= rupiah($d['amount']) ?></p>
                <p class="text-xs text-gray-500"><?= date('d M Y, H:i', strtotime($d['created_at'])) ?></p>
              </div>
            </div>
            <?php endforeach; ?>
          </div>

          <!-- Pagination -->
          <?php if ($pages>1): ?>
          <div class="pagination mt-5">
            <?php for($i=1;$i<=$pages;$i++): 
              $active = $i===$page ? 'active':'';
            ?>
              <a class="<?= $active ?>" href="?page=<?= $i ?>"><?= $i ?></a>
            <?php endfor; ?>
          </div>
          <?php endif; ?>
        <?php endif; ?>
      </div>
    </div>

  </div>
</section>

<?php include '../footer.php'; ?>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 800, once: true });

// Preset selection
const presetGroup = document.getElementById('presetGroup');
const presetInput = document.getElementById('presetInput');
const customAmount = document.getElementById('customAmount');
const btnUseCustom = document.getElementById('btnUseCustom');

presetGroup?.addEventListener('click', (e)=>{
  const card = e.target.closest('.opt'); if(!card) return;
  presetGroup.querySelectorAll('.opt').forEach(o=>o.classList.remove('active'));
  card.classList.add('active');
  presetInput.value = card.dataset.value;
});

btnUseCustom?.addEventListener('click', ()=>{
  presetGroup.querySelectorAll('.opt').forEach(o=>o.classList.remove('active'));
  const val = (customAmount.value || '').replace(/\D/g,'');
  customAmount.value = val;
  if (!val) { alert('Isi nominal custom terlebih dahulu'); return; }
  presetInput.value = ''; // custom overrides
  alert('Nominal custom akan digunakan: Rp ' + new Intl.NumberFormat('id-ID').format(val));
});

// Tabs payment
const payTabs = document.getElementById('payTabs');
const metodeInput = document.getElementById('metodeInput');
const channelInput = document.getElementById('channelInput');
payTabs?.addEventListener('click', (e)=>{
  e.preventDefault();
  const a = e.target.closest('a'); if(!a) return;
  payTabs.querySelectorAll('a').forEach(x=>x.classList.remove('active'));
  a.classList.add('active');
  const tab = a.dataset.tab;
  document.getElementById('tab_bank').style.display   = tab==='bank' ? '' : 'none';
  document.getElementById('tab_ewallet').style.display= tab==='ewallet' ? '' : 'none';
  metodeInput.value = tab;
  // default channel
  channelInput.value = tab==='bank' ? 'BCA' : 'OVO';
});

// Choose specific channel button
document.querySelectorAll('.choose-channel').forEach(btn=>{
  btn.addEventListener('click', ()=>{
    metodeInput.value = btn.dataset.method;
    channelInput.value = btn.dataset.channel;
    alert('Metode dipilih: ' + btn.dataset.method.toUpperCase() + ' • ' + btn.dataset.channel);
  });
});
</script>
</body>
</html>
