<?php
ini_set("session.save_path", "");
session_start(); //start session
include '../db/database_conn.php'; //include database
require_once('../controls.php');
echo makePageStart("Sign Up");
echo makeHeader("Sign Up");
?>

<link rel='stylesheet' href='../css/jquery-ui.min.css' />
<script src="../scripts/jquery.js"></script>
<script src='../scripts/jquery-ui.min.js'></script>
<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
  $("#txtDOB").datepicker({
    dateFormat: 'yy-mm-dd', //'dd-M-y' = 01-Sep-17, 'dd M yy' = 12 Sep 2017
    showWeek: true,
    maxDate: '0d', //Constrain maximum date to today
    yearRange: '-100:+0', //Allow year range from 100 years ago until current year
    changeMonth: true,
    changeYear: true,
  });
});
</script>

<form id="signUpForm" data-parsley-validate method="post">
  <h3>New to Ima's Official Fanbase? Sign Up<h3>
    <p>Full Name: <input type="text" id='txtFullName' name='txtFullName' value="<?php if (isset($_POST['txtFullName'])) echo $_POST['txtFullName']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>*</p>
    <p>Email Address: <input type="text" id='txtEmail' name='txtEmail' placeholder="name@email.com" value="<?php if (isset($_POST['txtEmail'])) echo $_POST['txtEmail']; ?>" data-parsley-required="true" data-parsley-type="email" data-parsley-errors-messages-disabled/>*</p>
    <p>Username: <input type="text" id='txtUsername' name='txtUsername' value="<?php if (isset($_POST['txtUsername'])) echo $_POST['txtUsername']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>*</p>
    <p>
      Password: <input type="password" id='txtPassword' data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-equalto="#txtConfirmPassword"/>*
      Confirm Password: <input type="password" id='txtConfirmPassword' data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-equalto="#txtPassword"/>*
    </p>
    <p>Date of Birth: <input id='txtDOB' name='txtDOB' size='8' placeholder="2017-10-01" value="<?php if (isset($_POST['txtDOB'])) echo $_POST['txtDOB']; ?>" readonly data-parsley-trigger="change" data-parsley-required="true" data-parsley-errors-messages-disabled/>*</p>
    <!-- TODO: Retain textarea value -->
    <p>Shipping Address: <textarea id='txtAddress' name='txtAddress' value="<?php if (isset($_POST['txtAddress'])) echo $_POST['txtAddress']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled></textarea>*</p>
    <p>Security Question:
      <!-- TODO: Retain dropdownlist selection -->
      <select id='ddlSecurityQuestion' name='ddlSecurityQuestion' value="<?php if (isset($_POST['ddlSecurityQuestion'])) echo $_POST['ddlSecurityQuestion']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled>
        <option value="">----SELECT----</option>
        <option value="favouriteBook">What is your favourite book?</option>
        <option value="maidenName">What is your mother's maiden name?</option>
        <option value="favouriteFood">What is your favourite food?</option>
        <option value="birthPlace">What city were you born in?</option>
        <option value="school">Where did you go to high school/college?</option>
      </select>*
    </p>
    <p>Answer: <input id='txtSecurityAns' name='txtSecurityAns' value="<?php if (isset($_POST['txtSecurityAns'])) echo $_POST['txtSecurityAns']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>*</p>
    <p class='errorMessage'><small>*All fields are required to complete the registration</small></p>
    <input type='submit' value='Submit' name='btnSubmit'/>
  </form>

  <script src="../scripts/parsley.min.js"></script>
  <link rel="stylesheet" href="../css/parsley.css" type="text/css" />
  <script language="JavaScript" type="text/javascript">
  $(document).ready(function() {
    // instanciate parsley and set the container as the element title without a wrapper
    // $("#signUpForm").parsley({
    //   errorsContainer: function (ParsleyField) {
    //     return ParsleyField.$element.attr("title");
    //   },
    //   errorsWrapper: false
    // });

    // window.Parsley.on('field:error', function(fieldInstance) {
    //   var messages = fieldInstance.getErrorsMessages();
    //   //access the DOM element and retrieve the attribute name
    //   var fieldName = fieldInstance.$element.attr('name');
    //   console.log(fieldName + ": " + messages);
    //   //alert(fieldName  + ": " + messages[0]);
    // });
  });
  </script>

  <?php
  if (isset($_POST['btnSubmit'])) { //Clicked on submit button
    //Obtain user input from textbox
    $fullName = filter_has_var(INPUT_POST, 'txtFullName') ? $_POST['txtFullName']: null;
    $email = filter_has_var(INPUT_POST, 'txtEmail') ? $_POST['txtEmail']: null;
    $username = filter_has_var(INPUT_POST, 'txtUsername') ? $_POST['txtUsername']: null;
    $password = filter_has_var(INPUT_POST, 'txtPassword') ? $_POST['txtPassword']: null;
    $confirmPassword = filter_has_var(INPUT_POST, 'txtConfirmPassword') ? $_POST['txtConfirmPassword']: null;
    $dob = filter_has_var(INPUT_POST, 'txtDOB') ? $_POST['txtDOB']: null;
    $shippingAddr = filter_has_var(INPUT_POST, 'txtAddress') ? $_POST['txtAddress']: null;
    $securityQuestion = filter_has_var(INPUT_POST, 'ddlSecurityQuestion') ? $_POST['ddlSecurityQuestion']: null;
    $securityAns = filter_has_var(INPUT_POST, 'txtSecurityAns') ? $_POST['txtSecurityAns']: null;

    //Trim white space
    $fullName = trim($fullName);
    $email = trim($email);
    $username = trim($username);
    $password = trim($password);
    $confirmPassword = trim($confirmPassword);
    $dob = trim($dob);
    $shippingAddr = trim($shippingAddr);
    $securityAns = trim($securityAns);

    //Sanitize user input
    $fullName = filter_var($fullName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $email = filter_var($email, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $username = filter_var($username, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $password = filter_var($password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $confirmPassword = filter_var($confirmPassword, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $dob = filter_var($dob, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $shippingAddr = filter_var($shippingAddr, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $securityAns = filter_var($securityAns, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    $password = password_hash($password, PASSWORD_DEFAULT); //Hash password
    $birthDate = new DateTime($dob);
    $currentDate = new DateTime(date("Y-m-d"));
    $diff = $currentDate->diff($birthDate);

    if ($diff->y <= 16) {
      $userType = "junior";
    }
    else {
      $userType = "senior";
    }

    $userStatus = "pending";

    // echo "1. $fullName <br />";
    // echo "2. $email <br />";
    // echo "3. $username <br />";
    // echo "4. $password <br />";
    // echo "5. $confirmPassword <br />";
    // echo "6. $dob <br />";
    // echo "7. $shippingAddr <br />";
    // echo "8. $securityQuestion <br />";
    // echo "9. $securityAns <br />";
    // echo "10. $userStatus <br />";

    try {
        $signupSQL = "INSERT INTO user (fullName, username, emailAddr, passwordHash, shippingAddr, dob, userType,
        userStatus, securityQuestion, securityAns) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $signupSQL);
        mysqli_stmt_bind_param($stmt, "ssssssssss", $fullName, $username, $email, $password, $shippingAddr, $dob, $userType,
        $userStatus, $securityQuestion, $securityAns);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
          echo "<script>alert('Registration successful! Please check your email.')</script>";
          mysqli_stmt_close($stmt);
          mysqli_close($conn);
        }
      }
      catch(Exception $e) {
        echo "<script>alert('Registration failed!')</script>";
        //echo $e->getErrorsMessages();
      }
    }
    ?>

    <?php
    echo makeFooter();
    echo makePageEnd();
    ?>
