<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
  echo "<script>
    alert('Silakan login terlebih dahulu!');
    window.location.href='../user/login.php';
  </script>";
  exit();
}

$page = "settings";
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Ambil data pengaturan berdasarkan ID
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
  echo "<script>alert('ID tidak valid!'); window.location.href='index.php';</script>";
  exit;
}

$q = mysqli_query($connect, "SELECT * FROM settings WHERE id = '$id'");
$data = mysqli_fetch_assoc($q);
if (!$data) {
  echo "<script>alert('Data tidak ditemukan!'); window.location.href='index.php';</script>";
  exit;
}
?>

<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left flex-column flex-md-row pt-2 pb-3">
      <div>
        <h3 class="fw-bold mb-3">Edit Pengaturan</h3>
        <h6 class="op-7 mb-2">Ubah nilai dari pengaturan sistem</h6>
      </div>
    </div>

    <div class="row">
      <div class="col-md-10 mx-auto">
        <div class="card shadow-sm card-round">
          <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Form Edit Pengaturan</h5>
          </div>

          <div class="card-body">
            <form id="updateSettingForm">
              <input type="hidden" name="id" value="<?= $data['id'] ?>">

              <div class="mb-3">
                <label class="form-label">Nama Pengaturan</label>
                <input type="text" class="form-control" 
                       value="<?= htmlspecialchars($data['setting_key']) ?>" disabled>
              </div>

              <div class="mb-3">
                <label for="setting_value" class="form-label">Nilai Pengaturan</label>
                <textarea name="setting_value" id="setting_value" class="form-control" rows="4" required><?= htmlspecialchars($data['setting_value']) ?></textarea>
              </div>

              <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-success me-2">
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('updateSettingForm').addEventListener('submit', async function(e) {
  e.preventDefault();
  
  const formData = new FormData(this);
  const res = await fetch('../../actions/settings/update.php', {
    method: 'POST',
    body: formData
  });
  const result = await res.json();

  if (result.status === 'success') {
    Swal.fire({
      toast: true,
      icon: 'success',
      title: result.message,
      position: 'top-end',
      showConfirmButton: false,
      timer: 2500,
      timerProgressBar: true
    });
  } else {
    Swal.fire({
      toast: true,
      icon: 'error',
      title: result.message || 'Gagal menyimpan perubahan',
      position: 'top-end',
      showConfirmButton: false,
      timer: 2500
    });
  }
});
</script>
