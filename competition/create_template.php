<?php
// include "action.php";
include '../db/database_conn.php';
?>

<!DOCTYPE html>
<html>
<head>
  <!-- Latest compiled and minified CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

  <!-- jQuery library -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  <!-- Latest compiled JavaScript -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script><meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0"/>
  <title>Your Website</title>
  <link rel="stylesheet" href="" type="text/css" />
  <script type="text/javascript"></script>
</head>

<body>
  <div class ="container">
    <div class ="jumbotron">
      <h1>Create Your Template</h1>
    </div>
  </div>

  <div class ="container">
    <div class="row">
      <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class ="panel panel-primary">
          <div class="panel-heading">Enter Your Questions</div>
          <div class="panel-body">
            <?php
            if(isset($_GET["templateID"])){
              $templateID = $_GET["templateID"] ?? null;

              $templateSQL = "SELECT * FROM competition_template WHERE templateID=".$templateID;
              $templateRs = mysqli_query($conn, $templateSQL) or die(mysqli_error($conn));

              while ($row = mysqli_fetch_assoc($templateRs)){

                ?>

                <form method="post">
                  <table class="table table-hover">
                    <tr>
                      <td><input type="hidden" name="templateID" value="<?php echo $templateID; ?>"></td>
                    </tr>
                    <tr>
                      <td>Template Title</td>
                      <td><input type="text" class="form-control" value="<?php echo $row["templateTitle"];  ?>" name="title" placeholder="Enter Template Title"></td>
                    </tr>
                    <tr>
                      <td>Question 1</td>
                      <td><input type="text" class="form-control" name="question1" ></td>
                    </tr>
                    <tr>
                      <td>Answer 1</td>
                      <td><input type="text" class="form-control" name="answer1" ></td>
                    </tr>
                    <tr>
                      <td>Question 2</td>
                      <td><input type="text" class="form-control" name="question2" ></td>
                    </tr>
                    <tr>
                      <td>Asnwer 2</td>
                      <td><input type="text" class="form-control" name="question2" ></td>
                    </tr>
                    <tr>
                      <td>Question 3</td>
                      <td><input type="text" class="form-control" name="question3" ></td>
                    </tr>
                    <tr>
                      <td>Answer 3</td>
                      <td><input type="text" class="form-control" name="answer3" ></td>
                    </tr>
                    <tr>
                      <td colspan="2" align="center"><input type="submit" class="btn btn-primary" name="edit" value="update"/></td>
                    </tr>
                  </table>
                </form>
                <?php
              }}else{
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

    </div>

    <div class="container">
      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">
          <table class="table table-bordered">
            <tr>
              <th></th>

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
                <td><a href= "create_template.php?templateID=<?php echo $row["templateID"]; ?>"><button>UPDATE</button></a></td>
                <td><form method ="post"><input type="hidden" name="templateID" value ="<?php echo $row["templateID"]; ?>"/><input type="submit" name="delete" value="DELETE"></form></td>
              </tr>
              <?php
            }
            // mysqli_stmt_close($stmt);
            ?>
          </table>
        </div>
        <div class="col-md-2"></div>
      </div>
    </div>

  </body>
  </html>

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
    $question = filter_has_var(INPUT_POST, 'q1ID') ? $_POST['q1ID']: null;
    //Trim white space
    $question = trim($question);
    //Sanitize user input
    $question = filter_var($question, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    $answer = 'answer';

    $questionSQL = "INSERT INTO competition_question (templateID, questionTitle, questionAns) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conn, $questionSQL) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "iss", $tempID, $question, $answer);
    mysqli_stmt_execute($stmt);

    if (mysqli_stmt_affected_rows($stmt) > 0) {
      echo "<script>alert('Question created!')</script>";
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
  if (isset($_POST['update'])) { //Clicked on update button
    //Obtain user input
    $title = filter_has_var(INPUT_POST, 'title') ? $_POST['title']: null;
    //Trim white space
    $title = trim($title);
    //Sanitize user input
    $title = filter_var($title, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

    // $templateID = filter_has_var(INPUT_POST, 'templateID') ? $_POST['templateID']: null;
    // //Trim white space
    // $templateID = trim($templateID);
    // //Sanitize user input
    // $templateID = filter_var($templateID, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    // $templateID = "3";

    $updateSQL = "SELECT questionID, questionTitle FROM competition_question WHERE templateID  = ?,?";
    $stmt = mysqli_prepare($conn, $updateSQL) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "is", $templateID);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_bind_result($stmt, $questionID, $questionTitle);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);

    // if ("select *") {
    //   echo "<script>alert('Template Updated!')</script>";
    // }
    // else {
    //   echo "<script>alert('Failed to update template!')</script>";
    // }
    // mysqli_stmt_close($stmt);
  }


  ?>

  <?php
  if (isset($_POST['delete'])) {
    $templateID = $_POST["templateID"];

    ?><script>alert('Your template had been deleted !');</script><?php

    $sql = "DELETE FROM competition_template WHERE templateID='$templateID'";

    if (mysqli_query($conn, $sql)) {
      echo "Record deleted successfully";
    } else {
      echo "Error deleting record: " . mysqli_error($conn);
    }
    ?>
    <Script>
    window.url('create_template.php');
    </script>
    <?php
  }
  else
  {

  }
  ?>
