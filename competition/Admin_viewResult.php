<?php
// ini_set("session.save_path", ""); //TODO: comment out
session_start();
include '../db/database_conn.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("View Results");
echo makeWrapper("../");
echo "<form method='post'>" . makeLoginLogoutBtn("../") . "</form>";
echo makeProfileButton("../");
echo makeNavMenu("../");
echo makeHeader("View Results");
?>

<script src="../scripts/jquery.js"></script>
<script src="../scripts/bootstrap.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
<link rel="stylesheet" href="../css/stylesheet.css" type="text/css" />
<link href="../css/bootstrap.css" rel="stylesheet">

<div class="content">
  <div class="container">
    <?php //Only show content to junior members
    if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
    (isset($_SESSION['userType']) && ($_SESSION['userType'] == "admin" || $_SESSION['userType'] == "mainAdmin"))) {
      if (checkUserStatus($conn, $_SESSION['userID']) == "active") { //Only allow if user status is active
        ?>
        <div class="row">
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <table class="table table-bordered">
              <br>
              <tr>
                <th>Result ID</th>
                <th>User ID</th>
                <th>Test ID</th>
                <th>Result</th>
                <th>Competition Duration</th>
              </tr>
              <?php
              $resultSQL = "SELECT * FROM competition_result";
              $resultRs = mysqli_query($conn, $resultSQL) or die(mysqli_error($conn));

              while ($row = mysqli_fetch_assoc($resultRs)){
                ?>
                <tr>
                  <td><?php echo $row["resultID"]; ?></td>
                  <td><?php echo $row["userID"]; ?></td>
                  <td><?php echo $row["testID"]; ?></td>
                  <td><?php echo $row["result"]; ?></td>
                  <td><?php echo $row["competitionDuration"]; ?></td>
                </tr>
                <?php
              }

              ?>
            </table>
          </div>
          <div class="col-md-2"></div>
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
