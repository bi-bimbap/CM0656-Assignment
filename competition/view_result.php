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
  <title>Results</title>
  <link rel="stylesheet" href="" type="text/css" />
  <script type="text/javascript"></script>
  </head>

<body>
  <div class ="container">
    <div class ="jumbotron">
      <h1>View all results</h1>
    </div>
  </div>

  <div class="container">
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
</div>
</body>
</html>
