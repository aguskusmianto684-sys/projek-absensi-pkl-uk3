<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
  echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href='../user/login.php';
    </script>";
  exit();
}

$page = "rekap";
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// === Ambil data rekap absensi dari view v_rekap_absensi ===
$qRekap = "
  SELECT 
    v.participant_id,
    v.nama_peserta,
    v.total_absen,
    v.total_hadir,
    v.total_izin,
    v.total_sakit,
    v.total_alpa,
    p.school,
    p.program_study,
    p.start_date,
    p.end_date,
    p.supervisor_name
  FROM v_rekap_absensi v
  LEFT JOIN participants p ON v.participant_id = p.id
  ORDER BY v.nama_peserta ASC
";

$result = mysqli_query($connect, $qRekap) or die(mysqli_error($connect));
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
    <div class="d-flex align-items-left flex-column flex-md-row pt-2 pb-3">
      <div>
        <h3 class="fw-bold mb-3">Rekapitulasi Absensi Peserta PKL / Magang</h3>
        <h6 class="op-7 mb-2">Menampilkan total kehadiran setiap peserta berdasarkan data absensi harian</h6>
      </div>
    </div>

    <div class="row">
      <div class="col-md-12">
        <div class="card card-round shadow-sm">
          <div class="card-header"
            style="background: linear-gradient(135deg, #023e8a, #0077b6, #90e0ef); color: #fff;">
            <h5 class="mb-0">Tabel Rekap Absensi</h5>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table id="rekapTable" class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                  <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>Sekolah</th>
                    <th>Program Studi</th>
                    <th>Supervisor</th>
                    <th>Total Hadir</th>
                    <th>Total Izin</th>
                    <th>Total Sakit</th>
                    <th>Total Alpha</th>
                    <th>Total Absen</th>
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
                        <td><?= htmlspecialchars($row['nama_peserta'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['school'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['program_study'] ?? '-') ?></td>
                        <td><?= htmlspecialchars($row['supervisor_name'] ?? '-') ?></td>
                        <td><span class="badge bg-success"><?= $row['total_hadir'] ?? 0 ?></span></td>
                        <td><span class="badge bg-info text-dark"><?= $row['total_izin'] ?? 0 ?></span></td>
                        <td><span class="badge bg-warning text-dark"><?= $row['total_sakit'] ?? 0 ?></span></td>
                        <td><span class="badge bg-danger"><?= $row['total_alpa'] ?? 0 ?></span></td>
                        <td><strong><?= $row['total_absen'] ?? 0 ?></strong></td>
                      </tr>
                  <?php endwhile;
                  else: ?>
                    <tr>
                      <td colspan="10" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle me-1"></i> Belum ada data rekap absensi.
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
    $('#rekapTable').DataTable({
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
