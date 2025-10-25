<?php
date_default_timezone_set('Asia/Jakarta');

// ============================================================
// 🔧 AUTLOAD COMPOSER (PHPMailer)
// ============================================================
$autoload1 = __DIR__ . '/../vendor/autoload.php';
$autoload2 = __DIR__ . '/../../vendor/autoload.php';
if (file_exists($autoload1)) {
    require $autoload1;
    error_log("[NOTIFY] ✅ Autoload ditemukan di $autoload1");
} elseif (file_exists($autoload2)) {
    require $autoload2;
    error_log("[NOTIFY] ✅ Autoload ditemukan di $autoload2");
} else {
    error_log("[NOTIFY] ⚠️ Autoload PHPMailer tidak ditemukan! Jalankan: composer install");
}

// ============================================================
// 📦 IMPORT CLASS PHPMailer
// ============================================================
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// ============================================================
// 🧩 FUNGSI LOGGING INTERNAL
// ============================================================
function dbg_log($msg)
{
    error_log("[NOTIFY] " . $msg);
}

// ============================================================
// 📧 KONFIGURASI EMAIL (GMAIL SMTP)
// ============================================================
// ⚠️ Ganti data di bawah ini sesuai akun Gmail kamu
define('MAIL_HOST', 'smtp.gmail.com');
define('MAIL_USERNAME', 'aguskusmianto684@gmail.com');   // alamat Gmail kamu
define('MAIL_PASSWORD', 'zfvk bsdw qszh yhjn');          // ini App Password Gmail kamu
define('MAIL_FROM', 'aguskusmianto684@gmail.com');       // sama dengan MAIL_USERNAME
define('MAIL_FROM_NAME', 'Sistem Absensi');




// ============================================================
// 💬 KONFIGURASI FONNTE (WHATSAPP)
// ============================================================
// ⚠️ Ganti dengan token dari dashboard Fonnte kamu
define('FONNTE_TOKEN', 'YOUR_FONNTE_TOKEN');

// ============================================================
// 📨 FUNGSI KIRIM EMAIL (PHPMailer)
// ============================================================
function sendEmail($to, $subject, $body, $debug = false)
{
    if (empty(MAIL_USERNAME) || empty(MAIL_PASSWORD)) {
        dbg_log("sendEmail: Konfigurasi email belum diisi!");
        return ['ok' => false, 'error' => 'Mail config missing'];
    }

    try {
        $mail = new PHPMailer(true);

        $mail->isSMTP();
        $mail->Host       = MAIL_HOST;
        $mail->SMTPAuth   = true;
        $mail->Username   = MAIL_USERNAME;
        $mail->Password   = MAIL_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;
        $mail->CharSet    = 'UTF-8';

        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        $mail->addAddress($to);

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        $mail->send();

        dbg_log("✅ Email terkirim ke $to dengan subjek '$subject'");
        return ['ok' => true];
    } catch (\PHPMailer\PHPMailer\Exception $e) {
        $err = $e->getMessage();
        dbg_log("❌ PHPMailer Error ($to): $err");
        return ['ok' => false, 'error' => $err];
    } catch (\Exception $e) {
        $err = $e->getMessage();
        dbg_log("❌ General Error ($to): $err");
        return ['ok' => false, 'error' => $err];
    }
}

// ============================================================
// 💬 FUNGSI KIRIM WHATSAPP (FONNTE API)
// ============================================================
function sendWhatsApp($target, $message, $debug = false)
{
    if (empty(FONNTE_TOKEN)) {
        dbg_log("sendWhatsApp: Token Fonnte belum diisi!");
        return ['ok' => false, 'error' => 'Fonnte token missing'];
    }

    if (empty($target)) {
        dbg_log("sendWhatsApp: Nomor tujuan kosong!");
        return ['ok' => false, 'error' => 'Target empty'];
    }

    // Bersihkan nomor jadi format angka saja
    $clean = preg_replace('/[^0-9]/', '', $target);
    if (strlen($clean) < 9) {
        dbg_log("sendWhatsApp: Nomor tidak valid ($target)");
        return ['ok' => false, 'error' => 'Invalid phone number'];
    }

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL => "https://api.fonnte.com/send",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => [
            'target' => $clean,
            'message' => $message,
        ],
        CURLOPT_HTTPHEADER => [
            "Authorization: " . FONNTE_TOKEN
        ],
        CURLOPT_TIMEOUT => 30,
    ]);

    $resp = curl_exec($ch);
    $errNo = curl_errno($ch);
    $errMsg = curl_error($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    dbg_log("WA Log: to=$clean | HTTP=$httpCode | curl_errno=$errNo | resp=" . substr($resp ?? '', 0, 300));

    if ($errNo !== 0) {
        return ['ok' => false, 'error' => $errMsg];
    }

    $json = json_decode($resp, true);
    if (json_last_error() === JSON_ERROR_NONE && isset($json['success'])) {
        if ($json['success']) {
            dbg_log("✅ Pesan WhatsApp berhasil dikirim ke $clean");
            return ['ok' => true, 'resp' => $json];
        }
        dbg_log("❌ Fonnte Response: " . json_encode($json));
        return ['ok' => false, 'resp' => $json];
    }

    if ($httpCode >= 200 && $httpCode < 300) {
        dbg_log("✅ Pesan WA dikirim (non-JSON response)");
        return ['ok' => true, 'raw' => $resp];
    }

    dbg_log("❌ sendWhatsApp gagal ($clean) - HTTP: $httpCode");
    return ['ok' => false];
}
