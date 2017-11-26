<?php
include '../db/database_conn.php';
include_once '../config.php';
$environment = WEB; //TODO: Change to WEB
header('content-type: application/json');

$function = filter_has_var(INPUT_POST, 'action') ? $_POST['action']: null;
$function = trim($function);
$function = filter_var($function, FILTER_SANITIZE_STRING);

$a_json = array();
$a_json_row = array();

if ($function == "ageGroup") {
  //Age group 10 - 19
  $age10SQL = "SELECT fullName FROM user WHERE YEAR(CURDATE()) - YEAR(dob) >= 10 AND YEAR(CURDATE()) - YEAR(dob) < 20";
  $stmt = mysqli_prepare($conn, $age10SQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $age10Count = mysqli_stmt_num_rows($stmt);
  mysqli_stmt_close($stmt);
  $a_json_row = array("ageGroup" => "10 - 19", "count" => $age10Count);
  array_push($a_json, $a_json_row);

  //Age group 20 - 29
  $age20SQL = "SELECT fullName FROM user WHERE YEAR(CURDATE()) - YEAR(dob) >= 20 AND YEAR(CURDATE()) - YEAR(dob) < 30";
  $stmt = mysqli_prepare($conn, $age20SQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $age20Count = mysqli_stmt_num_rows($stmt);
  mysqli_stmt_close($stmt);
  $a_json_row = array("ageGroup" => "20 - 29", "count" => $age20Count);
  array_push($a_json, $a_json_row);

  //Age group 30 - 39
  $age30SQL = "SELECT fullName FROM user WHERE YEAR(CURDATE()) - YEAR(dob) >= 30 AND YEAR(CURDATE()) - YEAR(dob) < 40";
  $stmt = mysqli_prepare($conn, $age30SQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $age30Count = mysqli_stmt_num_rows($stmt);
  mysqli_stmt_close($stmt);
  $a_json_row = array("ageGroup" => "30 - 39", "count" => $age30Count);
  array_push($a_json, $a_json_row);

  //Age group 40 - 49
  $age40SQL = "SELECT fullName FROM user WHERE YEAR(CURDATE()) - YEAR(dob) >= 40 AND YEAR(CURDATE()) - YEAR(dob) < 50";
  $stmt = mysqli_prepare($conn, $age40SQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $age40Count = mysqli_stmt_num_rows($stmt);
  mysqli_stmt_close($stmt);
  $a_json_row = array("ageGroup" => "40 - 49", "count" => $age40Count);
  array_push($a_json, $a_json_row);

  //Age group 50 - 59
  $age50SQL = "SELECT fullName FROM user WHERE YEAR(CURDATE()) - YEAR(dob) >= 50 AND YEAR(CURDATE()) - YEAR(dob) < 60";
  $stmt = mysqli_prepare($conn, $age50SQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $age50Count = mysqli_stmt_num_rows($stmt);
  mysqli_stmt_close($stmt);
  $a_json_row = array("ageGroup" => "50 - 59", "count" => $age50Count);
  array_push($a_json, $a_json_row);

  //Age group 60 - 69
  $age60SQL = "SELECT fullName FROM user WHERE YEAR(CURDATE()) - YEAR(dob) >= 60 AND YEAR(CURDATE()) - YEAR(dob) < 70";
  $stmt = mysqli_prepare($conn, $age60SQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $age60Count = mysqli_stmt_num_rows($stmt);
  mysqli_stmt_close($stmt);
  $a_json_row = array("ageGroup" => "60 - 69", "count" => $age60Count);
  array_push($a_json, $a_json_row);

  //Age group 70 - 79
  $age70SQL = "SELECT fullName FROM user WHERE YEAR(CURDATE()) - YEAR(dob) >= 70 AND YEAR(CURDATE()) - YEAR(dob) < 80";
  $stmt = mysqli_prepare($conn, $age70SQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $age70Count = mysqli_stmt_num_rows($stmt);
  mysqli_stmt_close($stmt);
  $a_json_row = array("ageGroup" => "70 - 79", "count" => $age70Count);
  array_push($a_json, $a_json_row);

  //Age group 80 - 89
  $age80SQL = "SELECT fullName FROM user WHERE YEAR(CURDATE()) - YEAR(dob) >= 80 AND YEAR(CURDATE()) - YEAR(dob) < 90";
  $stmt = mysqli_prepare($conn, $age80SQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $age80Count = mysqli_stmt_num_rows($stmt);
  mysqli_stmt_close($stmt);
  $a_json_row = array("ageGroup" => "80 - 89", "count" => $age80Count);
  array_push($a_json, $a_json_row);

  //Age group 90 - 99
  // $age90SQL = "SELECT fullName FROM user WHERE YEAR(CURDATE()) - YEAR(dob) >= 90 AND YEAR(CURDATE()) - YEAR(dob) < 100";
  $age90SQL = "SELECT fullName FROM user WHERE YEAR(CURDATE()) - YEAR(dob) >= 90";
  $stmt = mysqli_prepare($conn, $age90SQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $age90Count = mysqli_stmt_num_rows($stmt);
  mysqli_stmt_close($stmt);
  $a_json_row = array("ageGroup" => ">90", "count" => $age90Count);
  array_push($a_json, $a_json_row);

  echo json_encode($a_json, JSON_PRETTY_PRINT);
}
else if ($function == "registeredUsers") { //Get no. of registered users for the past 6 months
  for ($i = 1; $i <= 6; $i++) {
    $registeredUsersSQL = "SELECT fullName FROM user WHERE (MONTH(CURDATE()) - " . $i . ") = MONTH(registeredDate)";
    $stmt = mysqli_prepare($conn, $registeredUsersSQL) or die( mysqli_error($conn));
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $registeredUsersCount = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    //Extract month from date
    $currMonthValue = date('m', strtotime(date('Y-m-d H:i:s'))) - $i;
    $months = array(1 => "January", 2 => "February", 3 => "March", 4 => "April", 5 => "May", 6 => "June", 7 => "July",
    8 => "August", 9 => "September", 10 => "October", 11 => "November", 12 => "December");
    $currMonthName = $months[$currMonthValue];

    $a_json_row = array("month" => $currMonthName, "count" => $registeredUsersCount);
    array_push($a_json, $a_json_row);
  }
  echo json_encode($a_json, JSON_PRETTY_PRINT);
}
else if ($function == "auction") { //Get no. of users that participated in an auction
  //Obtain passed value, trim whitespace & sanitize value
  $auctionID = filter_has_var(INPUT_POST, 'auctionID') ? $_POST['auctionID']: null;
  $auctionID = trim($auctionID);
  $auctionID = filter_var($auctionID, FILTER_SANITIZE_STRING);
  // $auctionID = 1;

  for ($i = 10; $i <= 90; $i = $i + 10) {
    if ($i == 90) {
      //Get no. of participated members based on age group
      $participatedSQL = "SELECT fullName FROM user u JOIN bid b ON u.userID = b.userID JOIN auction a
      ON b.auctionID = a.auctionID WHERE b.auctionID = ? AND bidStatus = 'active'
      AND YEAR(CURDATE()) - YEAR(dob) >= " . intval($i);

      //Get no. of withdrawn members based on age group
      $withdrawnSQL = "SELECT fullName FROM user u JOIN bid b ON u.userID = b.userID JOIN auction a
      ON b.auctionID = a.auctionID WHERE b.auctionID = ? AND bidStatus = 'withdrawn'
      AND YEAR(CURDATE()) - YEAR(dob) >= " . intval($i);

      $ageGroup = ">" . $i;
    }
    else {
      //Get no. of participated members based on age group
      $participatedSQL = "SELECT fullName FROM user u JOIN bid b ON u.userID = b.userID JOIN auction a
      ON b.auctionID = a.auctionID WHERE b.auctionID = ? AND bidStatus = 'active'
      AND YEAR(CURDATE()) - YEAR(dob) >= " . intval($i) . " AND YEAR(CURDATE()) - YEAR(dob) < " . intval($i + 10);

      //Get no. of withdrawn members based on age group
      $withdrawnSQL = "SELECT fullName FROM user u JOIN bid b ON u.userID = b.userID JOIN auction a
      ON b.auctionID = a.auctionID WHERE b.auctionID = ? AND bidStatus = 'withdrawn'
      AND YEAR(CURDATE()) - YEAR(dob) >= " . intval($i) . " AND YEAR(CURDATE()) - YEAR(dob) < " . intval($i + 10);

      $ageGroup = $i . " - " . intval($i + 9);

      if ($ageGroup == "10 - 19") { //Set label for 'less than 20'
        $ageGroup = "<20";
      }
    }

    $stmt = mysqli_prepare($conn, $participatedSQL) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "s", $auctionID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $participatedCount = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    $stmt = mysqli_prepare($conn, $withdrawnSQL) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "s", $auctionID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $withdrawnCount = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    $a_json_row = array("ageGroup" => $ageGroup, "participatedCount" => $participatedCount, "withdrawnCount" => $withdrawnCount);
    array_push($a_json, $a_json_row);
  }
  echo json_encode($a_json, JSON_PRETTY_PRINT);
}
else if ($function == "competition") { //Get no. of users that participated in a competition
  //Obtain passed value, trim whitespace & sanitize value
  $testID = filter_has_var(INPUT_POST, 'testID') ? $_POST['testID']: null;
  $testID = trim($testID);
  $testID = filter_var($testID, FILTER_SANITIZE_STRING);

  $ageSQL = "SELECT ageRange FROM competition_test WHERE testID = ?";
  $stmt = mysqli_prepare($conn, $ageSQL) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmt, "s", $testID);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $ageGroup);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

  if ($ageGroup == "13") {
    $ageGroup = "10 - 13";
  }
  else if ($ageGroup == "16") {
    $ageGroup = "13 - 16";
  }
  else if ($ageGroup == "18") {
    $ageGroup = "16 - 18";
  }

  //Get no. of participated members based on age group
  $participatedSQL = "SELECT fullName FROM user u JOIN competition_result r
  ON u.userID = r.userID JOIN competition_test t ON r.testID = t.testID WHERE r.testID = ?";
  $stmt = mysqli_prepare($conn, $participatedSQL) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmt, "s", $testID);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $participatedCount = mysqli_stmt_num_rows($stmt);
  mysqli_stmt_close($stmt);

  $a_json_row = array("ageGroup" => $ageGroup, "participatedCount" => $participatedCount);
  array_push($a_json, $a_json_row);
  echo json_encode($a_json, JSON_PRETTY_PRINT);
}
?>
