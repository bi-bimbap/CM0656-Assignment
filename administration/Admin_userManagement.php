<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("User Management");
echo makeHeader("User Management");
$environment = LOCAL;
?>

<link href="../css/bootstrap.css" rel="stylesheet">
<script src="../scripts/jquery.js"></script>
<script src="../scripts/bootstrap.min.js"></script>

<?php //Only show content to admin/main admin
if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
(isset($_SESSION['userType']) && ($_SESSION['userType'] == "admin" || $_SESSION['userType'] == "mainAdmin"))) {
?>

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
  <li class="nav-item">
    <a class="nav-link active" data-toggle="tab" href="#home" role="tab">List of Members</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#profile" role="tab">Blacklisted Members</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" data-toggle="tab" href="#messages" role="tab">Banned Members</a>
  </li>
  <?php
  if ($_SESSION['userType'] == "mainAdmin") {
    echo "<li class='nav-item'>";
    echo "<a class='nav-link' data-toggle='tab' href='#settings' role='tab'>Admin</a>";
    echo "</li>";
  }
  ?>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="home" role="tabpanel">
    <input type='submit' value='+ New Admin' name='btnNewAdmin'/>
    <form id="addAdminForm" data-parsley-validate method="post">
      <p>Full Name: <input type="text" id='txtFullName' name='txtFullName' value="<?php if (isset($_POST['txtFullName'])) echo $_POST['txtFullName']; else echo 'sjm'; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>*</p>
      <p>Email Address: <input type="text" id='txtEmail' name='txtEmail' placeholder="name@email.com" value="<?php if (isset($_POST['txtEmail'])) echo $_POST['txtEmail']; else echo 'sjm@gmail.com'; ?>" data-parsley-required="true" data-parsley-type="email" data-parsley-errors-messages-disabled/>*</p>
      <input type='submit' value='Add' name='btnAdd'/>
    </form>
  </div>
  <div class="tab-pane" id="profile" role="tabpanel">...</div>
  <div class="tab-pane" id="messages" role="tabpanel">...</div>
  <div class="tab-pane" id="settings" role="tabpanel">...</div>
</div>

<?php
}
else { //Redirect user to home page
  echo "<script>alert('You are not allowed here!')</script>";
  header("Refresh:1;url=index.php"); //TODO: change url
}
?>

<script src="../scripts/parsley.min.js"></script>
<link rel="stylesheet" href="../css/parsley.css" type="text/css" />

<?php
if (isset($_POST['btnAdd'])) { //Clicked on add button
  //Obtain user input
  $fullName = filter_has_var(INPUT_POST, 'txtFullName') ? $_POST['txtFullName']: null;
  $email = filter_has_var(INPUT_POST, 'txtEmail') ? $_POST['txtEmail']: null;
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
      echo "<script>alert('An account has already been registered under this email address!')</script>";
    }
    else { //Email available to use; Add new addmin
      try {
        $signupSQL = "INSERT INTO user (fullName, emailAddr, userType, userStatus, memberConfirmationExpiryDate)
        VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $signupSQL);
        mysqli_stmt_bind_param($stmt, "sssss", $fullName, $email, $userType, $userStatus, $memberConfirmationExpiryDate);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) { //Send email to new admin
          $emailEncoded = urlencode(base64_encode($email));
          $fullNameEncoded = urlencode(base64_encode($fullName));
          $memberConfirmationExpiryDateEncoded = urlencode(base64_encode($memberConfirmationExpiryDate));
          $url = $environment . "/CM0656-Assignment/administration/Member_signup.php?mail=" . $emailEncoded . "&name=" . $fullNameEncoded
          . "&exDate=" . $memberConfirmationExpiryDateEncoded;
          if (sendEmail($email, $fullName, 'Please Complete Your Registration', '../email/notifier_completeRegistration.html', $url)) { //Email sent
            echo "<script>alert('New admin added!')</script>";
          }
          else { //Email failed to send
            echo "<script>alert('Failed to send email!')</script>";
          }
        }
        else { //SQL statement failed; Failed to add admin
          echo "<script>alert('Failed to add admin!')</script>";
        }
      }
      catch (Exception $e) {
        echo "<script>alert('Registration failed!')</script>";
        //echo $e->getErrorsMessages();
      }
    }
  }
  catch (Exception $e) {
    echo "<script>alert('Unable to add new admin!')</script>";
    //echo $e->getErrorsMessages();
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
?>

<?php
echo makeFooter();
echo makePageEnd();
?>
