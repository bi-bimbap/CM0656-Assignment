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

if ($function == "loadAll") { //Load active members
  $memberListSQL = "SELECT username, emailAddr FROM user WHERE (userType = 'junior' OR userType = 'senior')
  AND userStatus = 'active' AND penaltyCount < 3";
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
else if ($function == "loadAdmin") { //Load admin user
  $adminSQL = "SELECT userID, fullName, emailAddr, userStatus FROM user WHERE userType = 'admin'";
  $stmt = mysqli_prepare($conn, $adminSQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $userID, $fullName, $emailAddr, $userStatus);

  while (mysqli_stmt_fetch($stmt)) {
    $a_json_row = array("userID" => $userID, "fullName" => $fullName, "email" => $emailAddr, "userStatus" => $userStatus);
    array_push($a_json, $a_json_row);
  }
  echo json_encode($a_json, JSON_PRETTY_PRINT); //Convert the array into JSON format

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else if ($function == "updateAdminEmail") { //Update email address for admin (with status "pending")
  //NOTE: json_encode echo results if have header('content-type: application/json');

  //Obtain passed value, trim whitespace & sanitize value
  $userID = filter_has_var(INPUT_POST, 'userID') ? $_POST['userID']: null;
  $userID = trim($userID);
  $userID = filter_var($userID, FILTER_SANITIZE_STRING);

  $email = filter_has_var(INPUT_POST, 'email') ? $_POST['email']: null;
  $email = trim($email);
  $email = filter_var($email, FILTER_SANITIZE_STRING);

  $fullName = filter_has_var(INPUT_POST, 'fullName') ? $_POST['fullName']: null;
  $fullName = trim($fullName);
  $fullName = filter_var($fullName, FILTER_SANITIZE_STRING);

  //Check if email already is associated with an account
  $checkEmailSQL = "SELECT userID FROM user WHERE emailAddr = ?";
  $stmt = mysqli_prepare($conn, $checkEmailSQL) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $count = mysqli_stmt_num_rows($stmt);
  mysqli_stmt_close($stmt);

  if ($count > 0) { //Email in use; Do not allow update
    echo json_encode("4An account has already been registered under this email address!");
  }
  else { //Email available to use; Update email & send confirmation email to new admin
    $memberConfirmationExpiryDate = time(); //Get current date
    $memberConfirmationExpiryDate = date('Y-m-d H:i:s', strtotime('+1 day', $memberConfirmationExpiryDate)); //Calculate url expiration date

    $updateEmailSQL = "UPDATE user SET emailAddr = ?, memberConfirmationExpiryDate = ? WHERE userID = ?";
    $stmt = mysqli_prepare($conn, $updateEmailSQL) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "sss", $email, $memberConfirmationExpiryDate, $userID);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
      //Encode variables to be used in url
      $emailEncoded = urlencode(base64_encode($email));
      $fullNameEncoded = urlencode(base64_encode($fullName));
      $memberConfirmationExpiryDateEncoded = urlencode($memberConfirmationExpiryDate);
      $url = $environment . "/CM0656-Assignment/administration/Member_signup.php?mail=" . $emailEncoded . "&name=" . $fullNameEncoded
      . "&exDate=" . $memberConfirmationExpiryDateEncoded;

      if (sendEmail($email, $fullName, 'Please Complete Your Registration', '../email/notifier_completeRegistration.html', $url)) { //Email sent
        echo json_encode("1Email for " . $fullName . " has been updated!");
      }
      else { //Email failed to send
        echo json_encode("2Failed to send email!");
      }
    }
    else { //Failed to update email address
      echo json_encode("3Failed to update email address!");
    }
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else if ($function == "deleteAdmin") { //Remove admin user
  //Obtain passed value, trim whitespace & sanitize value
  $userID = filter_has_var(INPUT_POST, 'userID') ? $_POST['userID']: null;
  $userID = trim($userID);
  $userID = filter_var($userID, FILTER_SANITIZE_STRING);

  $deleteAdminSQL = "UPDATE user SET userStatus = 'banned' WHERE userID = ?";
  $stmt = mysqli_prepare($conn, $deleteAdminSQL) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmt, "s", $userID);
  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo json_encode("1Admin removed!");
  }
  else {
    echo json_encode("2Failed to remove admin!");
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
else if ($function == "addAdmin") { //Add new admin
  //Obtain user input
  $fullName = filter_has_var(INPUT_POST, 'fullName') ? $_POST['fullName']: null;
  $email = filter_has_var(INPUT_POST, 'email') ? $_POST['email']: null;
  $userType = "admin";
  $userStatus = "pending";
  $memberConfirmationExpiryDate = time(); //Get current date
  $memberConfirmationExpiryDate = date('Y-m-d H:i:s', strtotime('+1 day', $memberConfirmationExpiryDate)); //Calculate url expiration date

  //Trim white space
  $fullName = trim($fullName);
  $email = trim($email);

  //Sanitize user input
  $fullName = filter_var($fullName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $email = filter_var($email, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

  try { //Check if there is an account associated with that email
    $emailSQL = "SELECT userID FROM user WHERE emailAddr = ?";
    $stmt = mysqli_prepare($conn, $emailSQL) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $count = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($count > 0) { //Email in use; Unable to add admin
      echo json_encode("1An account has already been registered under this email address!");
    }
    else { //Email available to use; Add new admin
      try {
        $signupSQL = "INSERT INTO user (fullName, emailAddr, userType, userStatus, memberConfirmationExpiryDate)
        VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $signupSQL) or die( mysqli_error($conn));
        mysqli_stmt_bind_param($stmt, "sssss", $fullName, $email, $userType, $userStatus, $memberConfirmationExpiryDate);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) { //Send email to new admin
          $emailEncoded = urlencode(base64_encode($email));
          $fullNameEncoded = urlencode(base64_encode($fullName));
          $memberConfirmationExpiryDateEncoded = urlencode($memberConfirmationExpiryDate);
          $url = $environment . "/CM0656-Assignment/administration/Member_signup.php?mail=" . $emailEncoded . "&name=" . $fullNameEncoded
          . "&exDate=" . $memberConfirmationExpiryDateEncoded;
          if (sendEmail($email, $fullName, 'Please Complete Your Registration', '../email/notifier_completeRegistration.html', $url)) { //Email sent
            echo json_encode("2New admin added!");
          }
          else { //Email failed to send
            echo json_encode("3Failed to send email!");
          }
        }
        else { //SQL statement failed; Failed to add admin
          echo json_encode("4Failed to add admin!");
        }
      }
      catch (Exception $e) {
        echo json_encode("4 Failed to add admin!");
        //echo $e->getErrorsMessages();
      }
    }
  }
  catch (Exception $e) {
    echo json_encode("5Unable to add new admin!");
    //echo $e->getErrorsMessages();
  }
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
else if ($function == "loadReportedContents") {
  $repotSQL = "SELECT reportID, contentID, contentType, userID, reportReason, reportFrom FROM report where reportStatus = '0' ORDER BY reportDateTime";
  $stmt = mysqli_prepare($conn, $repotSQL) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $reportID, $contentID, $contentType, $reportedID, $reason, $reportFrom);

  while (mysqli_stmt_fetch($stmt)) {
	  
    $a_json_row = array("ReportID" => "<a class='various' data-fancybox-type='iframe' href='manageReport.php?reportid=$reportID'>".$reportID."</a>", "ContentType" => $contentType, "ReportedUser" => $reportedID, "ReportedBy" => $reportFrom);
    array_push($a_json, $a_json_row);
  }
  echo json_encode($a_json, JSON_PRETTY_PRINT); //Convert the array into JSON format

  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
?>
