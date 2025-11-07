<?php
session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'peserta') {
    echo "<script>alert('Akses ditolak!'); window.location.href='../users/login.php';</script>";
    exit;
}

$page = "attendance";
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
?>

<div class="container">
  <div class="page-inner">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card shadow-sm">
          <div class="card-header text-center" style="background:linear-gradient(135deg,#023e8a,#0077b6,#48cae4);">
            <h5 class="text-white mb-0">Form Izin / Sakit</h5>
          </div>

          <div class="card-body">
            <form action="../../actions/attendance/store_izin.php" method="POST" enctype="multipart/form-data">

              <label>Status</label>
              <select name="status" class="form-control" required>
                <option value="izin">Izin</option>
                <option value="sakit">Sakit</option>
              </select>

              <label class="mt-3">Keterangan</label>
              <textarea name="note" class="form-control" required></textarea>

              <label class="mt-3">Upload Bukti (opsional)</label>
              <input type="file" name="bukti" class="form-control">

              <button class="btn btn-primary w-100 mt-4">Kirim</button>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
