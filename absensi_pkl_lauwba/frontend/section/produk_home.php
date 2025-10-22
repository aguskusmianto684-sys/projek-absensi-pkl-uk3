<?php
session_name("ecommerceUserSession");
session_start();

include "../config/connection.php"; // koneksi db

// Produk Pertanian (id_kategori = 2)
$qPertanian = mysqli_query($connect, "SELECT * FROM produk WHERE id_kategori = 2 ORDER BY id_produk ASC");

// Produk Peternakan (id_kategori = 1)
$qPeternakan = mysqli_query($connect, "SELECT * FROM produk WHERE id_kategori = 1 ORDER BY id_produk ASC");
?>

<!-- ================= PRODUK PERTANIAN ================= -->
<section class="mt-8">
  <div class="container mx-auto">
    <div class="flex flex-wrap">
      <div class="w-full">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Produk Pertanian</h2>
      </div>
    </div>

    <div class="swiper swiperPertanian">
      <div class="swiper-wrapper pb-12">

        <?php while ($row = mysqli_fetch_assoc($qPertanian)) { ?>
          <div class="swiper-slide">
            <a href="../frontend/produk.php?produk=<?= intval($row['id_produk']) ?>">
              <div class="relative rounded-lg border bg-white border-gray-200 shadow-sm hover:shadow-lg hover:border-green-600 transition duration-300">
                <div class="p-6 text-center">
                  <img src="../uploads/produk/<?= htmlspecialchars($row['gambar_produk']) ?>" 
                       alt="<?= htmlspecialchars($row['nama_produk']) ?>" 
                       class="mb-4 mx-auto h-28 object-contain" />

                  <div class="text-base font-semibold text-gray-800 mb-2 line-clamp-1">
                    <?= htmlspecialchars($row['nama_produk']) ?>
                  </div>

                  <div class="text-green-600 font-bold mb-1">
                    Rp <?= number_format($row['harga'], 0, ',', '.') ?>
                  </div>

                  <div class="text-sm <?= ($row['stok'] > 0 ? 'text-gray-600' : 'text-red-500 font-semibold') ?>">
                    <?= $row['stok'] > 0 ? 'Stok: ' . $row['stok'] : 'Stok Habis' ?>
                  </div>
                </div>
              </div>
            </a>
          </div>
        <?php } ?>

      </div>
      <div class="swiper-pagination mt-4"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </div>
</section>

<!-- ================= PRODUK PETERNAKAN ================= -->
<section class="mt-12">
  <div class="container mx-auto">
    <div class="flex flex-wrap">
      <div class="w-full">
        <h2 class="text-xl font-bold mb-6 text-gray-800">Produk Peternakan</h2>
      </div>
    </div>

    <div class="swiper swiperPeternakan">
      <div class="swiper-wrapper pb-12">

        <?php while ($row = mysqli_fetch_assoc($qPeternakan)) { ?>
          <div class="swiper-slide">
            <a href="../frontend/produk.php?produk=<?= intval($row['id_produk']) ?>">
              <div class="relative rounded-lg border bg-white border-gray-200 shadow-sm hover:shadow-lg hover:border-green-600 transition duration-300">
                <div class="p-6 text-center">
                  <img src="../uploads/produk/<?= htmlspecialchars($row['gambar_produk']) ?>" 
                       alt="<?= htmlspecialchars($row['nama_produk']) ?>" 
                       class="mb-4 mx-auto h-28 object-contain" />

                  <div class="text-base font-semibold text-gray-800 mb-2 line-clamp-1">
                    <?= htmlspecialchars($row['nama_produk']) ?>
                  </div>

                  <div class="text-green-600 font-bold mb-1">
                    Rp <?= number_format($row['harga'], 0, ',', '.') ?>
                  </div>

                  <div class="text-sm <?= ($row['stok'] > 0 ? 'text-gray-600' : 'text-red-500 font-semibold') ?>">
                    <?= $row['stok'] > 0 ? 'Stok: ' . $row['stok'] : 'Stok Habis' ?>
                  </div>
                </div>
              </div>
            </a>
          </div>
        <?php } ?>

      </div>
      <div class="swiper-pagination mt-4"></div>
      <div class="swiper-button-next"></div>
      <div class="swiper-button-prev"></div>
    </div>
  </div>
</section>

<!-- Swiper JS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
  // Swiper untuk Pertanian
  var swiperPertanian = new Swiper(".swiperPertanian", {
    slidesPerView: 2,
    spaceBetween: 20,
    loop: true,
    autoplay: { delay: 3000 },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      480: { slidesPerView: 2 },
      768: { slidesPerView: 3 },
      1024: { slidesPerView: 5 }
    }
  });

  // Swiper untuk Peternakan
  var swiperPeternakan = new Swiper(".swiperPeternakan", {
    slidesPerView: 2,
    spaceBetween: 20,
    loop: true,
    autoplay: { delay: 3000 },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    },
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    breakpoints: {
      480: { slidesPerView: 2 },
      768: { slidesPerView: 3 },
      1024: { slidesPerView: 5 }
    }
  });
</script>
