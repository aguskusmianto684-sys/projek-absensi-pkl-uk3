<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
  echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href='../user/login.php';
    </script>";
  exit();
}

$page = "supervisors";
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
  echo "<script>alert('ID pembimbing tidak valid!'); window.location.href='index.php';</script>";
  exit;
}

// Ambil data pembimbing dari database
$q = "
  SELECT 
    s.*, 
    u.full_name AS nama_pembimbing, 
    u.email 
  FROM supervisors s
  LEFT JOIN users u ON s.user_id = u.id
  WHERE s.id = '$id'
  LIMIT 1
";
$result = mysqli_query($connect, $q);

if (!$result || mysqli_num_rows($result) === 0) {
  echo "<script>alert('Data pembimbing tidak ditemukan!'); window.location.href='index.php';</script>";
  exit;
}

$supervisor = mysqli_fetch_object($result);
?>

<style>
.card {
  border-radius: 12px;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
  padding: 25px 30px;
}

.label-info {
  font-weight: 600;
  color: #111;
  margin-bottom: 3px;
}

.value-info {
  color: #333;
  margin-bottom: 12px;
}

h4.card-title {
  color: #111;
  font-weight: 700;
  margin-bottom: 0;
}

.page-inner {
  padding-top: 10px !important;
}

.btn-back {
  background-color: #555;
  color: white;
  padding: 8px 18px;
  border-radius: 8px;
  transition: 0.2s;
}

.btn-back:hover {
  background-color: #333;
  color: #fff;
}
</style>

<!-- Main Content -->
<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left flex-column flex-md-row pt-2 pb-3">
      <div>
        <h3 class="fw-bold mb-2 text-dark">Detail Pembimbing Lapangan</h3>
        <p class="text-muted mb-0">Berikut informasi lengkap pembimbing PKL / Magang.</p>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-9">
        <div class="card">
          <div class="card-header bg-white border-0 mb-3">
            <h4 class="card-title">
              <i class="fas fa-user-tie me-2 text-dark"></i>
              <?= htmlspecialchars($supervisor->nama_pembimbing ?? '-') ?>
            </h4>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-md-6 mb-3">
                <p class="label-info">Email</p>
                <p class="value-info"><?= htmlspecialchars($supervisor->email ?? '-') ?></p>
              </div>
              <div class="col-md-6 mb-3">
                <p class="label-info">Departemen / Bidang</p>
                <p class="value-info"><?= htmlspecialchars($supervisor->department ?? '-') ?></p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <p class="label-info">Nomor Telepon</p>
                <p class="value-info"><?= htmlspecialchars($supervisor->phone ?? '-') ?></p>
              </div>
              <div class="col-md-6 mb-3">
                <p class="label-info">Catatan</p>
                <p class="value-info"><?= htmlspecialchars($supervisor->note ?? '-') ?></p>
              </div>
            </div>

            <hr class="my-3">

            <div class="row">
              <div class="col-md-6 mb-3">
                <p class="label-info">Dibuat Pada</p>
                <p class="value-info"><?= htmlspecialchars($supervisor->created_at ?? '-') ?></p>
              </div>
              <div class="col-md-6 mb-3">
                <p class="label-info">Terakhir Diperbarui</p>
                <p class="value-info"><?= htmlspecialchars($supervisor->updated_at ?? '-') ?></p>
              </div>
            </div>

            <div class="d-flex justify-content-end mt-3">
              <a href="./index.php" class="btn btn-back">
                <i class="fas fa-arrow-left me-1"></i> Kembali
              </a>
            </div>

          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- End Main Content -->

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
