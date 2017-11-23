<?php
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Sign Up");
echo makeWrapper();
echo "<form method='post'>" . makeLoginLogoutBtn() . "</form>";
echo makeProfileButton();
echo makeNavMenu();
echo makeHeader("Sign Up");
$environment = WEB; //TODO: Change to server
?>

<?php //Complete admin registration
if (isset($_GET['mail']) && isset($_GET['name']) && isset($_GET['exDate'])) { //Get email address, name & membership confirmation expiry date
  //Decode url-encoded string
  $email = urldecode(base64_decode($_GET['mail']));
  $fullName = urldecode(base64_decode($_GET['name']));
  $expiryDate = urldecode($_GET['exDate']);

  //Trim white space
  $email = trim($email);
  $fullName = trim($fullName);
  $expiryDate = trim($expiryDate);

  //Sanitize url parameters
  $email = filter_var($email, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $fullName = filter_var($fullName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $expiryDate = filter_var($expiryDate, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $expiryDate = date('Y-m-d H:i:s', strtotime($expiryDate)); //Convert string to date time

  //Check if email address & URL expiry date matches the one in database
  $validationSQL = "SELECT userID FROM user WHERE emailAddr = ? AND memberConfirmationExpiryDate = ?";
  $stmt = mysqli_prepare($conn, $validationSQL) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmt, "ss", $email, $expiryDate);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_store_result($stmt);
  $count = mysqli_stmt_num_rows($stmt);
  mysqli_stmt_close($stmt);

  if ($count > 0) { //Email & URL expiry date matches
    if (date('Y-m-d H:i:s') > $expiryDate) { //Link expired; Resend email to new admin
      $memberConfirmationExpiryDate = time(); //Get current date
      $memberConfirmationExpiryDate = date('Y-m-d H:i:s', strtotime('+1 day', $memberConfirmationExpiryDate)); //Calculate url expiration date

      $updateDateSQL = "UPDATE user SET memberConfirmationExpiryDate = ?, registeredDate = ? WHERE emailAddr = ?";
      $stmt = mysqli_prepare($conn, $updateDateSQL);
      $registeredDate = date('Y-m-d H:i:s');
      mysqli_stmt_bind_param($stmt, "sss", $registeredDate, $memberConfirmationExpiryDate, $email);
      mysqli_stmt_execute($stmt);

      if (mysqli_stmt_affected_rows($stmt) > 0) { //Update successful
        //Encode variables to be used in url
        $emailEncoded = urlencode(base64_encode($email));
        $fullNameEncoded = urlencode(base64_encode($fullName));
        $memberConfirmationExpiryDateEncoded = urlencode(base64_encode($memberConfirmationExpiryDate));
        $url = $environment . "/CM0656-Assignment/administration/Member_signup.php?mail=" . $emailEncoded . "&name=" . $fullNameEncoded
        . "&exDate=" . $memberConfirmationExpiryDateEncoded;

        if (sendEmail($email, $fullName, 'Please Complete Your Registration', '../email/notifier_completeRegistration.html', $url)) { //Email sent
          echo "<script>alert('The link you clicked on has expired. Another email has been sent to your email address. Follow the instructions to complete the registration process.')</script>";
          header("Refresh:1;url=../index.php"); //TODO: Change url
        }
        else { //Email failed to send
          echo "<script>alert('Failed to send email!')</script>";
          header("Refresh:1;url=../index.php"); //TODO: Change url
        }
      }
      else {
        echo "<script>alert('Failed to send email!')</script>";
      }
    }
  }
  else { //Email & URL expiry date does not match; Redirect to error page
    header("Location:../error404.php");
  }
}
?>

<script src="../scripts/jquery.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
<link rel="stylesheet" href="../css/stylesheet.css" type="text/css" />
<link rel='stylesheet' href='../css/jquery-ui.min.css' />
<link href="../css/bootstrap.css" rel="stylesheet">
<script src="../scripts/jquery.js"></script>
<script src='../scripts/jquery-ui.min.js'></script>
<script src="../scripts/bootstrap.min.js"></script> <!-- Note: bootstrap js must be after jquery ui for tooltip data-placement to work -->

<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
  $("#txtDOB").datepicker({
    dateFormat: 'yy-mm-dd', //'Format: 2017-11-01
    showWeek: true,
    maxDate: '-10Y', //Members must be at least 10 years old from current year
    yearRange: '-150:+0', //Allow max age up to 150 years old
    changeMonth: true,
    changeYear: true,
  });

  $('[data-toggle="tooltip"]').tooltip(); //Trigger tooltips
});
</script>

<div class="content">
  <div class="container">
    <form id="signUpForm" class="form-inline" data-parsley-validate method="post">
      <?php
      if (!isset($_GET['mail']) && !isset($_GET['name']) && !isset($_GET['exDate'])) { //Only visible to normal members
        echo "<h6>New to Ima's Official Fanbase? Sign Up</h6>";
      }
      ?>

      <p><h4 id="label">Full Name:</h4> <input type="text" id='txtFullName' name='txtFullName' value="<?php if (isset($_POST['txtFullName'])) echo $_POST['txtFullName']; else if (isset($_GET['name'])) echo $fullName; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/></p>
      <p><h4 id="label">Email Address:</h4> <input type="email" id='txtEmail' name='txtEmail' placeholder="name@email.com" value="<?php if (isset($_POST['txtEmail'])) echo $_POST['txtEmail']; else if (isset($_GET['mail'])) echo $email; ?>" data-parsley-required="true" data-parsley-type="email" data-parsley-errors-messages-disabled/></p>

      <?php
      if (!isset($_GET['mail']) && !isset($_GET['name']) && !isset($_GET['exDate'])) { //Only visible to normal members
        echo "<p><h4 id='label'>Username:</h4> <input type='text' id='txtUsername' name='txtUsername' value='" . (isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '') . "' data-parsley-required='true' data-parsley-errors-messages-disabled/></p>";
      }
      ?>

      <div>
        <div id="password"><h4 id="label">Password:</h4> <input type="password" id='txtPassword' data-toggle="tooltip" data-placement="right" title="Min. 5 characters" data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-equalto="#txtConfirmPassword" data-parsley-minlength="5" maxlength="60" /></div>
        <div id="password"><h4 id="label">Confirm Password:</h4> <input type="password" id='txtConfirmPassword' data-toggle="tooltip" data-placement="right" title="Min. 5 characters" data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-equalto="#txtPassword" data-parsley-minlength="5" maxlength="60" /></div>
      </div>

      <?php
      if (!isset($_GET['mail']) && !isset($_GET['name']) && !isset($_GET['exDate'])) { //Only visible to normal members
        echo "<p><h4 id='label'>Date of Birth:</h4> <input id='txtDOB' name='txtDOB' size='8' placeholder='2017-10-01' value='". (isset($_POST['txtDOB']) ? $_POST['txtDOB'] : '') . "' readonly data-parsley-trigger='change' data-parsley-required='true' data-parsley-errors-messages-disabled/></p>";
        echo "<p><h4 id='label'>Shipping Address:</h4> <textarea id='txtAddress' name='txtAddress' data-parsley-required='true' data-parsley-errors-messages-disabled>" . (isset($_POST['txtAddress']) ? $_POST['txtAddress'] : '') . "</textarea></p>";
      }
      ?>

      <p><h4 id="label">Security Question:</h4>
        <select id='ddlSecurityQuestion' name='ddlSecurityQuestion' value="<?php if (isset($_POST['ddlSecurityQuestion'])) echo $_POST['ddlSecurityQuestion']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled>
          <option value="" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='') echo 'selected';?>>----SELECT----</option>
          <option value="favouriteBook" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='favouriteBook') echo 'selected';?>>What is your favourite book?</option>
          <option value="maidenName" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='maidenName') echo 'selected';?>>What is your mother's maiden name?</option>
          <option value="favouriteFood" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='favouriteFood') echo 'selected';?>>What is your favourite food?</option>
          <option value="birthPlace" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='birthPlace') echo 'selected';?>>What city were you born in?</option>
          <option value="school" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='school') echo 'selected';?>>Where did you go to high school/college?</option>
        </select>
      </p>

      <p><h4 id="label">Answer:</h4> <input id='txtSecurityAns' name='txtSecurityAns' value="<?php if (isset($_POST['txtSecurityAns'])) echo $_POST['txtSecurityAns']; else echo ''; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/></p>
      <p><small>*All fields are required to complete the registration</small></p>
      <input type='submit' value='Submit' name='btnSubmit'/>
    </form>
  </div> <!-- End container div -->
</div> <!-- End content div -->

<script src="../scripts/parsley.min.js"></script>
<link rel="stylesheet" href="../css/parsley.css" type="text/css" />

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

    if ($diff->y < 18) {
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
