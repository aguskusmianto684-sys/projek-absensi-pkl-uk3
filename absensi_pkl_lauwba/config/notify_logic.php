<?php
include_once __DIR__ . '/notification.php';

function sendNotification($toEmail, $toPhone, $subject, $message)
{
    sendEmail($toEmail, $subject, $message);
    sendWhatsApp($toPhone, $message);
}

function notifyPesertaAbsensiDiverifikasi($connect, $attendance_id)
{
    $sql = "
        SELECT 
            u.full_name AS nama_peserta,
            u.email AS email_peserta,
            u.phone AS phone_peserta,
            pb.full_name AS nama_pembimbing
        FROM attendance a
        JOIN participants p ON a.participant_id = p.id
        JOIN users u ON p.user_id = u.id
        JOIN supervisors s ON p.supervisor_id = s.id
        JOIN users pb ON s.user_id = pb.id
        WHERE a.id = '$attendance_id'
    ";

    $res = mysqli_query($connect, $sql);
    if (!$res || mysqli_num_rows($res) == 0) {
        error_log("[NOTIFY] Tidak ditemukan data peserta untuk attendance_id=$attendance_id");
        return;
    }

    $data = mysqli_fetch_assoc($res);

    $subject = "Absensi Telah Diverifikasi";
    $message = "Halo {$data['nama_peserta']}, absensi kamu telah diverifikasi oleh {$data['nama_pembimbing']} pada " . date('d-m-Y H:i');

    sendNotification($data['email_peserta'], $data['phone_peserta'], $subject, $message);
}
?>
