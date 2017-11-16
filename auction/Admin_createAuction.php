<?php
// ini_set("session.save_path", "");
// session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Create Auction");
echo makeNavMenu();
echo makeHeader("Create New Auction");
$environment = LOCAL; //TODO: Change to server
?>

<link rel='stylesheet' href='../css/jquery-ui.min.css' />
<script src="../scripts/jquery.js"></script>
<script src='../scripts/jquery-ui.min.js'></script>
<script src="../scripts/parsley.min.js"></script>
<link rel="stylesheet" href="../css/stylesheet.css" type="text/css" />
<link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="../css/parsley.css" type="text/css" />
<script>
$(document).ready(function() {
  var dateToday = new Date();
  var yrRange = dateToday.getFullYear() + ":" + (dateToday.getFullYear() + 5); //Allow year range from current year until 5 years later

  $("#aucStartDate").datepicker({
    dateFormat: 'yy-mm-dd', //'Format: 2017-11-01
    showWeek: true, 
    yearRange: yrRange,
    changeMonth: true,
    changeYear: true,
  });
});
</script>

<form id="createAuctionForm" data-parsley-validate method="post">

  <p>Title: <input type="text" id='aucTitle' name='aucTitle' data-parsley-required="true" data-parsley-errors-messages-disabled/></p>
  <p>Description: <input type="text" id='aucDesc' name='aucDesc' data-parsley-required="true" data-parsley-errors-messages-disabled/></p>
  <p>Item Name: <input type="text" id='aucItem' name='aucItem' data-parsley-required="true" data-parsley-errors-messages-disabled/></p>
  <p>Start Price: <input type="text" id='aucStartPrice' name='aucStartPrice' data-parsley-required="true" data-parsley-errors-messages-disabled/></p>
  <p>Buy it now? <input type="checkbox" id='aucBuyItNow' name='aucBuyItNow'/></p>
  <p>Start Date: <input id='aucStartDate' name='aucStartDate' size='8' data-parsley-trigger="change" data-parsley-required="true" data-parsley-errors-messages-disabled/></p>
  <p>End Date: <input id='aucEndDate' name='aucEndDate' size='8' data-parsley-trigger="change" data-parsley-required="true" data-parsley-errors-messages-disabled/></p>

  <p class='errorMessage'><small>*All fields are required to complete the registration</small></p>
  <input type='submit' value='Submit' name='btnSubmit'/>
</form>

<?php
if (isset($_POST['btnSubmit'])) { //Clicked on submit button
  //Obtain user input
  $fullName = filter_has_var(INPUT_POST, 'txtFullName') ? $_POST['txtFullName']: null;
  $password = filter_has_var(INPUT_POST, 'txtPassword') ? $_POST['txtPassword']: null;
  $confirmPassword = filter_has_var(INPUT_POST, 'txtConfirmPassword') ? $_POST['txtConfirmPassword']: null;
  if (!isset($_GET['mail']) && !isset($_GET['name']) && !isset($_GET['exDate'])) { //For normal member registration use
    $username = filter_has_var(INPUT_POST, 'txtUsername') ? $_POST['txtUsername']: null;
    $email = filter_has_var(INPUT_POST, 'txtEmail') ? $_POST['txtEmail']: null;
    $dob = filter_has_var(INPUT_POST, 'txtDOB') ? $_POST['txtDOB']: null;
    $shippingAddr = filter_has_var(INPUT_POST, 'txtAddress') ? $_POST['txtAddress']: null;
  }
  $securityQuestion = filter_has_var(INPUT_POST, 'ddlSecurityQuestion') ? $_POST['ddlSecurityQuestion']: null;
  $securityAns = filter_has_var(INPUT_POST, 'txtSecurityAns') ? $_POST['txtSecurityAns']: null;

  //Trim white space
  $fullName = trim($fullName);
  $email = trim($email);
  $password = trim($password);
  $confirmPassword = trim($confirmPassword);
  if (!isset($_GET['mail']) && !isset($_GET['name']) && !isset($_GET['exDate'])) { //For normal member registration use
    $username = trim($username);
    $dob = trim($dob);
    $shippingAddr = trim($shippingAddr);
  }
  $securityAns = trim($securityAns);

  //Sanitize user input
  $fullName = filter_var($fullName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $email = filter_var($email, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $password = filter_var($password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $confirmPassword = filter_var($confirmPassword, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  if (!isset($_GET['mail']) && !isset($_GET['name']) && !isset($_GET['exDate'])) { //Only for normal member registration use
    $username = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $dob = filter_var($dob, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $shippingAddr = filter_var($shippingAddr, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  }
  $securityAns = filter_var($securityAns, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

  $password = password_hash($password, PASSWORD_DEFAULT); //Hash password

  if (!isset($_GET['mail']) && !isset($_GET['name']) && !isset($_GET['exDate'])) { //For normal member registration use
    //Determine user type
    $birthDate = new DateTime($dob);
    $currentDate = new DateTime(date("Y-m-d"));
    $diff = $currentDate->diff($birthDate);

    if ($diff->y <= 18) {
      $userType = "junior";
    }
    else {
      $userType = "senior";
    }

    $userStatus = "pending";
    $memberConfirmationExpiryDate = time(); //Get current date
    $memberConfirmationExpiryDate = date('Y-m-d H:i:s', strtotime('+1 day', $memberConfirmationExpiryDate)); //Calculate url expiration date

    $emailSQL = "SELECT userID FROM user WHERE emailAddr = ?";
    $stmt = mysqli_prepare($conn, $emailSQL) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $count = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($count > 0) {
      echo "<script>alert('An account has already been registered under this email address!')</script>";
    }
    else {
      $usernameSQL = "SELECT userID FROM user WHERE username = ?";
      $stmt = mysqli_prepare($conn, $usernameSQL) or die( mysqli_error($conn));
      mysqli_stmt_bind_param($stmt, "s", $username);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $count = mysqli_stmt_num_rows($stmt);
      mysqli_stmt_close($stmt);

      if ($count == 0) {
        try {
          //echo "<script>alert('Registration successful!')</script>";
          $signupSQL = "INSERT INTO user (fullName, username, emailAddr, passwordHash, shippingAddr, dob, userType,
            userStatus, memberConfirmationExpiryDate, securityQuestion, securityAns) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $signupSQL) or die( mysqli_error($conn));
            mysqli_stmt_bind_param($stmt, "ssssssssss", $fullName, $username, $email, $password, $shippingAddr, $dob, $userType,
            $userStatus, $memberConfirmationExpiryDate, $securityQuestion, $securityAns);
            mysqli_stmt_execute($stmt);

            if (mysqli_stmt_affected_rows($stmt) > 0) {
              mysqli_stmt_close($stmt);

              //Encode variables to be used in url
              $emailEncoded = urlencode(base64_encode($email));
              $memberConfirmationExpiryDateEncoded = urlencode(base64_encode($memberConfirmationExpiryDate));

              $url = $environment . "/CM0656-Assignment/administration/Member_confirmMembership.php?mail=" . $emailEncoded .
              "&exDate=" . $memberConfirmationExpiryDateEncoded;
              if (sendEmail($email, $fullName, 'Please Verify Your Email Address', '../email/notifier_verifyEmail.html', $url)) {
                header('Location:' . "Member_signupSuccessful.php");
              }
              else {
                echo "<script>alert('Failed to send email!')</script>";
              }
            }
          }
          catch(Exception $e) {
            echo "<script>alert('Signup failed!')</script>";
            //echo $e->getErrorsMessages();
          }
        }
        else {
          echo "<script>alert('This username has been taken!')</script>";
        }
      }
    }
    else { //For administrator's registration use
      $userType = "admin";
      $userStatus = "active";
      $memberConfirmationExpiryDate = NULL;

      try {
        $signupSQL = "UPDATE user SET fullName = ?, passwordHash = ?, userType = ?, userStatus = ?,
        memberConfirmationExpiryDate = ?, securityQuestion = ?,  securityAns = ? WHERE emailAddr = ?";
        $stmt = mysqli_prepare($conn, $signupSQL);
        mysqli_stmt_bind_param($stmt, "ssssssss", $fullName, $password, $userType,
        $userStatus, $memberConfirmationExpiryDate, $securityQuestion, $securityAns, $email);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
          echo "<script>alert('Signup complete!')</script>";
          header("Location:../loginForm.php");
        }
        else {
          echo "<script>alert('Signup failed!')</script>";
        }
      }
      catch (Exception $e) {
        echo "<script>alert('Signup failed!')</script>";
        //echo $e->getErrorsMessages();
      }
      mysqli_stmt_close($stmt);
      mysqli_close($conn);
    }
  }
  ?>


<?php
echo makeFooter();
echo makePageEnd();
?>
