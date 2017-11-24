<?php
function makePageStart($pageTitle) { //Start page
    $pageStartContent = <<<PAGESTART
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>$pageTitle</title>
</head>
<body>
PAGESTART;
    $pageStartContent .="\n";
    return $pageStartContent;
  }

function makePageEnd() { //End page
    return "</body>\n</html>";
}

function makeHeader($pageHeader) { //Display header
    $headContent = <<<HEAD
<header>
  <h1>$pageHeader</h1>
</header>
HEAD;
    $headContent .="\n";
    return $headContent;
}

function makeWrapper($prefix) {
	$wrapper = "<div class='wrapper'>
                <div class='container'>
                  <div id='logo'>
                    <img src='" . $prefix ."images/logo.png'/>Ima's Official Fanbase
                  </div>";
	return $wrapper;
}

function makeFooter($prefix) { //Display footer
  $footContent = '
  <footer>
  <div class="container">
  <div>
  <div id="logo"><img src="' . $prefix . 'images/logo.png"/>Ima\'s Official Fanbase</div>
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
  <span>2017&copy; Ima\'s Official Fanbase All rights reserved.</span>
  <a href="#">Private Policy</a>
  <a href="#">Terms of Use</a>
  </div>
  </div>';

  $footContent .="\n";
  return $footContent;
}

function makeNavMenu($prefix) {
  $navBar = '
  <nav><ul>
  <li><a href="' . $prefix . 'index.php">Home</a></li>
  <li><a href="' . $prefix . 'index.php">Auction</a></li>
  <li><a href="' . $prefix . 'index.php">Gallery</a></li>
  <li><a href="' . $prefix . 'index.php">Discussion Board</a></li>
  <li><a href="' . $prefix . 'index.php">Competitions</a></li>
  </ul></nav></div></div>';

  return $navBar;
}

function makeProfileButton($prefix) {
  if(isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) {
    $profileButton = "<div class='dropdown'>";
    $profileButton .= "<button class='btn btn-secondary dropdown-toggle' type='button' id='btnAccountInfo' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>";
    $profileButton .= "<i class='fa fa-user'></i>";
    $profileButton .= "</button>";

    $profileButton .= "<div class='dropdown-menu' aria-labelledby='btnAccountInfo'>";
    $profileButton .= "<p><a class='dropdown-item' href='" . $prefix . "administration/manageDetails.php'>Manage My Details</a></p>";

    //Show user management features to admin/main admin only
    if((isset($_SESSION['userType']) && ($_SESSION['userType'] == "admin" || $_SESSION['userType'] == "mainAdmin"))) {
    $profileButton .= "<p><a class='dropdown-item' href='" . $prefix . "administration/Admin_userManagement.php'>User Management</a></p>";
    $profileButton .= "<p><a class='dropdown-item' href='" . $prefix . "administration/Admin_statisticalReport.php'>View Reports</a></p>";
    }
    $profileButton .= "</div>";
    $profileButton .= "</div>";

    return $profileButton;
  }
}

function makeLoginLogoutBtn($prefix) { //Display login/logout button based on session
  $output = "<div id='loginLogoutDiv'>";

  if (isset($_SESSION['logged-in']) && ($_SESSION['logged-in'] == true)) {
      $output .= "<p>Welcome, " . $_SESSION['username'] . "\n";
      $output .= "<input type='submit' name='btnLogout' value='L&#818;ogout' accessKey='L'></p>";
  }
  else {
      $output .= "<p><input type='submit' name='btnLogin' value='L&#818;ogin' accessKey='L'></p>";
  }
  $output .= "</div>";

  //Perform actions if login/logout button is clicked
  if (isset($_POST['btnLogout'])) {
      setCookie(session_name(), "", time() - 1000, "/");
      $_SESSION = array();
      session_destroy();
      //$redirect = $_SERVER['REQUEST_URI']; //Return users to the originating page after logout
      // header('Location:' . $redirect);
      header('Location:' . $prefix . 'index.php');
  }

  if (isset($_POST['btnLogin'])) {
      $_SESSION['origin'] = $_SERVER['REQUEST_URI']; //Store current page URL
      header('Location:' . $prefix . 'loginForm.php');
  }
  return $output;
}
