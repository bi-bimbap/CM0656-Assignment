<?php
require_once('controls.php');
echo makePageStart("Page Not Found");
echo makeHeader("Page Not Found");
?>

<img src="images/Error-404.png" />

<!-- Start footer  -->
<footer>
  <div class="container">
    <div>
      <div id='logo'><img src='images/logo.png'/>Ima's Official Fanbase</div>
    </div>
    <div class="middle">
      <div><i class="fa fa-envelope"></i> info@imamegastar.forum.com</div>
      <div><i class="fa fa-phone"></i> +6012-2151725</div>
    </div>
    <div>
      <i class="fa fa-facebook"></i>
      <i class="fa fa-instagram"></i>
      <i class="fa fa-google-plus"></i>
      <i class="fa fa-twitter"></i>
    </div>
  </div>
</footer>
<div class="powered">
  <div class="container">
    <span>2017&copy; Ima's Official Fanbase All rights reserved.</span>
    <a href="#">Private Policy</a>
    <a href="#">Terms of Use</a>
  </div>
</div>
<!-- End footer -->

<?php
echo makePageEnd();
?>
