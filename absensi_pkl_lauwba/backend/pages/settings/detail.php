<?php
// session_start();
// if (!isset($_SESSION['logged_in'])) {
//   echo "<script>
//         alert('Silakan login terlebih dahulu!');
//         window.location.href='../user/login.php';
//     </script>";
//   exit();
// }

$page = "participants";
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
include '../../actions/participants/show.php'; // ambil data peserta berdasarkan id

// Ambil nama peserta & pembimbing dari tabel users
$namaPeserta = '-';
$namaPembimbing = '-';

$qPeserta = mysqli_query($connect, "SELECT full_name FROM users WHERE id = '{$participant->user_id}' LIMIT 1");
if ($qPeserta && mysqli_num_rows($qPeserta) > 0) {
  $namaPeserta = mysqli_fetch_assoc($qPeserta)['full_name'];
}

$qPembimbing = mysqli_query($connect, "SELECT full_name FROM users WHERE id = '{$participant->supervisor_id}' LIMIT 1");
if ($qPembimbing && mysqli_num_rows($qPembimbing) > 0) {
  $namaPembimbing = mysqli_fetch_assoc($qPembimbing)['full_name'];
}
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
    margin-bottom: 2px;
  }

  .value-info {
    color: #333;
    margin-bottom: 10px;
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
        <h3 class="fw-bold mb-2 text-dark">Detail Peserta PKL / Magang</h3>
        <p class="text-muted mb-0">Berikut informasi lengkap dari peserta yang terdaftar.</p>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-md-9">
        <div class="card">
          <div class="card-header bg-white border-0 mb-3">
            <h4 class="card-title">
              <i class="fas fa-user me-2 text-dark"></i>
              <?= htmlspecialchars($namaPeserta) ?>
            </h4>
          </div>

          <div class="card-body">
            <div class="row">
              <div class="col-md-6 mb-2">
                <p class="label-info">Asal Sekolah</p>
                <p class="value-info"><?= htmlspecialchars($participant->school) ?></p>
              </div>
              <div class="col-md-6 mb-2">
                <p class="label-info">Program Studi / Jurusan</p>
                <p class="value-info"><?= htmlspecialchars($participant->program_study) ?></p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-2">
                <p class="label-info">Tanggal Mulai</p>
                <p class="value-info"><?= htmlspecialchars($participant->start_date) ?></p>
              </div>
              <div class="col-md-6 mb-2">
                <p class="label-info">Tanggal Selesai</p>
                <p class="value-info"><?= htmlspecialchars($participant->end_date) ?></p>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-2">
                <p class="label-info">Pembimbing Lapangan</p>
                <p class="value-info"><?= htmlspecialchars($namaPembimbing) ?></p>
              </div>
              <div class="col-md-6 mb-2">
                <p class="label-info">Pembimbing Sekolah</p>
                <p class="value-info"><?= htmlspecialchars($participant->supervisor_name ?: '-') ?></p>
              </div>
            </div>

            <hr class="my-3">

            <div class="row">
              <div class="col-md-6 mb-2">
                <p class="label-info">Dibuat Pada</p>
                <p class="value-info"><?= htmlspecialchars($participant->created_at) ?></p>
              </div>
              <div class="col-md-6 mb-2">
                <p class="label-info">Terakhir Diperbarui</p>
                <p class="value-info"><?= htmlspecialchars($participant->updated_at) ?></p>
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