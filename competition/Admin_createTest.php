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

                <form>
                  <table class="table table-hover">
                    <tr>
                      <td>Test Name:</td>
                      <td><input type="text" class="form-control" name="t_name" placeholder="Test Name"></td>
                    </tr>
                    <tr>
                      <td>Template ID:</td>
                      <td><button class= "btn btn-primary dropdown-toggle" name="templateID" type="button" data-toggle="dropdown">Choose your template
                        <span class="caret"></span></button>
                        <ul class= "dropdown-menu">
                          <li></li>
                        </ul>
                      </tr>
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
                        <td colspan="2" align="center"><input type="submit" class="btn btn-primary" name="submit" value="Save"></td>
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
