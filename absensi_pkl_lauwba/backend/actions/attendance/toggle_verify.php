<?php
ob_start();
header('Content-Type: application/json'); // ✅ supaya fetch() bisa baca JSON
session_start();

include '../../../config/connection.php';
include '../../../config/logActivity.php';
include '../../../config/notification.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$id = $_POST['id'] ?? null;
$verified = $_POST['verified'] ?? null;
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'] ?? null;

if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'ID tidak valid']);
    exit;
}

// 🔹 Ambil data peserta & pembimbing
$qInfo = "
    SELECT 
        a.id,
        u.full_name AS nama_peserta,
        u.email AS email_peserta,
        u.phone AS phone_peserta,
        sp.full_name AS nama_pembimbing,
        sp.email AS email_pembimbing,
        sp.phone AS phone_pembimbing
    FROM attendance a
    LEFT JOIN participants p ON a.participant_id = p.id
    LEFT JOIN users u ON p.user_id = u.id
    LEFT JOIN users sp ON p.supervisor_id = sp.id
    WHERE a.id = '$id'
";
$data = mysqli_fetch_assoc(mysqli_query($connect, $qInfo));

if (!$data) {
    echo json_encode(['status' => 'error', 'message' => 'Data peserta tidak ditemukan']);
    exit;
}

// 🔹 Cek status lama untuk mencegah spam
$qCheck = mysqli_query($connect, "SELECT verified_by FROM attendance WHERE id='$id'");
$before = mysqli_fetch_assoc($qCheck);

if ($verified == 1 && !empty($before['verified_by'])) {
    echo json_encode(['status' => 'info', 'message' => 'Data sudah diverifikasi sebelumnya.']);
    exit;
}
if ($verified == 0 && empty($before['verified_by'])) {
    echo json_encode(['status' => 'info', 'message' => 'Data belum diverifikasi, tidak ada perubahan.']);
    exit;
}

// 🔹 Update status verifikasi
if ($verified == 1) {
    $q = "UPDATE attendance SET verified_by='$user_id', verified_at=NOW() WHERE id='$id'";
    $aksi = 'Verifikasi';
    $desc = "Memverifikasi data absensi ID: $id";
} else {
    $q = "UPDATE attendance SET verified_by=NULL, verified_at=NULL WHERE id='$id'";
    $aksi = 'Batalkan Verifikasi';
    $desc = "Membatalkan verifikasi absensi ID: $id";
}

$res = mysqli_query($connect, $q);

if ($res) {
    logActivity($connect, $user_id, $aksi, $desc);

    if ($verified == 1) {
        // === Notif diverifikasi ===
        $subject = "Absensi Diverifikasi oleh Pembimbing";
        $body = "
            <b>Halo {$data['nama_peserta']},</b><br>
            Absensi kamu telah <b>diverifikasi</b> oleh pembimbing <b>{$data['nama_pembimbing']}</b>.<br>
            Silakan cek dashboard sistem absensi.<br><br>
            <i>Pesan otomatis dari Sistem Absensi PKL Lauwba.</i>
        ";
        $msg_wa = "Halo {$data['nama_peserta']}, absensi kamu telah diverifikasi oleh pembimbing {$data['nama_pembimbing']}. - Sistem Absensi PKL Lauwba";

        if (!empty($data['email_peserta'])) sendEmail($data['email_peserta'], $subject, $body);
        if (!empty($data['phone_peserta'])) sendWhatsApp($data['phone_peserta'], $msg_wa);

        echo json_encode(['status' => 'success', 'message' => '✅ Absensi berhasil diverifikasi & notifikasi dikirim.']);
    } else {
        // === Notif dibatalkan ===
        $subject = "Verifikasi Absensi Dibatalkan";
        $body = "
            <b>Halo {$data['nama_peserta']},</b><br>
            Verifikasi absensi kamu telah <b>dibatalkan</b> oleh pembimbing <b>{$data['nama_pembimbing']}</b>.<br>
            Silakan hubungi pembimbing jika ada kesalahan.<br><br>
            <i>Pesan otomatis dari Sistem Absensi PKL Lauwba.</i>
        ";
        $msg_wa = "Halo {$data['nama_peserta']}, verifikasi absensi kamu dibatalkan oleh pembimbing {$data['nama_pembimbing']}. - Sistem Absensi PKL Lauwba";

        if (!empty($data['email_peserta'])) sendEmail($data['email_peserta'], $subject, $body);
        if (!empty($data['phone_peserta'])) sendWhatsApp($data['phone_peserta'], $msg_wa);

        echo json_encode(['status' => 'warning', 'message' => '⚠️ Verifikasi dibatalkan & notifikasi dikirim.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal memperbarui data: ' . mysqli_error($connect)]);
}

ob_end_clean();
exit;
?>
