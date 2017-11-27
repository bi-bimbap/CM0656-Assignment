<?php
// ini_set("session.save_path", ""); //TODO: comment out
session_start();
include '../db/database_conn.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Create Template");
echo makeWrapper("../");
echo "<form method='post'>" . makeLoginLogoutBtn("../") . "</form>";
echo makeProfileButton("../");
echo makeNavMenu("../");
echo makeHeader("Create Template");
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
              <div class="panel-heading">Enter Your Questions</div>
              <div class="panel-body">
                <?php
                if(isset($_GET["templateID"])){
                  $templateID = $_GET["templateID"];
                  $templateSQL = "SELECT * FROM competition_template JOIN competition_question ON
                  competition_template.templateID = competition_question.templateID
                  WHERE competition_template.templateID=" . $templateID;
                  $templateRs = mysqli_query($conn, $templateSQL) or die(mysqli_error($conn));

                  if ($row = mysqli_fetch_assoc($templateRs)){
                    ?>

                    <form method="post">
                      <table class="table table-hover">
                        <tr>
                          <td><input type="hidden" name="templateID" value="<?php echo $templateID; ?>"></td>
                        </tr>
                        <tr>
                          <td>Template Title</td>
                          <td><input type="text" class="form-control" value="<?php echo $row["templateTitle"];  ?>" name="title" ></td>
                        </tr>
                        <tr>
                          <td>Question 1</td>
                          <td><input type="text" class="form-control" value="<?php echo $row["questionTitle"];  ?>" name="questionTitle" ></td>
                        </tr>
                        <tr>
                          <td>Answer 1</td>
                          <td><input type="text" class="form-control" value="<?php echo $row["questionAns"];  ?>" name="answer1" ></td>
                        </tr>
                        <tr>
                          <td colspan="2" align="center"><input type="submit" class="btn btn-primary" name="edit" value="update"/></td>
                        </tr>
                        <td colspan="2" align="center"><a href="Admin_createTemplate.php" onclick="history.back(1);" class="btn btn-primary">Back</a></td>
                      </table>
                    </form>
                    <?php
                  }
                }
                else{
                  ?>
                  <form method="post">
                    <table class="table table-hover">
                      <tr>
                        <td>Template Title</td>
                        <input type="hidden" name="templateID" value="<?php echo $templateID; ?>"/>
                        <td><input type="text" class="form-control" name="title" placeholder="Enter Template Title"></td>
                      </tr>
                      <tr>
                        <td>Question 1</td>
                        <td><input type="text" class="form-control" name="q1ID" placeholder="Enter Question 1" ></td>
                      </tr>
                      <tr>
                        <td>Answer 1</td>
                        <td><input type="text" class="form-control" name="answer1" ></td>
                      </tr>
                      <tr>
                        <td colspan="2" align="center"><input type="submit" class="btn btn-primary" name="submit" value="Save"></td>
                      </tr>
                    </table>
                  </form>
                  <?php
                }
                ?>
              </div>
            </div>
          </div>
          <div class="col-md-3"></div>
        </div>

        <div class="container">
          <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <table class="table table-bordered">
                <tr>
                  <th>Template ID</th>
                  <th>Template Title</th>
                  <th>&nbsp;</th>
                  <th>&nbsp;</th>
                </tr>
                <?php
                $templateSQL = "SELECT * FROM competition_template";
                $templateRs = mysqli_query($conn, $templateSQL) or die(mysqli_error($conn));

                while ($row = mysqli_fetch_assoc($templateRs)){

                  ?>
                  <tr>
                    <td><?php echo $row["templateID"]; ?></td>
                    <td><?php echo $row["templateTitle"]; ?></td>
                    <td><a href= "Admin_createTemplate.php?templateID=<?php echo $row["templateID"]; ?>"><button id="button">UPDATE</button></a></td>
                    <td><form method ="post"><input type="hidden" name="templateID" value ="<?php echo $row["templateID"]; ?>"/><input type="submit" name="delete" value="DELETE"></form></td>
                  </tr>
                  <?php
                }
                ?>
              </table>
            </div>
            <div class="col-md-2"></div>
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
if (isset($_POST['submit'])) { //Clicked on submit button
  //Obtain user input
  $title = filter_has_var(INPUT_POST, 'title') ? $_POST['title']: null;
  //Trim white space
  $title = trim($title);
  //Sanitize user input
  $title = filter_var($title, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

  $titleSQL = "INSERT INTO competition_template (templateTitle) VALUES (?)";
  $stmt = mysqli_prepare($conn, $titleSQL) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmt, "s", $title);
  mysqli_stmt_execute($stmt);

  if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "<script>alert('Template created!')</script>";
    $sql = "SELECT MAX(templateID) FROM competition_template";
    $stmt = mysqli_prepare($conn, $sql) or die( mysqli_error($conn));
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $tempID);
    mysqli_stmt_fetch($stmt);
    $tempID = intval($tempID);
    mysqli_stmt_close($stmt);

    //Obtain user input
    $question1 = filter_has_var(INPUT_POST, 'q1ID') ? $_POST['q1ID']: null;
    //Trim white space
    $question1 = trim($question1);
    //Sanitize user input
    $question1 = filter_var($question1, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    $answer1 = filter_has_var(INPUT_POST, 'answer1') ? $_POST['answer1']: null;
    //Trim white space
    $answer1 = trim($answer1);
    //Sanitize user input
    $answer1 = filter_var($answer1, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    $question1SQL = "INSERT INTO competition_question (templateID, questionTitle, questionAns) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $question1SQL) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "iss", $tempID, $question1, $answer1);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
      echo "<script>alert('Question created!')</script>";
      echo "<meta http-equiv=\"refresh\" content=\"0;URL=Admin_createTemplate.php\">";
    }
    else {
      echo "<script>alert('Failed to create Question!')</script>";
    }
  }
  else {
    echo "<script>alert('Failed to create template!')</script>";
  }

  mysqli_stmt_close($stmt);
}
?>

<?php
if (isset($_POST['edit'])) { //Clicked on update button
  //Obtain user input
  $templateID = filter_has_var(INPUT_POST, 'templateID') ? $_POST['templateID']: null;
  //Trim white space
  $templateID = trim($templateID);
  //Sanitize user input
  $templateID = filter_var($templateID, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

  $title = filter_has_var(INPUT_POST, 'title') ? $_POST['title']: null;
  //Trim white space
  $title = trim($title);
  //Sanitize user input
  $title = filter_var($title, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

  $questionTitle = filter_has_var(INPUT_POST, 'questionTitle') ? $_POST['questionTitle']: null;
  //Trim white space
  $questionTitle = trim($questionTitle);
  //Sanitize user input
  $questionTitle = filter_var($questionTitle, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

  $answer = filter_has_var(INPUT_POST, 'answer1') ? $_POST['answer1']: null;
  //Trim white space
  $answer = trim($answer);
  //Sanitize user input
  $answer = filter_var($answer, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

  $updateSQL = "UPDATE competition_template SET templateTitle=? WHERE templateID=?";
  $stmt = mysqli_prepare($conn, $updateSQL) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmt, "si", $title, $templateID);
  mysqli_stmt_execute($stmt);
  //
  $updateSQL2 = "UPDATE competition_question SET questionTitle=?, questionAns=? WHERE templateID=?";
  $stmt2 = mysqli_prepare($conn, $updateSQL2) or die( mysqli_error($conn));
  mysqli_stmt_bind_param($stmt2, "ssi", $questionTitle, $answer, $templateID);
  mysqli_stmt_execute($stmt2);

  if (mysqli_stmt_affected_rows($stmt) > 0) {
    echo "<script>alert('Titile updated!')</script>";
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=Admin_createTemplate.php\">";
  }
  else {

  }
  if (mysqli_stmt_affected_rows($stmt2) > 0) {
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=Admin_createTemplate.php\">";
  }
  else {

  }
  mysqli_stmt_close($stmt);
  mysqli_stmt_close($stmt2);

}


?>

<?php

if (isset($_POST['delete'])) {

  $templateID = $_POST["templateID"];

  ?><script>alert('Your template had been deleted !');</script><?php

  $sql = "DELETE FROM competition_template WHERE templateID='$templateID'";

  if (mysqli_query($conn, $sql)) {
    echo "Record deleted successfully";
    echo "<meta http-equiv=\"refresh\" content=\"0;URL=Admin_createTemplate.php\">";
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
echo makeFooter("../");
echo makePageEnd();
?>
