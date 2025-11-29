<?php
if (session_status() === PHP_SESSION_NONE) session_start();
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

// Cek apakah sudah ada absensi hari ini
$check = mysqli_query($connect, "
    SELECT a.*, u.full_name as verified_by_name 
    FROM attendance a 
    LEFT JOIN users u ON a.verified_by = u.id
    WHERE a.participant_id = '$participant_id' 
    AND (
        (a.status = 'hadir' AND DATE(a.check_in) = CURDATE()) OR
        (a.status IN ('izin', 'sakit') AND DATE(a.created_at) = CURDATE())
    )
    ORDER BY a.id DESC LIMIT 1
");
$today = mysqli_fetch_assoc($check);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- CHECK-IN ---
    if (isset($_POST['checkin'])) {
        $note = trim($_POST['note']);
        $check_in_location = "Kampus Lauwba";
        $status = "hadir";

        $insert = mysqli_query($connect, "
            INSERT INTO attendance (participant_id, check_in, check_in_location, status, note, verified_by, verified_at)
            VALUES ('$participant_id', NOW(), '$check_in_location', '$status', '$note', NULL, NULL)
        ");

        if ($insert) {
            echo "<script>alert('Berhasil check-in! Menunggu verifikasi admin/pembimbing untuk dapat check-out.'); window.location.href='index.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan absensi!'); window.location.href='index.php';</script>";
            exit;
        }
    }

    // --- CHECK-OUT ---
    if (isset($_POST['checkout'])) {
        $note = trim($_POST['note']);
        if (empty($note)) {
            echo "<script>alert('Note wajib diisi saat check-out!'); window.location.href='index.php';</script>";
            exit;
        }

        $current_id = $today['id'];

        $update = mysqli_query($connect, "
            UPDATE attendance
            SET check_out = NOW(), check_out_location = 'Kampus Lauwba', note = CONCAT(note, ' | Check-out: ', '$note')
            WHERE id = '$current_id'
        ");

        if ($update) {
            echo "<script>alert('Berhasil check-out!'); window.location.href='index.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan check-out!'); window.location.href='index.php';</script>";
            exit;
        }
    }

    // --- IZIN/SAKIT ---
    if (isset($_POST['submit_izin'])) {
        $status = trim($_POST['status']);
        $keterangan = trim($_POST['keterangan']);
        $tanggal_mulai = trim($_POST['tanggal_mulai']);
        $tanggal_selesai = trim($_POST['tanggal_selesai']);
        
        if (empty($keterangan)) {
            echo "<script>alert('Keterangan wajib diisi!'); window.location.href='index.php';</script>";
            exit;
        }

        // Format note dengan informasi waktu
        $note_with_time = $keterangan;
        if (!empty($tanggal_mulai) && !empty($tanggal_selesai)) {
            $note_with_time .= " (Periode: " . date('d/m/Y', strtotime($tanggal_mulai)) . " - " . date('d/m/Y', strtotime($tanggal_selesai)) . ")";
        } else {
            $note_with_time .= " (Hari ini: " . date('d/m/Y') . ")";
        }

        // Untuk izin/sakit, check_in dan check_out NULL
        $insert = mysqli_query($connect, "
            INSERT INTO attendance (participant_id, check_in, check_out, check_in_location, status, note)
            VALUES ('$participant_id', NULL, NULL, NULL, '$status', '$note_with_time')
        ");

        if ($insert) {
            echo "<script>alert('Berhasil mengajukan $status! Menunggu verifikasi admin/pembimbing.'); window.location.href='index.php';</script>";
            exit;
        } else {
            echo "<script>alert('Gagal menyimpan pengajuan!'); window.location.href='index.php';</script>";
            exit;
        }
    }
}
?>

<!-- Tampilan Section Absen yang Diperbaiki -->
<section class="py-5" id="absen">
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
                                        <p class="mb-0 opacity-75 text-white">
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
                        <?php if (!$today): ?>
                            <!-- PILIHAN AWAL: Check-in atau Izin/Sakit -->
                            <div class="text-center py-3">
                                <div class="status-indicator bg-light border p-4 rounded-3 mb-4">
                                    <i class="fas fa-calendar-day fa-3x mb-3 text-primary"></i>
                                    <h4 class="fw-bold text-dark">Apa kegiatan Anda hari ini?</h4>
                                    <p class="mb-0 text-muted">Pilih salah satu opsi di bawah ini</p>
                                </div>
                                
                                <div class="row g-4">
                                    <!-- Opsi 1: Check-in Biasa -->
                                    <div class="col-md-6">
                                        <div class="choice-card card border-0 h-100 shadow-sm" onclick="showCheckinForm()" style="cursor: pointer;">
                                            <div class="card-body text-center p-4">
                                                <div class="icon-circle bg-primary text-white rounded-circle p-3 mx-auto mb-3">
                                                    <i class="fas fa-sign-in-alt fa-2x"></i>
                                                </div>
                                                <h5 class="fw-bold text-primary">Hadir & Bekerja</h5>
                                                <p class="text-muted small">Saya akan hadir dan bekerja di lokasi PKL hari ini</p>
                                                <div class="mt-3">
                                                    <span class="badge bg-light text-primary">Check-in → Check-out</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <!-- Opsi 2: Izin/Sakit -->
                                    <div class="col-md-6">
                                        <div class="choice-card card border-0 h-100 shadow-sm" onclick="showIzinForm()" style="cursor: pointer;">
                                            <div class="card-body text-center p-4">
                                                <div class="icon-circle bg-warning text-white rounded-circle p-3 mx-auto mb-3">
                                                    <i class="fas fa-user-clock fa-2x"></i>
                                                </div>
                                                <h5 class="fw-bold text-warning">Izin / Sakit</h5>
                                                <p class="text-muted small">Saya tidak bisa hadir karena izin atau sakit</p>
                                                <div class="mt-3">
                                                    <span class="badge bg-light text-warning">Ajukan Ketidakhadiran</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Form Check-in (Awalnya Disembunyikan) -->
                                <div id="checkinForm" class="mt-4" style="display: none;">
                                    <form method="POST" action="">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-start w-100">
                                                <i class="fas fa-sticky-note me-2 text-primary"></i>Note Check-in (Opsional)
                                            </label>
                                            <textarea name="note" class="form-control form-control-lg" 
                                                      placeholder="Masukkan catatan aktivitas hari ini (opsional)..." 
                                                      rows="3"></textarea>
                                            <div class="form-text text-start">
                                                <i class="fas fa-info-circle me-1"></i>Contoh: "Siap mengerjakan project website, meeting dengan pembimbing"
                                            </div>
                                        </div>
                                        <div class="d-flex gap-2">
                                            <button type="button" onclick="hideForms()" class="btn btn-secondary btn-lg py-3 flex-fill">
                                                <i class="fas fa-arrow-left me-2"></i>Kembali
                                            </button>
                                            <button type="submit" name="checkin" class="btn btn-primary btn-lg py-3 flex-fill">
                                                <i class="fas fa-sign-in-alt me-2"></i>Check In Sekarang
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                
                                <!-- Form Izin/Sakit (Awalnya Disembunyikan) -->
                                <div id="izinForm" class="mt-4" style="display: none;">
                                    <form method="POST" action="" id="izinFormElement">
                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-start w-100">
                                                <i class="fas fa-clipboard-list me-2 text-warning"></i>Status Ketidakhadiran
                                            </label>
                                            <select name="status" class="form-select form-control-lg" required onchange="updateContohKeterangan()">
                                                <option value="">Pilih status...</option>
                                                <option value="izin">Izin</option>
                                                <option value="sakit">Sakit</option>
                                            </select>
                                        </div>

                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-start w-100">
                                                <i class="fas fa-calendar-alt me-2 text-warning"></i>Periode Ketidakhadiran
                                            </label>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold">Tanggal Mulai</label>
                                                    <input type="date" name="tanggal_mulai" class="form-control" 
                                                           min="<?= date('Y-m-d') ?>" 
                                                           value="<?= date('Y-m-d') ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label small fw-bold">Tanggal Selesai</label>
                                                    <input type="date" name="tanggal_selesai" class="form-control" 
                                                           min="<?= date('Y-m-d') ?>" 
                                                           value="<?= date('Y-m-d') ?>">
                                                </div>
                                                <div class="col-12">
                                                    <small class="text-muted" id="infoRange">Kosongkan jika hanya hari ini</small>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label class="form-label fw-bold text-start w-100">
                                                <i class="fas fa-sticky-note me-2 text-warning"></i>Keterangan
                                                <span class="text-danger">*</span>
                                            </label>
                                            <textarea name="keterangan" class="form-control form-control-lg" 
                                                      placeholder="Berikan alasan lengkap ketidakhadiran Anda..." 
                                                      rows="4" required></textarea>
                                            <div class="form-text text-start">
                                                <i class="fas fa-info-circle me-1"></i>
                                                <span id="contohIzin" style="display: none;">Contoh: "Izin tidak masuk karena ada keperluan keluarga yang mendesak"</span>
                                                <span id="contohSakit" style="display: none;">Contoh: "Sakit demam dan batuk, disarankan dokter untuk istirahat"</span>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex gap-2">
                                            <button type="button" onclick="hideForms()" class="btn btn-secondary btn-lg py-3 flex-fill">
                                                <i class="fas fa-arrow-left me-2"></i>Kembali
                                            </button>
                                            <button type="submit" name="submit_izin" class="btn btn-warning btn-lg py-3 flex-fill">
                                                <i class="fas fa-paper-plane me-2"></i>Ajukan
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        <?php elseif ($today && !$today['verified_by']): ?>
                            <!-- Menunggu Verifikasi (untuk semua status: hadir/izin/sakit) -->
                            <div class="text-center py-3">
                                <div class="status-indicator bg-warning text-dark p-4 rounded-3 mb-4">
                                    <i class="fas fa-clock fa-3x mb-3"></i>
                                    <h4 class="fw-bold">Menunggu Verifikasi</h4>
                                    <p class="mb-2"><strong>Status:</strong> 
                                        <span class="badge bg-<?= $today['status'] == 'hadir' ? 'success' : ($today['status'] == 'izin' ? 'info' : 'warning') ?>">
                                            <?= ucfirst($today['status']) ?>
                                        </span>
                                    </p>
                                    
                                    <?php if ($today['status'] == 'hadir'): ?>
                                        <p class="mb-2"><strong>Waktu Check-in:</strong> <?= date('H:i', strtotime($today['check_in'])) ?></p>
                                    <?php else: ?>
                                        <p class="mb-2"><strong>Waktu Pengajuan:</strong> <?= date('H:i', strtotime($today['created_at'])) ?></p>
                                    <?php endif; ?>
                                    
                                    <p class="mb-1"><strong>Keterangan:</strong> <?= htmlspecialchars($today['note'] ?: '-') ?></p>
                                    <p class="mb-0 text-danger">Silakan tunggu verifikasi dari admin/pembimbing</p>
                                </div>
                                
                                <button type="button" class="btn btn-secondary btn-lg py-3 col-lg-8" disabled>
                                    <i class="fas fa-hourglass-half me-2"></i>Menunggu Verifikasi
                                </button>
                            </div>

                        <?php elseif ($today && $today['verified_by'] && !$today['check_out'] && $today['status'] == 'hadir'): ?>
                            <!-- Sudah Check-in dan sudah diverifikasi, tapi belum Check-out (Hanya untuk status hadir) -->
                            <div class="text-center py-3">
                                <div class="status-indicator bg-success text-white p-4 rounded-3 mb-4">
                                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                                    <h4 class="fw-bold">Terverifikasi - Siap Check-out</h4>
                                    <p class="mb-2 text-white"><strong>Waktu Check-in:</strong> <?= date('H:i', strtotime($today['check_in'])) ?></p>
                                    <p class="mb-1 text-white"><strong>Diverifikasi oleh:</strong> <?= htmlspecialchars($today['verified_by_name']) ?></p>
                                    <p class="mb-1 text-white"><strong>Note Check-in:</strong> <?= htmlspecialchars($today['note'] ?: '-') ?></p>
                                    <p class="mb-0 text-white">Silakan lakukan check-out saat pulang</p>
                                </div>
                                
                                <form method="POST" action="" class="col-lg-8 mx-auto">
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-start w-100">
                                            <i class="fas fa-sticky-note me-2 text-success"></i>Note Check-out
                                            <span class="text-danger">*</span>
                                        </label>
                                        <textarea name="note" class="form-control form-control-lg" 
                                                  placeholder="Masukkan catatan aktivitas hari ini (wajib diisi)..." 
                                                  rows="4" required></textarea>
                                        <div class="form-text text-start">
                                            <i class="fas fa-info-circle me-1"></i>Contoh: "Project website selesai 80%, besok lanjut debugging"
                                        </div>
                                    </div>
                                    <button type="submit" name="checkout" class="btn btn-success btn-lg w-100 py-3">
                                        <i class="fas fa-sign-out-alt me-2"></i>Check Out Sekarang
                                    </button>
                                    <small class="text-danger mt-2 d-block">Note check-out wajib diisi!</small>
                                </form>
                            </div>

                        <?php elseif ($today && $today['verified_by'] && in_array($today['status'], ['izin', 'sakit'])): ?>
                            <!-- Izin/Sakit sudah diverifikasi -->
                            <div class="text-center py-3">
                                <div class="status-indicator bg-info text-white p-4 rounded-3 mb-4">
                                    <i class="fas fa-check-circle fa-3x mb-3"></i>
                                    <h4 class="fw-bold">Pengajuan <?= ucfirst($today['status']) ?> Disetujui</h4>
                                    <p class="mb-2"><strong>Status:</strong> <?= ucfirst($today['status']) ?></p>
                                    <p class="mb-2"><strong>Waktu Pengajuan:</strong> <?= date('H:i', strtotime($today['created_at'])) ?></p>
                                    <p class="mb-1"><strong>Disetujui oleh:</strong> <?= htmlspecialchars($today['verified_by_name']) ?></p>
                                    <p class="mb-0 mt-2"><strong>Keterangan:</strong> <?= htmlspecialchars($today['note']) ?></p>
                                </div>
                                
                                <button type="button" class="btn btn-success btn-lg py-3 col-lg-6" disabled>
                                    <i class="fas fa-check-double me-2"></i>Pengajuan Telah Disetujui
                                </button>
                                <small class="text-muted mt-2 d-block">Terima kasih! Pengajuan Anda telah disetujui</small>
                            </div>

                        <?php else: ?>
                            <!-- Sudah Check-in dan Check-out atau kondisi lainnya -->
                            <div class="text-center py-3">
                                <div class="status-indicator bg-info text-white p-4 rounded-3 mb-4">
                                    <i class="fas fa-flag-checkered fa-3x mb-3"></i>
                                    <h4 class="fw-bold">
                                        <?= $today['status'] == 'hadir' ? 'Absensi Selesai' : 'Pengajuan ' . ucfirst($today['status']) ?>
                                    </h4>
                                    <?php if ($today['status'] == 'hadir'): ?>
                                        <p class="mb-1"><strong>Check-in:</strong> <?= date('H:i', strtotime($today['check_in'])) ?></p>
                                        <p class="mb-1"><strong>Check-out:</strong> <?= date('H:i', strtotime($today['check_out'])) ?></p>
                                    <?php else: ?>
                                        <p class="mb-1"><strong>Status:</strong> <?= ucfirst($today['status']) ?></p>
                                        <p class="mb-1"><strong>Waktu Pengajuan:</strong> <?= date('H:i', strtotime($today['created_at'])) ?></p>
                                    <?php endif; ?>
                                    <p class="mb-0 mt-2"><strong>Keterangan:</strong> <?= htmlspecialchars($today['note']) ?></p>
                                </div>
                                
                                <button type="button" class="btn btn-secondary btn-lg py-3 col-lg-6" disabled>
                                    <i class="fas fa-check-double me-2"></i>
                                    <?= $today['status'] == 'hadir' ? 'Absensi Hari Ini Selesai' : 'Pengajuan Telah Dikirim' ?>
                                </button>
                                <small class="text-muted mt-2 d-block">
                                    <?= $today['status'] == 'hadir' ? 'Terima kasih! Sampai jumpa besok' : 'Terima kasih! Pengajuan Anda telah direkam' ?>
                                </small>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Info Tambahan -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-info-circle fa-2x text-primary mb-3"></i>
                                <h6>Hadir & Bekerja</h6>
                                <small class="text-muted">
                                    • Note opsional<br>
                                    • Lakukan saat tiba<br>
                                    • Tunggu verifikasi
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-info-circle fa-2x text-warning mb-3"></i>
                                <h6>Izin / Sakit</h6>
                                <small class="text-muted">
                                    • Pilih periode<br>
                                    • Keterangan wajib<br>
                                    • Tunggu persetujuan
                                </small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-info-circle fa-2x text-success mb-3"></i>
                                <h6>Check-out</h6>
                                <small class="text-muted">
                                    • Note wajib diisi<br>
                                    • Update progress<br>
                                    • Hanya setelah diverifikasi
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
.btn {
    opacity: 1 !important;
    visibility: visible !important;
    display: inline-block !important;
    position: relative !important;
    z-index: 1 !important;
}

.btn-primary, .btn-success, .btn-secondary, .btn-warning {
    opacity: 1 !important;
    visibility: visible !important;
    display: inline-block !important;
    border: 2px solid transparent;
    transition: all 0.3s ease;
    background-color: #4361ee !important;
    color: white !important;
    padding: 12px 24px !important;
    font-size: 16px !important;
}

.btn-primary:hover, .btn-success:hover, .btn-warning:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    opacity: 0.9 !important;
}

.btn-success {
    background-color: #28a745 !important;
}

.btn-warning {
    background-color: #ffc107 !important;
    color: #000 !important;
}

.btn-secondary {
    background-color: #6c757d !important;
}

#absen .btn,
#absen button,
#absen input[type="submit"] {
    opacity: 1 !important;
    visibility: visible !important;
    display: inline-block !important;
    background-color: #4361ee !important;
    color: white !important;
    border: none !important;
    padding: 15px 30px !important;
    font-size: 18px !important;
    font-weight: 600 !important;
    border-radius: 10px !important;
    cursor: pointer !important;
    width: 100% !important;
    margin: 10px 0 !important;
}

#absen .btn-primary {
    background: linear-gradient(135deg, #4361ee, #3a0ca3) !important;
}

#absen .btn-success {
    background: linear-gradient(135deg, #28a745, #20c997) !important;
}

#absen .btn-warning {
    background: linear-gradient(135deg, #ffc107, #fd7e14) !important;
    color: #000 !important;
}

#absen .btn-secondary {
    background: linear-gradient(135deg, #6c757d, #495057) !important;
}

.choice-card {
    transition: all 0.3s ease;
    border: 2px solid transparent !important;
}

.choice-card:hover {
    transform: translateY(-5px);
    border-color: #4361ee !important;
    box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
}

.icon-circle {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
}

.form-check-input:checked {
    background-color: #ffc107;
    border-color: #ffc107;
}

.form-check-label {
    font-weight: 500;
}

input[type="date"] {
    border-radius: 8px;
    border: 2px solid #e9ecef;
    padding: 10px;
}

input[type="date"]:focus {
    border-color: #ffc107;
    box-shadow: 0 0 0 0.2rem rgba(255, 193, 7, 0.25);
}

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

#absen .btn:disabled {
    opacity: 0.6 !important;
    cursor: not-allowed !important;
}

#absen .btn:hover:not(:disabled) {
    transform: translateY(-2px) !important;
    box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    opacity: 0.95 !important;
}
</style>

<script>
// Update real-time clock
function updateClock() {
    const now = new Date();
    const timeString = now.toLocaleTimeString('id-ID');
    document.getElementById('currentTime').textContent = timeString;
}

// Show check-in form
function showCheckinForm() {
    document.getElementById('checkinForm').style.display = 'block';
    document.getElementById('izinForm').style.display = 'none';
    document.querySelectorAll('.choice-card').forEach(card => {
        card.style.display = 'none';
    });
}

// Show izin/sakit form
function showIzinForm() {
    document.getElementById('izinForm').style.display = 'block';
    document.getElementById('checkinForm').style.display = 'none';
    document.querySelectorAll('.choice-card').forEach(card => {
        card.style.display = 'none';
    });
}

// Hide all forms and show choice cards
function hideForms() {
    document.getElementById('checkinForm').style.display = 'none';
    document.getElementById('izinForm').style.display = 'none';
    document.querySelectorAll('.choice-card').forEach(card => {
        card.style.display = 'block';
    });
}

// Update range information
function updateRangeInfo() {
    const mulai = document.querySelector('input[name="tanggal_mulai"]');
    const selesai = document.querySelector('input[name="tanggal_selesai"]');
    const infoRange = document.getElementById('infoRange');
    
    if (mulai.value && selesai.value) {
        const start = new Date(mulai.value);
        const end = new Date(selesai.value);
        const diffTime = Math.abs(end - start);
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
        
        infoRange.textContent = `Total ${diffDays} hari (${formatDate(start)} - ${formatDate(end)})`;
    } else {
        infoRange.textContent = 'Kosongkan jika hanya hari ini';
    }
}

// Format date to Indonesian format
function formatDate(date) {
    return date.toLocaleDateString('id-ID', {
        day: '2-digit',
        month: '2-digit',
        year: 'numeric'
    });
}

// Update contoh keterangan berdasarkan status yang dipilih
function updateContohKeterangan() {
    const statusSelect = document.querySelector('select[name="status"]');
    const contohIzin = document.getElementById('contohIzin');
    const contohSakit = document.getElementById('contohSakit');
    
    if (statusSelect.value === 'izin') {
        contohIzin.style.display = 'inline';
        contohSakit.style.display = 'none';
    } else if (statusSelect.value === 'sakit') {
        contohIzin.style.display = 'none';
        contohSakit.style.display = 'inline';
    } else {
        contohIzin.style.display = 'none';
        contohSakit.style.display = 'none';
    }
}

// Initialize event listeners
document.addEventListener('DOMContentLoaded', function() {
    // Update contoh keterangan
    updateContohKeterangan();
    
    // Add event listeners for date inputs
    const mulaiInput = document.querySelector('input[name="tanggal_mulai"]');
    const selesaiInput = document.querySelector('input[name="tanggal_selesai"]');
    
    if (mulaiInput && selesaiInput) {
        mulaiInput.addEventListener('change', function() {
            selesaiInput.min = this.value;
            if (selesaiInput.value && selesaiInput.value < this.value) {
                selesaiInput.value = this.value;
            }
            updateRangeInfo();
        });
        
        selesaiInput.addEventListener('change', updateRangeInfo);
        updateRangeInfo(); // Initial call
    }
    
    // Set clock
    setInterval(updateClock, 1000);
    updateClock();
});
</script>