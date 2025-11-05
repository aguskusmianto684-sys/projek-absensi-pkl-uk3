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
  
<?php include './section/lokasi.php'; ?>
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