<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Auction Lists");
echo "<form method='post'>" . makeLoginLogoutBtn("../") . "</form>";
echo makeProfileButton("../");
echo makeNavMenu("../");
echo makeHeader("Auction Lists");
$environment = LOCAL; //TODO: Change to server

$_SESSION['userID'] = '1'; //TODO: Remove session
$_SESSION['userType'] = 'senior'; //TODO: Remove
$_SESSION['username'] = 'seahjm'; //TODO: Remove
$_SESSION['logged-in'] = true; //TODO: Remove
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
if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) && (isset($_SESSION['userID'])) &&
(isset($_SESSION['userType']) && ($_SESSION['userType'] == "admin" || $_SESSION['userType'] == "mainAdmin" || $_SESSION['userType'] == "senior" ))) {

  $sqlAuctionList = "SELECT auction.auctionID, auction.auctionTitle, auction.itemName, auction.startDate,auction.endDate,
                            auction.startPrice, auction.itemPrice, auction.currentBid, COUNT(bid.bidID)
                            FROM auction LEFT JOIN bid ON auction.auctionID = bid.auctionID
                            WHERE auction.endDate > CURRENT_TIMESTAMP GROUP BY auction.auctionID";
  $stmtAuctionList = mysqli_prepare($conn, $sqlAuctionList) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmtAuctionList);
  mysqli_stmt_bind_result($stmtAuctionList, $aucID, $aucTitle, $aucItem, $aucStartDate, $aucEndDate, $aucStartPrice, $aucItemPrice, $aucCurrentBid,$bids);
  while (mysqli_stmt_fetch($stmtAuctionList)) {
    echo "
    <div class=\"media\">
      <div class=\"media-left media-middle\">
        <a href=\"#\">
          <img class=\"media-object\" src=\"...\" alt=\"...\">
        </a>
      </div>
      <div class=\"media-body\">
        <a class=\"media-heading\" href=\"Member_viewAuction.php?aucID=$aucID\">$aucTitle</a><br/>
        Item Name: $aucItem <br/>
        Start Date: $aucStartDate | End Date: $aucEndDate <br/>";
        if ($aucItemPrice > 0) {
          echo "Item Price: $aucItemPrice<br/>";
        }
        if ($aucCurrentBid > 0) {
          echo "Currend Bid: $aucCurrentBid<br/>";
        } else {
          echo "Start Price: $aucStartPrice<br/>";
        } echo "<b>$bids</b> bid(s)
      </div>
    </div>";
  }
  mysqli_stmt_close($stmtAuctionList);
  mysqli_close($conn);
} else {
  echo "Sorry you have no permission to access to this page.";
}
  ?>


<?php
echo makeFooter("../");
echo makePageEnd();
?>
