<?php
session_start();
if (!isset($_SESSION['logged_in'])) {
  echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location.href='../auth/login.php';
    </script>";
  exit();
}

$page = "dashboard";
include __DIR__ . '/../../../config/connection.php';
include '../../partials/header.php';
include '../../partials/sidebar.php';
include '../../partials/navbar.php';

$role = $_SESSION['role'];
$user_id = $_SESSION['user_id'];

// ====== Statistik Berdasarkan Role ======
$total_peserta = $total_pembimbing = $total_absensi = $total_hadir = $total_izin = $total_sakit = 0;

// For peserta role we need the participant.id (not user_id)
$participant_id_for_user = 0;
if ($role === 'peserta') {
  $qGetPart = mysqli_query($connect, "SELECT id FROM participants WHERE user_id = '$user_id' LIMIT 1");
  $pRow = mysqli_fetch_assoc($qGetPart);
  $participant_id_for_user = $pRow['id'] ?? 0;
}

if ($role === 'admin') {
  $qPeserta = mysqli_query($connect, "SELECT COUNT(*) AS total FROM participants");
  $qPembimbing = mysqli_query($connect, "SELECT COUNT(*) AS total FROM supervisors");
  $qAbsensi = mysqli_query($connect, "SELECT COUNT(*) AS total FROM attendance");
  $qHadir = mysqli_query($connect, "
    SELECT 
      SUM(CASE WHEN status='Hadir' THEN 1 ELSE 0 END) AS hadir,
      SUM(CASE WHEN status='Izin' THEN 1 ELSE 0 END) AS izin,
      SUM(CASE WHEN status='Sakit' THEN 1 ELSE 0 END) AS sakit
    FROM attendance
  ");

  $total_peserta = mysqli_fetch_assoc($qPeserta)['total'] ?? 0;
  $total_pembimbing = mysqli_fetch_assoc($qPembimbing)['total'] ?? 0;
  $total_absensi = mysqli_fetch_assoc($qAbsensi)['total'] ?? 0;
  $dataHadir = mysqli_fetch_assoc($qHadir);
  $total_hadir = $dataHadir['hadir'] ?? 0;
  $total_izin = $dataHadir['izin'] ?? 0;
  $total_sakit = $dataHadir['sakit'] ?? 0;

  $qTable = mysqli_query($connect, "
    SELECT a.*, u.full_name AS participant_name, a.note
    FROM attendance a
    LEFT JOIN participants p ON a.participant_id = p.id
    LEFT JOIN users u ON p.user_id = u.id
    ORDER BY a.created_at DESC
    LIMIT 5
  ");
} elseif ($role === 'pembimbing') {
  // peserta yang dibimbing pembimbing ini
  $qPeserta = mysqli_query($connect, "SELECT COUNT(*) AS total FROM participants WHERE supervisor_id='$user_id'");
  $qAbsensi = mysqli_query($connect, "
    SELECT COUNT(*) AS total 
    FROM attendance 
    WHERE participant_id IN (SELECT id FROM participants WHERE supervisor_id='$user_id')
  ");
  $qHadir = mysqli_query($connect, "
    SELECT 
      SUM(CASE WHEN status='Hadir' THEN 1 ELSE 0 END) AS hadir,
      SUM(CASE WHEN status='Izin' THEN 1 ELSE 0 END) AS izin,
      SUM(CASE WHEN status='Sakit' THEN 1 ELSE 0 END) AS sakit
    FROM attendance 
    WHERE participant_id IN (SELECT id FROM participants WHERE supervisor_id='$user_id')
  ");

  $total_peserta = mysqli_fetch_assoc($qPeserta)['total'] ?? 0;
  $total_absensi = mysqli_fetch_assoc($qAbsensi)['total'] ?? 0;
  $dataHadir = mysqli_fetch_assoc($qHadir);
  $total_hadir = $dataHadir['hadir'] ?? 0;
  $total_izin = $dataHadir['izin'] ?? 0;
  $total_sakit = $dataHadir['sakit'] ?? 0;

  $qTable = mysqli_query($connect, "
    SELECT a.*, u.full_name AS participant_name, a.note
    FROM attendance a
    LEFT JOIN participants p ON a.participant_id = p.id
    LEFT JOIN users u ON p.user_id = u.id
    WHERE p.supervisor_id = '$user_id'
    ORDER BY a.created_at DESC
    LIMIT 5
  ");
} elseif ($role === 'peserta') {
  // gunakan participant_id_for_user
  $qAbsensi = mysqli_query($connect, "SELECT COUNT(*) AS total FROM attendance WHERE participant_id='{$participant_id_for_user}'");
  $qHadir = mysqli_query($connect, "
    SELECT 
      SUM(CASE WHEN status='Hadir' THEN 1 ELSE 0 END) AS hadir,
      SUM(CASE WHEN status='Izin' THEN 1 ELSE 0 END) AS izin,
      SUM(CASE WHEN status='Sakit' THEN 1 ELSE 0 END) AS sakit
    FROM attendance WHERE participant_id='{$participant_id_for_user}'
  ");

  $total_absensi = mysqli_fetch_assoc($qAbsensi)['total'] ?? 0;
  $dataHadir = mysqli_fetch_assoc($qHadir);
  $total_hadir = $dataHadir['hadir'] ?? 0;
  $total_izin = $dataHadir['izin'] ?? 0;
  $total_sakit = $dataHadir['sakit'] ?? 0;

  $qTable = mysqli_query($connect, "
    SELECT a.*, u.full_name AS participant_name, a.note
    FROM attendance a
    LEFT JOIN participants p ON a.participant_id = p.id
    LEFT JOIN users u ON p.user_id = u.id
    WHERE a.participant_id = '{$participant_id_for_user}'
    ORDER BY a.created_at DESC
    LIMIT 5
  ");
}

// ====== Data Bulanan (Tren per bulan) - untuk chart line
// Ambil jumlah absensi per bulan untuk tahun ini. Filter sesuai role.
$monthlyCounts = array_fill(1, 12, 0);
$yearNow = date('Y');

if ($role === 'admin') {
  $qMonthly = mysqli_query($connect, "
    SELECT MONTH(created_at) AS m, COUNT(*) AS cnt
    FROM attendance
    WHERE YEAR(created_at) = '$yearNow'
    GROUP BY MONTH(created_at)
  ");
} elseif ($role === 'pembimbing') {
  $qMonthly = mysqli_query($connect, "
    SELECT MONTH(a.created_at) AS m, COUNT(*) AS cnt
    FROM attendance a
    JOIN participants p ON a.participant_id = p.id
    WHERE YEAR(a.created_at) = '$yearNow' AND p.supervisor_id = '$user_id'
    GROUP BY MONTH(a.created_at)
  ");
} else { // peserta
  $qMonthly = mysqli_query($connect, "
    SELECT MONTH(created_at) AS m, COUNT(*) AS cnt
    FROM attendance
    WHERE YEAR(created_at) = '$yearNow' AND participant_id = '{$participant_id_for_user}'
    GROUP BY MONTH(created_at)
  ");
}

if (isset($qMonthly) && $qMonthly) {
  while ($r = mysqli_fetch_assoc($qMonthly)) {
    $m = (int)$r['m'];
    $c = (int)$r['cnt'];
    if ($m >= 1 && $m <= 12) $monthlyCounts[$m] = $c;
  }
}

// Convert monthlyCounts to JS array order Jan..Dec
$monthlyJsArray = [];
for ($i = 1; $i <= 12; $i++) $monthlyJsArray[] = $monthlyCounts[$i];

?>

<style>
.card-round {
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}
.card-header-gradient {
  background: linear-gradient(135deg, #023e8a, #0077b6, #90e0ef);
  color: #fff;
}
.table-bordered td, .table-bordered th {
  border: 1px solid #999 !important;
}
.table thead th {
  background-color: #f8f9fa;
}

/* Tinggi dan perataan antar card */
.card-round {
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  height: 100%;
}

.card-body {
  min-height: 130px;
}

/* Pastikan semua chart-card punya tinggi sama */
.chart-card .card-body {
  height: 340px !important;
  display: flex;
  justify-content: center;
  align-items: center;
}

canvas {
  max-height: 300px !important;
  width: 100% !important;
}
</style>

<div class="container">
  <div class="page-inner">
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-3">
      <div>
        <h3 class="fw-bold mb-1">Dashboard</h3>
        <p class="text-muted mb-0">Menampilkan ringkasan data dan absensi terakhir.</p>
      </div>
    </div>

    <!-- Statistik -->
    <div class="row">
      <?php if ($role !== 'peserta'): ?>
      <div class="col-sm-6 col-md-3 mb-3">
        <div class="card card-round text-center">
          <div class="card-body">
            <h6>Total Peserta</h6>
            <h3 class="fw-bold text-primary"><?= $total_peserta ?></h3>
            <p class="small text-muted">Jumlah peserta aktif<?= ($role==='pembimbing' ? ' (bimbingan Anda)' : '') ?></p>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <?php if ($role === 'admin'): ?>
      <div class="col-sm-6 col-md-3 mb-3">
        <div class="card card-round text-center">
          <div class="card-body">
            <h6>Total Pembimbing</h6>
            <h3 class="fw-bold text-info"><?= $total_pembimbing ?></h3>
            <p class="small text-muted">Pembimbing terdaftar</p>
          </div>
        </div>
      </div>
      <?php endif; ?>

      <div class="col-sm-6 col-md-3 mb-3">
        <div class="card card-round text-center">
          <div class="card-body">
            <h6>Total Absensi</h6>
            <h3 class="fw-bold text-success"><?= $total_absensi ?></h3>
            <p class="small text-muted">Semua data absensi<?= ($role==='pembimbing' ? ' (bimbingan Anda)' : ($role==='peserta' ? ' (riwayat Anda)' : '')) ?></p>
          </div>
        </div>
      </div>

      <div class="col-sm-6 col-md-3 mb-3">
        <div class="card card-round text-center">
          <div class="card-body">
            <h6>Hadir / Izin / Sakit</h6>
            <h4 class="fw-bold"><?= "$total_hadir / $total_izin / $total_sakit" ?></h4>
            <p class="small text-muted">Statistik kehadiran terbaru<?= ($role==='pembimbing' ? ' (bimbingan Anda)' : ($role==='peserta' ? ' (Anda)' : '')) ?></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Diagram -->
    <div class="row mt-3">
      <div class="col-md-8 mb-3">
        <div class="card card-round chart-card">
          <div class="card-header card-header-gradient">
            <h6 class="mb-0"><i class="fas fa-chart-bar me-2"></i>Grafik Kehadiran</h6>
          </div>
          <div class="card-body">
            <canvas id="attendanceChart"></canvas>
          </div>
        </div>
      </div>

      <div class="col-md-4 mb-3">
        <div class="card card-round chart-card">
          <div class="card-header card-header-gradient">
            <h6 class="mb-0"><i class="fas fa-chart-pie me-2"></i>Rasio Kehadiran</h6>
          </div>
          <div class="card-body">
            <canvas id="pieChart"></canvas>
          </div>
        </div>
      </div>
    </div>

    <!-- Absensi Terbaru -->
    <div class="row mt-4">
      <div class="col-md-12">
        <div class="card card-round shadow-sm">
          <div class="card-header card-header-gradient d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><i class="fas fa-table me-2"></i>Absensi Terbaru</h6>
            <a href="../attendance/index.php" class="btn btn-light btn-sm">
              <i class="fas fa-eye me-1"></i> Lihat Semua
            </a>
          </div>
          <div class="card-body">
            <p class="text-muted small mb-3">Menampilkan 5 absensi terakhir berdasarkan tanggal terbaru.</p>
            <div class="table-responsive">
              <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                  <tr>
                    <th>No</th>
                    <?php if ($role !== 'peserta'): ?><th>Nama Peserta</th><?php endif; ?>
                    <th>Tanggal</th>
                    <th>Status</th>
                    <th>Keterangan</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  if ($qTable && mysqli_num_rows($qTable) > 0):
                    while ($row = mysqli_fetch_assoc($qTable)): ?>
                      <tr>
                        <td><?= $no++ ?></td>
                        <?php if ($role !== 'peserta'): ?><td><?= htmlspecialchars($row['participant_name'] ?? '-') ?></td><?php endif; ?>
                        <td><?= date('d-m-Y', strtotime($row['created_at'])) ?></td>
                        <td>
                          <span class="badge bg-<?=
                            (strtolower($row['status'])=='hadir')?'success':
                            ((strtolower($row['status'])=='izin')?'info':
                            ((strtolower($row['status'])=='sakit')?'warning':'secondary'))
                          ?>"><?= ucfirst($row['status']) ?></span>
                        </td>
                        <td><?= htmlspecialchars($row['note'] ?? '-') ?></td>
                      </tr>
                    <?php endwhile;
                  else: ?>
                    <tr><td colspan="<?= ($role!=='peserta')?5:4 ?>" class="text-muted">Belum ada data absensi.</td></tr>
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

<?php
include '../../partials/footer.php';
include '../../partials/script.php';
?>

<!-- Chart scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
  // Data dari PHP
  const totalHadir = <?= (int)$total_hadir ?>;
  const totalIzin  = <?= (int)$total_izin ?>;
  const totalSakit = <?= (int)$total_sakit ?>;
  const totalSemua = totalHadir + totalIzin + totalSakit;

  const monthlyData = <?= json_encode(array_values($monthlyJsArray)) ?>;
  const monthlyLabels = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];

  const warna = ['#28a745', '#17a2b8', '#ffc107'];

  // ====== Bar chart (Hadir/Izin/Sakit) ======
  const barCtx = document.getElementById('attendanceChart').getContext('2d');
  new Chart(barCtx, {
    type: 'bar',
    data: {
      labels: ['Hadir', 'Izin', 'Sakit'],
      datasets: [{
        data: [totalHadir, totalIzin, totalSakit],
        backgroundColor: warna,
        borderRadius: 6,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
        tooltip: {
          callbacks: {
            label: ctx => {
              const v = ctx.raw;
              const p = totalSemua ? ((v / totalSemua) * 100).toFixed(1) : 0;
              return `${ctx.label}: ${v} (${p}%)`;
            }
          }
        },
        datalabels: {
          color: '#000',
          anchor: 'end',
          align: 'top',
          font: { weight: 'bold', size: 12 },
          formatter: v => {
            const p = totalSemua ? ((v / totalSemua) * 100).toFixed(1) : 0;
            return `${v} (${p}%)`;
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { color: '#333' },
          grid: { color: 'rgba(0,0,0,0.05)' }
        },
        x: { ticks: { color: '#333' } }
      }
    },
    plugins: [ChartDataLabels]
  });

  // ====== Pie / Doughnut chart ======
  const pieEl = document.getElementById('pieChart');
  if (pieEl) {
    new Chart(pieEl.getContext('2d'), {
      type: 'doughnut',
      data: {
        labels: ['Hadir', 'Izin', 'Sakit'],
        datasets: [{
          data: [totalHadir, totalIzin, totalSakit],
          backgroundColor: warna,
          borderWidth: 2,
          hoverOffset: 8
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '70%',
        plugins: {
          legend: {
            position: 'bottom',
            labels: {
              color: '#333',
              generateLabels: (chart) => {
                const data = chart.data.datasets[0].data;
                return chart.data.labels.map((label, i) => {
                  const val = data[i];
                  const percent = totalSemua ? ((val / totalSemua) * 100).toFixed(1) : 0;
                  return {
                    text: `${label} (${percent}%)`,
                    fillStyle: warna[i],
                    strokeStyle: warna[i],
                    lineWidth: 2
                  };
                });
              }
            }
          },
          tooltip: {
            callbacks: {
              label: ctx => {
                const v = ctx.raw;
                const p = totalSemua ? ((v / totalSemua) * 100).toFixed(1) : 0;
                return `${ctx.label}: ${v} (${p}%)`;
              }
            }
          },
          datalabels: {
            color: '#fff',
            font: { weight: 'bold', size: 14 },
            formatter: (v) => `${totalSemua ? ((v / totalSemua) * 100).toFixed(1) : 0}%`
          }
        }
      },
      plugins: [ChartDataLabels]
    });
  }

  // ====== Line chart: Absensi per bulan (tahun berjalan) ======
  const monthlyCtx = document.getElementById('monthlyChart');
  if (!monthlyCtx) {
    // kalau belum ada elemen, buatnya (inject)
    const container = document.querySelector('.page-inner');
    const node = document.createElement('div');
    node.innerHTML = `
      <div class="row mt-4">
        <div class="col-md-12">
          <div class="card card-round chart-card">
            <div class="card-header card-header-gradient">
              <h6 class="mb-0"><i class="fas fa-chart-line me-2"></i> Tren Absensi per Bulan</h6>
            </div>
            <div class="card-body">
              <canvas id="monthlyChart"></canvas>
            </div>
          </div>
        </div>
      </div>
    `;
    container.appendChild(node);
  }

  const monthlyChartEl = document.getElementById('monthlyChart').getContext('2d');
  new Chart(monthlyChartEl, {
    type: 'line',
    data: {
      labels: monthlyLabels,
      datasets: [{
        label: 'Jumlah Absensi',
        data: monthlyData,
        borderColor: '#0077b6',
        backgroundColor: 'rgba(0,119,182,0.18)',
        fill: true,
        tension: 0.3,
        pointBackgroundColor: '#0077b6',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { position: 'top' },
        tooltip: { callbacks: { label: ctx => `Absensi: ${ctx.raw}` } }
      },
      scales: {
        y: { beginAtZero: true, ticks: { color: '#333' }, grid: { color: 'rgba(0,0,0,0.05)' } },
        x: { ticks: { color: '#333' } }
      }
    }
  });
</script>
