<?php
ini_set("session.save_path", "");
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
$environment = LOCAL; //TODO: Change to server
?>

<script src="../scripts/jquery.js"></script>
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

<input type="submit" class="btn btn-primary" id="btnNotify" name="btnNotify" value="Send Notification" />

<?php
echo makeFooter("../");
echo makePageEnd();
?>
