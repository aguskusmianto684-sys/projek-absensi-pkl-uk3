<?php
require __DIR__ . '/config/notification.php';

// Tes kirim email
$email = sendEmail('target@gmail.com', 'Tes Sistem Absensi', '<b>Halo!</b> Ini pesan dari sistem.');
var_dump($email);

// Tes kirim WA
$wa = sendWhatsApp('628xxxxxxxxxx', 'Halo, ini pesan otomatis dari sistem absensi.');
var_dump($wa);
