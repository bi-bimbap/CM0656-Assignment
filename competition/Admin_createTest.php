<?php
// ini_set("session.save_path", ""); //TODO: comment out
session_start();
include '../db/database_conn.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Create Competition");
echo makeWrapper("../");
echo "<form method='post'>" . makeLoginLogoutBtn("../") . "</form>";
echo makeNavMenu("../");
echo makeHeader("Create Competition");
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
    (isset($_SESSION['userType']) && ($_SESSION['userType'] == "admin" || $_SESSION['userType'] == "mainAdmin"))) {
      if (checkUserStatus($conn, $_SESSION['userID']) == "active") { //Only allow if user status is active
        ?>
        <div class="row">
          <div class="col-md-3"></div>
          <div class="col-md-6">
            <div class ="panel panel-primary">
              <div class="panel-heading">Enter Your Test Details</div>
              <div class="panel-body">

                <form method="post">
                  <table class="table table-hover">
                    <tr>
                      <td>Test Name:</td>
                      <td><input type="text" class="form-control" name="t_name" placeholder="Test Name"></td>
                    </tr>
                    <tr>
                      <td>Template Name:</td>
                      <td><select class= "btn btn-primary dropdown-toggle" name="templateID" type="button" data-toggle="dropdown">Choose your template

                      <?php
                      $sql = "select * from competition_template";
                      $result=mysqli_query($conn,$sql);
                      while ($row=mysqli_fetch_assoc($result))
                      {
                         echo "<option value= '{$row['templateID']}'>{$row['templateTitle']}</option>";
                        }
                        ?>
                      </select></td>
                        <ul class= "dropdown-menu">
                          <li></li>
                        </ul>
                    </tr>
                    <tr>
                      <td>Age Range:</td>
                      <td><select class= "btn btn-primary dropdown-toggle" name="ageRange" type="button" data-toggle="dropdown">Age Range
                            <option value="10-13">10-13</option>
                            <option value="13-16">13-16</option>
                            <option value="16-18">16-18</option>
                          </select>

                    <tr>
                      <tr>
                        <td>Start Date:</td>
                        <td><input type="date" class="form-control" name="startDate" placeholder="Start"></td>
                      </tr>
                      <tr>
                        <td>End Date:</td>
                        <td><input type="date" class="form-control" name="endDate" placeholder=" End"></td>
                      </tr>
                      <tr>
                        <td>Prize:</td>
                        <td><input type="text" class="form-control" name="prize" placeholder="Prize"></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center"><input type="submit" class="btn btn-primary" name="submit" value="Create"></td>
                        </tr>
                        </table>
                        </form>
                        </div>
                        </div>
                        </div>
                        <div class="col-md-3"></div>
                        </div>

                        </div>

                        <form method="post">
                        <div class="container">
                        <div class="row">
                        <div class="col-md-2"></div>
                        <div class="col-md-8">
                        <table class="table table-bordered">
                        <tr>
                        <th>Test Name</th>
                        <th>Test Start Date</th>
                        <th>Test End Date</th>
                        <th>Age Range</th>
                        <th>&nbsp;</th>
                        </tr>
                        <?php
                        $testSQL = "SELECT * FROM competition_test";
                        $testRs = mysqli_query($conn, $testSQL) or die(mysqli_error($conn));

                        while ($row = mysqli_fetch_assoc($testRs)){

                        ?>
                        <tr>
                        <td><?php echo $row["testName"]; ?></td>
                        <td><?php echo $row["testStartDate"]; ?></td>
                        <td><?php echo $row["testEndDate"]; ?></td>
                        <td><?php echo $row["ageRange"]; ?></td>
                        <td><form method ="post"><input type="hidden" name="testName" value ="<?php echo $row["testName"]; ?>"/><input type="submit" name="delete" value="DELETE"></form></td>
                        </tr>
                        <?php
                        }

                        ?>
                        </table>
                        </form>
                        </div>
                        <div class="col-md-2"></div>
                        </div>
                        </div>



                        </body>
                        </html>

                        <?php
                        if (isset($_POST['submit'])) { //Clicked on submit button
                        //Obtain user input
                        $t_name = filter_has_var(INPUT_POST, 't_name') ? $_POST['t_name']: null;
                        //Trim white space
                        $t_name = trim($t_name);
                        //Sanitize user input
                        $t_name = filter_var($t_name, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

                        //Obtain user input
                        $templateID = filter_has_var(INPUT_POST, 'templateID') ? $_POST['templateID']: null;
                        //Trim white space
                        $templateID = trim($templateID);
                        //Sanitize user input
                        $templateID = filter_var($templateID, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

                        //Obtain user input
                        $startDate = filter_has_var(INPUT_POST, 'startDate') ? $_POST['startDate']: null;
                        //Trim white space
                        $startDate = trim($startDate);
                        //Sanitize user input
                        $startDate = filter_var($startDate, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

                        //Obtain user input
                        $endDate = filter_has_var(INPUT_POST, 'endDate') ? $_POST['endDate']: null;
                        //Trim white space
                        $endDate = trim($endDate);
                        //Sanitize user input
                        $endDate = filter_var($endDate, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

                        //Obtain user input
                        $prize = filter_has_var(INPUT_POST, 'prize') ? $_POST['prize']: null;
                        //Trim white space
                        $prize = trim($prize);
                        //Sanitize user input
                        $prize = filter_var($prize, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

                        $ageRange = $_POST['ageRange'];

                        $testSQL = "INSERT INTO competition_test (`testName`, `templateID`, `testStartDate`, `testEndDate`, `prize`, `ageRange`) VALUES (?,?,?,?,?,?)";
                        $stmt = mysqli_prepare($conn, $testSQL) or die( mysqli_error($conn));
                        mysqli_stmt_bind_param($stmt, "sissss", $t_name, $templateID, $startDate, $endDate, $prize, $ageRange);
                        mysqli_stmt_execute($stmt);

                        if (mysqli_stmt_affected_rows($stmt) > 0) {
                        echo "<script>alert('Test created!')</script>";
                        echo "<meta http-equiv=\"refresh\" content=\"0;URL=Admin_createTest.php\">";
                        }
                        else {
                        echo "<script>alert('Failed to create test!')</script>";
                        }
                        mysqli_stmt_close($stmt);
                        }
                        ?>

                        <?php

                        if (isset($_POST['delete'])) {

                        $testName = $_POST["testName"];

                        ?><script>alert('Your test had been deleted !');</script><?php

                        $sql = "DELETE FROM competition_test WHERE testName='$testName  '";

                        if (mysqli_query($conn, $sql)) {
                        echo "Record deleted successfully";
                        echo "<meta http-equiv=\"refresh\" content=\"0;URL=Admin_createTest.php\">";
                        } else {
                        echo "Error deleting record: " . mysqli_error($conn);
                        }
                        ?>

                        <?php
                        }
                        else
                        {

                        }
                        ?>
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
  <!-- </div> -->

  <?php
  echo makeFooter("../");
  echo makePageEnd();
  ?>
