<?php
// ini_set("session.save_path", "");
// session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Create Auction");
echo makeWrapper();
echo "<form method='post'>" . makeLoginLogoutBtn() . "</form>";
echo makeProfileButton();
echo makeNavMenu();
echo makeHeader("Create New Auction");
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
    <style>
    #inputBuyItNow { display: none; }
    </style>

<script type="text/javascript">
$(document).ready(function() {
  var dateToday = new Date();
  var yrRange = dateToday.getFullYear() + ":" + (dateToday.getFullYear() + 5); //Allow year range from current year until 5 years later

  // $("#aucStartDate").datetimepicker({
  //   dateFormat: 'yy-mm-dd', //'Format: 2017-11-01
  //   showWeek: true,
  //   yearRange: yrRange,
  //   changeMonth: true,
  //   changeYear: true,
  // });
  //
  // $("#aucStartDate").datetimepicker({
  //   dateFormat: 'yy-mm-dd', //'Format: 2017-11-01
  //   showWeek: true,
  //   yearRange: yrRange,
  //   changeMonth: true,
  //   changeYear: true,
  // });

  $("#aucBuyItNow").on("change", function() {
   if ($(this).is(":checked")) {
     $("#inputBuyItNow").css('display','block'); //to show item price input box
   } else {
     $("#inputBuyItNow").css('display','none'); //to hide item price input box
   }
 });

});
</script>

<form id="createAuctionForm" data-parsley-validate method="post">
  Title:
  <div class="input-group">
     <input type="text" class="form-control" id='aucTitle' name='aucTitle' data-parsley-required="true" data-parsley-errors-messages-disabled/>
  </div>

  Item Name:
  <div class="input-group">
    <input type="text" class="form-control" id='aucItem' name='aucItem' data-parsley-required="true" data-parsley-errors-messages-disabled/>
  </div>

  Description:
  <div class="input-group">
    <textarea class="form-control" style="width:250px;" id='aucDesc' name='aucDesc' data-parsley-required="true" data-parsley-errors-messages-disabled></textarea>
  </div>

  Start Price:
  <div class="input-group">
    <span class="input-group-addon">£</span>
    <input type="text" class="form-control" id='aucStartPrice' name='aucStartPrice' aria-label="Amount (to the nearest dollar)" data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-type="number">
    <span class="input-group-addon">.00</span>
  </div>
  <br/>

  <div class="input-group">
    <input type="checkbox" id='aucBuyItNow' name='aucBuyItNow'/> Buy it now?
  </div>
  <br/>

  <div id="inputBuyItNow">
    Item Price:
    <div class="input-group">
      <input type="text" class="form-control" id='aucItemPrice' name='aucItemPrice' aria-label="Amount (to the nearest dollar)" data-parsley-type="number" data-parsley-errors-messages-disabled>
    </div>
  </div>

  Start Date:
  <div class="input-group">
    <div class="input-group date form_datetime col-md-5" data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
        <input class="form-control" id="aucStartDate" name="aucStartDate" style="width:250px;" size="16" type="text" value="" data-parsley-required="true" readonly>
        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
    </div>
    <input type="hidden" id="dtp_input1" value="" /><br/>
  </div>

  End Date:
  <div class="input-group">
    <div class="input-group date form_datetime2 col-md-5" data-date-format="yyyy-mm-dd hh:ii:ss" data-link-field="dtp_input1">
        <input class="form-control" id="aucEndDate" name="aucEndDate" style="width:250px;" size="16" type="text" value="" data-parsley-required="true" readonly>
        <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
        <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
    </div>
    <input type="hidden" id="dtp_input1" value="" /><br/>
  </div>

  <input type='submit' value='Submit' name='btnSubmit'/>
</form>

<script src="../scripts/moment.js"></script>
<script src='../scripts/jquery-ui.min.js'></script>
<script src="../scripts/parsley.min.js"></script>
<script type="text/javascript" src="../scripts/jquery-1.8.3.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="../scripts/bootstrap.min.test.js"></script>
<script type="text/javascript" src="../scripts/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script type="text/javascript" src="../scripts/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
<script type="text/javaScript">
var dateToday = new Date();

$('.form_datetime').datetimepicker({
    //language:  'fr',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
    showMeridian: 1,
    startDate: dateToday
});

$('.form_datetime2').datetimepicker({
    //language:  'fr',
    weekStart: 1,
    todayBtn:  1,
    autoclose: 1,
    todayHighlight: 1,
    startView: 2,
    forceParse: 0,
    showMeridian: 1,
    startDate: dateToday
});
</script>

<?php
if (isset($_POST['btnSubmit'])) { //Clicked on submit button
  //Obtain user input
  $aucTitle = filter_has_var(INPUT_POST, 'aucTitle') ? $_POST['aucTitle']: null;
  $aucItem = filter_has_var(INPUT_POST, 'aucItem') ? $_POST['aucItem']: null;
  $aucDesc = filter_has_var(INPUT_POST, 'aucTitle') ? $_POST['aucTitle']: null;
  $aucStartPrice = filter_has_var(INPUT_POST, 'aucStartPrice') ? $_POST['aucStartPrice']: null;
  $aucItemPrice = filter_has_var(INPUT_POST, 'aucItemPrice') ? $_POST['aucItemPrice']: null;
  $aucStartDate = filter_has_var(INPUT_POST, 'aucStartDate') ? $_POST['aucStartDate']: null;
  $aucEndDate = filter_has_var(INPUT_POST, 'aucEndDate') ? $_POST['aucEndDate']: null;

  //Trim white space
  $aucTitle = trim($aucTitle);
  $aucItem = trim($aucItem);
  $aucDesc = trim($aucDesc);
  $aucStartPrice = trim($aucStartPrice);
  $aucItemPrice = trim($aucItemPrice);
  $aucStartDate = trim($aucStartDate);
  $aucEndDate = trim($aucEndDate);

  //Sanitize user input
  $aucTitle = filter_var($aucTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $aucItem = filter_var($aucItem, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $aucDesc = filter_var($aucDesc, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $aucStartPrice = filter_var($aucStartPrice, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $aucItemPrice = filter_var($aucItemPrice, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $aucStartDate = filter_var($aucStartDate, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $aucEndDate = filter_var($aucEndDate, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

  $sqlCreateAuction = "INSERT INTO auction (auctionTitle, itemName, itemDesc, startDate, endDate, startPrice, itemPrice) VALUES (?, ?, ?, ?, ?, ?, ?)";
  $stmtCreateAuction = mysqli_prepare($conn, $sqlCreateAuction) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmtCreateAuction, "sssssii", $aucTitle, $aucItem, $aucDesc, $aucStartDate, $aucEndDate, $aucStartPrice, $aucItemPrice);
  mysqli_stmt_execute($stmtCreateAuction);
  if (mysqli_stmt_affected_rows($stmtCreateAuction) > 0) {
    echo "<script>alert(\"Insert succesfully!\")</script>";
    header("Location:../auction/auctionList.php");
  }
  mysqli_stmt_close($stmtCreateAuction);
  mysqli_close($conn);
}
  ?>


<?php
echo makeFooter();
echo makePageEnd();
?>
