<?php
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Auction Lists");
echo makeWrapper("../");
echo "<form method='post'>" . makeLoginLogoutBtn("../") . "</form>";
echo makeProfileButton("../");
echo makeNavMenu("../");
echo makeHeader("Auction Lists");
$environment = LOCAL; //TODO: Change to server

?>
<script src="../scripts/jquery.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
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
                            auction.startPrice, auction.itemPrice, auction.currentBid, COUNT(bid.bidID), file.filePath
                            FROM auction LEFT JOIN bid ON auction.auctionID = bid.auctionID JOIN file ON auction.auctionID = file.auctionID
                            WHERE auction.endDate > CURRENT_TIMESTAMP AND CURRENT_TIMESTAMP > auction.startDate AND auction.auctionStatus = 'active' OR file.fileType = 'coverPhoto' GROUP BY auction.auctionID";
  $stmtAuctionList = mysqli_prepare($conn, $sqlAuctionList) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmtAuctionList);
  mysqli_stmt_bind_result($stmtAuctionList, $aucID, $aucTitle, $aucItem, $aucStartDate, $aucEndDate, $aucStartPrice, $aucItemPrice, $aucCurrentBid,$bids,$coverPhoto);
  while (mysqli_stmt_fetch($stmtAuctionList)) {
    $seconds = strtotime($aucEndDate) - time();

    $days = floor($seconds / 86400);
    $seconds %= 86400;

    $hours = floor($seconds / 3600);
    $seconds %= 3600;

    $minutes = floor($seconds / 60);
    $seconds %= 60;
    echo "
    <div class=\"media\">
      <div class=\"media-left media-middle\">
        <a href=\"#\">
          <img class=\"media-object\" src=\"$environment/$coverPhoto\" alt=\"...\" height=\"200px\" width=\"150px\">
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
        }
        echo "<b>$bids</b> bid(s)<br/>";
        if ($days == 0) {
          echo "Time Left: $hours hours and $minutes minutes<br/>";
        } else if ($days == 0 && $hours == 0 ) {
          echo "Time Left: $minutes minutes<br/>";
        } else {
          echo "Time Left: $days days and $hours hours and $minutes minutes<br/>";
        } echo"
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
