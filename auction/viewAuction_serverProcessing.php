<?php
include '../db/database_conn.php';
require_once('../functions.php');
include_once '../config.php';
$environment = WEB; //TODO: Change to WEB
header('content-type: application/json');

$function = filter_has_var(INPUT_POST, 'action') ? $_POST['action']: null;
$function = trim($function);
$function = filter_var($function, FILTER_SANITIZE_STRING);

$a_json = array();
$a_json_row = array();

if ($function == "placeBid") { //Place bid
  $bidAmount = filter_has_var(INPUT_POST, 'bidAmount') ? $_POST['username']: null;
  $bidAmount = trim($bidAmount);
  $bidAmount = filter_var($bidAmount, FILTER_SANITIZE_STRING);

  $userID = filter_has_var(INPUT_POST, 'userID') ? $_POST['userID']: null;
  $userID = trim($userID);
  $userID = filter_var($userID, FILTER_SANITIZE_STRING);

  $aucID = filter_has_var(INPUT_POST, 'aucID') ? $_POST['aucID']: null;
  $aucID = trim($aucID);
  $aucID = filter_var($aucID, FILTER_SANITIZE_STRING);

  $date = date('Y-m-d H:i:s');
  $status = "active";

  //check if the bid amount is greater than the currentBid
  $sqlCheckCurrentBid = "SELECT currentBid, auctionTitle FROM auction WHERE auctionID = ?";
  $stmtCheckCurrentBid = mysqli_prepare($conn, $sqlCheckCurrentBid) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmtCheckCurrentBid, "i", $aucID);
  mysqli_stmt_execute($stmtCheckCurrentBid);
  mysqli_stmt_bind_result($stmtCheckCurrentBid, $currentBid, $aucTitle);
  mysqli_stmt_fetch($stmtCheckCurrentBid);
  mysqli_stmt_close($stmtCheckCurrentBid);

  if ($bidAmount > $currentBid) {
    $sqlPlaceBid = "INSERT INTO bid (userID,auctionID,bidAmount,bidStatus,bidTime) VALUES (?,?,?,?,?)";
    $stmtPlaceBid = mysqli_prepare($conn, $sqlPlaceBid) or die(mysqli_error($conn));
    mysqli_stmt_bind_param($stmtPlaceBid, "iiiss", $userID, $aucID, $bidAmount, $status, $date);
    mysqli_stmt_execute($stmtPlaceBid);

    if (mysqli_stmt_affected_rows($stmtPlaceBid) > 0) {
      //notify bidder
      $sqlBidderList = "SELECT DISTINCT u.emailAddr, u.fullName, b.bidAmount FROM user u JOIN bid b ON u.userID = b.userID WHERE b.auctionID = ? AND b.bidStatus = 'active'";
      $stmtBidderList = mysqli_prepare($conn, $sqlBidderList) or die( mysqli_error($conn));
      mysqli_stmt_bind_param($stmtBidderList, "i", $aucID);
      mysqli_stmt_execute($stmtBidderList);
      mysqli_stmt_bind_result($stmtBidderList, $email, $fullName, $bidAmt);
      while (mysqli_stmt_fetch($stmtBidderList)){
        //encode variable to be used in url
        $auctionIDEncoded = urlencode(base64_encode($auctionIDEncoded));
        $url = $environment."/CM0656-Assignment/auction/Member_viewAuction.php?auctionID=".$auctionIDEncoded;
        if ($bidAmt == $currentBid) { //notify highest bidder has been outbidded
          if (sendBidUpdateEmail($email, $fullName, 'You have been outbidded on '.$aucTitle.'!', '../email/notifier_outbidded.html', $url, $bidAmount, $aucTitle)) { //Email sent
            //testing purpose
            echo json_encode("3Outbid email has been sent.");
          }
        } else {
          if (sendBidUpdateEmail($email, $fullName, 'New bid on '.$aucTitle.'!', '../email/notifier_bidUpdate.html', $url, $bidAmount, $aucTitle)) { //Email sent
            //testing purpose
            echo json_encode("4Bid update email has been sent.");
          }
        }
      }
      mysqli_stmt_close($stmtBidderList);

      //notify the watchlist member
      $sqlWatchList = "SELECT u.emailAddr, u.fullName FROM watchlist w
                              JOIN user u ON w.userID = u.userID
                              WHERE w.auctionID = ?";
      $stmtWatchList = mysqli_prepare($conn, $sqlWatchList) or die( mysqli_error($conn));
      mysqli_stmt_bind_param($stmtWatchList, "i", $aucID);
      mysqli_stmt_execute($stmtWatchList);
      mysqli_stmt_bind_result($stmtWatchList, $email, $fullName, $bidAmt);
      while (mysqli_stmt_fetch($stmtWatchList)){
        if (sendBidUpdateEmail($email, $fullName, 'New bid on '.$aucTitle.'!', '../email/notifier_bidUpdate.html', $url, $bidAmount, $aucTitle)) { //Email sent
          //testing purpose
          echo json_encode("5Watchlist email has been sent.");
        }
      }
      mysqli_stmt_close($stmtWatchList);

      //update auction current bid
      $sqlUpdateAuction = "UPDATE auction SET currentBid = ? WHERE auctionID = ?";
      $stmtUpdateAuction = mysqli_prepare($conn, $sqlUpdateAuction) or die( mysqli_error($conn));
      mysqli_stmt_bind_param($stmtUpdateAuction, "ii", $bidAmount, $aucID);
      mysqli_stmt_execute($stmtUpdateAuction);
      if (mysqli_stmt_affected_rows($stmtUpdateAuction) > 0) {
        echo json_encode("6Auction latest bid has been updated!");
      }
      mysqli_stmt_close($stmtUpdateAuction);
    }
    mysqli_stmt_close($stmtPlaceBid);
    echo json_encode("2Bid has been placed!");
  } else {
    echo json_encode("1Please enter an amount that is greater than £ $currentBid.00!");
  }
  mysqli_close($conn);
}

?>
