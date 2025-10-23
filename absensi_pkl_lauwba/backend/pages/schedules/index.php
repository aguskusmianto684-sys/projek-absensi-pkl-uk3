<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
  echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href='../user/login.php';
    </script>";
  exit();
}

$page = "schedules";
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// === Ambil data jadwal dari database ===
$qSchedules = "
  SELECT 
    id,
    date,
    expected_in,
    expected_out,
    description,
    created_at
  FROM schedules
  ORDER BY date DESC
";
$result = mysqli_query($connect, $qSchedules) or die(mysqli_error($connect));
?>

<style>
.table,
.table-bordered,
.table-bordered th,
.table-bordered td {
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
table {
  border-collapse: collapse !important;
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

<!-- === Konten Utama === -->
<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-3"></div>

    <!-- ======== DAFTAR JADWAL ======== -->
    <div class="row">
      <div class="col-md-12">
        <div class="card card-round shadow-sm">
          <div class="card-header d-flex align-items-center justify-content-between"
            style="background: linear-gradient(135deg, #023e8a, #0077b6, #90e0ef);">
            <h5 class="mb-0 text-white">Daftar Jadwal Absensi</h5>
            <a href="create.php" class="btn btn-primary">Tambah Jadwal</a>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table id="schedulesTable" class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                  <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jam Masuk</th>
                    <th>Jam Keluar</th>
                    <th>Keterangan</th>
                    <th>Tanggal Dibuat</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  if ($result && mysqli_num_rows($result) > 0):
                    while ($row = mysqli_fetch_assoc($result)):
                  ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime($row['date']))) ?></td>
                        <td><?= htmlspecialchars($row['expected_in']) ?></td>
                        <td><?= htmlspecialchars($row['expected_out']) ?></td>
                        <td><?= htmlspecialchars($row['description'] ?? '-') ?></td>
                        <td><?= htmlspecialchars(date('d/m/Y', strtotime($row['created_at']))) ?></td>
                        <td>
                          <a href="./edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-white">Edit</a>
                          <a href="../../actions/schedules/destroy.php?id=<?= $row['id'] ?>"
                             class="btn btn-danger btn-sm"
                             onclick="return confirm('Yakin ingin menghapus jadwal ini?')">
                            Hapus
                          </a>
                        </td>
                      </tr>
                  <?php endwhile;
                  else: ?>
                    <tr>
                      <td colspan="7" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle me-1"></i> Belum ada jadwal absensi.
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
