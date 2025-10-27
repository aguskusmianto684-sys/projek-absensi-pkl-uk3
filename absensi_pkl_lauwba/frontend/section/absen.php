<?php
include '../config/connection.php';

// Cek login
if (!isset($_SESSION['id_user'])) {
    echo "
    <section class='py-5 text-center'>
      <div class='container'>
        <div class='row justify-content-center'>
          <div class='col-lg-8'>
            <div class='card border-0 shadow-lg'>
              <div class='card-body py-5'>
                <h6 class='text-primary mb-2'>AKSES DITOLAK</h6>
                <h2 class='fw-bold mb-3'>Silakan Login Terlebih Dahulu</h2>
                <p class='text-muted mb-4'>Anda perlu login untuk mengakses sistem absensi.</p>
                <a href='auth/login.php' class='btn btn-primary btn-lg'>Login Sekarang</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>";
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data peserta
$q = mysqli_query($connect, "SELECT id FROM participants WHERE user_id = '$id_user' LIMIT 1");
$participant = mysqli_fetch_assoc($q);

if (!$participant) {
    echo "<script>alert('Data peserta tidak ditemukan!'); window.location.href='index.php';</script>";
    exit;
}

$participant_id = $participant['id'];

// Ambil data user untuk info tambahan
$user_query = mysqli_query($connect, "
    SELECT u.full_name, u.email, p.school, p.program_study 
    FROM users u 
    LEFT JOIN participants p ON u.id = p.user_id 
    WHERE u.id = '$id_user'
");
$user_data = mysqli_fetch_assoc($user_query);

// Cek apakah sudah check-in tapi belum check-out hari ini
$check = mysqli_query($connect, "
    SELECT * FROM attendance 
    WHERE participant_id = '$participant_id' 
    AND DATE(check_in) = CURDATE()
    ORDER BY id DESC LIMIT 1
");
$today = mysqli_fetch_assoc($check);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- CHECK-IN ---
    if (isset($_POST['checkin'])) {
        $note = trim($_POST['note']);
        if (empty($note)) {
            echo "<script>alert('Note wajib diisi saat check-in!'); window.location.href='index.php';</script>";
            exit;
        }

        $check_in_location = "Kampus Lauwba";
        $status = "hadir";

        $insert = mysqli_query($connect, "
            INSERT INTO attendance (participant_id, check_in, check_in_location, status, note)
            VALUES ('$participant_id', NOW(), '$check_in_location', '$status', '$note')
        ");

        if ($insert) {
            echo "<script>alert('Berhasil check-in!'); window.location.href='index.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan absensi!'); window.location.href='index.php';</script>";
            exit;
        }
    }

    // --- CHECK-OUT ---
    if (isset($_POST['checkout'])) {
        $note = trim($_POST['note']);
        $current_id = $today['id'];

        // Kalau note kosong, ambil dari record sebelumnya (tidak diganti)
        if (empty($note)) {
            $update = mysqli_query($connect, "
                UPDATE attendance
                SET check_out = NOW(), check_out_location = 'Kampus Lauwba'
                WHERE id = '$current_id'
            ");
        } else {
            $update = mysqli_query($connect, "
                UPDATE attendance
                SET check_out = NOW(), check_out_location = 'Kampus Lauwba', note = CONCAT(note, ' | ', '$note')
                WHERE id = '$current_id'
            ");
        }

        if ($update) {
            echo "<script>alert('Berhasil check-out!'); window.location.href='index.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan check-out!'); window.location.href='index.php';</script>";
            exit;
        }
    }
}
?>

<!-- Tampilan Section Absen yang Diperbaiki -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Header Section -->
                <div class="text-center mb-5">
                    <h6 class="text-primary mb-2">SISTEM ABSENSI</h6>
                    <h2 class="fw-bold mb-3">Absensi Harian PKL</h2>
                    <p class="text-muted">Halo, <strong><?php echo htmlspecialchars($user_data['full_name']); ?></strong>! Silakan lakukan absensi harian Anda.</p>
                </div>

                <!-- Info User Card -->
                <div class="card border-0 bg-gradient-primary text-white shadow-lg mb-4">
                    <div class="card-body py-4">
                        <div class="row align-items-center">
                            <div class="col-md-8">
                                <div class="d-flex align-items-center">
                                    <div class="bg-white text-primary rounded-circle p-3 me-3">
                                        <i class="fas fa-user fa-lg"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-1"><?php echo htmlspecialchars($user_data['full_name']); ?></h5>
                                        <p class="mb-0 opacity-75">
                                            <?php echo htmlspecialchars($user_data['school']); ?> - <?php echo htmlspecialchars($user_data['program_study']); ?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="h4 mb-1" id="currentTime"><?php echo date('H:i:s'); ?></div>
                                <small class="opacity-75"><?php echo date('l, d F Y'); ?></small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Main Absensi Card -->
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-4">
                        <?php if (!$today || !$today['check_in']): ?>
                            <!-- Belum Check-in -->
                            <div class="text-center py-3">
                                <div class="status-indicator bg-warning text-dark p-4 rounded-3 mb-4">
                                    <i class="fas fa-clock fa-3x mb-3"></i>
                                    <h4 class="fw-bold">Belum Check-in</h4>
                                    <p class="mb-0 text-muted">Silakan isi note dan lakukan check-in untuk memulai aktivitas hari ini</p>
                                </div>
                                
                                <form method="POST" action="" class="col-lg-8 mx-auto">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-start w-100">
                                            <i class="fas fa-sticky-note me-2 text-primary"></i>Note Check-in
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="note" class="form-control form-control-lg" 
                                                  placeholder="Masukkan catatan aktivitas hari ini (wajib diisi)..." 
                                                  rows="4" required></textarea>
                                        <div class="form-text text-start">
                                            <i class="fas fa-info-circle me-1"></i>Contoh: "Siap mengerjakan project website, meeting dengan pembimbing"
                                        </div>
                                    </div>
                                    <button type="submit" name="checkin" class="btn btn-primary btn-lg w-100 py-3">
                                        <i class="fas fa-sign-in-alt me-2"></i>Check In Sekarang
                                    </button>
                                    <small class="text-muted mt-2 d-block">Pastikan note sudah diisi sebelum check-in</small>
                                </form>
                            </div>

                        <?php elseif ($today && !$today['check_out']): ?>
                            <!-- Sudah Check-in tapi belum Check-out -->
                            <div class="text-center py-3">
                                <div class="status-indicator bg-success text-white p-4 rounded-3 mb-4">
                                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                                    <h4 class="fw-bold">Sudah Check-in</h4>
                                    <p class="mb-2"><strong>Waktu Check-in:</strong> <?= date('H:i', strtotime($today['check_in'])) ?></p>
                                    <p class="mb-1"><strong>Note:</strong> <?= htmlspecialchars($today['note']) ?></p>
                                    <p class="mb-0">Silakan lakukan check-out saat pulang</p>
                                </div>
                                
                                <form method="POST" action="" class="col-lg-8 mx-auto">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-start w-100">
                                            <i class="fas fa-sticky-note me-2 text-success"></i>Note Check-out (Opsional)
                                        </label>
                                        <textarea name="note" class="form-control form-control-lg" 
                                                  placeholder="Masukkan catatan tambahan atau update progress..." 
                                                  rows="3"></textarea>
                                        <div class="form-text text-start">
                                            <i class="fas fa-info-circle me-1"></i>Contoh: "Project website selesai 80%, besok lanjut debugging"
                                        </div>
                                    </div>
                                    <button type="submit" name="checkout" class="btn btn-success btn-lg w-100 py-3">
                                        <i class="fas fa-sign-out-alt me-2"></i>Check Out Sekarang
                                    </button>
                                    <small class="text-muted mt-2 d-block">Note check-out akan digabung dengan note check-in</small>
                                </form>
                            </div>

                        <?php else: ?>
                            <!-- Sudah Check-in dan Check-out -->
                            <div class="text-center py-3">
                                <div class="status-indicator bg-info text-white p-4 rounded-3 mb-4">
                                    <i class="fas fa-flag-checkered fa-3x mb-3"></i>
                                    <h4 class="fw-bold">Absensi Selesai</h4>
                                    <p class="mb-1"><strong>Check-in:</strong> <?= date('H:i', strtotime($today['check_in'])) ?></p>
                                    <p class="mb-1"><strong>Check-out:</strong> <?= date('H:i', strtotime($today['check_out'])) ?></p>
                                    <p class="mb-0 mt-2"><strong>Note:</strong> <?= htmlspecialchars($today['note']) ?></p>
                                </div>
                                
                                <button type="button" class="btn btn-secondary btn-lg py-3 col-lg-6" disabled>
                                    <i class="fas fa-check-double me-2"></i>Absensi Hari Ini Selesai
                                </button>
                                <small class="text-muted mt-2 d-block">Terima kasih! Sampai jumpa besok</small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Info Tambahan -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-info-circle fa-2x text-primary mb-3"></i>
                                <h6>Check-in Rules</h6>
                                <small class="text-muted">
                                    • Note wajib diisi<br>
                                    • Isi rencana aktivitas hari ini<br>
                                    • Lakukan saat tiba di lokasi
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-info-circle fa-2x text-success mb-3"></i>
                                <h6>Check-out Rules</h6>
                                <small class="text-muted">
                                    • Note opsional<br>
                                    • Update progress pekerjaan<br>
                                    • Lakukan saat akan pulang
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.bg-gradient-primary {
    background: linear-gradient(135deg, #4361ee, #3a0ca3) !important;
}
.status-indicator {
    transition: all 0.3s ease;
    border: 2px solid transparent;
}
.status-indicator:hover {
    transform: translateY(-3px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.card {
    border-radius: 15px;
}
.rounded-3 {
    border-radius: 15px !important;
}
.form-control-lg {
    border-radius: 10px;
    border: 2px solid #e9ecef;
    transition: all 0.3s ease;
}
.form-control-lg:focus {
    border-color: #4361ee;
    box-shadow: 0 0 0 0.2rem rgba(67, 97, 238, 0.25);
}
</style>

<script>
// Update real-time clock
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID');
    document.getElementById('currentTime').textContent = timeString;
}

setInterval(updateClock, 1000);
updateClock();
</script>