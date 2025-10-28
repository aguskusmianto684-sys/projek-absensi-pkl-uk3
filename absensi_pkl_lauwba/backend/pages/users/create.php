<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
  echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href='../user/login.php';
    </script>";
  exit();
}

$page = "users";
include '../../../config/notify_logic.php';

include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';
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
        <h3 class="fw-bold mb-3">Tambah Data Pengguna</h3>
        <h6 class="op-7 mb-2">Isi form berikut untuk menambahkan akun baru</h6>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card card-round shadow-sm">
          <div class="card-header" style="background: linear-gradient(135deg, white, #0077b6, #90e0ef);">
            <h5 class="mb-0">Form Tambah User</h5>
          </div>

          <div class="card-body">
            <form action="../../actions/users/store.php" method="POST">

              <!-- Username -->
              <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username" required>
              </div>

              <!-- Nama Lengkap -->
              <div class="mb-3">
                <label for="full_name" class="form-label">Nama Lengkap</label>
                <input type="text" name="full_name" id="full_name" class="form-control" placeholder="Masukkan nama lengkap" required>
              </div>

              <!-- Email -->
              <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="Masukkan email" required>
              </div>

              <!-- Nomor Telepon -->
              <div class="mb-3">
                <label for="phone" class="form-label">Nomor Telepon</label>
                <input type="text" name="phone" id="phone" class="form-control" placeholder="Masukkan nomor telepon">
              </div>


              <!-- Password -->
              <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password" required>
              </div>

              <!-- Role -->
              <div class="mb-3">
                <label for="role" class="form-label">Role</label>
                <select name="role" id="role" class="form-control" required>
                  <option value="">-- Pilih Role --</option>
                  <option value="admin">Admin</option>
                  <option value="pembimbing">Pembimbing</option>
                  <option value="peserta">Peserta</option>
                </select>
              </div>

              <!-- Status -->
              <div class="mb-3">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-control" required>
                  <option value="">-- Pilih Status --</option>
                  <option value="aktif">Aktif</option>
                  <option value="nonaktif">Nonaktif</option>
                </select>
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