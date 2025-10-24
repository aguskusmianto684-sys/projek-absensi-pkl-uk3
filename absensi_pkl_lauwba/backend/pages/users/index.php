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
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Ambil semua user dari database
$query = "SELECT * FROM users ORDER BY id DESC";
$result = mysqli_query($connect, $query);
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

<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-3">
      <div>
        <h3 class="fw-bold mb-3">Data Pengguna (Users)</h3>
        <h6 class="op-7 mb-2">Daftar seluruh akun yang terdaftar dalam sistem</h6>
      </div>
      <div class="ms-auto">
        <a href="create.php" class="btn btn-primary">
          <i class="fas fa-plus me-1"></i> Tambah User
        </a>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card card-round shadow-sm">
          <div class="card-header"
            style="background: linear-gradient(135deg, #023e8a, #0077b6, #90e0ef); color: #fff;">
            <h5 class="mb-0">Tabel Data Pengguna</h5>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table id="usersTable" class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                  <tr>
                    <th width="5%">No</th>
                    <th>Nama Lengkap</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Tanggal Dibuat</th>
                    <th width="20%">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  if ($result && mysqli_num_rows($result) > 0):
                    while ($row = mysqli_fetch_assoc($result)): ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <td><?= htmlspecialchars($row['full_name'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['username'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['email'] ?? '-') ?></td>
                        <td><span class="badge bg-info text-dark"><?= htmlspecialchars($row['role'] ?? '-') ?></span></td>
                        <td>
                          <?php if ($row['status'] == 'aktif'): ?>
                            <span class="badge bg-success">Aktif</span>
                          <?php else: ?>
                            <span class="badge bg-danger">Nonaktif</span>
                          <?php endif; ?>
                        </td>
                        <td><?= $row['created_at'] ? date('d/m/Y', strtotime($row['created_at'])) : '-' ?></td>
                        <td>
                          <a href="./detail.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">
                            <i class="fas fa-eye"></i>
                          </a>
                          <a href="./edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-white">
                            <i class="fas fa-edit"></i>
                          </a>
                          <a href="../../actions/users/destroy.php?id=<?= $row['id'] ?>"
                            class="btn btn-danger btn-sm"
                            onclick="return confirm('Yakin ingin menghapus user ini?')">
                            <i class="fas fa-trash"></i>
                          </a>
                        </td>
                      </tr>
                  <?php endwhile;
                  else: ?>
                    <tr>
                      <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle me-1"></i> Belum ada data pengguna.
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

<!-- DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function() {
    $('#usersTable').DataTable({
      pageLength: 10,
      language: {
        search: "🔍 Cari:",
        zeroRecords: "❌ Tidak ditemukan",
        info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
        infoEmpty: "Tidak ada data tersedia",
        lengthMenu: "Tampilkan _MENU_ data"
      }
    });
  });
</script>
