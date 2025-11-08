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
        <div class="card shadow-sm border-0">
          <div class="card-header text-center text-white fw-bold"
               style="background: linear-gradient(135deg, #023e8a, #0077b6, #48cae4); border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
            Form Izin / Sakit
          </div>

          <div class="card-body">
            <form action="../../actions/attendance/store_izin.php" method="POST" enctype="multipart/form-data" autocomplete="off">

              <!-- Status -->
              <div class="mb-3">
                <label for="status" class="form-label fw-semibold">Status</label>
                <select name="status" id="status" class="form-select" required>
                  <option value="">-- Pilih Status --</option>
                  <option value="Izin">Izin</option>
                  <option value="Sakit">Sakit</option>
                </select>
              </div>

              <!-- Keterangan -->
              <div class="mb-3">
                <label for="note" class="form-label fw-semibold">Keterangan</label>
                <textarea name="note" id="note" class="form-control" rows="3" placeholder="Masukkan alasan izin/sakit..." required></textarea>
              </div>

              <!-- Bukti -->
              <div class="mb-3">
                <label for="bukti" class="form-label fw-semibold">Upload Bukti (opsional)</label>
                <input type="file" name="bukti" id="bukti" class="form-control" accept=".jpg,.jpeg,.png,.pdf">
                <small class="text-muted">Format: JPG, PNG, atau PDF. Maksimal 2MB.</small>
              </div>

              <!-- Tombol Kirim -->
              <button type="submit" class="btn btn-primary w-100 fw-semibold">
                <i class="fas fa-paper-plane me-1"></i> Kirim Permohonan
              </button>

              <!-- Tombol Kembali -->
              <a href="../attendance/index.php" class="btn btn-secondary w-100 mt-2 fw-semibold">
                <i class="fas fa-arrow-left me-1"></i> Kembali
              </a>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
