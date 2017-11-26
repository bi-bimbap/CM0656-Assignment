<?php
// ini_set("session.save_path", ""); //TODO: comment out
session_start();
include '../db/database_conn.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Competition (16 - 18 Years Old)");
echo makeWrapper("../");
echo "<form method='post'>" . makeLoginLogoutBtn("../") . "</form>";
echo makeNavMenu("../");
echo makeHeader("Competition (16 - 18 Years Old)");
?>

<script src="../scripts/jquery.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
<link rel="stylesheet" href="../css/stylesheet.css" type="text/css" />
<link href="../css/bootstrap.css" rel="stylesheet">

<div class="content">
  <div class ="container">
    <?php //Only show content to junior members
    if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
    (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "admin" || $_SESSION['userType'] == "mainAdmin"))) {
      if (checkUserStatus($conn, $_SESSION['userID']) == "active") { //Only allow if user status is active
        ?>
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class ="panel panel-primary">
              <div class="panel-heading">Enter Your Answer</div>
              <div class="panel-body">
                <form method="post">
                  <table class="table table-hover">
                    <tr>
                      <td>Question 1</td>
                      <td><input type="text" class="form-control" value="<?php echo $row["questionTitle"];  ?>" name="questionTitle"  ></td>
                    </tr>
                    <tr>
                      <td>Answer 1</td>
                      <td><input type="text" class="form-control" name="answer1" ></td>
                    </tr>
                    <!-- <tr>
                    <td>Question 2</td>
                    <td><input type="text" class="form-control" name="q2ID" placeholder="Enter Question 2" ></td>
                  </tr>
                  <tr>
                  <td>Answer 2</td>
                  <td><input type="text" class="form-control" name="answer2" ></td>
                </tr>
                <tr>
                <td>Question 3</td>
                <td><input type="text" class="form-control" name="q3ID" placeholder="Enter Question 3" ></td>
              </tr>
              <tr>
              <td>Answer 3</td>
              <td><input type="text" class="form-control" name="answer3" ></td>
            </tr> -->
            <tr>
              <td colspan="2" align="left"><input type="submit" class="btn btn-primary" name="submit" value="Submit"></td>
              <td colspan="2" align="right"><a href="main_page.php" onclick="history.back(1);" class="btn btn-primary">Give up</a></td>
            </tr>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
<?php
}
else { //User has been banned; Redirect to home page
  setCookie(session_name(), "", time() - 1000, "/");
  $_SESSION = array();
  session_destroy();
  echo "<script>alert('You are not allowed here!')</script>";
  header("Refresh:0;url=../index.php");
}
}
else { //Redirect user to home page
  echo "<script>alert('You are not allowed here!')</script>";
  header("Refresh:0;url=../index.php");
}
?>
</div>
</div>

<?php
echo makeFooter("../");
echo makePageEnd();
?>
