<?php
// ini_set("session.save_path", ""); //TODO: Comment out
session_start();
include 'db/database_conn.php';
require_once('controls.php');
echo makePageStart("Forgot Password");
echo "<div class='wrapper'><div class='container'><div id='logo'><img src='images/logo.png'/>Ima's Official Fanbase</div>";
echo makeLoginLogoutBtn();
echo makeProfileButton();
echo makeNavMenu();
echo makeHeader("Forgot Password");
?>

<script src="scripts/jquery.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
<script src="scripts/parsley.min.js"></script>
<link rel="stylesheet" href="css/parsley.css" type="text/css" />
<link rel="stylesheet" href="css/stylesheet.css" type="text/css" />
<link href="css/bootstrap.css" rel="stylesheet">
<script src="scripts/bootstrap.min.js"></script>

<script>
$(document).ready(function() {
  $('#btnSearch').on('click', function(e) { //Send password reset url to member
    $("#formForgotPassword").parsley().validate(); //Trigger parsley js validation

    if ($("#formForgotPassword").parsley().isValid()) {
      var email = $("#txtEmail").val(); //Obtain entered email

      $.ajax({
        url :"forgotPassword_serverProcessing.php",
        type: "POST",
        data: "action=forgotPassword&email=" + email,
        success: function(data) {
          alert(data);
        }
      });
    }
  });
});
</script>

<div class="content">
  <div class="container">
    <form id='formForgotPassword' data-parsley-validate>
      <div>
        <p>Find Your Account: </p>
        <input type="text" placeholder="name@email.com" id="txtEmail" name="txtEmail" data-parsley-required="true" data-parsley-type="email" data-parsley-errors-messages-disabled>
      </div>

      <div id="button"><button type="button" id='btnSearch' name="btnSearch">Search</button></div>
    </form>
  </div>
</div>

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
