<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
  echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href='../users/login.php';
    </script>";
  exit();
}

$page = "attendance";
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// =========================
//  QUERY SESUAI ROLE
// =========================

// ADMIN → lihat semua data
if ($role === 'admin') {
  $qAttendance = "
    SELECT 
      a.id,
      u.full_name AS nama_peserta,
      a.check_in,
      a.check_out,
      a.status,
      a.note,
      a.verified_by,
      v.full_name AS diverifikasi_oleh,
      a.verified_at
    FROM attendance a
    LEFT JOIN participants p ON a.participant_id = p.id
    LEFT JOIN users u ON p.user_id = u.id
    LEFT JOIN users v ON a.verified_by = v.id
    ORDER BY a.created_at DESC
  ";

// PEMBIMBING → lihat hanya peserta bimbingannya
} elseif ($role === 'pembimbing') {
  $qAttendance = "
    SELECT 
      a.id,
      u.full_name AS nama_peserta,
      a.check_in,
      a.check_out,
      a.status,
      a.note,
      a.verified_by,
      v.full_name AS diverifikasi_oleh,
      a.verified_at
    FROM attendance a
    LEFT JOIN participants p ON a.participant_id = p.id
    LEFT JOIN users u ON p.user_id = u.id
    LEFT JOIN users v ON a.verified_by = v.id
    WHERE p.supervisor_id = '$user_id'
    ORDER BY a.created_at DESC
  ";

// PESERTA → lihat hanya absensinya sendiri
} elseif ($role === 'peserta') {
  $qAttendance = "
    SELECT 
      a.id,
      u.full_name AS nama_peserta,
      a.check_in,
      a.check_out,
      a.status,
      a.note,
      a.verified_by,
      v.full_name AS diverifikasi_oleh,
      a.verified_at
    FROM attendance a
    LEFT JOIN participants p ON a.participant_id = p.id
    LEFT JOIN users u ON p.user_id = u.id
    LEFT JOIN users v ON a.verified_by = v.id
    WHERE p.id = (SELECT id FROM participants WHERE user_id = '$user_id' LIMIT 1)
    ORDER BY a.created_at DESC
  ";
}

$result = mysqli_query($connect, $qAttendance) or die(mysqli_error($connect));
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
.table tbody td { border: 1px solid #999 !important; }
.card { border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.2); }
.toggle-switch { position: relative; display: inline-block; width: 36px; height: 18px; }
.toggle-switch input { opacity: 0; width: 0; height: 0; }
.slider { position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0; background-color: #ccc; transition: .3s; border-radius: 20px; }
.slider:before { content: ""; position: absolute; height: 12px; width: 12px; left: 3px; bottom: 3px; background: white; transition: .3s; border-radius: 50%; }
input:checked + .slider { background-color: #28a745; }
input:checked + .slider:before { transform: translateX(18px); }
.small-text { font-size: 11px; color: #555; margin-top: 3px; }
.btn-sm { padding: 3px 7px; font-size: 12px; }
</style>

<div class="container">
  <div class="page-inner">
    <div class="row">
      <div class="col-md-12">
        <div class="card card-round shadow-sm">
          <div class="card-header d-flex align-items-center justify-content-between"
            style="background: linear-gradient(135deg, #023e8a, #0077b6, #90e0ef);">
            <h5 class="mb-0 text-white">Tabel Absensi Peserta</h5>
            <div>
              <?php if ($role === 'peserta'): ?>
                <a href="./scan_verify.php" class="btn btn-success me-2">
                  <i class="fas fa-qrcode me-1"></i> Scan QR
                </a>
              <?php endif; ?>

              <?php if (in_array($role, ['admin', 'pembimbing'])): ?>
                <a href="create.php" class="btn btn-primary">Tambah Absensi</a>
              <?php endif; ?>
            </div>
          </div>

          <div class="card-body">
            <div class="table-responsive">
              <table id="attendanceTable" class="table table-bordered table-hover align-middle text-center">
                <thead class="table-light">
                  <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>Check In</th>
                    <th>Check Out</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                    <th>Verifikasi</th>
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
                        <td><?= htmlspecialchars($row['nama_peserta']) ?></td>
                        <td><?= $row['check_in'] ? date('d/m/Y H:i', strtotime($row['check_in'])) : '-' ?></td>
                        <td><?= $row['check_out'] ? date('d/m/Y H:i', strtotime($row['check_out'])) : '-' ?></td>
                        <td>
                          <span class="badge bg-<?=
                            $row['status'] == 'hadir' ? 'success' :
                            ($row['status'] == 'izin' ? 'info' :
                            ($row['status'] == 'sakit' ? 'warning' : 'secondary')) ?>">
                            <?= ucfirst($row['status']) ?>
                          </span>
                        </td>
                        <td><?= htmlspecialchars($row['note']) ?></td>
                        <td>
                          <?php if (in_array($role, ['admin', 'pembimbing'])): ?>
                            <label class="toggle-switch">
                              <input type="checkbox" class="verify-toggle" data-id="<?= $row['id'] ?>" <?= $row['verified_by'] ? 'checked' : '' ?>>
                              <span class="slider"></span>
                            </label>
                            <div class="small-text">
                              <?= $row['verified_by'] ? htmlspecialchars($row['diverifikasi_oleh']) : 'Belum diverifikasi' ?>
                            </div>
                          <?php else: ?>
                            <div class="small-text text-muted">Hanya pembimbing yang bisa verifikasi</div>
                          <?php endif; ?>
                        </td>
                        <td>
                          <a href="./detail.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Detail</a>
                          <?php if ($role === 'admin' || ($role === 'pembimbing' && $row['verified_by'] == $user_id)): ?>
                            <a href="./edit.php?id=<?= $row['id'] ?>" class="btn btn-warning btn-sm text-white">Edit</a>
                            <a href="../../actions/attendance/destroy.php?id=<?= $row['id'] ?>"
                              class="btn btn-danger btn-sm"
                              onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                          <?php endif; ?>
                        </td>
                      </tr>
                    <?php endwhile;
                  else: ?>
                    <tr>
                      <td colspan="8" class="text-center text-muted py-4">
                        <i class="fas fa-info-circle me-1"></i> Belum ada data absensi.
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

<script>
$(document).ready(function () {
  $('#attendanceTable').DataTable({
    paging: true,
    searching: true,
    info: true,
    ordering: true,
    pageLength: 10,
    lengthChange: false,
    language: { url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json" }
  });

  document.querySelectorAll('.verify-toggle').forEach(toggle => {
    toggle.addEventListener('change', async function() {
      const id = this.dataset.id;
      const verified = this.checked ? 1 : 0;
      const formData = new FormData();
      formData.append('id', id);
      formData.append('verified', verified);
      const res = await fetch('../../actions/attendance/toggle_verify.php', {
        method: 'POST',
        body: formData
      });
      console.log(await res.text());
    });
  });
});
</script>

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
