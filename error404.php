<?php
ini_set("session.save_path", "");
session_start();
require_once('controls.php');
echo makePageStart("Page Not Found");
echo makeHeader("Page Not Found");
?>

<img src="images/Error-404.png" />

<?php
echo makeFooter();
echo makePageEnd();
?>
