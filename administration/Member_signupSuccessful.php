<!-- Note: NO LOGIN/LOGOUT BUTTON HERE -->


<?php
require_once('../controls.php');
echo makeWrapper();
echo makePageStart("Sign Up Succesful");
echo makeHeader("Sign Up Successful");
?>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
<script src="../scripts/bootstrap.min.js"></script>
<link rel="stylesheet" href="../css/stylesheet.css" type="text/css" />
<link href="../css/bootstrap.css" rel="stylesheet">

<div class="content">
  <div class="container">
    <p>Account created! Please follow the link in the email sent to you to complete the registration process.</p>
  </div>
</div>

<?php
echo makeFooter();
echo makePageEnd();
?>
