<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
//include_once '../config.php';
require_once('../controls.php');
//require_once('../functions.php');
echo makePageStart("Manage My Details");
echo makeHeader("Manage My Details");
//$environment = LOCAL;
?>

<link href="../css/bootstrap.css" rel="stylesheet">
<script src="../scripts/jquery.js"></script>
<script src="../scripts/bootstrap.min.js"></script>

<script language="JavaScript" type="text/javascript">

</script>

<!-- <link rel='stylesheet' href='../css/jquery-ui.min.css' />
<script src='../scripts/jquery-ui.min.js'></script>
<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
$("#txtDOB").datepicker({
dateFormat: 'yy-mm-dd', //'Format: 2017-11-01
showWeek: true,
maxDate: '0d', //Constrain maximum date to today
yearRange: '-100:+0', //Allow year range from 100 years ago until current year
changeMonth: true,
changeYear: true,
});
});
</script> -->

<script src="../scripts/parsley.min.js"></script>
<link rel="stylesheet" href="../css/parsley.css" type="text/css" />

<div class="well">
  <ul class="nav nav-tabs">
    <li class="active"><a href="#home" data-toggle="tab">Profile</a></li>
    <li><a href="#profile" data-toggle="tab">Password</a></li>
  </ul>

  <div id="myTabContent" class="tab-content">
    <div class="tab-pane active in" id="home">
      <form id="tab" data-parsley-validate method="post">
        <div class="form-group">
          <label for="txtFullName">Full Name * </label>
          <input type="text" class="form-control" id='txtFullName' name='txtFullName' value="<?php if (isset($_POST['txtFullName'])) echo $_POST['txtFullName']; else echo 'cyq'; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>
        </div>

        <div class="form-group">
          <label for="txtEmail">Email Address *</label>
          <input type="email" class="form-control" id="txtEmail" aria-describedby="emailHelp" placeholder="name@email.com" value="<?php if (isset($_POST['txtEmail'])) echo $_POST['txtEmail']; else echo 'sjm@gmail.com'; ?>" data-parsley-required="true" data-parsley-type="email" data-parsley-errors-messages-disabled/>
          <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>

        <div class="form-group">
          <label for="txtUsername">Username *</label>
          <input type='text' class="form-control" id='txtUsername' name='txtUsername' value='<?php if (isset($_POST['txtUsername'])) echo $_POST['txtUsername']; ?>' data-parsley-required='true' data-parsley-errors-messages-disabled/>
        </div>

        <div class="form-group">
          <label for="txtAddress">Shipping Address *</label>
          <textarea id='txtAddress' class="form-control" rows="3" name='txtAddress' data-parsley-required='true' data-parsley-errors-messages-disabled><?php if (isset($_POST['txtAddress'])) echo $_POST['txtAddress']; else echo '123'; ?></textarea>
        </div>

        <input type="submit" class="btn btn-primary" id="btnSave" name='btnSave' value='Save'/>
      </form>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="modalSecurity" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Provide Your Security Question & Answer</h4>
        </div>

        <div class="modal-body">
          <form data-parsley-validate method="post">
            <div class="form-group">
              <label for="ddlSecurityQuestion">Security Question * </label>
              <select class="form-control" id='ddlSecurityQuestion' name='ddlSecurityQuestion' value="<?php if (isset($_POST['ddlSecurityQuestion'])) echo $_POST['ddlSecurityQuestion']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled>
                <option value="" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='') echo 'selected';?>>----SELECT----</option>
                <option value="favouriteBook" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='favouriteBook') echo 'selected';?>>What is your favourite book?</option>
                <option value="maidenName" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='maidenName') echo 'selected';?>>What is your mother's maiden name?</option>
                <option value="favouriteFood" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='favouriteFood') echo 'selected';?>>What is your favourite food?</option>
                <option value="birthPlace" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='birthPlace') echo 'selected';?>>What city were you born in?</option>
                <option value="school" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='school') echo 'selected';?>>Where did you go to high school/college?</option>
              </select>
            </div>

            <div class="form-group">
              <label for="txtSecurityAns">Answer *</label>
              <input class="form-control" id='txtSecurityAns' name='txtSecurityAns' value="<?php if (isset($_POST['txtSecurityAns'])) echo $_POST['txtSecurityAns']; else echo '123'; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>
            </div>
          </div>

          <div class="modal-footer">
            <input type="submit" class="btn btn-primary" id="btnUpdateDetails" name="btnUpdateDetails" value="Update Details" />
          </div>
        </form>
      </div>
    </div>

    <div class="tab-pane fade" id="profile">
      <form id="tab2">
        <label>New Password</label>
        <input type="password" class="input-xlarge">
        <div>
          <button class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>

  <?php
  if (isset($_POST['btnSave'])) { //Clicked on submit button
    $_SESSION['userID'] = '3'; //TODO: Remove
    $_SESSION['userType'] = 'junior'; //TODO: Remove



    //Obtain user input
    $email = filter_has_var(INPUT_POST, 'txtEmail') ? $_POST['txtEmail']: null;

    if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
    (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) { //For normal member
      $username = filter_has_var(INPUT_POST, 'txtUsername') ? $_POST['txtUsername']: null;
    }

    //Trim white space
    $email = trim($email);

    if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
    (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) { //For normal member
      $username = trim($username);
    }

    //Sanitize user input
    $email = filter_var($email, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
    (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) { //For normal member
      $username = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    }

    //Get user's existing email & username
    $detailsSQL = "SELECT emailAddr, username FROM user WHERE userID = ?";
    $stmt = mysqli_prepare($conn, $detailsSQL) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['userID']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $existingEmail, $existingUsername);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    $emailApproved = true;
    $emailChanged = false;
    //Compare if user changed his/her email
    if ($email != $existingEmail) { //User changed his/her email
      $emailChanged = true;
      //Check if new email is already associated with an account; If yes, do not allow changes
      $emailSQL = "SELECT fullName FROM user WHERE emailAddr = ? AND userID != ?";
      $stmt = mysqli_prepare($conn, $emailSQL) or die( mysqli_error($conn));
      mysqli_stmt_bind_param($stmt, "ss", $email, $_SESSION['userID']);
      mysqli_stmt_execute($stmt);
      mysqli_stmt_store_result($stmt);
      $count = mysqli_stmt_num_rows($stmt);
      mysqli_stmt_close($stmt);

      if ($count > 0) {
        $emailApproved = false;
        echo "<script>alert('An account has already been registered under this email address!')</script>";
      }
      else {
        $usernameApproved = true;
        $usernameChanged = false;
        $extraSQL = "";
        if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
        (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) { //For normal member
          if ($username != $existingUsername) { //User changed his/her username
            $usernameChanged = true;
            //Check if new username is taken; If yes, do not allow changes
            $usernameSQL = "SELECT fullName FROM user WHERE username = ? AND userID != ?";
            $stmt = mysqli_prepare($conn, $usernameSQL) or die( mysqli_error($conn));
            mysqli_stmt_bind_param($stmt, "ss", $username, $_SESSION['userID']);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $count = mysqli_stmt_num_rows($stmt);
            mysqli_stmt_close($stmt);

            if ($count > 0) {
              $usernameApproved = false;
              echo "<script>alert('This username has been taken!')</script>";
            }
            else {
              $extraSQL = ", username = ?";
            }
          }
        }

        //$show_modal = false;
        if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
        (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) { //For normal member
          if ($emailApproved && $usernameApproved) {
            //$show_modal = true;
            echo '<script type="text/javascript"> $("#modalSecurity").modal("show")</script>';
          }
        }
        else {
          if ($emailApproved) {
            //$show_modal = true;
            echo '<script type="text/javascript"> $("#modalSecurity").modal("show")</script>';
          }
        }
      }
    }
  }
  ?>

  <?php
  if (isset($_POST['btnUpdateDetails'])) {
    $_SESSION['userID'] = '3'; //TODO: Remove
    $_SESSION['userType'] = 'junior'; //TODO: Remove

    //Obtain user input
    $fullName = filter_has_var(INPUT_POST, 'txtFullName') ? $_POST['txtFullName']: null;
    $email = filter_has_var(INPUT_POST, 'txtEmail') ? $_POST['txtEmail']: null;
    $question = filter_has_var(INPUT_POST, 'ddlSecurityQuestion') ? $_POST['ddlSecurityQuestion']: null;
    $answer = filter_has_var(INPUT_POST, 'txtSecurityAns') ? $_POST['txtSecurityAns']: null;

    if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
    (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) { //For normal member
      $username = filter_has_var(INPUT_POST, 'txtUsername') ? $_POST['txtUsername']: null;
      $shippingAddr = filter_has_var(INPUT_POST, 'txtAddress') ? $_POST['txtAddress']: null;
    }

    //Trim white space
    $fullName = trim($fullName);
    $email = trim($email);
    $answer = trim($answer);

    if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
    (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) { //For normal member
      $username = trim($username);
      $shippingAddr = trim($shippingAddr);
    }

    //Sanitize user input
    $fullName = filter_var($fullName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $email = filter_var($email, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $answer = filter_var($answer, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
    (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) { //For normal member
      $username = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
      $shippingAddr = filter_var($shippingAddr, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    }

    //Get user's existing email & username
    $detailsSQL = "SELECT securityQuestion, securityAns FROM user WHERE userID = ?";
    $stmt = mysqli_prepare($conn, $detailsSQL) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "s", $_SESSION['userID']);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $securityQuestion, $securityAns);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    if ($securityQuestion == $question) { //Security question matches
      if ($securityAns == $answer) { //Answer matches
        echo "yes";
        // //Update details in database
        // $updateDetailsSQL = "UPDATE user SET fullName = ?, emailAddr = ?, shippingAddr = ?" . $extraSQL . " WHERE userID = ?";
        // $stmt = mysqli_prepare($conn, $updateDetailsSQL) or die( mysqli_error($conn));
        // if ($extraSQL != "") {
        //   mysqli_stmt_bind_param($stmt, "sssss", $fullName, $email, $shippingAddr, $username, $userID);
        //
        // }
        // else {
        //   mysqli_stmt_bind_param($stmt, "ssss", $fullName, $email, $shippingAddr, $userID);
        // }
        // mysqli_stmt_execute($stmt);
        //
        // if (mysqli_stmt_affected_rows($stmt) > 0) {
        //   echo "<script>alert('Details updated!')</script>";
        // }
        // else {
        //   echo "<script>alert('Failed to update details!')</script>";
        // }
      }
      else { //Answer does not match
        //echo "no";
        echo '<script type="text/javascript"> $("#modalSecurity").modal("show")</script>';

      }
    }
    else { //Security question does not match
      //echo "no";
      echo '<script type="text/javascript"> $("#modalSecurity").modal("show")</script>';
    }
  }
  ?>

  <?php
  echo makeFooter();
  echo makePageEnd();
  ?>
