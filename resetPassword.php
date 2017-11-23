<!-- Note: NO NAV BAR HERE -->

<?php
// ini_set("session.save_path", ""); //TODO: Comment out
session_start();
include 'db/database_conn.php';
include_once 'config.php';
require_once('controls.php');
require_once('functions.php');
echo makePageStart("Reset Password");
echo "<div class='wrapper'><div class='container'><div id='logo'><img src='images/logo.png'/>Ima's Official Fanbase</div>";
echo makeHeader("Reset Password");
$environment = WEB; //TODO: Change to WEB
?>

<?php
if (isset($_GET['mail']) && isset($_GET['exDate'])) { //Get email address & reset password expiry date
  //Decode url-encoded string
  $emailAddr = urldecode(base64_decode($_GET['mail']));
  $expiryDate = urldecode($_GET['exDate']);

  //Trim white space
  $emailAddr = trim($emailAddr);
  $expiryDate = trim($expiryDate);

  //Sanitize url parameters
  $emailAddr = filter_var($emailAddr, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $expiryDate = filter_var($expiryDate, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

  $expiryDate = date('Y-m-d H:i:s', strtotime($expiryDate)); //Convert string to date time

  $membershipSQL = "SELECT memberConfirmationExpiryDate FROM user WHERE emailAddr = ? AND userStatus = 'active'";
  $stmt = mysqli_prepare($conn, $membershipSQL) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmt, "s", $emailAddr);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $memberConfirmationExpiryDate);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

  if ($memberConfirmationExpiryDate != "" || $memberConfirmationExpiryDate != NULL) { //Member requested to reset password
    if (date('Y-m-d H:i:s') > $expiryDate) { //Link expired; Redirect to error page
      //Remove member confirmation expiry date
      $updateDateSQL = "UPDATE user SET memberConfirmationExpiryDate = NULL WHERE emailAddr = ?";
      $stmt = mysqli_prepare($conn, $updateDateSQL);
      mysqli_stmt_bind_param($stmt, "s", $emailAddr);
      mysqli_stmt_execute($stmt);

      if (mysqli_stmt_affected_rows($stmt) > 0) { //Update successful
        header("Location:error404.php");
      }
    }
    else { //Link is still valid; Reset password
      echo "<label id='lblEmail' hidden>$emailAddr</label>"; //For jQuery to obtain value for Ajax
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
      <script src='scripts/jquery-ui.min.js'></script>
      <script src="scripts/bootstrap.min.js"></script>

      <script>
      $(document).ready(function() {
        $('#btnSave').on('click', function(e) { //Send password reset url to member

          $("#formResetPassword").parsley().validate(); //Trigger parsley js validation

          if ($("#formResetPassword").parsley().isValid()) {
            var password = $("#txtPassword").val();
            var email = $("#lblEmail").text();

            $.ajax({
              url : "forgotPassword_serverProcessing.php",
              type: "POST",
              data: "action=resetPassword&email=" + email + "&password=" + password,
              success: function(data) {
                var dataString = data;
                var firstChar  = dataString.charAt(0);
                var message    = dataString.slice(1);

                alert(message);

                if (firstChar == "1") { //Password updated; Redirect to login page
                  window.location.href = "loginForm.php";
                }
              }
            });
          }
        });
      });
    </script>

    <div class="content">
      <div class="container">
        <form id='formResetPassword' method='POST' data-parsley-validate>
          <div>
            <p>Enter Your New Password: </p>
            <input type="password" id="txtPassword" name="txtPassword" data-toggle="tooltip" data-placement="right" title="Min. 5 characters" data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-equalto="#txtConfirmPassword" data-parsley-minlength="5" maxlength="60">
          </div>

          <div>
            <p>Enter Your New Password Again: </p>
            <input type="password" id="txtConfirmPassword" name="txtConfirmPassword" data-toggle="tooltip" data-placement="right" title="Min. 5 characters" data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-equalto="#txtPassword" data-parsley-minlength="5" maxlength="60">
          </div>

          <div id="button"><button type="button" id='btnSave' name="btnSave">Save</button></div>
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

<?php
} //End else { //Link is still valid; Reset password
} //End if ($memberConfirmationExpiryDate != "" || $memberConfirmationExpiryDate != NULL) {
else { //Member did not request to reset password/URL expired
header("Location:error404.php");
}
}
else { //Parameters not complete; Redirect to error page
header("Location:error404.php");
}
?>
