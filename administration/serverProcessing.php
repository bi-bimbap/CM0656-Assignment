<?php
include '../db/database_conn.php';
header('content-type: application/json');

$function = filter_has_var(INPUT_POST, 'action') ? $_POST['action']: null;
$function = trim($function);
$function = filter_var($function, FILTER_SANITIZE_STRING);

$a_json = array();
$a_json_row = array();

if ($function == "loadAll") { //Load active members
  $memberListSQL = "SELECT username, emailAddr FROM user WHERE (userType = 'junior' OR userType = 'senior')
  AND userStatus = 'active'";
  $stmt = mysqli_prepare($conn, $memberListSQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $username, $emailAddr);

  while (mysqli_stmt_fetch($stmt)) {
    $a_json_row = array("username" => $username, "email" => $emailAddr);
    array_push($a_json, $a_json_row);
  }
  echo json_encode($a_json, JSON_PRETTY_PRINT); //Convert the array into JSON format

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else if ($function == "loadBlacklistedMembers") { //Load blacklisted members
  $blacklistMemberSQL = "SELECT username, emailAddr, blacklistReason FROM user u JOIN user_blacklist ub
  ON u.userID = ub.userID WHERE (userType = 'junior' OR userType = 'senior')
  AND userStatus = 'active' AND penaltyCount >= 3";
  $stmt = mysqli_prepare($conn, $blacklistMemberSQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $username, $emailAddr, $blacklistReason);

  while (mysqli_stmt_fetch($stmt)) {
    $a_json_row = array("username" => $username, "email" => $emailAddr, "blacklistReason" => $blacklistReason);
    array_push($a_json, $a_json_row);
  }
  echo json_encode($a_json, JSON_PRETTY_PRINT); //Convert the array into JSON format

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else if ($function == "loadBannedMembers") { //Load banned members
  $bannedMemberSQL = "SELECT username, emailAddr, banReason FROM user u JOIN user_banned ub
  ON u.userID = ub.userID";
  $stmt = mysqli_prepare($conn, $bannedMemberSQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $username, $emailAddr, $banReason);

  while (mysqli_stmt_fetch($stmt)) {
    $a_json_row = array("username" => $username, "email" => $emailAddr, "banReason" => $banReason);
    array_push($a_json, $a_json_row);
  }
  echo json_encode($a_json, JSON_PRETTY_PRINT); //Convert the array into JSON format

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else if ($function == "loadAdmin") { //Load banned members
  $adminSQL = "SELECT fullName, emailAddr, userStatus FROM user WHERE userType = 'admin'";
  $stmt = mysqli_prepare($conn, $adminSQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $fullName, $emailAddr, $userStatus);

  while (mysqli_stmt_fetch($stmt)) {
    $a_json_row = array("fullName" => $fullName, "email" => $emailAddr, "userStatus" => $userStatus);
    array_push($a_json, $a_json_row);
  }
  echo json_encode($a_json, JSON_PRETTY_PRINT); //Convert the array into JSON format

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else if ($function == "banMember") { //Ban selected member
  //Obtain passed value, trim whitespace & sanitize value
  $username = filter_has_var(INPUT_POST, 'username') ? $_POST['username']: null;
  $username = trim($username);
  $username = filter_var($username, FILTER_SANITIZE_STRING);

  $banBy = filter_has_var(INPUT_POST, 'banBy') ? $_POST['banBy']: null;
  $banBy = trim($banBy);
  $banBy = filter_var($banBy, FILTER_SANITIZE_STRING);

  $tab = filter_has_var(INPUT_POST, 'tab') ? $_POST['tab']: null;
  $tab = trim($tab);
  $tab = filter_var($tab, FILTER_SANITIZE_STRING);

  if ($tab == "Active Members") { //Reason given by admin for banning a member
    $reason = filter_has_var(INPUT_POST, 'reason') ? $_POST['reason']: null;
    $reason = trim($reason);
    $reason = filter_var($reason, FILTER_SANITIZE_STRING);
  }

  //Get userID
  $userIDSQL = "SELECT userID FROM user WHERE username = ?";
  $stmt = mysqli_prepare($conn, $userIDSQL) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $userID);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

  //Update member's status to 'banned'
  $updateStatusSQL = "UPDATE user SET userStatus = 'banned' WHERE username = ?";
  $stmt = mysqli_prepare($conn, $updateStatusSQL) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmt, "s", $username);
  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_affected_rows($stmt) > 0) { //Insert into user_banned table
    if ($tab == "Active Members") { //Active members; Assign ban reason given by admin
        $blacklistReason = $reason;
        $hasBeenBlacklisted = false;
    }
    else { //Blacklisted members
      //Get blacklist reason if available
      $blacklistReasonSQL = "SELECT blacklistReason FROM user_blacklist WHERE userID = ?";
      $stmt = mysqli_prepare($conn, $blacklistReasonSQL) or die( mysqli_error($conn));
      mysqli_stmt_bind_param($stmt, "s", $userID);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_bind_result($stmt, $blacklistReason);
      mysqli_stmt_fetch($stmt);
      mysqli_stmt_close($stmt);

      $hasBeenBlacklisted = true;
    }

    $banMemberSQL = "INSERT INTO user_banned (userID, banReason, banDate, banBy) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $banMemberSQL) or die( mysqli_error($conn));
    $banDate = date('Y-m-d H:i:s'); //Get current date
    mysqli_stmt_bind_param($stmt, "ssss", $userID, $blacklistReason, $banDate, $banBy);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) { //Remove record if it exists in user_blacklist table
      if ($hasBeenBlacklisted) {
        $removeBlacklistSQL = "DELETE FROM user_blacklist WHERE userID = ?";
        $stmt = mysqli_prepare($conn, $removeBlacklistSQL) or die( mysqli_error($conn));
        mysqli_stmt_bind_param($stmt, "s", $userID);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
          echo true;
        }
        else {
          echo false;
        }
      }
      else { //Member has not been blacklisted
        echo true;
      }
    }
    else { //Failed to ban member
      echo false;
    }
  }
  else { //Failed to ban member
    echo false;
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
?>
