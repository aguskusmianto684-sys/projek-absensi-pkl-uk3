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

// Ambil ID supervisor dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
  echo "<script>alert('ID pembimbing tidak ditemukan!'); window.location.href='index.php';</script>";
  exit;
}

// Ambil data supervisor berdasarkan ID
$q = mysqli_query($connect, "SELECT * FROM supervisors WHERE id = '$id'");
$data = mysqli_fetch_assoc($q);
if (!$data) {
  echo "<script>alert('Data pembimbing tidak ditemukan!'); window.location.href='index.php';</script>";
  exit;
}

// Ambil daftar user dengan role pembimbing
$qUsers = mysqli_query($connect, "
  SELECT id, full_name 
  FROM users 
  WHERE role = 'pembimbing'
  ORDER BY full_name ASC
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
        <h3 class="fw-bold mb-3">Edit Data Pembimbing Lapangan</h3>
        <h6 class="op-7 mb-2">Perbarui informasi pembimbing PKL / Magang</h6>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card card-round shadow-sm">
          <div class="card-header" style="background: linear-gradient(135deg, white, #0077b6, #90e0ef);">
            <h5 class="mb-0">Form Edit Pembimbing</h5>
          </div>

          <div class="card-body">
            <form action="../../actions/supervisors/update.php" method="POST">
              <input type="hidden" name="id" value="<?= $data['id'] ?>">

              <!-- Nama Pembimbing -->
              <div class="mb-3">
                <label for="user_id" class="form-label">Nama Pembimbing</label>
                <select name="user_id" id="user_id" class="form-control" required>
                  <option value="">-- Pilih Pembimbing --</option>
                  <?php while ($u = mysqli_fetch_assoc($qUsers)) : ?>
                    <option value="<?= $u['id'] ?>" <?= ($u['id'] == $data['user_id']) ? 'selected' : '' ?>>
                      <?= htmlspecialchars($u['full_name']) ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>

              <!-- Departemen -->
              <div class="mb-3">
                <label for="department" class="form-label">Departemen / Bidang</label>
                <input type="text" name="department" id="department" class="form-control" 
                       value="<?= htmlspecialchars($data['department']) ?>" required>
              </div>

              <!-- Nomor Telepon -->
              <div class="mb-3">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="text" name="phone" id="phone" class="form-control" 
                       value="<?= htmlspecialchars($data['phone']) ?>" required>
              </div>

              <!-- Catatan -->
              <div class="mb-3">
                <label for="note" class="form-label">Catatan (Opsional)</label>
                <textarea name="note" id="note" class="form-control" rows="3"><?= htmlspecialchars($data['note']) ?></textarea>
              </div>

              <!-- Tombol -->
              <div class="d-flex justify-content-end mt-4">
                <button type="submit" name="tombol" class="btn btn-success me-2">
                  <i class="fas fa-save me-1"></i> Perbarui
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

<!-- Select2 untuk dropdown pembimbing -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.full.min.js"></script>

<script>
  $(document).ready(function() {
    $('#user_id').select2({
      placeholder: "-- Cari atau pilih pembimbing --",
      allowClear: true,
      width: '100%'
    });
  });
</script>
</body>
</html>
