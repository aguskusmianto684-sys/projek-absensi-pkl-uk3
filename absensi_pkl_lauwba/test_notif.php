<?php
require __DIR__ . '/config/notification.php';

// Tes kirim WA (format internasional TANPA tanda +)
$wa = sendWhatsApp(
    '6285294035095', // ✅ ganti dengan nomor WhatsApp aktif kamu
    'Halo, ini pesan otomatis dari sistem absensi.'
);
var_dump($wa);
