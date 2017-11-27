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
      while (mysqli_stmt_fetch($stmtBidderList)) {
        //encode variable to be used in url
        $auctionIDEncoded = urlencode(base64_encode($auctionID));
        $url = $environment."/CM0656-Assignment/auction/Member_viewAuction.php?auctionID=".$auctionIDEncoded;
        if ($bidAmt == $currentBid) { //notify highest bidder has been outbidded
          sendBidUpdateEmail($email, $fullName, 'You have been outbidded on '.$aucTitle.'!', '../email/notifier_outbidded.html', $url, $bidAmount, $aucTitle);
        } else {
          sendBidUpdateEmail($email, $fullName, 'New bid on '.$aucTitle.'!', '../email/notifier_bidUpdate.html', $url, $bidAmount, $aucTitle);
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
      mysqli_stmt_bind_result($stmtWatchList, $email, $fullName);
      while (mysqli_stmt_fetch($stmtWatchList)){
        //encode variable to be used in url
        $auctionIDEncoded = urlencode(base64_encode($auctionID));
        $url = $environment."/CM0656-Assignment/auction/Member_viewAuction.php?auctionID=".$auctionIDEncoded;
        sendBidUpdateEmail($email, $fullName, 'New bid on '.$aucTitle.'!', '../email/notifier_bidUpdate.html', $url, $bidAmount, $aucTitle);
      }
      mysqli_stmt_close($stmtWatchList);

      //update auction current bid
      $sqlUpdateAuction  = "UPDATE auction SET currentBid = ? WHERE auctionID = ?";
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
else if ($function == "addToWatch") { //add to watch list
  $userID = filter_has_var(INPUT_POST, 'userID') ? $_POST['userID']: null;
  $userID = trim($userID);
  $userID = filter_var($userID, FILTER_SANITIZE_STRING);

  $aucID = filter_has_var(INPUT_POST, 'aucID') ? $_POST['aucID']: null;
  $aucID = trim($aucID);
  $aucID = filter_var($aucID, FILTER_SANITIZE_STRING);

  //check if user has bid on this auction
  $sqlCheckUser  = "SELECT userID FROM bid WHERE auctionID = ? AND userID = ?";
  $stmtCheckUSer = mysqli_prepare($conn, $sqlCheckUser) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmtCheckUSer, "ii", $aucID, $userID);
  mysqli_stmt_execute($stmtCheckUSer);
  $count = mysqli_stmt_num_rows($stmtCheckUSer);
  mysqli_stmt_close($stmtCheckUSer);
  if ($count > 0) { //user is one of the bidder; not allowed to add to watchlist
    echo json_encode("1Add to Watchlist failed! You already have the privilege to receive updates on this auction as you are one of the bidders.");
  } else { //auction has been added to the watchlist
    $sqlAddToWatch = "INSERT INTO watchlist (userID,auctionID) VALUES (?,?)";
    $stmtAddToWatch = mysqli_prepare($conn, $sqlAddToWatch) or die(mysqli_error($conn));
    mysqli_stmt_bind_param($stmtAddToWatch, "ii", $userID, $aucID);
    mysqli_stmt_execute($stmtAddToWatch);
    if (mysqli_stmt_affected_rows($stmtAddToWatch) > 0) {
        echo json_encode("2Successfully added to watchlist!");
    }
    mysqli_stmt_close($stmtAddToWatch);
  }
  mysqli_close($conn);
}
else if ($function == "withdrawBid") { //withdraw bid
  $userID = filter_has_var(INPUT_POST, 'userID') ? $_POST['userID']: null;
  $userID = trim($userID);
  $userID = filter_var($userID, FILTER_SANITIZE_STRING);

  $aucID = filter_has_var(INPUT_POST, 'aucID') ? $_POST['aucID']: null;
  $aucID = trim($aucID);
  $aucID = filter_var($aucID, FILTER_SANITIZE_STRING);

  //get user penalties count
  $sqlPenalties = "SELECT penaltyCount,bidPenalty FROM user
                      WHERE userID = ?";
  $stmtPenalties = mysqli_prepare($conn, $sqlPenalties) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmtPenalties, "i", $userID);
  mysqli_stmt_execute($stmtPenalties);
  mysqli_stmt_bind_result($stmtPenalties, $penaltyCount, $bidPenalty);
  mysqli_stmt_fetch($stmtPenalties);
  mysqli_stmt_close($stmtPenalties);

  //indicate withdraw status
  $boolWithdraw = 'true';

  // if user's bid penalty is less than 2
  if ($bidPenalty < 2) {
    $bidPenalty = $bidPenalty + 1;
    //update bid penalty
    $sqlBidPenalty = "UPDATE user SET bidPenalty = ? WHERE userID = ?";
    $stmtBidPenalty = mysqli_prepare($conn, $sqlBidPenalty) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmtBidPenalty, "ii", $bidPenalty, $userID);
    mysqli_stmt_execute($stmtBidPenalty);
    mysqli_stmt_close($stmtBidPenalty);

    $sqlWithdrawBid = "UPDATE bid SET bidStatus = 'withdrawn' WHERE userID = ? AND auctionID = ?";
    $stmtWithdrawBid = mysqli_prepare($conn, $sqlWithdrawBid) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmtWithdrawBid, "ii", $userID, $aucID);
    mysqli_stmt_execute($stmtWithdrawBid);
    if (mysqli_stmt_affected_rows($stmtWithdrawBid) > 0) {
      $penaltyLeft = 2 - $bidPenalty;
      echo json_encode("1Bids have been withdrawn! Your penalty-free withdraw quota: $penaltyLeft");
    }
    mysqli_stmt_close($stmtWithdrawBid);
  }
  else { //if user's bid penalty is = 2
    if ($penaltyCount < 3) {
      $penaltyCount = $penaltyCount + 1;
      //withdraw bid
      $sqlWithdrawBid = "UPDATE bid SET bidStatus = 'withdrawn' WHERE userID = ? AND auctionID = ?";
      $stmtWithdrawBid = mysqli_prepare($conn, $sqlWithdrawBid) or die( mysqli_error($conn));
      mysqli_stmt_bind_param($stmtWithdrawBid, "ii", $userID, $aucID);
      mysqli_stmt_execute($stmtWithdrawBid);
      if (mysqli_stmt_affected_rows($stmtWithdrawBid) > 0) {
        //update penalty count
        $sqlPenaltyCount = "UPDATE user SET penaltyCount = ? WHERE userID = ?";
        $stmtPenaltyCount = mysqli_prepare($conn, $sqlPenaltyCount) or die( mysqli_error($conn));
        mysqli_stmt_bind_param($stmtPenaltyCount, "ii", $penaltyCount, $userID);
        mysqli_stmt_execute($stmtPenaltyCount);
        mysqli_stmt_close($stmtPenaltyCount);

        if ($penaltyCount==3) {
          $blacklistReason = "Exceed auction penalties";
          //insert to blacklist
          $sqlInsertBlacklist = "INSERT INTO user_blacklist (userID,blacklistReason) VALUES (?, ?)";
          $stmtBlacklist = mysqli_prepare($conn, $sqlInsertBlacklist) or die( mysqli_error($conn));
          mysqli_stmt_bind_param($stmtBlacklist, "is", $userID, $blacklistReason);
          mysqli_stmt_execute($stmtBlacklist);
        }
        echo json_encode("2Bids have been withdrawn! Your penalty count: $penaltyCount");
      }
      mysqli_stmt_close($stmtWithdrawBid);
    }
    else {
      $boolWithdraw = 'false';
      echo json_encode("3Failed to withdraw! You have exceeded your penalty limit.");
    }
  }

  if ($boolWithdraw == 'true') {
    //pull auction Title
    $sqlAucTitle  = "SELECT auctionTitle FROM auction WHERE auctionID = ?";
    $stmtAucTitle =  mysqli_prepare($conn, $sqlAucTitle) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmtAucTitle, "i", $aucID);
    mysqli_stmt_execute($stmtAucTitle);
    mysqli_stmt_bind_result($stmtAucTitle, $aucTitle);
    mysqli_stmt_fetch($stmtAucTitle);
    mysqli_stmt_close($stmtAucTitle);

    //check whether user's highest bid = auction's highest bid
    $sqlCheckHighestBid  = "SELECT MAX(bidAmount) FROM bid WHERE userID = ? AND auctionID = ?";
    $stmtCheckHighestBid =  mysqli_prepare($conn, $sqlCheckHighestBid) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmtCheckHighestBid, "ii", $userID, $aucID);
    mysqli_stmt_execute($stmtCheckHighestBid);
    mysqli_stmt_bind_result($stmtCheckHighestBid, $highestBid);
    mysqli_stmt_fetch($stmtCheckHighestBid);
    mysqli_stmt_close($stmtCheckHighestBid);

    $sqlCheckCurrentBid  = "SELECT MAX(bidAmount) FROM bid WHERE userID = ? AND auctionID = ?";
    $stmtCheckCurrentBid =  mysqli_prepare($conn, $sqlCheckCurrentBid) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmtCheckCurrentBid, "ii", $userID, $aucID);
    mysqli_stmt_execute($stmtCheckCurrentBid);
    mysqli_stmt_bind_result($stmtCheckCurrentBid, $aucCurrentBid);
    mysqli_stmt_fetch($stmtCheckCurrentBid);
    mysqli_stmt_close($stmtCheckCurrentBid);

    if ($highestBid == $aucCurrentBid) {
      //select alternate highest bid under this auction
      $sqlSelectAlternate  = "SELECT MAX(bidAmount) FROM bid WHERE bidStatus = 'active' AND auctionID = ?";
      $stmtSelectAlternate = mysqli_prepare($conn, $sqlSelectAlternate) or die( mysqli_error($conn));
      mysqli_stmt_bind_param($stmtSelectAlternate, "i", $aucID);
      mysqli_stmt_execute($stmtSelectAlternate);
      mysqli_stmt_bind_result($stmtSelectAlternate, $alternateBid);
      mysqli_stmt_fetch($stmtSelectAlternate);
      mysqli_stmt_close($stmtSelectAlternate);

      //replace auction current bid to second highest bid
      $sqlUpdateCurrentBid = "UPDATE auction SET currentBid = ? WHERE auctionID = ?";
      $stmtUpdateCurrentBid = mysqli_prepare($conn, $sqlUpdateCurrentBid) or die( mysqli_error($conn));
      mysqli_stmt_bind_param($stmtUpdateCurrentBid, "ii", $alternateBid, $aucID);
      mysqli_stmt_execute($stmtUpdateCurrentBid);
      if (mysqli_stmt_affected_rows($stmtUpdateCurrentBid) > 0) {
        //notify bidder "attention for the max bid amount"
        $sqlBidderList = "SELECT DISTINCT u.emailAddr, u.fullName, MAX(b.bidAmount) FROM user u JOIN bid b ON u.userID = b.userID WHERE b.auctionID = ? AND b.bidStatus = 'active'";
        $stmtBidderList = mysqli_prepare($conn, $sqlBidderList) or die( mysqli_error($conn));
        mysqli_stmt_bind_param($stmtBidderList, "i", $aucID);
        mysqli_stmt_execute($stmtBidderList);
        mysqli_stmt_bind_result($stmtBidderList, $email, $fullName, $bidAmt);
        while (mysqli_stmt_fetch($stmtBidderList)) {
          //encode variable to be used in url
          $auctionIDEncoded = urlencode(base64_encode($auctionID));
          $url = $environment."/CM0656-Assignment/auction/Member_viewAuction.php?auctionID=".$auctionIDEncoded;
          if ($bidAmt == $alternateBid) { //notify highest bidder has been outbidded
            sendBidUpdateEmail($email, $fullName, 'You are currently the highest bidder on '.$aucTitle.'!', '../email/notifier_highestBidder.html', $url, $bidAmount, $aucTitle); //Email sent
          }
          else {
            sendBidUpdateEmail($email, $fullName, 'Bid update on '.$aucTitle.'!', '../email/notifier_bidderChanged.html', $url, $bidAmount, $aucTitle); //Email sent
          }
        }
        mysqli_stmt_close($stmtBidderList);
      }
    }
  }
  mysqli_close($conn);
}
else if ($function == "buyItNow") { //buy the item with specific price
  $userID = filter_has_var(INPUT_POST, 'userID') ? $_POST['userID']: null;
  $userID = trim($userID);
  $userID = filter_var($userID, FILTER_SANITIZE_STRING);

  $aucID = filter_has_var(INPUT_POST, 'aucID') ? $_POST['aucID']: null;
  $aucID = trim($aucID);
  $aucID = filter_var($aucID, FILTER_SANITIZE_STRING);

  $itemPrice = filter_has_var(INPUT_POST, 'itemPrice') ? $_POST['itemPrice']: null;
  $itemPrice = trim($itemPrice);
  $itemPrice = filter_var($itemPrice, FILTER_SANITIZE_STRING);

  $bidDateTime = date('Y-m-d H:i:s');
  $aucStatus = 'ended';
  //Update auction status as ended
  $sqlUpdateAucStatus = "UPDATE auction SET auctionStatus = ? WHERE auctionID = ?";
  $stmtUpdateAucStatus = mysqli_prepare($conn, $sqlUpdateAucStatus) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmtUpdateAucStatus, "si", $aucStatus, $aucID);
  mysqli_stmt_execute($stmtUpdateAucStatus);
  mysqli_stmt_close($stmtUpdateAucStatus);

  $bidStatus = 'buyItNow';
  //insert to bid table
  $sqlInsertBid = "INSERT INTO bid (userID,auctionID,bidAmount,bidStatus,bidTime) VALUES (?,?,?,?,?)";
  $stmtInsertBid = mysqli_prepare($conn, $sqlInsertBid) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmtInsertBid, "iiiss", $userID, $aucID, $itemPrice, $bidStatus, $bidDateTime);
  mysqli_stmt_execute($stmtInsertBid);
  mysqli_stmt_close($stmtInsertBid);

  //pull bid amount and ID
  $sqlBidInfo = "SELECT bidID,bidAmount FROM bid WHERE auctionID = ? AND bidStatus = 'buyItNow'";
  $stmtBidInfo = mysqli_prepare($conn, $sqlBidInfo) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmtBidInfo, "i", $aucID);
  mysqli_stmt_execute($stmtBidInfo);
  mysqli_stmt_bind_result($stmtBidInfo, $bidID, $payAmount);
  mysqli_stmt_fetch($stmtBidInfo);
  mysqli_stmt_close($stmtBidInfo);

  $paymentStatus = 'awaiting';
  //insert to payment table
  $sqlInsertPayment = "INSERT INTO payment (bidID,paymentStatus) VALUES (?,?)";
  $stmtInsertPayment = mysqli_prepare($conn, $sqlInsertPayment) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmtInsertPayment, "is", $bidID, $paymentStatus);
  mysqli_stmt_execute($stmtInsertPayment);
  mysqli_stmt_close($stmtInsertPayment);

  //pull Auction title
  $sqlAucTitle = "SELECT auctionTitle FROM auction WHERE auctionID = ?";
  $stmtAucTitle = mysqli_prepare($conn, $sqlAucTitle) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmtAucTitle, "i", $aucID);
  mysqli_stmt_execute($stmtAucTitle);
  mysqli_stmt_bind_result($stmtAucTitle, $aucTitle);
  mysqli_stmt_fetch($stmtAucTitle);
  mysqli_stmt_close($stmtAucTitle);

  //notify the winning bidder
  $sqlWinningBidder = "SELECT DISTINCT emailAddr, fullName FROM user WHERE userID = ?";
  $stmtWinningBidder = mysqli_prepare($conn, $sqlWinningBidder) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmtWinningBidder, "i", $userID);
  mysqli_stmt_execute($stmtWinningBidder);
  mysqli_stmt_bind_result($stmtWinningBidder, $email, $fullName);
  mysqli_stmt_fetch($stmtWinningBidder);
  mysqli_stmt_close($stmtWinningBidder);
  sendPaymentEmail($email, $fullName, 'Congratulation on winning the item on '.$aucTitle.'!', '../email/notifier_paymentInfo.html', $aucTitle, $aucID, $itemPrice); //Email sent

  //notify the bidders auction has ended
  $sqlBidderList = "SELECT DISTINCT u.emailAddr, u.fullName FROM user u JOIN bid b ON u.userID = b.userID WHERE b.auctionID = ? AND b.bidStatus = 'active'";
  $stmtBidderList = mysqli_prepare($conn, $sqlBidderList) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmtBidderList, "i", $aucID);
  mysqli_stmt_execute($stmtBidderList);
  mysqli_stmt_bind_result($stmtBidderList, $bidEmail, $bidFullName);
  while (mysqli_stmt_fetch($stmtBidderList)) {
    sendAuctionEndEmail($bidEmail, $bidFullName, ' '.$aucTitle.' has ended!', '../email/notifier_auctionEnd.html', $aucTitle); //Email sent
  }
  mysqli_stmt_close($stmtBidderList);

  //notify the watchlist member
  $sqlWatchList = "SELECT u.emailAddr, u.fullName FROM watchlist w
                          JOIN user u ON w.userID = u.userID
                          WHERE w.auctionID = ?";
  $stmtWatchList = mysqli_prepare($conn, $sqlWatchList) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmtWatchList, "i", $aucID);
  mysqli_stmt_execute($stmtWatchList);
  mysqli_stmt_bind_result($stmtWatchList, $watchEmail, $watchFullName);
  while (mysqli_stmt_fetch($stmtWatchList)) {
    sendAuctionEndEmail($watchEmail, $watchFullName, ' '.$aucTitle.' has ended!', '../email/notifier_auctionEnd.html', $aucTitle); //Email sent
  }
  mysqli_stmt_close($stmtWatchList);
  echo json_encode("You have successfully bought the item. An email has been sent to your inbox with the bank transfer info. Please check your email for the instruction!");
  mysqli_close($conn);
}
?>
