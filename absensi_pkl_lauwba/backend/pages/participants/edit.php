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

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
  echo "<script>
        alert('ID peserta tidak ditemukan!');
        window.location.href='index.php';
      </script>";
  exit();
}

// Ambil data peserta berdasarkan ID
$qData = mysqli_query($connect, "SELECT * FROM participants WHERE id = '$id'") or die(mysqli_error($connect));
$data = mysqli_fetch_assoc($qData);
if (!$data) {
  echo "<script>
        alert('Data peserta tidak ditemukan!');
        window.location.href='index.php';
      </script>";
  exit();
}

// Ambil data user untuk dropdown
$qPeserta = mysqli_query($connect, "SELECT id, full_name FROM users WHERE role = 'peserta' ORDER BY full_name ASC");
$qPembimbing = mysqli_query($connect, "SELECT id, full_name FROM users WHERE role = 'pembimbing' ORDER BY full_name ASC");
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
        <h3 class="fw-bold mb-3">Edit Data Peserta PKL / Magang</h3>
        <h6 class="op-7 mb-2">Perbarui data peserta PKL / magang</h6>
      </div>
    </div>

    <!-- Form Edit Peserta -->
    <div class="row">
      <div class="col-md-12">
        <div class="card card-round shadow-lg">
          <div class="card-header" style="background: linear-gradient(135deg, white, #0077b6, #90e0ef);">
            <h5 class="mb-0">Form Edit Peserta</h5>
          </div>

          <div class="card-body">
            <form action="../../actions/participants/update.php" method="POST">
              <input type="hidden" name="id" value="<?= $data['id'] ?>">

              <!-- Pilih Peserta -->
              <div class="mb-3">
                <label for="user_id" class="form-label">Peserta</label>
                <select name="user_id" id="user_id" class="form-control" required>
                  <option value="">-- Pilih Peserta --</option>
                  <?php while ($p = mysqli_fetch_assoc($qPeserta)) : ?>
                    <option value="<?= $p['id'] ?>" <?= $p['id'] == $data['user_id'] ? 'selected' : '' ?>>
                      <?= htmlspecialchars($p['full_name']) ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>

              <!-- Asal Sekolah -->
              <div class="mb-3">
                <label for="school" class="form-label">Asal Sekolah</label>
                <input type="text" name="school" id="school" class="form-control"
                  value="<?= htmlspecialchars($data['school']) ?>" required>
              </div>

              <!-- Program Studi -->
              <div class="mb-3">
                <label for="program_study" class="form-label">Program Studi / Jurusan</label>
                <input type="text" name="program_study" id="program_study" class="form-control"
                  value="<?= htmlspecialchars($data['program_study']) ?>" required>
              </div>

              <!-- Tanggal Mulai & Selesai -->
              <div class="row mb-3">
                <div class="col-md-6">
                  <label for="start_date" class="form-label">Tanggal Mulai</label>
                  <input type="date" name="start_date" id="start_date" class="form-control"
                    value="<?= $data['start_date'] ?>" required>
                </div>
                <div class="col-md-6">
                  <label for="end_date" class="form-label">Tanggal Selesai</label>
                  <input type="date" name="end_date" id="end_date" class="form-control"
                    value="<?= $data['end_date'] ?>" required>
                </div>
              </div>

              <!-- Pembimbing Lapangan -->
              <div class="mb-3">
                <label for="supervisor_id" class="form-label">Pembimbing Lapangan</label>
                <select name="supervisor_id" id="supervisor_id" class="form-control" required>
                  <option value="">-- Pilih Pembimbing --</option>
                  <?php while ($s = mysqli_fetch_assoc($qPembimbing)) : ?>
                    <option value="<?= $s['id'] ?>" <?= $s['id'] == $data['supervisor_id'] ? 'selected' : '' ?>>
                      <?= htmlspecialchars($s['full_name']) ?>
                    </option>
                  <?php endwhile; ?>
                </select>
              </div>

              <!-- Pembimbing Sekolah -->
              <div class="mb-3">
                <label for="supervisor_name" class="form-label">Pembimbing Sekolah</label>
                <input type="text" name="supervisor_name" id="supervisor_name" class="form-control"
                  value="<?= htmlspecialchars($data['supervisor_name']) ?>">
              </div>

              <!-- Tombol -->
              <div class="d-flex justify-content-end mt-4">
                <button type="submit" name="tombol" class="btn btn-primary me-2">
                  <i class="fas fa-save me-1"></i> Update
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