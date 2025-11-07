<?php
session_start();
if (!isset($_SESSION['logged_in']) || !in_array($_SESSION['role'], ['admin', 'pembimbing'])) {
    echo "<script>
            alert('Akses ditolak!');
            window.location.href='../users/login.php';
        </script>";
    exit;
}

$page = "attendance";
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

// Ambil QR aktif terbaru
$q = mysqli_query($connect, "
    SELECT * FROM qr_sessions 
    WHERE expired_at > NOW()
    ORDER BY id DESC LIMIT 1
");
$qr = mysqli_fetch_assoc($q);
?>

<style>
.qr-box {
    border: 8px solid #0096c7;
    border-radius: 14px;
    display: inline-block;
    padding: 6px;
    background: #fff;
}
</style>

<div class="container">
    <div class="page-inner">

        <div class="card card-round shadow-lg">
            <div class="card-header d-flex justify-content-between align-items-center"
                style="background: linear-gradient(135deg, #023e8a, #0096c7, #48cae4);">
                <h5 class="text-white mb-0"><i class="fas fa-qrcode me-2"></i>Generate QR Kehadiran</h5>

                <button class="btn btn-light btn-sm" onclick="location.reload()">
                    <i class="fas fa-sync"></i>
                </button>
            </div>

            <div class="card-body text-center">

                <?php if ($qr): ?>
                    
                    <p class="text-muted">
                        Berlaku sampai: <b><?= date('d/m/Y H:i', strtotime($qr['expired_at'])) ?></b><br>
                        Waktu akses: <b><?= $qr['valid_from'] ?> - <?= $qr['valid_until'] ?></b>
                    </p>

                    <div class="qr-box">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=240x240&data=<?= $qr['token'] ?>"
                            class="img-fluid">
                    </div>

                    <p class="mt-2"><span class="badge bg-success">QR Aktif</span></p>
                    

                <?php else: ?>

                    <p class="text-muted mb-2">Tidak ada QR aktif saat ini.</p>

                <?php endif; ?>

                <a href="../../actions/attendance/generate_qr.php" class="btn btn-primary mt-3">
                    <i class="fas fa-plus me-1"></i> Buat QR Baru
                </a>

                <a href="./index.php" class="btn btn-secondary mt-3">
                    <i class="fas fa-arrow-left me-1"></i> Kembali
                </a>
            </div>
        </div>

    </div>
</div>

<?php include '../../partials/footer.php'; ?>
<?php include '../../partials/script.php'; ?>
