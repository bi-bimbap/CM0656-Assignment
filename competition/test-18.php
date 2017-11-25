
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
  <title>Test</title>
  <link rel="stylesheet" href="" type="text/css" />
  <script type="text/javascript"></script>
  </head>

<body>
  <div class ="container">
    <div class ="jumbotron">
      <h1>Complete Your Test</h1>

    </div>
  </div>

  <div class ="container">
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
        </body>
        </html>
