<?php
ini_set("session.save_path", "");
session_start();
include 'db/database_conn.php';
require_once('controls.php');
echo makePageStart("Login");
echo makeNavMenu();
echo makeHeader("Login");
?>

<script src="scripts/jquery.js"></script>
<script src="scripts/parsley.min.js"></script>
<link rel="stylesheet" href="css/parsley.css" type="text/css" />

<form class="login" method="post" data-parsley-validate>
  <div id="email"><p>Email Address</p><input type="text" placeholder="name@email.com" id="email" name="email" data-parsley-required="true" data-parsley-type="email" data-parsley-errors-messages-disabled></div>
  <div id="password"><p>Password</p><input type="password"  id="password" name="password" data-parsley-required="true" data-parsley-errors-messages-disabled></div>
  <p>
    <a href='forgotPassword.php'>Forgot password?</a>
    <a href='administration/Member_signup.php' accesskey="S">S&#818;ign Up</a>
  </p>
  <div id="button"><input type="submit" value="L&#818;ogin" accesskey="L" name="btnLogin"></div>
</form>

<?php
if (isset($_POST['btnLogin'])) { //Clicked on login button
  //Obtain user input from textbox
  $email = filter_has_var(INPUT_POST, 'email') ? $_POST['email']: null;
  $password = filter_has_var(INPUT_POST, 'password') ? $_POST['password']: null;

  //Trim white space
  $email = trim($email);
  $password = trim($password);

  //Sanitize user input
  $email = filter_var($email, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $password = filter_var($password, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

  //Check if user exists; User exists if passwordHash is returned
  $loginSQL = "SELECT passwordHash, userType, userStatus, username FROM user WHERE emailAddr = ?";
  $stmt = mysqli_prepare($conn, $loginSQL);
  mysqli_stmt_bind_param($stmt, "s", $email);
  mysqli_stmt_execute($stmt);
  mysqli_stmt_bind_result($stmt, $passwordHashDB, $userType, $userStatus, $username);
  mysqli_stmt_fetch($stmt);

  if (password_verify($password, $passwordHashDB)) { //Check if password matches email
    if ($userStatus == "active") {
      if ($userType == "mainAdmin" || $userType == "admin") {
        ($userType == "mainAdmin")? $_SESSION['userType'] = "mainAdmin" :  $_SESSION['userType'] = "admin";
      }
      else { //userType == junior/senior
        ($userType == "junior")? $_SESSION['userType'] = "junior" :  $_SESSION['userType'] = "senior";
      }

      $_SESSION['logged-in'] = true;
      $_SESSION['username'] = $username;
      $_SESSION['email'] = $email;

      if (isset($_SESSION['origin']) && $_SESSION['origin'] != "") {
        $redirect = $_SESSION['origin'];
      }
      else {
        $redirect = "index.php"; //TODO: change url
      }
      header('Location:' . $redirect);
      exit();
    }
    else { //userStatus == pending/banned
      if ($userStatus == "pending") {
        echo "<script>alert('Please complete the registration by clicking on the link sent to your email!')</script>";
      }
      else {
        echo "<script>alert('You are not allowed to access the application!')</script>";
      }
    }
  }
  else {
    echo "<script>alert('Your credientials are incorrect!')</script>";
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
?>

<?php
echo makeFooter();
echo makePageEnd();
?>
