<?php


include "../config/connection.php";

// ambil kategori dari database
$qKategori = mysqli_query($connect, "SELECT * FROM kategori ORDER BY nama_kategori ASC");
?>

<!-- Bagian Pilih Kategori -->
<section class="my-5">
  <div class="container">
    <div class="text-center mb-4">
      <h5 class="fw-semibold">Pilih Kategori</h5>
    </div>

    <div class="kategori-container">
      <?php while ($kat = mysqli_fetch_assoc($qKategori)) { ?>
        <div class="kategori-item-wrapper">
          <a href="../frontend/produk_kategori.php?id=<?= $kat['id_kategori'] ?>" class="text-decoration-none kategori-item">
            <div class="kategori-bulat">
              <img src="../uploads/kategori/<?= htmlspecialchars($kat['gambar_kategori']) ?>" 
                   alt="<?= htmlspecialchars($kat['nama_kategori']) ?>"
                   onerror="this.src='../frontend/template-user/src/assets/images/category-default.jpg'">
            </div>
            <small class="kategori-nama"><?= htmlspecialchars($kat['nama_kategori']) ?></small>
          </a>
        </div>
      <?php } ?>
    </div>
  </div>
</section>

<style>
  /* Container untuk kategori */
  .kategori-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    align-items: center;
    gap: 2rem;
    padding: 0 1rem;
  }

  /* Wrapper untuk setiap item kategori */
  .kategori-item-wrapper {
    flex-shrink: 0;
    text-align: center;
  }

  /* Link kategori */
  .kategori-link {
    text-decoration: none;
    color: #212529;
    display: block;
  }

  /* Lingkaran kategori */
  .kategori-bulat {
    width: 80px;
    height: 80px;
    border-radius: 50%;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    background-color: #fff;
    transition: all 0.3s ease;
    border: 2px solid #f8f9fa;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin: 0 auto;
  }

  .kategori-bulat img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .kategori-bulat:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 10px rgba(0,0,0,0.15);
    border-color: #198754;
  }

  /* Nama kategori */
  .kategori-nama {
    display: block;
    margin-top: 0.5rem;
    font-weight: 500;
    color: #212529;
    transition: color 0.3s ease;
    font-size: 0.875rem;
    white-space: nowrap;
  }

  .kategori-link:hover .kategori-nama {
    color: #198754;
  }

  /* Container utama */
  .container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 1rem;
  }

  /* Section spacing */
  .my-5 {
    margin-top: 3rem;
    margin-bottom: 3rem;
  }

  /* Text center */
  .text-center {
    text-align: center;
  }

  /* Margin bottom */
  .mb-4 {
    margin-bottom: 1.5rem;
  }

  /* Font weight */
  .fw-semibold {
    font-weight: 600;
  }

  /* Responsive Design */
  @media (max-width: 1024px) {
    .kategori-container {
      gap: 1.5rem;
    }
  }

  @media (max-width: 768px) {
    .kategori-container {
      gap: 1.25rem;
    }
    
    .kategori-bulat {
      width: 70px;
      height: 70px;
    }
    
    .kategori-nama {
      font-size: 0.8rem;
    }
  }

  @media (max-width: 576px) {
    .kategori-container {
      gap: 1rem;
      padding: 0 0.5rem;
    }
    
    .kategori-bulat {
      width: 60px;
      height: 60px;
    }
    
    .kategori-nama {
      font-size: 0.75rem;
    }
    
    .my-5 {
      margin-top: 2rem;
      margin-bottom: 2rem;
    }
  }

  @media (max-width: 400px) {
    .kategori-container {
      gap: 0.75rem;
    }
    
    .kategori-bulat {
      width: 55px;
      height: 55px;
    }
    
    .kategori-nama {
      font-size: 0.7rem;
    }
  }
</style>