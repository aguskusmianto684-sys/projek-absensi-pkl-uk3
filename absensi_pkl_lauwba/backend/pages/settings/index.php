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

// Ambil semua data pengaturan
$qSettings = "SELECT * FROM settings ORDER BY id ASC";
$result = mysqli_query($connect, $qSettings);
?>

<style>
.table, .table-bordered, .table-bordered th, .table-bordered td {
  border: 1px solid #999 !important;
  color: #000;
}
.table thead th {
  background-color: #f8f9fa;
  border: 1px solid #999 !important;
}
.table tbody td {
  border: 1px solid #999 !important;
}
.card {
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
}
.btn-sm {
  padding: 3px 7px;
  font-size: 12px;
}
</style>

<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-3">
      <div>
        <h3 class="fw-bold mb-3">Pengaturan Sistem (Settings)</h3>
        <h6 class="op-7 mb-2">Kelola konfigurasi umum aplikasi Absensi PKL Lauwba</h6>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card card-round shadow-sm">
          <div class="card-header" style="background: linear-gradient(135deg, #023e8a, #0077b6, #90e0ef); color: #fff;">
            <h5 class="mb-0">Daftar Pengaturan</h5>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table id="settingsTable" class="table table-bordered table-hover align-middle text-center">
                <thead>
                  <tr>
                    <th width="5%">No</th>
                    <th>Nama Pengaturan</th>
                    <th>Nilai</th>
                    <th>Diperbarui Pada</th>
                    <th width="10%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  if ($result && mysqli_num_rows($result) > 0):
                    while ($row = mysqli_fetch_assoc($result)): ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td class="text-capitalize"><?= htmlspecialchars(str_replace('_', ' ', $row['setting_key'])) ?></td>
                        <td><?= nl2br(htmlspecialchars($row['setting_value'])) ?></td>
                        <td><?= $row['updated_at'] ? date('d/m/Y H:i', strtotime($row['updated_at'])) : '-' ?></td>
                        <td>
                          <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-edit"></i> Edit
                          </a>
                        </td>
                      </tr>
                  <?php endwhile;
                  else: ?>
                    <tr>
                      <td colspan="5" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle me-1"></i> Belum ada pengaturan sistem.
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
            </div>
          </div>

        </div>
      </div>
    </div>

  </div>
</div>

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
