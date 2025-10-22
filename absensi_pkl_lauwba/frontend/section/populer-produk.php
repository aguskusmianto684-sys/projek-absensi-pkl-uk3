<?php


include "../config/connection.php"; // koneksi ke database

// Ambil semua produk (misal 10 teratas)
$qProduk = mysqli_query($connect, "SELECT * FROM produk ORDER BY id_produk DESC LIMIT 10");

$qProduk = mysqli_query($connect, "
  SELECT p.*, 
         k.nama_kategori,
         COALESCE(AVG(u.rating), 0) AS rata_rating,
         COUNT(u.id_ulasan) AS total_ulasan
  FROM produk p
  LEFT JOIN ulasan u ON p.id_produk = u.id_produk
  LEFT JOIN kategori k ON p.id_kategori = k.id_kategori
  GROUP BY p.id_produk
  ORDER BY p.id_produk DESC
  LIMIT 10
");
?>

<section id="produk" class="lg:my-14 my-8">
  <div class="container">
    <div class="flex flex-wrap">
      <div class="w-full mb-6">
        <h2 class="text-lg font-bold text-gray-800">Produk Populer</h2>
      </div>
    </div>

       <div class="grid gap-4 grid-cols-1 md:grid-cols-2 lg:gap-4 xl:grid-cols-5">
      <?php while ($row = mysqli_fetch_assoc($qProduk)) { ?>
        <div class="relative rounded-lg break-words border bg-white border-gray-300 card-product hover:shadow-lg transition cursor-pointer"
             onclick="window.location.href='../frontend/produk.php?produk=<?= intval($row['id_produk']) ?>'">
          <div class="flex-auto p-4">
            <div class="text-center relative flex justify-center">
              <?php if (!empty($row['diskon'])) { ?>
                <div class="absolute top-0 left-0">
                  <span class="inline-block p-1 text-center font-semibold text-sm rounded bg-red-600 text-white">
                    <?= intval($row['diskon']) ?>%
                  </span>
                </div>
              <?php } ?>

              <a href="../frontend/produk.php?produk=<?= intval($row['id_produk']) ?>">
                <img src="../uploads/produk/<?= htmlspecialchars($row['gambar_produk']) ?>" 
                     alt="<?= htmlspecialchars($row['nama_produk']) ?>" 
                     class="w-full h-48 object-cover rounded-md" />
              </a>

              <div class="absolute w-full bottom-[15%] opacity-0 invisible card-product-action transition-all duration-300">
                <a href="../frontend/produk.php?produk=<?= intval($row['id_produk']) ?>"
                  class="h-[34px] w-[34px] shadow inline-flex items-center justify-center rounded-lg  hover:text-white"
                  title="Quick View">

                </a>
              </div>
            </div>

            <div class="flex flex-col gap-3 mt-3">
           <a href="../frontend/produk.php?produk=<?= intval($row['id_produk']) ?>" class="text-gray-500 text-sm">
  <small><?= htmlspecialchars($row['nama_kategori'] ?? 'Tidak ada kategori') ?></small>
</a>

              <h3 class="text-base truncate font-semibold">
                <a href="../frontend/produk.php?produk=<?= intval($row['id_produk']) ?>" 
                   class="hover:text-green-600">
                   <?= htmlspecialchars($row['nama_produk']) ?>
                </a>
              </h3>
<div class="flex items-center gap-1 text-yellow-500 text-sm" title="Rating <?= number_format($row['rata_rating'], 1) ?> / 5">
  <?php 
  $rating = round($row['rata_rating']);
  for ($i = 1; $i <= 5; $i++) {
      echo $i <= $rating 
          ? '<i class="fa-solid fa-star"></i>' 
          : '<i class="fa-regular fa-star"></i>';
  }
  ?>
  <span class="text-gray-700 text-xs ml-3">
    <?= number_format($row['rata_rating'], 1) ?> (<?= $row['total_ulasan'] ?>)
  </span>
</div>

              <div class="flex justify-between items-center mt-2">
                <div>
                  <span class="text-gray-900 font-semibold">Rp<?= number_format($row['harga'], 0, ',', '.') ?></span>
                  <?php if (!empty($row['harga_asli']) && $row['harga_asli'] > $row['harga']) { ?>
                    <span class="line-through text-gray-500 ml-1">
                      Rp<?= number_format($row['harga_asli'], 0, ',', '.') ?>
                    </span>
                  <?php } ?>
                </div>
                <div>
                <!-- Tombol Add -->
<button class="btn btn-success btn-add" data-id="1" data-nama="Sawi Hijau" data-harga="5500" data-img="sawi.jpg">
    <i class="bi bi-plus-lg"></i>
</button>
                </div>

<!-- Modal Popup -->
<div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content rounded-4">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="productModalLabel">Detail Produk</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body text-center">
        <img id="productImg" src="" class="img-fluid rounded mb-3" style="max-height:150px;">
        <h5 id="productName"></h5>
        <p class="text-success fw-bold">Rp<span id="productPrice"></span></p>

        <div class="my-3">
          <label class="form-label">Pilih varian</label>
          <select class="form-select" id="variantSelect">
            <option>250 g</option>
            <option>1 Kg</option>
          </select>
        </div>

        <div class="d-flex justify-content-center align-items-center mb-3">
          <button class="btn btn-outline-secondary" id="minusBtn">-</button>
          <input type="number" id="qtyInput" class="form-control mx-2 text-center" value="1" min="1" style="width:60px;">
          <button class="btn btn-outline-secondary" id="plusBtn">+</button>
        </div>

        <button class="btn btn-success w-100" id="addToCartBtn">Tambah ke Keranjang</button>
      </div>
    </div>
  </div>
</div>

              </div>
            </div>
          </div>
        </div>
      <?php } ?>
    </div>
  </div>
</section>



