<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Create Inappropriate Phrase");
echo makeWrapper();
echo makeLoginLogoutBtn();
echo makeProfileButton();
echo makeNavMenu();
echo makeHeader("Create Inappropriate Phrase");
$environment = LOCAL; //TODO: Change to server
?>

<!-- CSS style -->
<link rel='stylesheet' href='../css/bootstrap.css' />
<link rel="stylesheet" href="../css/jquery-ui.min.css" />
<link rel="stylesheet" href="../css/parsley.css" />
<link rel="stylesheet" href="../css/stylesheet.css" />

<script src="../scripts/jquery.js"></script>
<script src="../scripts/parsley.min.js"></script>

<!--*******************************************************************************************************************************************************
      DISCUSSION BOARD : Create New Inappropriate Phrase Form
*******************************************************************************************************************************************************-->
    <form id="InappropriatePhrase" data-parsley-validate method="post">
          <p>Inappropriate Phrase: <input type="text" id="txtInappropriate" name="txtInappropriate" data-parsley-required="true" /></p>
          <input type='submit' value='Add' name='addInappropriate' />
      </br>
      </br>
      </br>
    </form>

<!--*******************************************************************************************************************************************************
      DISCUSSION BOARD: "Add" Button Function
*******************************************************************************************************************************************************-->
<?php
      if(isset($_POST['addInappropriate']) && !empty($_POST['txtInappropriate'])){

        //obtain user input
        $inappropriate_phrase = filter_has_var(INPUT_POST,'txtInappropriate') ? $_POST['txtInappropriate']: null;

        //Trim white space
        $inappropriate_phrase = trim($inappropriate_phrase);

        //Sanitize user input
        $inappropriate_phrase = filter_var($inappropriate_phrase, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        //Insert user's input into database
          $sqlInappropriate = "INSERT INTO discussion_inappropriate (InappropriatePhrase)	VALUES (?)";
          $stmtInappropriate = mysqli_prepare($conn, $sqlInappropriate) or die( mysqli_error($conn));
          mysqli_stmt_bind_param($stmtInappropriate, 's', $inappropriate_phrase);
          mysqli_stmt_execute($stmtInappropriate);

        	if (mysqli_stmt_affected_rows($stmtInappropriate) > 0) {
        		echo "<script>alert('New Inappropriate Phrase has been added successfully!')</script>";
        	}
          else {
        		echo "<script>alert('Failed to add! Try Again!')</script>";
        	}

          mysqli_stmt_close($stmtInappropriate);
          mysqli_close($conn);

          //validation: Prevent Resubmit Users' Previous Input Data
          clearstatcache();
}
?>

<?php
echo makeFooter();
echo makePageEnd();
?>
