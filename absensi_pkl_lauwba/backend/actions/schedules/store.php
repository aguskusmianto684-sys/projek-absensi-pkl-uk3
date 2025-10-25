<?php
include '../../app.php'; // koneksi $connect & fungsi escapeString()
include '../../../config/logActivity.php';
include '../../../config/notification.php'; // ✅ tambahkan file notifikasi
session_start();

if (isset($_POST['tombol'])) {
    // Ambil data dari form
    $date = escapeString($_POST['date']);
    $expected_in = escapeString($_POST['expected_in']);
    $expected_out = escapeString($_POST['expected_out']);
    $description = escapeString($_POST['description']);

    // Validasi input wajib
    if (empty($date) || empty($expected_in) || empty($expected_out) || empty($description)) {
        echo "<script>
            alert('⚠️ Harap isi semua field wajib!');
            window.location.href='../../pages/schedules/create.php';
        </script>";
        exit;
    }

    // Query insert jadwal
    $qInsert = "INSERT INTO schedules 
        (date, expected_in, expected_out, description, created_at) 
        VALUES ('$date', '$expected_in', '$expected_out', '$description', NOW())";

    $res = mysqli_query($connect, $qInsert);

    if ($res) {
        $last_id = mysqli_insert_id($connect);

        // ✅ Log aktivitas admin
        if (isset($_SESSION['user_id'])) {
            $desc = "Menambahkan jadwal baru (ID: $last_id) — Tanggal: $date, Masuk: $expected_in, Pulang: $expected_out, Keterangan: $description";
            logActivity($connect, $_SESSION['user_id'], 'Tambah', $desc);
        }

        // ✅ Kirim notifikasi ke semua peserta aktif
        $qUsers = "SELECT * FROM users WHERE role='peserta' AND status='aktif'";
        $resUsers = mysqli_query($connect, $qUsers);

        while ($user = mysqli_fetch_assoc($resUsers)) {
            $message = "Halo {$user['full_name']}!\nJadwal baru telah ditambahkan:\n📅 Tanggal: $date\n🕒 Masuk: $expected_in\n🏠 Pulang: $expected_out\n📝 $description";

            // 1️⃣ Simpan ke tabel notifications
            mysqli_query($connect, "INSERT INTO notifications (user_id, message, type)
                                    VALUES ('{$user['id']}', '".addslashes($message)."', 'info')");

            // 2️⃣ Kirim Email (jika user punya email)
            if (!empty($user['email'])) {
                sendEmail(
                    $user['email'],
                    "Jadwal Baru Telah Diumumkan",
                    nl2br($message)
                );
            }

            // 3️⃣ Kirim WhatsApp (jika user punya nomor WA)
            if (!empty($user['phone'])) { // pastikan kolom phone ada
                sendWhatsApp($user['phone'], $message);
            }
        }

        echo "<script>
            alert('✅ Jadwal berhasil ditambahkan dan notifikasi dikirim!');
            window.location.href='../../pages/schedules/index.php';
        </script>";
        exit;
    } else {
        echo "<script>
            alert('❌ Gagal menyimpan jadwal: " . addslashes(mysqli_error($connect)) . "');
            window.location.href='../../pages/schedules/create.php';
        </script>";
        exit;
    }
}
?>
