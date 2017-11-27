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

if ($function == "loadPending") { //Pull pending tables
  $sqlPaymentList = "SELECT username, emailAddr FROM user WHERE (userType = 'junior' OR userType = 'senior')
  AND userStatus = 'active' AND penaltyCount < 3";
  $stmtPaymentList = mysqli_prepare($conn, $sqlPaymentList) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmtPaymentList);
  mysqli_stmt_bind_result($stmtPaymentList, $username, $emailAddr);

  while (mysqli_stmt_fetch($stmt)) {
    $a_json_row = array("username" => $username, "email" => $emailAddr);
    array_push($a_json, $a_json_row);
  }
  echo json_encode($a_json, JSON_PRETTY_PRINT); //Convert the array into JSON format
  mysqli_stmt_close($stmt);
  mysqli_close($conn);

} else if ($function == "sendNotification") {
  //check which auction has expanded
  $sqlCheckAuction = "SELECT auctionID, auctionTitle, currentBid FROM auction WHERE endDate < CURRENT_TIMESTAMP AND auctionStatus = 'active'";
  $stmtCheckAuction = mysqli_prepare($conn, $sqlCheckAuction) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmtCheckAuction);
  mysqli_stmt_bind_result($stmtCheckAuction, $aucID, $aucTitle, $currentBid);
  while (mysqli_stmt_fetch($stmtCheckAuction)) {
    echo json_encode("testing:".$aucID);

    $aucStatus = 'ended';
    //Update auction status as ended
    $sqlUpdateAucStatus = "UPDATE auction SET auctionStatus = ? WHERE auctionID = ?";
    $stmtUpdateAucStatus = mysqli_prepare($conn, $sqlUpdateAucStatus) or die( mysqli_error($conn));
    var_dump(mysqli_stmt_bind_param($stmtUpdateAucStatus, "si", $aucStatus, $aucID));
    mysqli_stmt_execute($stmtUpdateAucStatus);
    mysqli_stmt_close($stmtUpdateAucStatus);

    // //check bid under this auction
    // $sqlCheckBid = "SELECT bid.bidAmount, bid.userID, user.emailAddr, user.fullName FROM bid JOIN user ON bid.userID = user.userID WHERE bidStatus = 'active' AND auctionID = ?";
    // $stmtCheckBid = mysqli_prepare($conn, $sqlCheckBid) or die( mysqli_error($conn));
    // mysqli_stmt_execute($stmtCheckBid);
    // mysqli_stmt_bind_result($stmtCheckBid, $bidAmount, $userID, $emailAddr, $fullName);
    // while (mysqli_stmt_fetch($stmtCheckBid)) {
    //   //if it is the highest bidder
    //   if ($bidAmount == $currentBid) {
    //     $paymentStatus = 'awaiting';
    //     //insert to payment table
    //     $sqlInsertPayment = "INSERT INTO payment (bidID,paymentStatus) VALUES (?,?)";
    //     $stmtInsertPayment = mysqli_prepare($conn, $sqlInsertPayment) or die( mysqli_error($conn));
    //     mysqli_stmt_bind_param($stmtInsertPayment, "is", $bidID, $paymentStatus);
    //     mysqli_stmt_execute($stmtInsertPayment);
    //     mysqli_stmt_close($stmtInsertPayment);
    //
    //     //notify the winning bidder
    //     $sqlWinningBidder = "SELECT DISTINCT emailAddr, fullName FROM user WHERE userID = ?";
    //     $stmtWinningBidder = mysqli_prepare($conn, $sqlWinningBidder) or die( mysqli_error($conn));
    //     mysqli_stmt_bind_param($stmtWinningBidder, "i", $userID);
    //     mysqli_stmt_execute($stmtWinningBidder);
    //     mysqli_stmt_bind_result($stmtWinningBidder, $email, $fullName);
    //     mysqli_stmt_fetch($stmtWinningBidder);
    //     mysqli_stmt_close($stmtWinningBidder);
    //     sendPaymentEmail($email, $fullName, 'Congratulation on winning the item on '.$aucTitle.'!', '../email/notifier_paymentInfo.html', $aucTitle, $aucID, $bidAmount); //Email sent
    //   }
    //   else {
    //     //notify the bidders auction has ended
    //     $sqlBidderList = "SELECT DISTINCT u.emailAddr, u.fullName FROM user u JOIN bid b ON u.userID = b.userID WHERE b.auctionID = ? AND b.bidStatus = 'active' AND b.userID = ?";
    //     $stmtBidderList = mysqli_prepare($conn, $sqlBidderList) or die( mysqli_error($conn));
    //     mysqli_stmt_bind_param($stmtBidderList, "i", $aucID, $userID);
    //     mysqli_stmt_execute($stmtBidderList);
    //     mysqli_stmt_bind_result($stmtBidderList, $bidEmail, $bidFullName);
    //     mysqli_stmt_fetch($stmtBidderList);
    //     mysqli_stmt_close($stmtBidderList);
    //     sendAuctionEndEmail($bidEmail, $bidFullName, ' '.$aucTitle.' has ended!', '../email/notifier_auctionAutomation.html', $aucTitle); //Email sent
    //   }
    //
    //   //notify the watchlist member
    //   $sqlWatchList = "SELECT u.emailAddr, u.fullName FROM watchlist w
    //                           JOIN user u ON w.userID = u.userID
    //                           WHERE w.auctionID = ?";
    //   $stmtWatchList = mysqli_prepare($conn, $sqlWatchList) or die( mysqli_error($conn));
    //   mysqli_stmt_bind_param($stmtWatchList, "i", $aucID);
    //   mysqli_stmt_execute($stmtWatchList);
    //   mysqli_stmt_bind_result($stmtWatchList, $watchEmail, $watchFullName);
    //   while (mysqli_stmt_fetch($stmtWatchList)) {
    //     sendAuctionEndEmail($watchEmail, $watchFullName, ' '.$aucTitle.' has ended!', '../email/notifier_auctionAutomation.html', $aucTitle); //Email sent
    //   }
    //   mysqli_stmt_close($stmtWatchList);
    // }
    // mysqli_stmt_close($stmtCheckBid);
  }
  mysqli_stmt_close($stmtCheckAuction);
  // echo json_encode("Notifications sent!");
  mysqli_close($conn);
}
?>
