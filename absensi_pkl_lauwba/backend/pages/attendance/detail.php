<?php
// session_start();
// if (!isset($_SESSION['logged_in'])) {
//   echo "<script>
//     alert('Silakan login terlebih dahulu!');
//     window.location.href='../user/login.php';
//   </script>";
//   exit();
// }

include '../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Ambil ID dari URL
$id = $_GET['id'] ?? null;
if (!$id) {
    echo "<script>alert('ID absensi tidak ditemukan!');window.location.href='index.php';</script>";
    exit();
}

// Ambil data absensi berdasarkan ID
$q = "
  SELECT 
    a.*, 
    u.full_name AS nama_peserta,
    v.full_name AS diverifikasi_oleh
  FROM attendance a
  LEFT JOIN participants p ON a.participant_id = p.id
  LEFT JOIN users u ON p.user_id = u.id
  LEFT JOIN users v ON a.verified_by = v.id
  WHERE a.id = '$id'
";
$result = mysqli_query($connect, $q) or die(mysqli_error($connect));
$attendance = mysqli_fetch_object($result);

if (!$attendance) {
    echo "<script>alert('Data tidak ditemukan!');window.location.href='index.php';</script>";
    exit();
}
?>

<style>
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .detail-item {
        margin-bottom: 14px;
    }

    .detail-label {
        font-weight: 600;
        color: #333;
        margin-bottom: 4px;
    }

    .detail-value {
        background: #f8f9fa;
        padding: 8px 12px;
        border-radius: 6px;
        color: #000;
    }

    .badge-status {
        padding: 5px 10px;
        border-radius: 6px;
        font-weight: 600;
    }
</style>

<div class="container">
    <div class="page-inner">
        <div class="d-flex align-items-center flex-column flex-md-row pt-2 pb-3">
            <div>
                <h3 class="fw-bold mb-2 text-dark">Detail Data Absensi</h3>
                <p class="text-muted mb-0">Informasi lengkap mengenai kehadiran peserta.</p>
            </div>
            <div class="ms-auto">
                <a href="./index.php" class="btn btn-primary btn-sm">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card card-round shadow-sm">
                    <div class="card-header" style="background: linear-gradient(135deg, #023e8a, #0077b6, #90e0ef);">
                        <h5 class="mb-0 text-white">Informasi Absensi Peserta</h5>
                    </div>
                    <div class="card-body">

                        <div class="detail-item">
                            <div class="detail-label">Nama Peserta</div>
                            <div class="detail-value"><?= htmlspecialchars($attendance->nama_peserta ?? '-') ?></div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Check In</div>
                            <div class="detail-value"><?= $attendance->check_in ? date('d/m/Y H:i', strtotime($attendance->check_in)) : '-' ?></div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Check Out</div>
                            <div class="detail-value"><?= $attendance->check_out ? date('d/m/Y H:i', strtotime($attendance->check_out)) : '-' ?></div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Status Kehadiran</div>
                            <div class="detail-value">
                                <span class="badge-status bg-<?=
                                                                $attendance->status == 'hadir' ? 'success' : ($attendance->status == 'izin' ? 'info' : ($attendance->status == 'sakit' ? 'warning' : 'danger')) ?>">
                                    <?= ucfirst($attendance->status) ?>
                                </span>
                            </div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Keterangan</div>
                            <div class="detail-value"><?= htmlspecialchars($attendance->note ?? '-') ?></div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Diverifikasi Oleh</div>
                            <div class="detail-value"><?= htmlspecialchars($attendance->diverifikasi_oleh ?? 'Belum diverifikasi') ?></div>
                        </div>

                        <div class="detail-item">
                            <div class="detail-label">Tanggal Verifikasi</div>
                            <div class="detail-value"><?= $attendance->verified_at ? date('d/m/Y H:i', strtotime($attendance->verified_at)) : '-' ?></div>
                        </div>

                        <div class="text-end mt-4">
                            <a href="./index.php" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Kembali
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
</body>

</html>