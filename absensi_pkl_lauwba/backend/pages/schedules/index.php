<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
  echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href='../user/login.php';
    </script>";
  exit();
}

$page = "participants";
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Ambil data peserta dari database
$qParticipants = "
SELECT 
    p.*, 
    u.full_name AS nama_peserta, 
    s.full_name AS nama_pembimbing
FROM participants p
LEFT JOIN users u ON p.user_id = u.id
LEFT JOIN users s ON p.supervisor_id = s.id
ORDER BY p.id DESC
";
$result = mysqli_query($connect, $qParticipants) or die(mysqli_error($connect));
?>
<style>
  /* Garis tabel lebih tipis dan halus */
  .table,
  .table-bordered,
  .table-bordered th,
  .table-bordered td {
    border: 1px solid #999 !important;
    /* abu-abu lebih soft */
    color: #000;
  }

  .table thead th {
    background-color: #f8f9fa;
    /* abu-abu muda bawaan bootstrap */
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
    /* bayangan lebih tegas */
  }
</style>

<!-- Mulai Konten -->
<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
    </div>

    <!-- TABEL PESERTA -->
    <div class="row">
      <div class="col-md-12">
        <div class="card card-round shadow-sm">
          <div class="card-header d-flex align-items-center justify-content-between" style="background: linear-gradient(135deg, #023e8a, #0077b6, #90e0ef);">
            <h5 class="mb-0 text-white">Tabel Peserta PKL</h5>
            <a href="create.php" class="btn btn-primary">Tambah</a>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table id="participantsTable" class="table table-bordered table-hover align-middle">
                <thead class="table-light text-center">
                  <tr>
                    <th>No</th>
                    <th>Nama Peserta</th>
                    <th>Sekolah</th>
                    <th>Program Studi</th>
                    <th>Pembimbing</th>
                    <th>Mulai</th>
                    <th>Selesai</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
               <tbody>
  <?php
  $no = 1;
  if ($result && mysqli_num_rows($result) > 0):
      while ($item = mysqli_fetch_object($result)):
  ?>
  <tr class="text-center">
    <td><?= $no ?></td>
    <td class="text-capitalize"><?= htmlspecialchars($item->nama_peserta ?? '') ?></td>
    <td><?= htmlspecialchars($item->school ?? '') ?></td>
    <td><?= htmlspecialchars($item->program_study ?? '') ?></td>
    <td><?= htmlspecialchars($item->nama_pembimbing ?? '-') ?></td>
    <td><?= htmlspecialchars($item->start_date ?? '-') ?></td>
    <td><?= htmlspecialchars($item->end_date ?? '-') ?></td>
    <td>
      <a href="./detail.php?id=<?= $item->id ?>" class="btn btn-success btn-sm">Detail</a>
      <a href="./edit.php?id=<?= $item->id ?>" class="btn btn-warning btn-sm text-white">Edit</a>
      <a href="../../actions/participants/destroy.php?id=<?= $item->id ?>"
         class="btn btn-danger btn-sm"
         onclick="return confirm('Apakah anda yakin ingin menghapus peserta ini?')">
         Hapus
      </a>
    </td>
  </tr>
  <?php
      $no++;
      endwhile;
  else:
  ?>
  <tr>
    <td colspan="8" class="text-center text-muted py-4">
      <i class="fas fa-info-circle me-1"></i> Belum ada data peserta.
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

  </div> <!-- end page-inner -->
</div> <!-- end container -->

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>