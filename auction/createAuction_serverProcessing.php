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
if ($function == "insertAuction") {
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
    echo json_encode("1Insert succesfully!");
  } else {
    echo json_encode("2Insert failed!");
  }
  mysqli_stmt_close($stmtCreateAuction);
  mysqli_close($conn);
}
?>
