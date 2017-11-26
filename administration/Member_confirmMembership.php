<!-- NOTE: NO LOGIN/LOGOUT, PROFILE BUTTON, NAV BAR HERE -->

<?php
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makeWrapper("../");
echo makePageStart("Membership Confirmation");
echo makeHeader("Membership Confirmation");
$environment = WEB; //TODO: Change to server
?>

<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
<link rel="stylesheet" href="../css/stylesheet.css" type="text/css" />
<link href="../css/bootstrap.css" rel="stylesheet">

<?php
if (isset($_GET['mail']) && isset($_GET['exDate'])) { //Get email address & membership confirmation expiry date
  //Decode url-encoded string
  $emailAddr = urldecode(base64_decode($_GET['mail']));
  $expiryDate = urldecode($_GET['exDate']);

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
        $emailEncoded = urlencode(base64_encode($emailAddr));
        $memberConfirmationExpiryDateEncoded = urlencode($memberConfirmationExpiryDate);
        $url = $environment . "/CM0656-Assignment/administration/Member_confirmMembership.php?mail=" . $emailEncoded .
        "&exDate=" . $memberConfirmationExpiryDateEncoded;
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
      $updateMembershipSQL = "UPDATE user SET userStatus = 'active', memberConfirmationExpiryDate = NULL,
      registeredDate = ? WHERE emailAddr = ?";
      $stmt = mysqli_prepare($conn, $updateMembershipSQL) or die( mysqli_error($conn));
      $registeredDate = date('Y-m-d H:i:s');
      mysqli_stmt_bind_param($stmt, "ss", $registeredDate, $emailAddr);
      mysqli_stmt_execute($stmt);

      if (mysqli_stmt_affected_rows($stmt) > 0) { //Membership confirmed
        echo "<p>Membership confirmed!</p>";
        echo "<p>You will be redirected in a short while!</p>";
        header("Refresh:2;url=../loginForm.php");
      }
      else { //Membership confirmation failed
        echo "<p>Membership confimation failed!</p><br />";
      }
      mysqli_stmt_close($stmt);
    }
    mysqli_close($conn);
  }
  else { //Member's email does not require verfication; Redirect to error page
    header("Location:../error404.php");
  }
}
else { //Parameters not complete; Redirect to error page
  header("Location:../error404.php");
}
?>

<?php
echo makeFooter("../");
echo makePageEnd();
?>
