<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
$environment = LOCAL; //TODO: Change to server

if(isset($_GET['aucID'])){
  $aucID = $_GET['aucID'];
}

//Pull auction info from database
$sqlAuctionInfo = "SELECT auction.auctionID, auction.auctionTitle, auction.itemName, auction.itemDesc, auction.startDate,auction.endDate,
                          auction.startPrice, auction.itemPrice, auction.currentBid, COUNT(bid.bidID)
                          FROM auction LEFT JOIN bid ON auction.auctionID = bid.auctionID
                          WHERE auction.auctionID = ? GROUP BY auction.auctionID";
$stmtAuctionInfo = mysqli_prepare($conn, $sqlAuctionInfo) or die( mysqli_error($conn));
mysqli_stmt_bind_param($stmtAuctionInfo, "i", $aucID);
mysqli_stmt_execute($stmtAuctionInfo);
mysqli_stmt_bind_result($stmtAuctionInfo, $aucID, $aucTitle, $aucItem, $aucDesc, $aucStartDate, $aucEndDate, $aucStartPrice, $aucItemPrice, $aucCurrentBid, $bids);
mysqli_stmt_fetch($stmtAuctionInfo);
mysqli_stmt_close($stmtAuctionInfo);


//Pull current active bidders from database
$sqlActiveBidder = "SELECT COUNT(DISTINCT userID)
                          FROM bid WHERE auctionID = ? AND bidStatus ='active'";
$stmtActiveBidder = mysqli_prepare($conn, $sqlActiveBidder) or die( mysqli_error($conn));
mysqli_stmt_bind_param($stmtActiveBidder, "i", $aucID);
mysqli_stmt_execute($stmtActiveBidder);
mysqli_stmt_bind_result($stmtActiveBidder, $bidder);
mysqli_stmt_fetch($stmtActiveBidder);
mysqli_stmt_close($stmtActiveBidder);

//Pull number of bids from database
$sqlActiveBid = "SELECT COUNT(bidID)
                          FROM bid WHERE auctionID = ? AND bidStatus ='active'";
$stmtActiveBid = mysqli_prepare($conn, $sqlActiveBid) or die( mysqli_error($conn));
mysqli_stmt_bind_param($stmtActiveBid, "i", $aucID);
mysqli_stmt_execute($stmtActiveBid);
mysqli_stmt_bind_result($stmtActiveBid, $totalBid);
mysqli_stmt_fetch($stmtActiveBid);
mysqli_stmt_close($stmtActiveBid);

//Pull bidding history
$sqlBidHistory = "SELECT b.bidAmount, b.bidTime, u.username
                          FROM bid b JOIN user u ON b.userID = u.userID WHERE b.auctionID = ? AND b.bidStatus ='active'";
$stmtBidHistory = mysqli_prepare($conn, $sqlBidHistory) or die( mysqli_error($conn));
mysqli_stmt_bind_param($stmtBidHistory, "i", $aucID);
mysqli_stmt_execute($stmtBidHistory);
mysqli_stmt_bind_result($stmtBidHistory, $bidAmount, $bidTime, $username);

//Only show content if user is logged in & is senior
$_SESSION['userID'] = '1'; //TODO: Remove session
$_SESSION['userType'] = 'senior'; //TODO: Remove
$_SESSION['username'] = 'seahjm'; //TODO: Remove
$_SESSION['logged-in'] = true; //TODO: Remove

echo makePageStart($aucTitle);
echo "<form method='post'>" . makeLoginLogoutBtn("../") . "</form>";
echo makeProfileButton("../");
echo makeNavMenu("../");
echo makeHeader($aucTitle);
?>
<!-- CSS style -->
<link rel='stylesheet' href='../css/bootstrap.css' />
<link rel="stylesheet" href="../css/jquery-ui.min.css" />
<link rel="stylesheet" href="../css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="../css/stylesheet.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<script src='../scripts/bootstrap.js'></script>
<script src='../scripts/jquery.dataTables.min.js'></script>
<script src="../scripts/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<?php
if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) && (isset($_SESSION['userID'])) &&
(isset($_SESSION['userType']) && ($_SESSION['userType'] == "admin" || $_SESSION['userType'] == "mainAdmin" || $_SESSION['userType'] == "senior" ))) {
?>
<script>
$(document).ready(function() {
  $('#btnPlaceBid').on('click', function(e) { //Place bid or bidding history
    $("#auctionInfo").css("display","none"); //Hide auction Info
    $("#biddingHistory").css("display","block");
  });

  $('#btnBackToInfo').on('click', function(e) { //Back to auction info
    $("#auctionInfo").css("display","block"); //Show auction info
    $("#biddingHistory").css("display","none");
  });

  $('#btnBid').on('click', function(e) { //Show confirm bid pop up box
    var bidAmt = $("#placeBid").val(); //Obtain bid Amount
    if (bidAmt > 0 && !isNaN(bidAmt)) {
      if (confirm("Are you confirm to bid at £ " + bidAmt + ".00? Please note that we have") == true) {
        var bidAmt = $("#placeBid").val(); //Obtain bid Amount
        var userID = <?php echo $_SESSION['userID']?>;
        var aucID  = <?php echo $aucID?>;
        $.ajax({
          url :"viewAuction_serverProcessing.php",
          type: "POST",
          data: "action=placeBid&bidAmount=" + bidAmt + "&userID=" + userID + "&aucID=" + aucID,
          success: function(data) {
            var dataString = data;
            var firstChar  = dataString.charAt(0);
            var message    = dataString.slice(1);

            if (firstChar == "1") { //Email in use; Unable to add admin
              alert(message);
            }
            else if (firstChar == "2") { //Admin successfully added
              alert(message);
            }
            else if (firstChar == "3") { //Failed to send email
              alert(message);
            }
            else if (firstChar == "4") { //Failed to add new admin
              alert(message);
            }
            else if (firstChar == "5") { //Unable to add new admin
              alert(message);
            }
          }
        });
      }
    } else {

    }
  });

  $('#btnBidConfirm').on('click', function(e) { //Submit bid

  });
});
</script>
<?php
  $seconds = strtotime($aucEndDate) - time();

  $days = floor($seconds / 86400);
  $seconds %= 86400;

  $hours = floor($seconds / 3600);
  $seconds %= 3600;

  $minutes = floor($seconds / 60);
  $seconds %= 60;

    echo "
    <div id=\"auctionInfo\" class=\"media\">
      <div class=\"media-left media-middle\">
        <a href=\"#\">
          <img class=\"media-object\" src=\"...\" alt=\"...\">
        </a>
      </div>
      <div class=\"media-body\">
        Item Name: $aucItem <br/>
        Item Description: $aucDesc <br/>";
        $startDatetime = date_create($aucStartDate);
        $endDatetime = date_create($aucEndDate);
        echo "Start Date: ".date_format($startDatetime, 'd M Y h:i:s A')."<br/>End Date: ".date_format($endDatetime, 'd M Y h:i:s A')."<br/>";
        if ($aucItemPrice > 0) {
          echo "Item Price: $aucItemPrice<br/>";
        }
        if ($aucCurrentBid > 0) {
          echo "Currend Bid: $aucCurrentBid<br/>";
        } else {
          echo "Start Price: $aucStartPrice<br/><br/>";
        }
        if ($days == 0) {
          echo "Time Left: $hours hours and $minutes minutes<br/>";
        } else if ($days == 0 && $hours == 0 ) {
          echo "Time Left: $minutes minutes<br/>";
        } else {
          echo "Time Left: $days days and $hours hours and $minutes minutes<br/>";
        }
        echo "$bids bid(s)<br/>
        <input type=\"submit\" class=\"btn btn-primary\" id=\"btnPlaceBid\" name=\"btnPlaceBid\" value=\"Place bid\" />
        <input type=\"submit\" class=\"btn btn-primary\" id=\"btnAddToWatch\" name=\"btnAddToWatch\" value=\"Add to Watch List\" />
      </div>
    </div>
    ";

    echo "
    <div id=\"biddingHistory\">
      <input type=\"submit\" class=\"btn btn-primary\" id=\"btnBackToInfo\" name=\"btnBackToInfo\" value=\"Back\" /><br/><br/>
      <div class=\"panel panel-default\" style=\"width: 80%;\">
        <div class=\"panel-heading\">Bidding History</div>
        <div class=\"panel-body\">
          Bidders: $bidder Bids: $totalBid Time End: ".date_format($endDatetime, 'd M Y h:i:s A')."
        </div>

        <table class=\"table\">
          <th>Bidder</th>
          <th>Bid Amount</th>
          <th>Bid Time</th>";
          while (mysqli_stmt_fetch($stmtBidHistory)){
          echo "<tr>
                  <td>$username</td>
                  <td>$bidAmount</td>
                  <td>$bidTime</td>
                </tr>";
          }
          mysqli_stmt_close($stmtBidHistory);
          echo "
        </table>
        <br/>
      </div>
      <input type=\"text\" id='placeBid' style=\"width: 200px;\" name='placeBid' aria-label=\"Amount (to the nearest dollar)\" data-parsley-required=\"true\" data-parsley-errors-messages-disabled data-parsley-type=\"number\"> .00
      <input type=\"submit\" class=\"btn btn-primary\" id=\"btnBid\" name=\"btnBackToInfo\" value=\"Bid\" />
      <div id=\"errorMsg\"> </div>
    </div>
    ";
} else {
  echo "Sorry you have no permission to access to this page.";
}

?>


<?php
mysqli_close($conn);
//} //for ajax, close
echo makeFooter("../");
echo makePageEnd();
?>
