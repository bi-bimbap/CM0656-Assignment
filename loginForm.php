<?php
// ini_set("session.save_path", ""); //TODO: Comment out
session_start();
include 'db/database_conn.php';
require_once('controls.php');
?>

<?php
if (isset($_POST['btnConfirmLogin'])) { //Clicked on login button
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
	$loginSQL = "SELECT passwordHash, userType, userStatus, username, fullName, userID FROM user WHERE emailAddr = ?";
	$stmt = mysqli_prepare($conn, $loginSQL);
	mysqli_stmt_bind_param($stmt, "s", $email);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $passwordHashDB, $userType, $userStatus, $username, $fullName, $userID);
	mysqli_stmt_fetch($stmt);

	if ($userStatus == "active") {
		if (password_verify($password, $passwordHashDB)) { //Check if password matches email
			if ($userType == "mainAdmin" || $userType == "admin") {
				($userType == "mainAdmin")? $_SESSION['userType'] = "mainAdmin" :  $_SESSION['userType'] = "admin";
			}
			else { //userType == junior/senior
				($userType == "junior")? $_SESSION['userType'] = "junior" :  $_SESSION['userType'] = "senior";
			}

			$_SESSION['logged-in'] = true;
			$_SESSION['userID'] = $userID;
			$_SESSION['username'] = $username;
			if ($username == "") {
				$_SESSION['username'] = $fullName;
			}
			$_SESSION['email'] = $email;

			if (isset($_SESSION['origin']) && $_SESSION['origin'] != "") {
				$redirect = $_SESSION['origin'];
			}
			else {
				$redirect = "index.php";
			}
			header('Location:' . $redirect);
			exit();
		}
		else {
			echo "<script>alert('Your credientials are incorrect!')</script>";
		}
	}
	else { //userStatus == pending/banned
		if ($userStatus == "pending") {
			echo "<script>alert('Please complete the registration by clicking on the link sent to your email!')</script>";
		}
		else {
			echo "<script>alert('You are not allowed to access the application!')</script>";
		}
	}
	mysqli_stmt_close($stmt);
	mysqli_close($conn);
}
?>

<?php
if(!isset($_SESSION['logged-in'])) { //Prevent users from entering login page if logged in
	echo makePageStart("Login");
	echo "<div class='wrapper'><div class='container'><div id='logo'><img src='images/logo.png'/>Ima's Official Fanbase</div>";
	echo "<form method='post'>" . makeLoginLogoutBtn() . "</form>";
	echo makeProfileButton();
	echo makeNavMenu();
	echo makeHeader("Login");
	?>

	<script src="scripts/jquery.js"></script>
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
	<script src="scripts/parsley.min.js"></script>
	<link rel="stylesheet" href="css/parsley.css" type="text/css" />
	<link rel="stylesheet" href="css/stylesheet.css" type="text/css" />
	<link href="css/bootstrap.css" rel="stylesheet">
	<script src="scripts/bootstrap.min.js"></script>

	<div class="content">
		<div class="container">
			<form class="login" method="post" data-parsley-validate>
				<div id="email"><p>Email Address</p><input type="text" placeholder="name@email.com" id="email" name="email" data-parsley-required="true" data-parsley-type="email" data-parsley-errors-messages-disabled></div>
				<div id="password"><p>Password</p><input type="password"  id="password" name="password" data-parsley-required="true" data-parsley-errors-messages-disabled></div>
				<p>
					<a href='forgotPassword.php'>Forgot password?</a>
					<a href='administration/Member_signup.php' accesskey="S">S&#818;ign Up</a>
				</p>
				<div id="button"><input type="submit" value="L&#818;ogin" accesskey="L" name="btnConfirmLogin" /></div>
			</form>
		</div>
	</div>

	<!-- Start footer  -->
	<footer>
		<div class="container">
			<div>
				<div id='logo'><img src='images/logo.png'/>Ima's Official Fanbase</div>
			</div>
			<div class="middle">
				<div><i class="fa fa-envelope"></i> info@imamegastar.forum.com</div>
				<div><i class="fa fa-phone"></i> +6012-2151725</div>
			</div>
			<div>
				<i class="fa fa-facebook"></i>
				<i class="fa fa-instagram"></i>
				<i class="fa fa-google-plus"></i>
				<i class="fa fa-twitter"></i>
			</div>
		</div>
	</footer>
	<div class="powered">
		<div class="container">
			<span>2017&copy; Ima's Official Fanbase All rights reserved.</span>
			<a href="#">Private Policy</a>
			<a href="#">Terms of Use</a>
		</div>
	</div>
	<!-- End footer -->

<?php
	echo makePageEnd();
}
else { //User is already logged in;Redirect user to home page
	echo "<script>alert('You are already logged in!')</script>";
	header("Refresh:0;url=index.php");
}
?>
