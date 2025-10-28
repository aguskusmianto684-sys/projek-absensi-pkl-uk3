<?php
require __DIR__ . '/config/notification.php';

// Tes kirim email
$email = sendEmail(
    'aguskusmianto684@gmail.com', // ganti dengan email tujuan
    'Tes Sistem Absensi',
    '<b>Halo!</b> Ini pesan dari sistem absensi.'
);
var_dump($email);

// Tes kirim WA (format internasional TANPA tanda +)
$wa = sendWhatsApp(
    '6285294035095', // ✅ ganti dengan nomor WhatsApp aktif kamu
    'Halo, ini pesan otomatis dari sistem absensi.'
);
var_dump($wa);
