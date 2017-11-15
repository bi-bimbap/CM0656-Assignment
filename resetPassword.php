<?php
ini_set("session.save_path", "");
session_start();
include 'db/database_conn.php';
include_once 'config.php';
require_once('controls.php');
require_once('functions.php');
echo makePageStart("Reset Password");
echo "<div class='wrapper'><div class='container'><div id='logo'><img src='images/logo.png'/>Ima's Official Fanbase</div>";
echo makeNavMenu();
echo makeHeader("Reset Password");
$environment = LOCAL;
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

  // $emailAddr = "test";
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
            header("Refresh:1;url=loginForm.php");
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
        <input type="password" id="txtPassword" name="txtPassword" data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-equalto="#txtConfirmPassword" data-parsley-minlength="5">
      </div>

      <div>
        <p>Enter Your New Password Again: </p>
        <input type="password" id="txtConfirmPassword" name="txtConfirmPassword" data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-equalto="#txtPassword" data-parsley-minlength="5">
      </div>

      <div id="button"><button type="button" id='btnSave' name="btnSave">Save</button></div>
    </form>
  </div>
</div>

<?php
}
else { //Parameters not complete; Redirect to error page
  header("Location:error404.php");
}
?>

<?php
echo makeFooter();
echo makePageEnd();
?>
