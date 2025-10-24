<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
  echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href='../user/login.php';
    </script>";
  exit();
}

$page = "logs";
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// === Ambil data log aktivitas dari database ===
$qLogs = "
  SELECT 
    l.id,
    u.full_name AS nama_user,
    u.username,
    l.action,
    l.description,
    l.created_at
  FROM logs AS l
  LEFT JOIN users AS u ON l.user_id = u.id
  ORDER BY l.created_at DESC
";

$result = mysqli_query($connect, $qLogs);
if (!$result) {
  die("<div style='padding:20px; background:#ffe3e3; color:#d00000;'>
      <b>Query Error:</b> " . mysqli_error($connect) . "</div>");
}
?>

<!-- === STYLE TAMBAHAN === -->
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
</style>

<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-3">
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card card-round shadow-sm">
          <div class="card-header"
            style="background: linear-gradient(135deg, #023e8a, #0077b6, #90e0ef); color: #fff;">
            <h5 class="mb-0">Tabel Log Aktivitas</h5>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table id="logsTable" class="table table-bordered table-hover align-middle text-center">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Pengguna</th>
                    <th>Username</th>
                    <th>Aksi</th>
                    <th>Deskripsi</th>
                    <th>Waktu</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                      <td><?= $no++ ?></td>
                      <td><?= htmlspecialchars($row['nama_user'] ?? '-') ?></td>
                      <td><?= htmlspecialchars($row['username'] ?? '-') ?></td>
                      <td><span class="badge bg-primary"><?= htmlspecialchars($row['action'] ?? '-') ?></span></td>
                      <td><?= htmlspecialchars($row['description'] ?? '-') ?></td>
                      <td><?= date('d/m/Y H:i:s', strtotime($row['created_at'])) ?></td>
                    </tr>
                  <?php endwhile; ?>
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

<!-- === DATATABLES === -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
  $('#logsTable').DataTable({
    responsive: true,
    pageLength: 10,
    lengthMenu: [5, 10, 25, 50, 100],
    ordering: true,
    searching: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json"
    }
  });
});
</script>
