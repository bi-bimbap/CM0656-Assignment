<?php
require_once('../controls.php');
//echo password_hash("testingpassword", PASSWORD_DEFAULT);
echo makePageStart("Page Title");
echo makeHeader("Page Header");
echo makeLoginLogoutBtn();
echo makeFooter();
echo makePageEnd();
?>
