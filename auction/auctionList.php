<?php
// ini_set("session.save_path", "");
// session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Auction Lists");
echo makeWrapper();
echo "<form method='post'>" . makeLoginLogoutBtn() . "</form>";
echo makeProfileButton();
echo makeNavMenu();
echo makeHeader("Auction Lists");
$environment = LOCAL; //TODO: Change to server
?>
<script src="../scripts/jquery.js"></script>
<link rel='stylesheet' href='../css/jquery-ui.min.css' />
<link rel="stylesheet" href="../css/stylesheet.css" type="text/css" />
<link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="../css/parsley.css" type="text/css" />
<link rel="stylesheet" href="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.2/themes/smoothness/jquery-ui.css" type="text/css" media="all" />
<script src='../scripts/jquery-ui.min.js'></script>
<script src="../scripts/parsley.min.js"></script>

<?php
  $sqlAuctionList = "SELECT auctionID, auctionTitle, itemName, startDate, endDate, startPrice, itemPrice, currentBid FROM auction WHERE endDate > CURRENT_TIMESTAMP";
  $stmtAuctionList = mysqli_prepare($conn, $sqlAuctionList) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmtAuctionList);
  mysqli_stmt_bind_result($stmtAuctionList, $aucID, $aucTitle, $aucItem, $aucStartDate, $aucEndDate, $aucStartPrice, $aucItemPrice, $aucCurrentBid);
  while (mysqli_stmt_fetch($stmtAuctionList)) {
    echo "
    <div class=\"media\">
      <div class=\"media-left media-middle\">
        <a href=\"#\">
          <img class=\"media-object\" src=\"...\" alt=\"...\">
        </a>
      </div>
      <div class=\"media-body\">
        <a class=\"media-heading\" href=\"$aucID\">$aucTitle</a><br/>
        Item Name: $aucItem <br/>
        Start Date: $aucStartDate | End Date: $aucEndDate <br/>";
        if ($aucItemPrice > 0) {
          echo "Item Price: $aucItemPrice<br/>";
        }
        if ($aucCurrentBid > 0) {
          echo "Currend Bid: $aucCurrentBid<br/>";
        } else {
          echo "Start Price: $aucStartPrice";
        }
        echo "
      </div>
    </div>";
  }
  mysqli_stmt_close($stmtAuctionList);
  mysqli_close($conn);
  ?>


<?php
echo makeFooter();
echo makePageEnd();
?>
