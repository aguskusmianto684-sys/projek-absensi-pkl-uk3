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

// Ambil data pembimbing dari database
$qSupervisors = "
  SELECT 
    s.id,
    u.full_name AS nama_pembimbing,
    u.email,
    s.department,
    s.phone,
    s.note,
    s.created_at
  FROM supervisors s
  LEFT JOIN users u ON s.user_id = u.id
  ORDER BY s.id DESC
";
$result = mysqli_query($connect, $qSupervisors) or die(mysqli_error($connect));
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

    <div class="row">
      <div class="col-md-12">
        <div class="card card-round shadow-sm">
          <div class="card-header d-flex align-items-center justify-content-between"
            style="background: linear-gradient(135deg, #023e8a, #0077b6, #90e0ef);">
            <h5 class="mb-0 text-white">Tabel Pembimbing Lapangan</h5>
            <a href="create.php" class="btn btn-primary">Tambah Pembimbing</a>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table id="supervisorsTable" class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                  <tr>
                    <th>No</th>
                    <th>Nama Pembimbing</th>
                    <th>Email</th>
                    <th>Departemen</th>
                    <th>Telepon</th>
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
                        <td class="text-capitalize"><?= htmlspecialchars($row['nama_pembimbing'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['email'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['department'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['phone'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['note'] ?? '-') ?></td>
                        <td><?= $row['created_at'] ? date('d/m/Y', strtotime($row['created_at'])) : '-' ?></td>
                        <td>
                          <a href="./detail.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Detail</a>
                          <a href="./edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-white">Edit</a>
                          <a href="../../actions/supervisors/destroy.php?id=<?= $row['id'] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus data pembimbing ini?')">Hapus</a>
                        </td>
                      </tr>
                  <?php endwhile;
                  else: ?>
                    <tr>
                      <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle me-1"></i> Belum ada data pembimbing.
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
