<?php
// ini_set("session.save_path", "");
// session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Create Auction");
echo makeNavMenu();
echo makeHeader("Create New Auction");
$environment = LOCAL; //TODO: Change to server
?>
<script src="../scripts/jquery.js"></script>
<link rel='stylesheet' href='../css/jquery-ui.min.css' />
<link rel="stylesheet" href="../css/stylesheet.css" type="text/css" />
<link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="../css/bootstrap-datetimepicker.css" type="text/css" />
<link rel="stylesheet" href="../css/parsley.css" type="text/css" />
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.css" type="text/css" media="all" />

<div class="form-group">
  <div class='input-group date' id='datetimepicker6'>
    <input type='text' class="form-control" />
    <div class="input-group-addon">
      <span class="glyphicon glyphicon-calendar"></span>
    </div>
  </div>
</div>

<div class="form-group">
  <div class='input-group date' id='datetimepicker7'>
    <input type='text' class="form-control" />
    <span class="input-group-addon">
        <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
    </span>
  </div>
 </div>
 <script src="../scripts/moment.js"></script>
 <script src='../scripts/jquery-ui.min.js'></script>
 <script src="../scripts/parsley.min.js"></script>
 <script src="../scripts/bootstrap-datepicker.js"></script>
 <script type="text/javaScript">
 $(function () {
     $('#datetimepicker6').datetimepicker();
     $('#datetimepicker7').datetimepicker({
         useCurrent: false //Important! See issue #1075
     });
     $("#datetimepicker6").on("dp.change", function (e) {
         $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
     });
     $("#datetimepicker7").on("dp.change", function (e) {
         $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
     });
 });
 </script>

 <?php
 echo makeFooter();
 echo makePageEnd();
 ?>
