<?php
include '../../../config/connection.php';
include '../../../config/logActivity.php'; // ✅ Catat aktivitas user
session_start();

$id = $_POST['id'] ?? null;
$status = $_POST['status'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;

if (!$id) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "ID tidak valid"]);
    exit;
}

if (!in_array($status, ['aktif', 'nonaktif'])) {
    http_response_code(400);
    echo json_encode(["success" => false, "message" => "Status tidak valid"]);
    exit;
}

// 🔹 Jalankan update status
$q = "
  UPDATE users 
  SET status='$status', updated_at=NOW() 
  WHERE id='$id'
";

$res = mysqli_query($connect, $q);

if ($res) {
    // ✅ Catat log aktivitas hanya kalau user login
    if ($user_id) {
        $desc = "Mengubah status user ID: $id menjadi '$status'";
        logActivity($connect, $user_id, 'Update Status', $desc);
    }

    echo json_encode([
        "success" => true,
        "status" => $status,
        "message" => $status === 'aktif' 
            ? "✅ User berhasil diaktifkan!" 
            : "⚠️ User berhasil dinonaktifkan!"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "❌ Gagal memperbarui status: " . mysqli_error($connect)
    ]);
}
?>
