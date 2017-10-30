<?php
function makePageStart($pageTitle) { //Start page
$pageStartContent = <<<PAGESTART
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>$pageTitle</title>
</head>
<body>
PAGESTART;
$pageStartContent .="\n";
return $pageStartContent;
}
// <link href="css/$css" rel="stylesheet" type="text/css" />
// <script src="scripts/jquery.js"></script>
// <script type='text/javascript' src='scripts/functions.js'></script>
// <script type='text/javascript' src='scripts/jquery-2.2.0.js'></script>
// <script type='text/javascript' src='scripts/jquery-ui-1.12.1/jquery-ui.js'></script>
// <link rel="stylesheet" href="css/jquery-ui.css" type="text/css" />
// <link href="https://fonts.googleapis.com/css?family=Permanent+Marker" rel="stylesheet">

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

function makeFooter() { //Display footer
$footContent = <<< FOOT
<footer>
<p>Testing Footer</p>
</footer>
FOOT;
$footContent .="\n";
return $footContent;
}

function makeLoginLogoutBtn() { //Display login/logout button based on session
  $output = "<div id='loginLogoutDiv'>";

  if(isset($_SESSION['logged-in']) && ($_SESSION['logged-in'] == true)) {
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
    $redirect = $_SERVER['REQUEST_URI']; //Return users to the originating page after logout
    header('Location:' . $redirect);
  }

  if (isset($_POST['btnLogin'])) {
    $_SESSION['origin'] = $_SERVER['REQUEST_URI']; //Store current page URL
    header('Location: loginForm.php');
  }
  return $output;
}
?>
