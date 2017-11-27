<?php
// ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Manage Auction");
echo makeWrapper("../");
echo "<form method='post'>" . makeLoginLogoutBtn("../") . "</form>";
echo makeProfileButton("../");
echo makeNavMenu("../");
echo makeHeader("Manage Auction");
$environment = WEB; //TODO: Change to server

// //Only show content if user is logged in & is senior
// $_SESSION['userID'] = '1'; //TODO: Remove session
// $_SESSION['userType'] = 'admin'; //TODO: Remove
// $_SESSION['username'] = 'seahjm'; //TODO: Remove
// $_SESSION['logged-in'] = true; //TODO: Remove
?>

<script src="../scripts/jquery.js"></script>
<script src="../scripts/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
<link rel='stylesheet' href='../css/jquery-ui.min.css' />
<link rel="stylesheet" href="../css/stylesheet.css" type="text/css" />
<link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="../css/bootstrapTest.css" type="text/css" media="screen" />
<link rel="stylesheet" href="../css/bootstrap-datetimepicker.min.css" type="text/css" media="screen"/>
<link rel="stylesheet" href="../css/parsley.css" type="text/css" />
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.css" type="text/css" media="all" />

<script>
$(document).ready(function() {
  $('#btnNotify').on('click', function(e) { //Send notifications
      $.ajax({
        url :"manageAuction_serverProcessing.php",
        type: "POST",
        data: "action=sendNotification",
        success: function(data) {
          alert(data);
        }
      });
  });
});
</script>

<center><input type="submit" class="btn btn-primary" style="width: 300px; height: 100px;" id="btnNotify" name="btnNotify" value="Send Notification" /></center><br/>

<?php
echo makeFooter("../");
echo makePageEnd();
?>
