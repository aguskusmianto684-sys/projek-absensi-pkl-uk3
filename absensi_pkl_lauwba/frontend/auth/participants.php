<?php
session_name("absenPklSession");
session_start();
include "../../config/connection.php";
include '../partials/header.php';

// Ambil user_id dari register
$user_id = $_GET['user_id'] ?? 0;

// Validasi user_id
if (!$user_id || !is_numeric($user_id)) {
    echo "<script>alert('User ID tidak valid!'); window.location.href='../auth/register.php';</script>";
    exit;
}

// Ambil data user untuk validasi
$qUser = mysqli_query($connect, "SELECT * FROM users WHERE id = $user_id");
$user = mysqli_fetch_assoc($qUser);

// Jika user tidak ditemukan
if (!$user) {
    echo "<script>alert('User tidak ditemukan!'); window.location.href='../auth/register.php';</script>";
    exit;
}

// Cek apakah user sudah melengkapi data peserta
$qCheckParticipant = mysqli_query($connect, "SELECT * FROM participants WHERE user_id = $user_id");
if (mysqli_num_rows($qCheckParticipant) > 0) {
    echo "<script>
            alert('Data peserta sudah dilengkapi sebelumnya! Silakan login.');
            window.location.href='../auth/login.php';
          </script>";
    exit;
}

// ----------------------------
// PROSES SIMPAN DATA
// ----------------------------
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Sanitize input data
    $school         = mysqli_real_escape_string($connect, $_POST['school']);
    $program_study  = mysqli_real_escape_string($connect, $_POST['program_study']);
    $start_date     = mysqli_real_escape_string($connect, $_POST['start_date']);
    $end_date       = mysqli_real_escape_string($connect, $_POST['end_date']);
    $supervisor_id  = mysqli_real_escape_string($connect, $_POST['supervisor_id']);
    
    // Validasi tanggal
    if (strtotime($end_date) < strtotime($start_date)) {
        echo "<script>alert('Tanggal selesai tidak boleh sebelum tanggal mulai!');</script>";
    } else {
        // Ambil nama supervisor
        $qSupervisor = mysqli_query($connect, "SELECT full_name FROM users WHERE id = '$supervisor_id'");
        $supervisor = mysqli_fetch_assoc($qSupervisor);
        $supervisor_name = $supervisor['full_name'];
        
        $qInsert = "
            INSERT INTO participants (user_id, school, program_study, start_date, end_date, supervisor_name, supervisor_id, created_at)
            VALUES ('$user_id', '$school', '$program_study', '$start_date', '$end_date', '$supervisor_name', '$supervisor_id', NOW())
        ";

        if (mysqli_query($connect, $qInsert)) {
            echo "<script>
                    alert('Data peserta berhasil disimpan! Silakan login.');
                    window.location.href='../auth/login.php';
                  </script>";
            exit;
        } else {
            $error_msg = mysqli_error($connect);
            echo "<script>alert('Gagal menyimpan data: " . addslashes($error_msg) . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lengkapi Data Peserta - Sistem PKL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .card-header {
            background: #007bff;
            color: white;
            border-radius: 10px 10px 0 0 !important;
        }
        .btn-primary {
            background: #007bff;
            border: none;
        }
        .user-info {
            background: #e9ecef;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h4 class="mb-0">Lengkapi Data Peserta PKL</h4>
                </div>
                
                <div class="card-body">
                    <!-- Info User -->
                    <div class="user-info">
                        <h5>Informasi Akun</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Nama:</strong> <?= htmlspecialchars($user['full_name']) ?>
                            </div>
                            <div class="col-md-6">
                                <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?>
                            </div>
                        </div>
                    </div>
                    
                    <form method="POST" id="participantForm">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="school" class="form-label">Sekolah/Universitas <span class="text-danger">*</span></label>
                                <input type="text" name="school" id="school" class="form-control" placeholder="Contoh: SMKN 3 Banjar" required>
                            </div>
                            
                            <div class="col-md-12 mb-3">
                                <label for="program_study" class="form-label">Program Studi/Jurusan <span class="text-danger">*</span></label>
                                <input type="text" name="program_study" id="program_study" class="form-control" placeholder="Contoh: Rekayasa Perangkat Lunak" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="start_date" class="form-label">Tanggal Mulai PKL <span class="text-danger">*</span></label>
                                <input type="date" name="start_date" id="start_date" class="form-control" required>
                                <div class="form-text">Bisa memilih tanggal di masa lalu atau masa depan</div>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="end_date" class="form-label">Tanggal Selesai PKL <span class="text-danger">*</span></label>
                                <input type="date" name="end_date" id="end_date" class="form-control" required>
                            </div>
                            
                            <div class="col-md-12 mb-4">
                                <label for="supervisor_id" class="form-label">Pilih Pembimbing <span class="text-danger">*</span></label>
                                <select name="supervisor_id" id="supervisor_id" class="form-select" required>
                                    <option value="">-- Pilih Pembimbing --</option>
                                    <?php
                                    $qSup = mysqli_query($connect, "SELECT id, full_name FROM users WHERE role='pembimbing' AND status='aktif'");
                                    while ($s = mysqli_fetch_assoc($qSup)) {
                                        echo "<option value='{$s['id']}'>{$s['full_name']}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Simpan Data Peserta
                            </button>
                            <a href="../auth/login.php" class="btn btn-outline-secondary">
                                Kembali ke Login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Validasi form - Hanya cek tanggal selesai tidak sebelum tanggal mulai
    document.getElementById('participantForm').addEventListener('submit', function(e) {
        const startDate = new Date(document.getElementById('start_date').value);
        const endDate = new Date(document.getElementById('end_date').value);
        
        if (endDate < startDate) {
            e.preventDefault();
            alert('Tanggal selesai tidak boleh sebelum tanggal mulai!');
            document.getElementById('end_date').focus();
        }
    });
    
    // Set min date untuk end_date berdasarkan start_date (tanpa batasan start_date)
    document.getElementById('start_date').addEventListener('change', function() {
        document.getElementById('end_date').min = this.value;
    });
</script>
</body>
</html>