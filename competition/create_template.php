<?php

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
  <title>Create Template</title>
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



              $templateSQL = "SELECT * FROM competition_template JOIN competition_question ON competition_template.templateID = competition_question.templateID WHERE competition_template.templateID=" . $templateID;
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
                    <td colspan="2" align="center"><a href="create_template.php" onclick="history.back(1);" class="btn btn-primary">Back</a></td>
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
                <td><a href= "create_template.php?templateID=<?php echo $row["templateID"]; ?>"><button>UPDATE</button></a></td>
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
      echo "<meta http-equiv=\"refresh\" content=\"0;URL=create_template.php\">";
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
      echo "<meta http-equiv=\"refresh\" content=\"0;URL=create_template.php\">";
    }
    else {

    }
    if (mysqli_stmt_affected_rows($stmt2) > 0) {
      echo "<meta http-equiv=\"refresh\" content=\"0;URL=create_template.php\">";
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
      echo "<meta http-equiv=\"refresh\" content=\"0;URL=create_template.php\">";
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
