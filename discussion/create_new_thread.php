<!DOCTYPE!>
<html lang="en">
************************************************************
  Database Connection, Header, Footer
************************************************************
<?php
ini_set("session.save_path", "../../../sessionData");
session_start(); //start session
include '../db/database_conn.php'; //include database
?>

<?php
require_once('../controls.php');
//echo password_hash("testingpassword", PASSWORD_DEFAULT);
echo makePageStart("Page Title");
echo makeHeader("Page Header");
echo makeLoginLogoutBtn();
echo makeFooter();
echo makePageEnd();
?>

************************************************************
    Script - Pop Our Form for Create New Thread
************************************************************
<SCRIPT LANGUAGE="JavaScript"><!--
function copyForm() {
    opener.document.hiddenForm.myTextField.value = document.popupForm.myTextField.value;
    opener.document.hiddenForm.submit();
    window.close();
    return false;
}
//--></SCRIPT>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}


<body bgColor="#808080" onLoad="javascript: openPopup('popupPage.html')">
************************************************************
    Discussion Board : Create New Thread
************************************************************
<div class="container">
  <ol class="breadcrumb">
      <li><a href="../discussion/discussion_index.php">Discussion Board</a></li>
      <li class="active">New Discussion Board</li>
  </ol>

  ************************************************************
      Verification - Only Admin Allowed to Login
  ************************************************************
  <!-- <div id="login">
  <?php
    $User = false;
    $Admin = false; // validation for admin set to false

    if (isset($_SESSION['CaseProjectAdmin']) && isset($_SESSION['CaseProjectUserName'])){
      $User = true;
      if($_SESSION['CaseProjectAdmin']== true){
        $Admin = true; //if is really admin set to true
      }
    }

    //require('../header.php');

    if ($Admin == false){
      $message = "You are the not administrator, please log in as administrator first to access this page !";
      $url = "../shared/registration-login.php";
      echo "<script type='text/javascript'>";
      echo "alert('$message');";
      echo 'window.location.href="'.$url.'";';
      echo '</script>';
    }
  ?>
  </div> -->

  ************************************************************
      Create New Thread
  ************************************************************
  <h1>Create New Thread</h1>

  <div class="box-wrapper">

  <FORM NAME="popupForm" onSubmit="return copyForm()" action="" method="post">
    <p>
      <INPUT TYPE="radio" NAME="group1" value="YellowPages">
      <span class="style1">    a) Yellow Pages<br></span>
        <input type="radio" name="group1" value="other">
      <span class="style1">b) Other means of communication</span>
        <br>
        <input type="radio" name="group1" value="friend">
      <span class="style1">c) By Friends</span><br>
        <input type="radio" name="group1" value="purchased" checked>
        <span class="style1">d) Purchased before</span></p>
    <p>
      <INPUT name="Submit" TYPE="submit" onClick="copyForm()" VALUE="Submit">
    </p>
  </FORM>


    <form method="post" action="../create_new_thread.php">
          <div class="form-group">
            <label for="thread_name" >Thread Name</label>
              <input type="text" class="form-control" id="thread_name" name="thread_name" placeholder="Thread Name"</>
            <label for="" >Thread Name</label>
              <input type="text" class="form-control" id="thread_desc" name="thread_desc" placeholder="Description">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-sm-3 col-md-offset-9">
            <button class ="btn btn-block btn-success btn-lg" type="submit" name="Submit" >Create</button>
          </div>
        </div>
      </div>
    </form>
  </div>

</div>
</body>
</html>
