<?php
include '../db/database_conn.php';
require_once('../functions.php');
include_once '../config.php';
$environment = WEB; //TODO: Change to WEB
header('content-type: application/json');

$function = filter_has_var(INPUT_POST, 'action') ? $_POST['action']: null;
$function = trim($function);
$function = filter_var($function, FILTER_SANITIZE_STRING);
// $function = "sendNotification";

$a_json = array();
$a_json_row = array();

if ($function == "sendNotification") {
  //check which auction has expired
  $sqlCheckAuction = "SELECT auctionID, auctionTitle, currentBid FROM auction WHERE endDate < CURRENT_TIMESTAMP AND auctionStatus = 'active'";
  $stmtCheckAuction = mysqli_prepare($conn, $sqlCheckAuction) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmtCheckAuction);
  mysqli_stmt_bind_result($stmtCheckAuction, $aucID, $aucTitle, $currentBid);
  mysqli_stmt_store_result($stmtCheckAuction);

  while (mysqli_stmt_fetch($stmtCheckAuction)) {
    //Update auction status as ended
    $aucStatus = 'ended';
    $sqlUpdateAucStatus = "UPDATE auction SET auctionStatus = ? WHERE auctionID = ?";
    $stmtUpdateAucStatus = mysqli_prepare($conn, $sqlUpdateAucStatus) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmtUpdateAucStatus, "si", $aucStatus, $aucID);
    mysqli_stmt_execute($stmtUpdateAucStatus);
    mysqli_stmt_close($stmtUpdateAucStatus);

    // if (mysqli_stmt_affected_rows($stmtUpdateAucStatus) > 0) {
    //   echo json_encode("test");
    // }

    // check bid under this auction
    $sqlCheckBid = "SELECT bid.bidID, bid.bidAmount, bid.userID, user.emailAddr, user.fullName FROM bid JOIN user ON bid.userID = user.userID
    WHERE bidStatus = 'active' AND auctionID = ?";
    $stmtCheckBid = mysqli_prepare($conn, $sqlCheckBid) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmtCheckBid, "i", $aucID);
    mysqli_stmt_execute($stmtCheckBid);
    mysqli_stmt_bind_result($stmtCheckBid, $bidID, $bidAmount, $userID, $emailAddr, $fullName);
    mysqli_stmt_store_result($stmtCheckBid);

    while (mysqli_stmt_fetch($stmtCheckBid)) {
      //if it is the highest bidder
      if ($bidAmount == $currentBid) {
        $paymentStatus = 'awaiting';
        //insert to payment table
        $sqlInsertPayment = "INSERT INTO payment (bidID,paymentStatus) VALUES (?,?)";
        $stmtInsertPayment = mysqli_prepare($conn, $sqlInsertPayment) or die( mysqli_error($conn));
        mysqli_stmt_bind_param($stmtInsertPayment, "is", $bidID, $paymentStatus);
        mysqli_stmt_execute($stmtInsertPayment);
        mysqli_stmt_close($stmtInsertPayment);

        //notify the winning bidder
        $sqlWinningBidder = "SELECT DISTINCT emailAddr, fullName FROM user WHERE userID = ?";
        $stmtWinningBidder = mysqli_prepare($conn, $sqlWinningBidder) or die( mysqli_error($conn));
        mysqli_stmt_bind_param($stmtWinningBidder, "i", $userID);
        mysqli_stmt_execute($stmtWinningBidder);
        mysqli_stmt_bind_result($stmtWinningBidder, $email, $fullName);
        mysqli_stmt_fetch($stmtWinningBidder);
        mysqli_stmt_close($stmtWinningBidder);
        sendPaymentEmail($email, $fullName, 'Congratulation on winning the item on '.$aucTitle.'!', '../email/notifier_paymentInfo.html', $aucTitle, $aucID, $bidAmount); //Email sent
      }
      else {
        //notify the bidders auction has ended
        $sqlBidderList = "SELECT DISTINCT u.emailAddr, u.fullName FROM user u JOIN bid b ON u.userID = b.userID WHERE b.auctionID = ? AND b.bidStatus = 'active' AND b.userID = ?";
        $stmtBidderList = mysqli_prepare($conn, $sqlBidderList) or die( mysqli_error($conn));
        mysqli_stmt_bind_param($stmtBidderList, "ii", $aucID, $userID);
        mysqli_stmt_execute($stmtBidderList);
        mysqli_stmt_bind_result($stmtBidderList, $bidEmail, $bidFullName);
        mysqli_stmt_fetch($stmtBidderList);
        mysqli_stmt_close($stmtBidderList);
        sendAuctionEndEmail($bidEmail, $bidFullName, ' '.$aucTitle.' has ended!', '../email/notifier_auctionAutomation.html', $aucTitle); //Email sent
      }

      //notify the watchlist member
      $sqlWatchList = "SELECT u.emailAddr, u.fullName FROM watchlist w
                              JOIN user u ON w.userID = u.userID
                              WHERE w.auctionID = ?";
      $stmtWatchList = mysqli_prepare($conn, $sqlWatchList) or die( mysqli_error($conn));
      mysqli_stmt_bind_param($stmtWatchList, "i", $aucID);
      mysqli_stmt_execute($stmtWatchList);
      mysqli_stmt_bind_result($stmtWatchList, $watchEmail, $watchFullName);
      while (mysqli_stmt_fetch($stmtWatchList)) {
        sendAuctionEndEmail($watchEmail, $watchFullName, ' '.$aucTitle.' has ended!', '../email/notifier_auctionAutomation.html', $aucTitle); //Email sent
      }
    //   mysqli_stmt_close($stmtWatchList);
    }
    // mysqli_stmt_close($stmtCheckBid);
  }
  // mysqli_stmt_close($stmtCheckAuction);
  echo json_encode("Notifications sent!");
  mysqli_close($conn);
}
?>
