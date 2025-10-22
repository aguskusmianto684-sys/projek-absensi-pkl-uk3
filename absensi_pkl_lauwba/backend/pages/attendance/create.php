<?php
// session_start();
// if (!isset($_SESSION['logged_in'])) {
//   echo "<script>
//         alert('Silakan login terlebih dahulu!');
//         window.location.href='../user/login.php';
//     </script>";
//   exit();
// }

$page = "attendance";
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Ambil data peserta untuk dropdown
$qParticipants = mysqli_query($connect, "
  SELECT p.id, u.full_name 
  FROM participants p
  LEFT JOIN users u ON p.user_id = u.id
  ORDER BY u.full_name ASC
");
?>

<style>
  .card {
    border-radius: 12px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
  }
</style>

<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
      <div>
        <h3 class="fw-bold mb-3">Tambah Data Absensi</h3>
        <h6 class="op-7 mb-2">Isi form berikut untuk mencatat absensi peserta PKL / Magang</h6>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card card-round shadow-sm">
          <div class="card-header" style="background: linear-gradient(135deg, white, #0077b6, #90e0ef);">
            <h5 class="mb-0">Form Tambah Absensi</h5>
          </div>

          <div class="card-body">
            <form action="../../actions/attendance/store.php" method="POST">

              <!-- Peserta -->
              <div class="mb-3">
                <label for="participant_id" class="form-label">Nama Peserta</label>
                <select name="participant_id" id="participant_id" class="form-control" required>
                  <option value="">-- Pilih Peserta --</option>
                  <?php while ($p = mysqli_fetch_assoc($qParticipants)) : ?>
                    <option value="<?= $p['id'] ?>"><?= htmlspecialchars($p['full_name']) ?></option>
                  <?php endwhile; ?>
                </select>
              </div>

              <!-- Check In -->
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="check_in" class="form-label">Waktu Check In</label>
                  <input type="datetime-local" name="check_in" id="check_in" class="form-control">
                </div>
                <div class="col-md-6">
                  <label for="check_in_location" class="form-label">Lokasi Check In</label>
                  <input type="text" name="check_in_location" id="check_in_location" class="form-control" placeholder="Masukkan lokasi check in...">
                </div>
              </div>

              <!-- Check Out -->
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="check_out" class="form-label">Waktu Check Out</label>
                  <input type="datetime-local" name="check_out" id="check_out" class="form-control">
                </div>
                <div class="col-md-6">
                  <label for="check_out_location" class="form-label">Lokasi Check Out</label>
                  <input type="text" name="check_out_location" id="check_out_location" class="form-control" placeholder="Masukkan lokasi check out...">
                </div>
              </div>

              <!-- Status -->
              <div class="mb-3">
                <label for="status" class="form-label">Status Kehadiran</label>
                <select name="status" id="status" class="form-control" required>
                  <option value="">-- Pilih Status --</option>
                  <option value="hadir">Hadir</option>
                  <option value="izin">Izin</option>
                  <option value="sakit">Sakit</option>
                  <option value="alpa">Alpa</option>
                </select>
              </div>

              <!-- Catatan -->
              <div class="mb-3">
                <label for="note" class="form-label">Keterangan</label>
                <textarea name="note" id="note" class="form-control" rows="3" placeholder="Tambahkan catatan (opsional)..."></textarea>
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

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

<script>
  $(document).ready(function() {
    // Inisialisasi Select2
    $('#participant_id').select2({
      placeholder: "-- Cari atau pilih peserta --",
      allowClear: true,
      width: '100%',
      language: {
        noResults: function() {
          return "❌ Peserta tidak ditemukan";
        },
        searching: function() {
          return "🔍 Mencari...";
        }
      }
    });

    // Styling agar konsisten dengan Kaiadmin
    $('.select2-container .select2-selection--single').css({
      'height': '38px',
      'border': '1px solid #ced4da',
      'border-radius': '6px',
      'padding': '5px 8px',
      'font-size': '14px'
    });

    $('.select2-selection__arrow').css({
      'top': '6px',
      'right': '8px'
    });
  });
</script>
</body>

</html>