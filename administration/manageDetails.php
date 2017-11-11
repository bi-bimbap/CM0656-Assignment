<!-- TODO: Unable to add parsley js validation in popup modal -->

<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../functions.php');
require_once('../controls.php');
echo makePageStart("Manage My Details");
echo makeWrapper();
echo makeLoginLogoutBtn();
echo makeProfileButton();
echo makeNavMenu();
echo makeHeader("Manage My Details");
$environment = LOCAL; //TODO: Change to server
?>

<?php //Only show content if user is logged in
$_SESSION['userID'] = '3'; //TODO: Remove session
$_SESSION['userType'] = 'admin'; //TODO: Remove
$_SESSION['logged-in'] = true;

if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) && isset($_SESSION['userID']) && isset($_SESSION['userType'])) {
?>

<?php
//Retrieve user's details
$detailsSQL = "SELECT fullName, emailAddr, username, passwordHash, shippingAddr, securityQuestion, securityAns
FROM user WHERE userID = ?";
$stmt = mysqli_prepare($conn, $detailsSQL) or die( mysqli_error($conn));
mysqli_stmt_bind_param($stmt, "s", $_SESSION['userID']);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $fName, $eAddr, $uName, $pHash, $shipAddr, $sQuestion, $sAnswer);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);
?>

  <link href="../css/bootstrap.css" rel="stylesheet">
  <script src="../scripts/jquery.js"></script>
  <script src="../scripts/bootstrap.min.js"></script>
  <script src="../scripts/parsley.min.js"></script>
  <link rel="stylesheet" href="../css/parsley.css" type="text/css" />

  <script language="JavaScript" type="text/javascript">
  $(document).ready(function() {
    $('.modal').on('hidden.bs.modal', function(e) { //Reset field values when popup modal is closed
      $(".modal-body select").val("");
      $(".modal-body input").val("");
    });
  });
  </script>

  <div class="well">
    <!-- Tab options -->
    <ul class="nav nav-tabs" id="tabDetails">
      <li class="active"><a href="#tabProfile" data-toggle="tab">Profile</a></li>
      <li><a href="#tabLogin" data-toggle="tab">Login</a></li>
      <li><a href="#tabSecurity" data-toggle="tab">Security</a></li>
    </ul>
    <!-- End tab options -->

    <div id="myTabContent" class="tab-content">
      <!-- Profile tab -->
      <div class="tab-pane active in" id="tabProfile">
        <form id="tab" data-parsley-validate method="post">
          <div class="form-group">
            <label for="txtFullName">Full Name *</label>
            <input type="text" class="form-control" id='txtFullName' name='txtFullName' value="<?php if (isset($_POST['txtFullName'])) echo $_POST['txtFullName']; else echo $fName; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>
          </div>

          <div class="form-group">
            <label for="txtEmail">Email Address *</label>
            <input type="email" class="form-control" id="txtEmail" name="txtEmail" aria-describedby="emailHelp" placeholder="name@email.com" value="<?php if (isset($_POST['txtEmail'])) echo $_POST['txtEmail']; else echo $eAddr;  ?>" data-parsley-required="true" data-parsley-type="email" data-parsley-errors-messages-disabled/>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
          </div>

          <?php //Display username & address field if user is not an admin
          if($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior") {
            ?>

            <div class="form-group">
              <label for="txtUsername">Username *</label>
              <input type='text' class="form-control" id='txtUsername' name='txtUsername' value='<?php if (isset($_POST['txtUsername'])) echo $_POST['txtUsername']; else echo $uName; ?>' data-parsley-required='true' data-parsley-errors-messages-disabled/>
            </div>

            <div class="form-group">
              <label for="txtAddress">Shipping Address *</label>
              <textarea id='txtAddress' class="form-control" rows="3" name='txtAddress' data-parsley-required='true' data-parsley-errors-messages-disabled><?php if (isset($_POST['txtAddress'])) echo $_POST['txtAddress']; else echo $shipAddr; ?></textarea>
            </div>

            <?php
          } //End if($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior")
          ?>

          <input type="submit" class="btn btn-primary" id="btnSave" name='btnSave' value='Save'/>

          <!-- Popup modal -->
          <div class="modal fade" id="modalSecurity" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Provide Your Security Question & Answer</h4>
                </div>

                <!-- TODO: Unable to add parsley js validation in modal -->
                <!-- data-parsley-required="true" data-parsley-errors-messages-disabled -->
                <div class="modal-body">
                  <div class="form-group">
                    <label for="ddlSecurityQuestion">Security Question *</label>
                    <select class="form-control" id='ddlSecurityQuestion' name='ddlSecurityQuestion'>
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
                    <input class="form-control" id='txtSecurityAns' name='txtSecurityAns' value="<?php if (isset($_POST['txtSecurityAns'])) echo $_POST['txtSecurityAns']; ?>"/>
                  </div>
                </div>

                <div class="modal-footer">
                  <input type="submit" class="btn btn-primary" id="btnUpdateDetails" name="btnUpdateDetails" value="Update Details" />
                </div>
              </div>
              <!-- End popup modal content -->
            </div>
          </div>
          <!-- End popup modal -->
        </form>
      </div>
      <!-- End profile tab  -->

      <!-- Login tab -->
      <div class="tab-pane fade" id="tabLogin">
        <form id="tab2" data-parsley-validate method="post">
          <div class="form-group">
            <label for="txtPassword">New Password *</label>
            <!-- <input type="password" class="form-control" id='txtPassword' name='txtPassword' data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-equalto="#txtConfirmPassword"/> -->
            <input type="password" class="form-control" id='txtPassword' name='txtPassword' value='<?php if (isset($_POST['txtPassword'])) echo $_POST['txtPassword']; ?>' data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-equalto="#txtConfirmPassword" data-parsley-minlength="5"/>
          </div>

          <div class="form-group">
            <label for="txtConfirmPassword">Confirm New Password *</label>
            <!-- <input type="password" class="form-control" id='txtConfirmPassword' name='txtConfirmPassword' data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-equalto="#txtPassword"/> -->
            <input type="password" class="form-control" id='txtConfirmPassword' name='txtConfirmPassword' value='<?php if (isset($_POST['txtConfirmPassword'])) echo $_POST['txtConfirmPassword']; ?>' data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-equalto="#txtPassword" data-parsley-minlength="5"/>
          </div>

          <div>
            <input type="submit" class="btn btn-primary" id="btnUpdatePassword" name="btnUpdatePassword" value="Save" />
          </div>

          <!-- Popup modal -->
          <div class="modal fade" id="modalSecurity2" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Provide Your Security Question & Answer</h4>
                </div>

                <!-- TODO: Unable to add parsley js validation in modal -->
                <!-- data-parsley-required="true" data-parsley-errors-messages-disabled -->
                <div class="modal-body">
                  <div class="form-group">
                    <label for="ddlSecurityQuestion2">Security Question *</label>
                    <select class="form-control" id='ddlSecurityQuestion2' name='ddlSecurityQuestion2'>
                      <option value="" <?php if (isset($_POST['ddlSecurityQuestion2']) && $_POST['ddlSecurityQuestion2']=='') echo 'selected';?>>----SELECT----</option>
                      <option value="favouriteBook" <?php if (isset($_POST['ddlSecurityQuestion2']) && $_POST['ddlSecurityQuestion2']=='favouriteBook') echo 'selected';?>>What is your favourite book?</option>
                      <option value="maidenName" <?php if (isset($_POST['ddlSecurityQuestion2']) && $_POST['ddlSecurityQuestion2']=='maidenName') echo 'selected';?>>What is your mother's maiden name?</option>
                      <option value="favouriteFood" <?php if (isset($_POST['ddlSecurityQuestion2']) && $_POST['ddlSecurityQuestion2']=='favouriteFood') echo 'selected';?>>What is your favourite food?</option>
                      <option value="birthPlace" <?php if (isset($_POST['ddlSecurityQuestion2']) && $_POST['ddlSecurityQuestion2']=='birthPlace') echo 'selected';?>>What city were you born in?</option>
                      <option value="school" <?php if (isset($_POST['ddlSecurityQuestion2']) && $_POST['ddlSecurityQuestion2']=='school') echo 'selected';?>>Where did you go to high school/college?</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="txtSecurityAns2">Answer *</label>
                    <input class="form-control" id='txtSecurityAns2' name='txtSecurityAns2' value="<?php if (isset($_POST['txtSecurityAns2'])) echo $_POST['txtSecurityAns2']; ?>"/>
                  </div>
                </div>

                <div class="modal-footer">
                  <input type="submit" class="btn btn-primary" id="btnUpdateDetails2" name="btnUpdateDetails2" value="Update Details" />
                </div>
              </div>
              <!-- End popup modal content -->
            </div>
          </div>
          <!-- End popup modal -->
        </form>
      </div>
      <!-- End tab login -->

      <!-- Security tab -->
      <div class="tab-pane fade" id="tabSecurity">
        <form id="tab3" data-parsley-validate method="post">
          <div class="form-group">
            <label for="ddlSecurityQuestion3">Security Question *</label>
            <select class="form-control" id='ddlSecurityQuestion3' name='ddlSecurityQuestion3' data-parsley-required="true" data-parsley-errors-messages-disabled>
              <option value="" <?php if (isset($_POST['ddlSecurityQuestion3']) && $_POST['ddlSecurityQuestion3']=='') echo 'selected';?>>----SELECT----</option>
              <option value="favouriteBook" <?php if (isset($_POST['ddlSecurityQuestion3']) && $_POST['ddlSecurityQuestion3']=='favouriteBook') echo 'selected';?>>What is your favourite book?</option>
              <option value="maidenName" <?php if (isset($_POST['ddlSecurityQuestion3']) && $_POST['ddlSecurityQuestion3']=='maidenName') echo 'selected';?>>What is your mother's maiden name?</option>
              <option value="favouriteFood" <?php if (isset($_POST['ddlSecurityQuestion3']) && $_POST['ddlSecurityQuestion3']=='favouriteFood') echo 'selected';?>>What is your favourite food?</option>
              <option value="birthPlace" <?php if (isset($_POST['ddlSecurityQuestion3']) && $_POST['ddlSecurityQuestion3']=='birthPlace') echo 'selected';?>>What city were you born in?</option>
              <option value="school" <?php if (isset($_POST['ddlSecurityQuestion3']) && $_POST['ddlSecurityQuestion3']=='school') echo 'selected';?>>Where did you go to high school/college?</option>
            </select>
          </div>

          <div class="form-group">
            <label for="txtSecurityAns3">Answer *</label>
            <input class="form-control" id='txtSecurityAns3' name='txtSecurityAns3' value="<?php if (isset($_POST['txtSecurityAns3'])) echo $_POST['txtSecurityAns3']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>
          </div>

          <div>
            <input type="submit" class="btn btn-primary" id="btnUpdateSecurity" name="btnUpdateSecurity" value="Save" />
          </div>

          <!-- Popup modal -->
          <div class="modal fade" id="modalSecurity3" role="dialog">
            <div class="modal-dialog">
              <!-- Modal content-->
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                  <h4 class="modal-title">Provide Your Current Security Question & Answer</h4>
                </div>

                <!-- TODO: Unable to add parsley js validation in modal -->
                <!-- data-parsley-required="true" data-parsley-errors-messages-disabled -->
                <div class="modal-body">
                  <div class="form-group">
                    <label for="ddlSecurityQuestion4">Security Question *</label>
                    <select class="form-control" id='ddlSecurityQuestion4' name='ddlSecurityQuestion4'>
                      <option value="" <?php if (isset($_POST['ddlSecurityQuestion4']) && $_POST['ddlSecurityQuestion4']=='') echo 'selected';?>>----SELECT----</option>
                      <option value="favouriteBook" <?php if (isset($_POST['ddlSecurityQuestion4']) && $_POST['ddlSecurityQuestion4']=='favouriteBook') echo 'selected';?>>What is your favourite book?</option>
                      <option value="maidenName" <?php if (isset($_POST['ddlSecurityQuestion4']) && $_POST['ddlSecurityQuestion4']=='maidenName') echo 'selected';?>>What is your mother's maiden name?</option>
                      <option value="favouriteFood" <?php if (isset($_POST['ddlSecurityQuestion4']) && $_POST['ddlSecurityQuestion4']=='favouriteFood') echo 'selected';?>>What is your favourite food?</option>
                      <option value="birthPlace" <?php if (isset($_POST['ddlSecurityQuestion4']) && $_POST['ddlSecurityQuestion4']=='birthPlace') echo 'selected';?>>What city were you born in?</option>
                      <option value="school" <?php if (isset($_POST['ddlSecurityQuestion4']) && $_POST['ddlSecurityQuestion4']=='school') echo 'selected';?>>Where did you go to high school/college?</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label for="txtSecurityAns4">Answer *</label>
                    <input class="form-control" id='txtSecurityAns4' name='txtSecurityAns4' value="<?php if (isset($_POST['txtSecurityAns4'])) echo $_POST['txtSecurityAns4']; ?>"/>
                  </div>
                </div>

                <div class="modal-footer">
                  <input type="submit" class="btn btn-primary" id="btnUpdateDetails4" name="btnUpdateDetails4" value="Update Details" />
                </div>
              </div>
              <!-- End popup modal content -->
            </div>
          </div>
          <!-- End popup modal -->
        </form>
      </div>
      <!-- End tab security -->
    </div>
    <!-- End tab content -->
  </div>

  <?php
  if (isset($_POST['btnSave'])) { //Check if user is allowed to update personal details
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

    $emailApproved = true;
    //Compare if user changed his/her email
    if ($email != $eAddr) { //User changed his/her email
      //$emailChanged = true;
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
    }

    $usernameApproved = true;
    //$usernameChanged = false;
    if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
    (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) { //For normal member
      if ($username != $uName) { //User changed his/her username
        //$usernameChanged = true;
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
      }
    }

    //Allowed to update details; Request for security question & answer
    if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
    (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) { //For normal members
      if ($emailApproved && $usernameApproved) { //Check if email & username are valid
        echo '<script type="text/javascript"> $("#modalSecurity").modal("show")</script>';
      }
    }
    else { //For admin users
      if ($emailApproved) { //Check if email is valid
        echo '<script type="text/javascript"> $("#modalSecurity").modal("show")</script>';
      }
    }
  }
  ?>

  <?php
  if (isset($_POST['btnUpdateDetails'])) { //Update personal details
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

    if ($sQuestion == $question) { //Security question matches
      if ($sAnswer == $answer) { //Answer matches
        $emailChanged = false;

        if ($email != $eAddr) { //User changed his/her email; Send verification email
          $emailChanged = true;
          $memberConfirmationExpiryDate = time(); //Get current date
          $memberConfirmationExpiryDate = date('Y-m-d H:i:s', strtotime('+1 day', $memberConfirmationExpiryDate)); //Calculate url expiration date

          //Update details in database, including member confirmation expiry date
          $updateDetailsSQL = "UPDATE user SET fullName = ?, emailAddr = ?, shippingAddr = ?, username = ?,
          memberConfirmationExpiryDate = ?  WHERE userID = ?";
          $stmt = mysqli_prepare($conn, $updateDetailsSQL) or die( mysqli_error($conn));
          mysqli_stmt_bind_param($stmt, "ssssss", $fullName, $email, $shippingAddr, $username,
          $memberConfirmationExpiryDate, $_SESSION['userID']);
          mysqli_stmt_execute($stmt);
        }
        else {
          //Update details in database, excluding member confirmation expiry date
          $updateDetailsSQL = "UPDATE user SET fullName = ?, emailAddr = ?, shippingAddr = ?, username = ? WHERE userID = ?";
          $stmt = mysqli_prepare($conn, $updateDetailsSQL) or die( mysqli_error($conn));
          mysqli_stmt_bind_param($stmt, "sssss", $fullName, $email, $shippingAddr, $username, $_SESSION['userID']);
          mysqli_stmt_execute($stmt);
        }

        if (mysqli_stmt_affected_rows($stmt) > 0) {
          if ($emailChanged) { //Send email to member
            //Encode variables to be used in url
            $emailEncoded = urlencode(base64_encode($email));
            $memberConfirmationExpiryDateEncoded = urlencode($memberConfirmationExpiryDate);
            $url = $environment . "/CM0656-Assignment/administration/Member_confirmMembership.php?mail=" . $emailEncoded .
            "&exDate=" . $memberConfirmationExpiryDateEncoded;
            if (sendEmail($email, $fullName, 'Please Verify Your Email Address', '../email/notifier_verifyEmail.html', $url)) {
              echo "<script>alert('Details updated! Please check your email to verify your updated email address.')</script>";
            }
            else {
              echo "<script>alert('Failed to send email!')</script>";
            }
          }
          else { //Email unchanged
            echo "<script>alert('Details updated!')</script>";
          }
        }
        else { //SQL failed to execute
          echo "<script>alert('Failed to update details!')</script>";
        }
      }
      else { //Answer does not match
        echo "<script>alert('Incorrect security question/answer combination!')</script>";
        echo '<script type="text/javascript"> $("#modalSecurity").modal("show")</script>';
      }
    }
    else { //Security question does not match
      echo "<script>alert('Incorrect security question/answer combination!')</script>";
      echo '<script type="text/javascript"> $("#modalSecurity").modal("show")</script>';
    }
    mysqli_close($conn);
  }
  ?>

  <?php
  if (isset($_POST['btnUpdatePassword'])) { //Check if user is allowed to update password
    //Obtain user input
    $password = filter_has_var(INPUT_POST, 'txtPassword') ? $_POST['txtPassword']: null;
    $confirmPassword = filter_has_var(INPUT_POST, 'txtConfirmPassword') ? $_POST['txtConfirmPassword']: null;

    //Trim white space
    $password = trim($password);
    $confirmPassword = trim($confirmPassword);

    //Sanitize user input
    $password = filter_var($password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $confirmPassword = filter_var($confirmPassword, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    if (password_verify($password, $pHash)) { //Check if new & old password are the same; If yes, do not allow
      echo '<script>alert("New password cannot be the same as your current password!")</script>';
    }
    else { //New & old password are different
      echo '<script type="text/javascript"> $("#modalSecurity2").modal("show")</script>';
      echo '<script>$("#tabDetails li:eq(1) a").tab("show")</script>';
    }
  }
  ?>

  <?php
  if (isset($_POST['btnUpdateDetails2'])) { //Update password
    //Obtain user input
    $password = filter_has_var(INPUT_POST, 'txtPassword') ? $_POST['txtPassword']: null;
    $confirmPassword = filter_has_var(INPUT_POST, 'txtConfirmPassword') ? $_POST['txtConfirmPassword']: null;
    $question = filter_has_var(INPUT_POST, 'ddlSecurityQuestion2') ? $_POST['ddlSecurityQuestion2']: null;
    $answer = filter_has_var(INPUT_POST, 'txtSecurityAns2') ? $_POST['txtSecurityAns2']: null;

    //Trim white space
    $password = trim($password);
    $confirmPassword = trim($confirmPassword);
    $answer = trim($answer);

    //Sanitize user input
    $password = filter_var($password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $confirmPassword = filter_var($confirmPassword, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $answer = filter_var($answer, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    if ($sQuestion == $question) { //Security question matches
      if ($sAnswer == $answer) { //Answer matches
        $updatePasswordSQL = "UPDATE user SET passwordHash = ? WHERE userID = ?";
        $stmt = mysqli_prepare($conn, $updatePasswordSQL) or die( mysqli_error($conn));
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);
        mysqli_stmt_bind_param($stmt, "ss", $passwordHash, $_SESSION['userID']);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
          echo "<script>alert('Password updated!')</script>";
        }
        else {
          echo "<script>alert('Unable to update password!')</script>";
        }
        //Clear textbox
        echo "<script>$('#txtPassword').val('')</script>";
        echo "<script>$('#txtConfirmPassword').val('')</script>";
      }
      else { //Answer does not match
        echo "<script>alert('Incorrect security question/answer combination!')</script>";
        echo '<script type="text/javascript"> $("#modalSecurity2").modal("show")</script>';
        echo '<script>$("#tabDetails li:eq(1) a").tab("show")</script>';
      }
    }
    else { //Security question does not match
      echo "<script>alert('Incorrect security question/answer combination!')</script>";
      echo '<script type="text/javascript"> $("#modalSecurity2").modal("show")</script>';
      echo '<script>$("#tabDetails li:eq(1) a").tab("show")</script>';
    }
  }
  ?>

  <?php
  if (isset($_POST['btnUpdateSecurity'])) { //Display popup modal to update security question/answer
    echo '<script type="text/javascript"> $("#modalSecurity3").modal("show")</script>';
    echo '<script>$("#tabDetails li:eq(2) a").tab("show")</script>';
  }
  ?>

  <?php
  if (isset($_POST['btnUpdateDetails4'])) { //Update security question/answer
    //Obtain user input
    //Security question/answer to be updated
    $updatedQuestion = filter_has_var(INPUT_POST, 'ddlSecurityQuestion3') ? $_POST['ddlSecurityQuestion3']: null;
    $updatedAnswer = filter_has_var(INPUT_POST, 'txtSecurityAns3') ? $_POST['txtSecurityAns3']: null;
    //Scurity question/answer from popup modal; Verify that it matches the one in database
    $modalQuestion = filter_has_var(INPUT_POST, 'ddlSecurityQuestion4') ? $_POST['ddlSecurityQuestion4']: null;
    $modalAnswer = filter_has_var(INPUT_POST, 'txtSecurityAns4') ? $_POST['txtSecurityAns4']: null;

    //Trim white space
    $updatedAnswer = trim($updatedAnswer);
    $modalAnswer = trim($modalAnswer);

    //Sanitize user input
    $updatedAnswer = filter_var($updatedAnswer, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $modalAnswer = filter_var($modalAnswer, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    if ($sQuestion == $modalQuestion) { //Security question matches the one in database
      if ($sAnswer == $modalAnswer) { //Security answer matches the one in database
        $updateSecuritySQL = "UPDATE user SET securityQuestion = ?, securityAns = ? WHERE userID = ?";
        $stmt = mysqli_prepare($conn, $updateSecuritySQL) or die( mysqli_error($conn));
        mysqli_stmt_bind_param($stmt, "sss", $updatedQuestion, $updatedAnswer, $_SESSION['userID']);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
          echo "<script>alert('Security question/answer updated!')</script>";
        }
        else {
          echo "<script>alert('Failed to update security question/answer!')</script>";
        }
        //Clear textbox
        echo "<script>$('#ddlSecurityQuestion3').val('')</script>";
        echo "<script>$('#txtSecurityAns3').val('')</script>";
      }
      else { //Security answer does not match
        echo "<script>alert('Incorrect security question/answer combination!')</script>";
        echo '<script type="text/javascript"> $("#modalSecurity3").modal("show")</script>';
        echo '<script>$("#tabDetails li:eq(2) a").tab("show")</script>';
      }
    }
    else { //Security question does not match
      echo "<script>alert('Incorrect security question/answer combination!')</script>";
      echo '<script type="text/javascript"> $("#modalSecurity3").modal("show")</script>';
      echo '<script>$("#tabDetails li:eq(2) a").tab("show")</script>';
    }
  }
  ?>

  <?php
}
else { //Did not login; Redirect to home page
  echo "<script>alert('You are not allowed here!')</script>";
  header("Refresh:1;url=index.php"); //TODO: change url
}
?>

<?php
echo makeFooter();
echo makePageEnd();
?>
