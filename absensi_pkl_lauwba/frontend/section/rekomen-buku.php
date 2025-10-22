<?php
session_name("ecommerceUserSession");
session_start();

include '../config/connection.php';

$qBuku = "SELECT * FROM buku ORDER BY BukuID DESC LIMIT 4"; 
$resBuku = mysqli_query($connect, $qBuku) or die("SQL ERROR: " . mysqli_error($connect));
?>

<section id="home" class="mb-5">
<div class="container-fluid p-0 wow fadeIn" data-wow-delay="0.1s">
    <div class="owl-carousel header-carousel py-5">
        <?php while ($buku = mysqli_fetch_assoc($resBuku)) { ?>
            <div class="container py-5">
                <div class="row g-5 align-items-center">
                    <!-- Teks -->
                    <div class="col-lg-6">
                        <div class="carousel-text">
                            <h1 class="display-1 text-uppercase mb-3">
                                <?= htmlspecialchars($buku['Judul']) ?>
                            </h1>
                            <p class="fs-5 mb-5">
                                <?= substr($buku['deskripsi'], 0, 150) ?>...
                            </p>
                            <div class="d-flex">
                                <a class="btn btn-primary py-3 px-4 me-3" 
                                   href="detail-buku.php?id=<?= $buku['BukuID'] ?>">Lihat Detail</a>
                                <a class="btn btn-secondary py-3 px-4" 
                                   href="semua-ulasan.php?id=<?= $buku['BukuID'] ?>"> Semua Ulasan</a>
                            </div>
                        </div>
                    </div>
                    <!-- Gambar -->
                    <div class="col-lg-6">
                        <div class="carousel-img text-center">
                            <img class="img-fluid rounded shadow-sm"
                                 src="../uploads/cover/<?= htmlspecialchars($buku['cover']) ?>"
                                 alt="<?= htmlspecialchars($buku['Judul']) ?>" style="max-height: 400px; object-fit: contain;">
                        </div>
                        
  
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
</section>