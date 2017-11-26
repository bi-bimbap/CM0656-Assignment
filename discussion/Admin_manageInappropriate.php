<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Create Inappropriate Phrase");
echo makeWrapper("../");
echo "<form method='post'>" . makeLoginLogoutBtn("../") . "</form>";
echo makeProfileButton("../");
echo makeNavMenu("../");
echo makeHeader("Create Inappropriate Phrase");
$_SESSION['userID'] = '3'; //TODO: Remove
$_SESSION['userType'] = 'mainAdmin'; //TODO: Remove
$_SESSION['logged-in'] = true; //TODO: Remove
$environment = WEB;
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
          <input type='submit' id='addInappropriate' name='addInappropriate' value='Add' />
      </br>
      </br>
      </br>
    </form>

<?php
    //Validation - Only admin can manage inappropriate phrase
    if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
    (isset($_SESSION['userType']) && ($_SESSION['userType'] == "admin" || $_SESSION['userType'] == "mainAdmin"))){

      /**********************************************************************************************************************************************************
            DISCUSSION BOARD: Create New Inappropriate Phrase "Add" Button Function
      **********************************************************************************************************************************************************/
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

                //validation: Prevent Resubmit Users' Previous Input Data
                clearstatcache();
            }

      /**********************************************************************************************************************************************************
            DISCUSSION BOARD : Dsiplay Inappropriate Phrase List
      **********************************************************************************************************************************************************/
      echo"
      <div class='displayInappropriateInfo'>
      <table id='tblInappropriateList' class='display' width='30%'>
        <thead>
          <tr>
            <th>Inappropriate Phrase</th>
          </tr>
        </thead>";

          $sqlDisplayInappropriate = "SELECT inappropriatePhrase FROM discussion_inappropriate ORDER BY inappropriatePhrase ASC";

          $stmtDisplayInappropriate = mysqli_prepare($conn, $sqlDisplayInappropriate) or die( mysqli_error($conn));
          mysqli_stmt_execute($stmtDisplayInappropriate);
          mysqli_stmt_bind_result($stmtDisplayInappropriate, $inappropriatePhrase);
          while (mysqli_stmt_fetch($stmtDisplayInappropriate)) {
              echo"
                  <tbody>
                    <tr>
                      <td>$inappropriatePhrase</td>
                    </tr>
                  </tbody>";
        }
            echo
            "</table>
            </div>";

} //End: isset check login
  else
  { //Did not login; Redirect to login page
    $url = "../loginForm.php";
    echo "<script>";
    echo "alert('You are not administrator, please log in as administrator to access this page!');";
    echo 'window.location.href="'.$url.'";';
    echo "</script>";
  }
  mysqli_stmt_close($stmtDisplayInappropriate);
  mysqli_close($conn);
 ?>

<?php
echo makeFooter("../");
echo makePageEnd();
?>
