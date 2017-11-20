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
          if(isset($_GET["update"])){
            $templateID = $_GET["templateID"] ?? null;
            $where = array("templateID"=>$templateID,);
            $row = $obj->select_record("create_template",$where);
            ?>
            <!-- <form method="post" action="action.php"> -->
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
                  <td><input type="text" class="form-control" name="q1ID" placeholder="Enter Question 1"></td>
                </tr>
                <tr>
                  <td colspan="2" align="center"><input type="submit" class="btn btn-primary" name="edit" value="Update"></td>
                </tr>
              </table>
            </form>
            <?php
          }else{
            ?>
            <!-- <form method="post" action="action.php"> -->
            <form method="post">
              <table class="table table-hover">
                <tr>
                  <td>Template Title</td>
                  <td><input type="text" class="form-control" name="title" placeholder="Enter Template Title"></td>
                </tr>
                <tr>
                  <td>Question 1</td>
                  <td><input type="text" class="form-control" name="q1ID" placeholder="Enter Question 1"></td>
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
                // $myrow = $obj->fetch_record("create_template");
                // foreach ($myrow as $row) {

                  ?>
                  <!-- <tr>
                    <td><?php echo $row["templateID"]; ?></td>
                    <td><?php echo $row["templateTitle"]; ?></td>
                    <td><a href="index.php?update=1&templateID=<?php echo $row["templateID"]; ?>">Edit</a></td>
                    <td><a href="action.php?delete=1&templateID=<?php echo $row["templateID"]; ?>">Delete</a></td>
                  </tr> -->
                  <?php
                // }
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
  }
  else {
    echo "<script>alert('Failed to create template!')</script>";
  }
  mysqli_stmt_close($stmt);
}
?>
