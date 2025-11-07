<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'peserta') {
  echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href='../users/login.php';
    </script>";
  exit();
}

$page = "attendance";
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
?>

<style>
  #reader {
    width: 260px;
    height: 260px;
    margin: auto;
    border-radius: 14px;
    overflow: hidden;
    border: 3px solid #0096c7;
    box-shadow: 0 6px 14px rgba(0,0,0,0.2);

    display: flex;
    justify-content: center;
    align-items: center;
    background: #000;
  }

  #reader img {
    width: 100%;
    height: 100%;
    object-fit: contain; /* ✅ gambar tidak memanjang */
  }

  #uploadBox {
    padding: 12px;
    border: 2px dashed #0077b6;
    border-radius: 10px;
    cursor: pointer;
    margin-top: 15px;
  }
  #uploadBox:hover {
    background: #e8f8ff;
  }
</style>


<div class="container">
  <div class="page-inner">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card card-round shadow-sm">
          <div class="card-header text-center" 
          style="background: linear-gradient(135deg, #023e8a, #0077b6, #90e0ef);">
            <h5 class="mb-0 text-white">
              <i class="fas fa-qrcode me-2"></i> Scan QR Absensi
            </h5>
          </div>

          <div class="card-body text-center">
            <p>Arahkan kamera atau upload gambar QR</p>

            <!-- AREA SCAN -->
            <div id="reader"></div>

            <hr>

            <!-- UPLOAD GAMBAR -->
            <div id="uploadBox">
              <i class="fas fa-image"></i> Upload gambar QR
            </div>
            <input type="file" id="qrImage" accept="image/*" style="display:none;">

            <div id="result" class="mt-3"></div>

            <a href="./index.php" class="btn btn-secondary mt-4">
              <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
let html5QrCode = new Html5Qrcode("reader");

// ✅ Jalankan kamera
html5QrCode.start(
  { facingMode: "environment" },
  { fps: 10, qrbox: 200 },
  (decodedText) => proses(decodedText)
).catch(err => {
  document.getElementById('result').innerHTML = `
    <div class="alert alert-danger mt-3">
      Gagal akses kamera, izinkan kamera.
    </div>`;
});

// ✅ Klik upload = pilih file
document.getElementById('uploadBox').onclick = () => {
  document.getElementById('qrImage').click();
};

// ✅ Ketika gambar dipilih
document.getElementById('qrImage').onchange = async function(evt) {
  let file = evt.target.files[0];
  if (!file) return;

  // ✅ Matikan kamera dulu
  try { await html5QrCode.stop(); } catch {}

  // ✅ Tampilkan gambar di dalam area scanner
  const readerEl = document.getElementById('reader');
  readerEl.innerHTML = "";
  const img = document.createElement("img");
  img.src = URL.createObjectURL(file);
  readerEl.appendChild(img);

  // ✅ Scan file
  try {
    const decoded = await html5QrCode.scanFile(file, true);
    proses(decoded);
  } catch (err) {
    document.getElementById('result').innerHTML = `
      <div class="alert alert-danger mt-3">
        Gambar tidak berisi QR valid!
      </div>`;
  }
};

// ✅ Proses scan kamera / gambar
function proses(token) {

  navigator.geolocation.getCurrentPosition(async (pos) => {

    let lokasi = pos.coords.latitude + "," + pos.coords.longitude;

    let formData = new FormData();
    formData.append("token", token);
    formData.append("location", lokasi);

    let res = await fetch("../../actions/attendance/scan_verify.php", {
      method: "POST",
      body: formData
    });

    let text = await res.text();
    document.getElementById('result').innerHTML = `
      <div class="alert alert-success mt-3">${text}</div>
    `;

    setTimeout(() => {
      window.location.href = "./index.php";
    }, 1500);

  }, () => {
    document.getElementById('result').innerHTML = `
      <div class="alert alert-danger mt-3">
        Aktifkan GPS untuk absen!
      </div>`;
  });
}
</script>


<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
