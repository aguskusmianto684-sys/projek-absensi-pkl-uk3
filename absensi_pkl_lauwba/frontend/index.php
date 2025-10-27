<?php 
session_name("absenPklSession");
 include './partials/header.php';
 
?>
<body>

  <!--====== NAVBAR NINE PART START ======-->

 <?php 
 include './partials/navbar.php';
 
?>

  <!--====== NAVBAR NINE PART ENDS ======-->

  <!--====== SIDEBAR PART START ======-->

<?php 

 include './partials/sidebar.php';
 
?>
  <div class="overlay-left"></div>

  <!--====== SIDEBAR PART ENDS ======-->

  <!-- Start header Area -->
<?php include './section/home.php'; ?>
<!-- End header Area -->

<!--====== ABOUT FIVE PART START ======-->

<?php include './section/about.php'; ?>


<!--====== ABOUT FIVE PART ENDS ======-->

<?php include './section/absen.php'; ?>
  <!-- ===== service-area start ===== -->
 





  <!-- ========================= map-section end ========================= -->
  <section class="map-section map-style-9">
    <div class="map-container">
      <object style="border:0; height: 500px; width: 100%;"
        data="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.9574756982042!2d110.31926073099586!3d-7.794327320861191!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e7a5765d4d95351%3A0x5175f045ca1816c!2sPT%20Lauwba%20Techno%20Indonesia!5e0!3m2!1sid!2sid!4v1761547542396!5m2!1sid!2sid" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></object>
    </div>
    </div>
  </section>
  <!-- ========================= map-section end ========================= -->
   

  <!-- Start Footer Area -->
  <?php 

 include './partials/footer.php';
 
?>


  <!--/ End Footer Area -->

	

  <a href="#" class="scroll-top btn-hover">
    <i class="lni lni-chevron-up"></i>
  </a>

 <?php 

 include './partials/script.php';
 
?>
</body>

</html>