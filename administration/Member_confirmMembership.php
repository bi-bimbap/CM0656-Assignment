<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Membership Confirmation");
echo makeHeader("Membership Confirmation");
$environment = LOCAL;
?>

<?php
if (isset($_GET['mail']) && isset($_GET['exDate'])) { //Get email address & membership confirmation expiry date
  //Decode url-encoded string
  $emailAddr = urldecode(base64_decode($_GET['mail']));
  $expiryDate = urldecode(base64_decode($_GET['exDate']));

  //Trim white space
  $emailAddr = trim($emailAddr);
  $expiryDate = trim($expiryDate);

  //Sanitize url parameters
  $emailAddr = filter_var($emailAddr, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $expiryDate = filter_var($expiryDate, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

  $expiryDate = date('Y-m-d H:i:s', strtotime($expiryDate)); //Convert string to date time

  $membershipSQL = "SELECT fullName, memberConfirmationExpiryDate FROM user WHERE emailAddr = ?";
  $stmt = mysqli_prepare($conn, $membershipSQL) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmt, "s", $emailAddr);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $fullName, $memberConfirmationExpiryDate);
  mysqli_stmt_fetch($stmt);
  mysqli_stmt_close($stmt);

  if ($memberConfirmationExpiryDate != "" || $memberConfirmationExpiryDate != NULL) { //Member's email require verification
    if (date('Y-m-d H:i:s') > $expiryDate) { //Link expired; Send another email
      $memberConfirmationExpiryDate = time(); //Get current date
      $memberConfirmationExpiryDate = date('Y-m-d H:i:s', strtotime('+1 day', $memberConfirmationExpiryDate)); //Calculate url expiration date

      //Update new member confirmation expiry date
      $updateDateSQL = "UPDATE user SET memberConfirmationExpiryDate = ? WHERE emailAddr = ?";
      $stmt = mysqli_prepare($conn, $updateDateSQL);
      mysqli_stmt_bind_param($stmt, "ss", $memberConfirmationExpiryDate, $emailAddr);
      mysqli_stmt_execute($stmt);

      if (mysqli_stmt_affected_rows($stmt) > 0) { //Update successful
        $url = $environment . "/CM0656-Assignment/administration/Member_confirmMembership.php?mail=" . $emailAddr . "&exDate=" . $memberConfirmationExpiryDate;
        if (sendEmail($emailAddr, $fullName, 'Please Verify Your Email Address', '../email/notifier_verifyEmail.html', $url)) { //Email sent
          echo "<p>The link you clicked on has expired. Another email has been sent to your email address.</p>";
          echo "<p>Follow the instructions to complete the registration process.</p>";
        }
        else { //Email failed to send
          echo "<script>alert('Failed to send email!')</script>";
        }
      }
      else { //Update failed
          echo "<script>alert('Update failed!')</script>";
      }
      mysqli_stmt_close($stmt);
    }
    else { //Link still valid; Verify member's email
      $updateMembershipSQL = "UPDATE user SET userStatus = 'active', memberConfirmationExpiryDate = NULL WHERE emailAddr = ?";
      $stmt = mysqli_prepare($conn, $updateMembershipSQL) or die( mysqli_error($conn));
      mysqli_stmt_bind_param($stmt, "s", $emailAddr);
      mysqli_stmt_execute($stmt);

      if (mysqli_stmt_affected_rows($stmt) > 0) { //Membership confirmed
        echo "<p>Membership confirmed!</p>";
        echo "<p>You will be redirected in a short while!</p>";
        //header("Refresh:2;url=index.php"); //TODO: Change url to home page
      }
      else { //Membership confirmation failed
        echo "<p>Membership confimation failed!</p><br />";
      }
      mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
  }
  else { //Member's email does not require verfication
    //header("Refresh:2;url=index.php"); //TODO: Change url to home page
    die ("You will be redirected in a short while");
  }
}
else { //Parameters not complete; Redirect to home page
  //header("Refresh:2;url=index.php"); //TODO: Change url to home page
  die ("You will be redirected in a short while");
}
?>

<?php
echo makeFooter();
echo makePageEnd();
?>
