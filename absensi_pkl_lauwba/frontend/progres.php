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

// Hitung statistik kehadiran
$qStats = mysqli_query($connect, "
    SELECT 
        COUNT(*) AS total_hari,
        SUM(CASE WHEN status = 'hadir' THEN 1 ELSE 0 END) AS total_hadir,
        SUM(CASE WHEN status = 'izin' THEN 1 ELSE 0 END) AS total_izin,
        SUM(CASE WHEN status = 'sakit' THEN 1 ELSE 0 END) AS total_sakit,
        SUM(CASE WHEN status = 'alpha' THEN 1 ELSE 0 END) AS total_alpha
    FROM attendance 
    WHERE participant_id = '$participant_id'
");
$stats = mysqli_fetch_assoc($qStats);

// Persentase kehadiran
$persen_hadir = ($stats['total_hari'] > 0) ? round(($stats['total_hadir'] / $stats['total_hari']) * 100, 1) : 0;

// Data untuk chart (30 hari terakhir)
$qChart = mysqli_query($connect, "
    SELECT 
        DATE(check_in) as tanggal,
        status
    FROM attendance 
    WHERE participant_id = '$participant_id' 
    AND check_in >= DATE_SUB(CURDATE(), INTERVAL 30 DAY)
    ORDER BY check_in DESC
    LIMIT 30
");

$chart_data = [];
while ($row = mysqli_fetch_assoc($qChart)) {
    $chart_data[] = $row;
}
$chart_data = array_reverse($chart_data); // Urutkan dari terlama
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Progress Kehadiran | Lauwba PKL</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    :root {
      --primary: #4361ee;
      --success: #4cc9f0;
      --warning: #f72585;
      --info: #7209b7;
      --light: #f8f9fa;
    }
    
    .gradient-bg {
      background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .stat-card {
      border-radius: 15px;
      border: none;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .stat-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }
    
    .progress {
      height: 20px;
      border-radius: 10px;
      background: #e9ecef;
    }
    
    .progress-bar {
      border-radius: 10px;
      transition: width 1s ease-in-out;
    }
    
    .chart-container {
      background: white;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    }
    
    .icon-circle {
      width: 60px;
      height: 60px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
    }
    
    .badge-status {
      padding: 8px 15px;
      border-radius: 20px;
      font-weight: 500;
    }
  </style>
</head>
<body class="bg-light">

<!-- Header -->
<div class="gradient-bg text-white py-4 mb-5">
  <div class="container">
    <div class="row align-items-center">
      <div class="col-md-8">
        <h1 class="h3 mb-0"><i class="fas fa-chart-line me-2"></i>Progress Kehadiran</h1>
        <p class="mb-0 opacity-75"><?= htmlspecialchars($user_data['full_name']) ?> - <?= htmlspecialchars($user_data['school']) ?></p>
      </div>
      <div class="col-md-4 text-md-end">
        <a href="index.php" class="btn btn-light btn-sm me-2">
          <i class="fas fa-home me-1"></i>Beranda
        </a>
        <a href="riwayat.php" class="btn btn-outline-light btn-sm">
          <i class="fas fa-history me-1"></i>Riwayat
        </a>
      </div>
    </div>
  </div>
</div>

<div class="container">
  <!-- Ringkasan Statistik -->
  <div class="row mb-5">
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card stat-card border-success">
        <div class="card-body text-center">
          <div class="icon-circle bg-success text-white mx-auto mb-3">
            <i class="fas fa-check-circle"></i>
          </div>
          <h3 class="text-success mb-1"><?= $stats['total_hadir'] ?></h3>
          <p class="text-muted mb-0">Hadir</p>
        </div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card stat-card border-info">
        <div class="card-body text-center">
          <div class="icon-circle bg-info text-white mx-auto mb-3">
            <i class="fas fa-envelope"></i>
          </div>
          <h3 class="text-info mb-1"><?= $stats['total_izin'] ?></h3>
          <p class="text-muted mb-0">Izin</p>
        </div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card stat-card border-warning">
        <div class="card-body text-center">
          <div class="icon-circle bg-warning text-white mx-auto mb-3">
            <i class="fas fa-briefcase-medical"></i>
          </div>
          <h3 class="text-warning mb-1"><?= $stats['total_sakit'] ?></h3>
          <p class="text-muted mb-0">Sakit</p>
        </div>
      </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-4">
      <div class="card stat-card border-danger">
        <div class="card-body text-center">
          <div class="icon-circle bg-danger text-white mx-auto mb-3">
            <i class="fas fa-times-circle"></i>
          </div>
          <h3 class="text-danger mb-1"><?= $stats['total_alpha'] ?></h3>
          <p class="text-muted mb-0">Alpha</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Progress Kehadiran -->
  <div class="row mb-5">
    <div class="col-lg-8">
      <div class="card stat-card">
        <div class="card-body">
          <h5 class="card-title mb-4">
            <i class="fas fa-chart-pie me-2 text-primary"></i>Persentase Kehadiran
          </h5>
          
          <div class="mb-4">
            <div class="d-flex justify-content-between mb-2">
              <span>Progress Kehadiran</span>
              <span class="fw-bold text-primary"><?= $persen_hadir ?>%</span>
            </div>
            <div class="progress">
              <div class="progress-bar bg-primary progress-bar-striped progress-bar-animated" 
                   role="progressbar" 
                   style="width: <?= $persen_hadir ?>%"
                   aria-valuenow="<?= $persen_hadir ?>" 
                   aria-valuemin="0" 
                   aria-valuemax="100">
              </div>
            </div>
          </div>
          
          <div class="row text-center">
            <div class="col-4">
              <div class="border-end">
                <h4 class="text-success mb-1"><?= $stats['total_hadir'] ?></h4>
                <small class="text-muted">Hadir</small>
              </div>
            </div>
            <div class="col-4">
              <div class="border-end">
                <h4 class="text-info mb-1"><?= $stats['total_izin'] + $stats['total_sakit'] ?></h4>
                <small class="text-muted">Izin & Sakit</small>
              </div>
            </div>
            <div class="col-4">
              <div>
                <h4 class="text-danger mb-1"><?= $stats['total_alpha'] ?></h4>
                <small class="text-muted">Alpha</small>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    
    <div class="col-lg-4">
      <div class="card stat-card h-100">
        <div class="card-body">
          <h5 class="card-title mb-4">
            <i class="fas fa-info-circle me-2 text-info"></i>Informasi
          </h5>
          
          <div class="d-flex align-items-center mb-3">
            <div class="bg-primary text-white rounded-circle p-2 me-3">
              <i class="fas fa-user"></i>
            </div>
            <div>
              <h6 class="mb-0"><?= htmlspecialchars($user_data['full_name']) ?></h6>
              <small class="text-muted">Peserta PKL</small>
            </div>
          </div>
          
          <div class="d-flex align-items-center mb-3">
            <div class="bg-success text-white rounded-circle p-2 me-3">
              <i class="fas fa-graduation-cap"></i>
            </div>
            <div>
              <h6 class="mb-0"><?= htmlspecialchars($user_data['school']) ?></h6>
              <small class="text-muted"><?= htmlspecialchars($user_data['program_study']) ?></small>
            </div>
          </div>
          
          <div class="mt-4">
            <span class="badge-status bg-success">Total Hari: <?= $stats['total_hari'] ?></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Grafik 30 Hari Terakhir -->
  <div class="row">
    <div class="col-12">
      <div class="chart-container">
        <h5 class="mb-4">
          <i class="fas fa-chart-bar me-2 text-primary"></i>Riwayat 30 Hari Terakhir
        </h5>
        <canvas id="attendanceChart" height="100"></canvas>
      </div>
    </div>
  </div>

  <!-- Action Buttons -->
  <div class="text-center mt-5 py-4">
    <a href="riwayat.php" class="btn btn-primary btn-lg me-3">
      <i class="fas fa-history me-2"></i>Lihat Riwayat Lengkap
    </a>
    <a href="index.php" class="btn btn-outline-primary btn-lg">
      <i class="fas fa-home me-2"></i>Kembali ke Beranda
    </a>
  </div>
</div>

<script>
// Chart untuk 30 hari terakhir
const ctx = document.getElementById('attendanceChart').getContext('2d');
const attendanceChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($chart_data, 'tanggal')) ?>,
        datasets: [{
            label: 'Status Kehadiran',
            data: <?= json_encode(array_map(function($item) {
                return $item['status'] === 'hadir' ? 1 : 0;
            }, $chart_data)) ?>,
            backgroundColor: '#4361ee',
            borderColor: '#3a0ca3',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                max: 1,
                ticks: {
                    callback: function(value) {
                        return value === 1 ? 'Hadir' : 'Tidak';
                    }
                }
            }
        }
    }
});
</script>

</body>
</html>