<?php
include '../../../config/connection.php';

if (isset($_POST['tombol'])) {
  // Ambil data dari form dan amankan input
  $user_id = mysqli_real_escape_string($connect, $_POST['user_id']);
  $department = mysqli_real_escape_string($connect, $_POST['department']);
  $phone = mysqli_real_escape_string($connect, $_POST['phone']);
  $note = mysqli_real_escape_string($connect, $_POST['note']);

  // Validasi wajib diisi
  if (empty($user_id) || empty($department) || empty($phone)) {
    echo "<script>
      alert('Harap isi semua field wajib!');
      window.location.href='../../pages/supervisors/create.php';
    </script>";
    exit;
  }

  // ✅ Query simpan ke tabel supervisors (tanpa updated_at)
  $query = "
    INSERT INTO supervisors (user_id, department, phone, note, created_at)
    VALUES ('$user_id', '$department', '$phone', '$note', NOW())
  ";

  $result = mysqli_query($connect, $query);

  if ($result) {
    echo "<script>
      alert('✅ Data pembimbing berhasil ditambahkan!');
      window.location.href='../../pages/supervisors/index.php';
    </script>";
  } else {
    echo "<script>
      alert('❌ Gagal menyimpan data: " . addslashes(mysqli_error($connect)) . "');
      window.location.href='../../pages/supervisors/create.php';
    </script>";
  }
}
?>
