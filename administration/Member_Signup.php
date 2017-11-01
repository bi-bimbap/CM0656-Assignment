<?php
ini_set("session.save_path", "../../../../sessionData");
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
    dateFormat: 'dd M yy', //'dd-M-y' = 01-Sep-17, 'dd M yy' = 12 Sep 2017
    showWeek: true,
    maxDate: '0d', //Constrain maximum date to today
    yearRange: '-100:+0', //Allow year range from 100 years ago until current year
    changeMonth: true,
    changeYear: true
  });
});
</script>

<h3>New to Ima's Official Fanbase? Sign Up<h3>
<p>Full Name: <input type="text" id='txtFullName' style="width:200px;"/></p>
<p>Email Address: <input type="text" id='txtEmail' style="width:200px;"/></p>
<p>Username: <input type="text" id='txtUsername' style="width:200px;"/></p>
<p>
  Password: <input type="text" id='txtPassword' style="width:200px;"/>
  Confirm Password: <input type="text" id='txtConfirmPassword' style="width:200px;"/>
</p>
<p>Date of Birth: <input id='txtDOB' size='8' maxlength="11" readonly/></p>
<p>Shipping Address: <input type="text" id='txtAddress' style="width:200px;"/></p>
<p class='errorMessage'><small>*All fields are required to complete the registration</small></p>
<input type='submit' value='Submit' name='btnSubmit'/>

  <?php
  echo makeFooter();
  echo makePageEnd();
  ?>
