<?php
ini_set("session.save_path", "../../../sessionData");
session_start(); //start session
include 'db/database_conn.php'; //include database
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login</title>
  <!-- <link rel="stylesheet" href="style1.css"> -->
</head>

<body>
  <!--Make header and navigation bar-->
  <!-- <div class = "header">
  <a href="BrowseEvent.php"><img src ="src/logo.png" alt="Logo"></a>
  <h3>
  <ul class="topnav">
  <li><a class="active" a href="loginForm.html">Log In</a></li>
  <li><a href="SearchForm.php">Search</a></li>
  <li><a href="BrowseEvent.php">All Events</a></li>
</ul>
</h3>
</div> -->

<!--Make login form-->
<form class="login" method="post">
  <div id="email"><p>Email</p><input type="text" name="email"></div>
  <div id="password"><p>Password</p><input type="password" name="password"></div>
  <p>
    <a href='forgotPassword.php'>Forgot password?</a>
    <a href='signUp.php' accesskey="S">S&#818;ign Up</a>
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

  if (empty($email) || empty($password)) {
    echo "<p class='errorMessage'>You have not entered all of the required fields!</p>\n";
  }
  else { //Check if user exists; User exists if passwordHash is returned
    $loginSQL = "SELECT passwordHash, userType, userStatus, username FROM user WHERE emailAddr = ?";
    $stmt = mysqli_prepare($conn, $loginSQL);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $passwordHashDB, $userType, $userStatus, $username);

    if (mysqli_stmt_fetch($stmt)) {
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

          //Set initial time when user logged in (To identify if user is inactive)
          //$_SESSION['logged-in-time'] = time();
          if ($_SESSION['origin'] != "") {
            $redirect = "homePage.php";
          }
          else {
            $redirect = $_SESSION['origin'];
          }
          header('Location:' . $redirect);
          exit();
          //header("Refresh:0;url=staff/staff_main.php");
        }
        else { //userStatus == pending/banned
          if ($userStatus == "pending") {
            echo "<p class='errorMessage'>Please complete the registration by clicking on the link sent to your email!</p>";
          }
          else {
            echo "<p class='errorMessage'>You are not allowed to access the application!</p>";
          }
        }
      }
      else {
        echo "<p class='errorMessage'>Your credientials are incorrect!</p>";
      }
    }
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
  }
}
?>
</body>
</html>
