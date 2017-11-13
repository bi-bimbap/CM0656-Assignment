<?php
// ini_set("session.save_path", "");
// session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Create Auction");
echo makeNavMenu();
echo makeHeader("Create New Auction");
$environment = LOCAL; //TODO: Change to server
?>

<link rel='stylesheet' href='../css/jquery-ui.min.css' />
<script src="../scripts/jquery.js"></script>
<script src='../scripts/jquery-ui.min.js'></script>
<script src="../scripts/parsley.min.js"></script>
<link rel="stylesheet" href="../css/stylesheet.css" type="text/css" />
<link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
<link rel="stylesheet" href="../css/parsley.css" type="text/css" />
<script>
$(document).ready(function() {
  var dateToday = new Date();
  var yrRange = dateToday.getFullYear() + ":" + (dateToday.getFullYear() + 5); //Allow year range from current year until 5 years later

  $("#txtDOB").datepicker({
    dateFormat: 'yy-mm-dd', //'Format: 2017-11-01
    showWeek: true,
    maxDate: '0d', //Constrain maximum date to today
    yearRange: yrRange,
    changeMonth: true,
    changeYear: true,
  });
});
</script>

<form id="createAuctionForm" data-parsley-validate method="post">

  <p>Auction Title: <input type="text" id='txtFullName' name='txtFullName' value="<?php if (isset($_POST['txtFullName'])) echo $_POST['txtFullName']; else if (isset($_GET['name'])) echo $fullName; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>*</p>
  <p>Item Name: <input type="email" id='txtEmail' name='txtEmail' placeholder="name@email.com" value="<?php if (isset($_POST['txtEmail'])) echo $_POST['txtEmail']; else if (isset($_GET['mail'])) echo $email; ?>" data-parsley-required="true" data-parsley-type="email" data-parsley-errors-messages-disabled/>*</p>
  <?php
  if (!isset($_GET['mail']) && !isset($_GET['name']) && !isset($_GET['exDate'])) { //Only visible to normal members
    echo "<p>Username: <input type='text' id='txtUsername' name='txtUsername' value='" . (isset($_POST['txtUsername']) ? $_POST['txtUsername'] : 'sjm') . "' data-parsley-required='true' data-parsley-errors-messages-disabled/>*</p>";
  }
  ?>
  <p>
    Password: <input type="password" id='txtPassword' data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-equalto="#txtConfirmPassword"/>*
    Confirm Password: <input type="password" id='txtConfirmPassword' data-parsley-required="true" data-parsley-errors-messages-disabled data-parsley-equalto="#txtPassword"/>*
  </p>

  <?php
  if (!isset($_GET['mail']) && !isset($_GET['name']) && !isset($_GET['exDate'])) { //Only visible to normal members
    echo "<p>Date of Birth: <input id='txtDOB' name='txtDOB' size='8' placeholder='2017-10-01' value='". (isset($_POST['txtDOB']) ? $_POST['txtDOB'] : '2011-11-01') . "' readonly data-parsley-trigger='change' data-parsley-required='true' data-parsley-errors-messages-disabled/>*</p>";
    echo "<p>Shipping Address: <textarea id='txtAddress' name='txtAddress' data-parsley-required='true' data-parsley-errors-messages-disabled>" . (isset($_POST['txtAddress']) ? $_POST['txtAddress'] : '123') . "</textarea>*</p>";
  }
  ?>
  <!-- <p>Date of Birth: <input id='txtDOB' name='txtDOB' size='8' placeholder="2017-10-01" value="<?php if (isset($_POST['txtDOB'])) echo $_POST['txtDOB']; else echo '2011-11-01'; ?>" readonly data-parsley-trigger="change" data-parsley-required="true" data-parsley-errors-messages-disabled/>*</p> -->
  <!-- <p>Shipping Address: <textarea id='txtAddress' name='txtAddress' data-parsley-required="true" data-parsley-errors-messages-disabled><?php if (isset($_POST['txtAddress'])) echo $_POST['txtAddress']; else echo '123'; ?></textarea>*</p> -->
  <p>Security Question:
    <select id='ddlSecurityQuestion' name='ddlSecurityQuestion' value="<?php if (isset($_POST['ddlSecurityQuestion'])) echo $_POST['ddlSecurityQuestion']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled>
      <option value="" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='') echo 'selected';?>>----SELECT----</option>
      <option value="favouriteBook" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='favouriteBook') echo 'selected';?>>What is your favourite book?</option>
      <option value="maidenName" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='maidenName') echo 'selected';?>>What is your mother's maiden name?</option>
      <option value="favouriteFood" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='favouriteFood') echo 'selected';?>>What is your favourite food?</option>
      <option value="birthPlace" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='birthPlace') echo 'selected';?>>What city were you born in?</option>
      <option value="school" <?php if (isset($_POST['ddlSecurityQuestion']) && $_POST['ddlSecurityQuestion']=='school') echo 'selected';?>>Where did you go to high school/college?</option>
    </select>*
  </p>
  <p>Answer: <input id='txtSecurityAns' name='txtSecurityAns' value="<?php if (isset($_POST['txtSecurityAns'])) echo $_POST['txtSecurityAns']; else echo '123'; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>*</p>
  <p class='errorMessage'><small>*All fields are required to complete the registration</small></p>
  <input type='submit' value='Submit' name='btnSubmit'/>
</form>

<?php
echo makeFooter();
echo makePageEnd();
?>
