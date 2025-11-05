<?php
session_name("absenPklSession");
session_start();
include '../config/connection.php';

if (!isset($_SESSION['id_user'])) {
    header("Location: auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];

// Ambil data user dan participant
$qUser = mysqli_query($connect, "
    SELECT u.full_name, u.email, p.id as participant_id, p.school, p.program_study 
    FROM users u 
    LEFT JOIN participants p ON u.id = p.user_id 
    WHERE u.id = '$id_user'
");
$user_data = mysqli_fetch_assoc($qUser);

if (!$user_data || !$user_data['participant_id']) {
    die("<div class='container mt-5 text-center'><h3>Data peserta tidak ditemukan.</h3></div>");
}

$participant_id = $user_data['participant_id'];

// Ambil data riwayat absensi dengan informasi verifikasi
$qRiwayat = mysqli_query($connect, "
    SELECT 
        a.*,
        u.full_name as verified_by_name,
        CASE 
            WHEN a.verified_by IS NOT NULL THEN 'Terverifikasi'
            ELSE 'Menunggu Verifikasi'
        END as status_verifikasi
    FROM attendance a
    LEFT JOIN users u ON a.verified_by = u.id
    WHERE a.participant_id = '$participant_id' 
    ORDER BY a.check_in DESC
");

// Hitung total data untuk pagination
$total_data = mysqli_num_rows($qRiwayat);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Absensi | Lauwba PKL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --success: #4cc9f0;
      --warning: #f72585;
      --info: #7209b7;
    }
    
    .gradient-bg {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .table-hover tbody tr:hover {
      background-color: rgba(67, 97, 238, 0.05);
    }
    
    .status-badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 500;
    }
    
    .verified-badge {
      background: #d4edda;
      color: #155724;
    }
    
    .pending-badge {
      background: #fff3cd;
      color: #856404;
    }
    
    .table th {
      border-top: none;
      font-weight: 600;
      color: #495057;
    }
    
    .card-shadow {
      box-shadow: 0 5px 15px rgba(0,0,0,0.08);
      border: none;
      border-radius: 15px;
    }
    
    .pagination .page-link {
      color: #4361ee;
      border: 1px solid #dee2e6;
    }
    
    .pagination .page-item.active .page-link {
      background: #4361ee;
      border-color: #4361ee;
    }
  </style>
</head>
<body class="bg-light">

<!-- Header -->
<div class="gradient-bg text-white py-4 mb-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1 class="h3 mb-0"><i class="fas fa-history me-2"></i>Riwayat Absensi</h1>
        <p class="mb-0 opacity-75"><?= htmlspecialchars($user_data['full_name']) ?> - <?= htmlspecialchars($user_data['school']) ?></p>
      </div>
      <div class="col-md-4 text-md-end">
        <a href="progres.php" class="btn btn-light btn-sm me-2">
          <i class="fas fa-chart-line me-1"></i>Progress
        </a>
        <a href="index.php" class="btn btn-outline-light btn-sm">
          <i class="fas fa-home me-1"></i>Beranda
        </a>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <!-- Summary Cards -->
  <div class="row mb-4">
    <div class="col-md-4 mb-3">
      <div class="card card-shadow border-start border-primary border-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="bg-primary text-white rounded-circle p-3 me-3">
              <i class="fas fa-list-alt"></i>
            </div>
            <div>
              <h4 class="mb-0"><?= $total_data ?></h4>
              <p class="text-muted mb-0">Total Absensi</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-4 mb-3">
      <div class="card card-shadow border-start border-success border-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="bg-success text-white rounded-circle p-3 me-3">
              <i class="fas fa-user-check"></i>
            </div>
            <div>
              <h4 class="mb-0"><?= htmlspecialchars($user_data['full_name']) ?></h4>
              <p class="text-muted mb-0">Nama Peserta</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-md-4 mb-3">
      <div class="card card-shadow border-start border-info border-4">
        <div class="card-body">
          <div class="d-flex align-items-center">
            <div class="bg-info text-white rounded-circle p-3 me-3">
              <i class="fas fa-graduation-cap"></i>
            </div>
            <div>
              <h6 class="mb-0"><?= htmlspecialchars($user_data['program_study']) ?></h6>
              <p class="text-muted mb-0">Program Studi</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Tabel Riwayat -->
  <div class="card card-shadow">
    <div class="card-header bg-white py-3">
      <h5 class="mb-0"><i class="fas fa-table me-2 text-primary"></i>Daftar Riwayat Absensi</h5>
    </div>
    <div class="card-body p-0">
      <div class="table-responsive">
        <table class="table table-hover mb-0">
          <thead class="table-light">
            <tr>
              <th class="text-center">No</th>
              <th>Tanggal</th>
              <th>Check In</th>
              <th>Check Out</th>
              <th>Durasi</th>
              <th>Status</th>
              <th>Verifikasi</th>
              <th>Keterangan</th>
            </tr>
          </thead>
          <tbody>
            <?php if (mysqli_num_rows($qRiwayat) > 0): 
              $no = 1;
              while ($row = mysqli_fetch_assoc($qRiwayat)): 
                // Hitung durasi
                $durasi = '-';
                if ($row['check_in'] && $row['check_out']) {
                  $check_in = new DateTime($row['check_in']);
                  $check_out = new DateTime($row['check_out']);
                  $diff = $check_out->diff($check_in);
                  $durasi = $diff->format('%h jam %i menit');
                }
                
                // Warna status
                $status_class = [
                  'hadir' => 'bg-success',
                  'izin' => 'bg-info',
                  'sakit' => 'bg-warning',
                  'alpha' => 'bg-danger'
                ][$row['status']] ?? 'bg-secondary';
              ?>
              <tr>
                <td class="text-center fw-bold"><?= $no++ ?></td>
                <td>
                  <strong><?= date('d/m/Y', strtotime($row['check_in'])) ?></strong>
                </td>
                <td>
                  <span class="badge bg-light text-dark">
                    <i class="fas fa-sign-in-alt me-1 text-success"></i>
                    <?= $row['check_in'] ? date('H:i', strtotime($row['check_in'])) : '-' ?>
                  </span>
                </td>
                <td>
                  <span class="badge bg-light text-dark">
                    <i class="fas fa-sign-out-alt me-1 text-primary"></i>
                    <?= $row['check_out'] ? date('H:i', strtotime($row['check_out'])) : '-' ?>
                  </span>
                </td>
                <td>
                  <small class="text-muted"><?= $durasi ?></small>
                </td>
                <td>
                  <span class="badge <?= $status_class ?> status-badge">
                    <?= ucfirst($row['status']) ?>
                  </span>
                </td>
                <td>
                  <span class="badge <?= $row['verified_by'] ? 'verified-badge' : 'pending-badge' ?> status-badge">
                    <i class="fas <?= $row['verified_by'] ? 'fa-check-circle' : 'fa-clock' ?> me-1"></i>
                    <?= $row['status_verifikasi'] ?>
                  </span>
                  <?php if ($row['verified_by']): ?>
                    <br><small class="text-muted">by <?= htmlspecialchars($row['verified_by_name']) ?></small>
                  <?php endif; ?>
                </td>
                <td>
                  <span class="d-inline-block text-truncate" style="max-width: 200px;" 
                        title="<?= htmlspecialchars($row['note']) ?>">
                    <?= htmlspecialchars($row['note'] ?: '-') ?>
                  </span>
                </td>
              </tr>
            <?php endwhile; else: ?>
              <tr>
                <td colspan="8" class="text-center py-5">
                  <div class="text-muted">
                    <i class="fas fa-inbox fa-3x mb-3"></i>
                    <h5>Belum ada data absensi</h5>
                    <p>Mulai dengan melakukan check-in pertama Anda</p>
                    <a href="index.php" class="btn btn-primary mt-2">
                      <i class="fas fa-plus me-1"></i>Check-in Sekarang
                    </a>
                  </div>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Pagination & Action Buttons -->
  <div class="d-flex justify-content-between align-items-center mt-4">
    <div>
      <span class="text-muted">Menampilkan <?= $total_data ?> data absensi</span>
    </div>
    <div>
      <a href="progres.php" class="btn btn-outline-primary me-2">
        <i class="fas fa-chart-line me-1"></i>Lihat Progress
      </a>
      <a href="index.php" class="btn btn-primary">
        <i class="fas fa-home me-1"></i>Kembali ke Beranda
      </a>
    </div>
  </div>
</div>

<!-- Footer Spacing -->
<div class="my-5"></div>

</body>
</html>