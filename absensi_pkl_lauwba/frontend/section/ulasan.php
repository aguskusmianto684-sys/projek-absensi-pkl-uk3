<?php
session_name("ecommerceUserSession");
session_start();
?>
<!-- Section Ulasan Terbaru -->
<section id="reviews" class="py-5 bg-light">
  <div class="container">
    <h2 class="text-center mb-4">💬 Ulasan Terbaru</h2>
    <div class="row">
      <?php
      $qUlasan = "
        SELECT ub.*, b.Judul, us.NamaLengkap 
        FROM ulasanbuku ub
        JOIN buku b ON ub.BukuID = b.BukuID
        JOIN user us ON ub.UserID = us.UserID
        ORDER BY ub.UlasanID DESC LIMIT 4
      ";
      $resUlasan = mysqli_query($connect, $qUlasan);
      if (mysqli_num_rows($resUlasan) == 0): ?>
        <p class="text-center text-muted">Belum ada ulasan yang masuk.</p>
      <?php else:
        while ($ul = mysqli_fetch_assoc($resUlasan)):
          $stars = round($ul['rating'] / 20); // 0–100 → 0–5
      ?>
          <div class="col-md-6 mb-4">
            <div class="card h-100 shadow-sm">
              <div class="card-body">
                <h5 class="card-title">📖 <?= htmlspecialchars($ul['Judul']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted">oleh <?= htmlspecialchars($ul['NamaLengkap']) ?></h6>
                
                <!-- Rating bintang -->
                <p class="mb-1">
                  <?php 
                    for($i=1;$i<=5;$i++){
                      if($i <= $stars){
                        echo '<span style="color:#FFD700; font-size:1.2em;">★</span>';
                      } else {
                        echo '<span style="color:#ccc; font-size:1.2em;">★</span>';
                      }
                    }
                  ?>
                </p>

                <p class="card-text"><?= nl2br(htmlspecialchars($ul['Ulasan'])) ?></p>
              </div>
            </div>
          </div>
      <?php endwhile; endif; ?>
    </div>
    <div class="text-center mt-3">
      <a href="semua-ulasan.php" class="btn btn-outline-primary">Lihat Semua Ulasan</a>
    </div>
  </div>
</section>
