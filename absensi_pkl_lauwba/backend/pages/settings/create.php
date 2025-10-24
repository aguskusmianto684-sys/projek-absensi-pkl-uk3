<?php
// session_start();
// if (!isset($_SESSION['logged_in'])) {
//   echo "<script>
//         alert('Silakan login terlebih dahulu!');
//         window.location.href='../user/login.php';
//     </script>";
//   exit();
// }

$page = "schedules";
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
?>

<style>
  .card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  }
</style>

<!-- Main Content -->
<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div>
        <h3 class="fw-bold mb-3">Tambah Jadwal (Schedule)</h3>
        <h6 class="op-7 mb-2">Isi form berikut untuk menambahkan jadwal baru</h6>
      </div>
    </div>

    <!-- Form Tambah Jadwal -->
    <div class="row">
      <div class="col-md-12">
        <div class="card card-round shadow-lg">
          <div class="card-header" style="background: linear-gradient(135deg, white, #0077b6, #90e0ef);">
            <h5 class="mb-0">Form Tambah Jadwal</h5>
          </div>

          <div class="card-body">
            <form action="../../actions/schedules/store.php" method="POST">

              <!-- Tanggal -->
              <div class="mb-3">
                <label for="date" class="form-label">Tanggal</label>
                <input type="date" name="date" id="date" class="form-control" required>
              </div>

              <!-- Jam Masuk -->
              <div class="mb-3">
                <label for="expected_in" class="form-label">Jam Masuk</label>
                <input type="time" name="expected_in" id="expected_in" class="form-control" required>
              </div>

              <!-- Jam Keluar -->
              <div class="mb-3">
                <label for="expected_out" class="form-label">Jam Keluar</label>
                <input type="time" name="expected_out" id="expected_out" class="form-control" required>
              </div>

              <!-- Deskripsi -->
              <div class="mb-3">
                <label for="description" class="form-label">Deskripsi / Kegiatan</label>
                <textarea name="description" id="description" rows="3" class="form-control" placeholder="Contoh: Briefing pagi dan pengerjaan laporan mingguan..." required></textarea>
              </div>

              <!-- Tombol -->
              <div class="d-flex justify-content-end mt-4">
                <button type="submit" name="tombol" class="btn btn-success me-2">
                  <i class="fas fa-save me-1"></i> Simpan
                </button>
                <a href="./index.php" class="btn btn-secondary">
                  <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>
<!-- End Main Content -->

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
