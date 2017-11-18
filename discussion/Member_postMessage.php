<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Discussion Forum");
echo makeWrapper();
echo makeLoginLogoutBtn();
echo makeProfileButton();
echo makeNavMenu();

$environment = LOCAL; //TODO: Change to server
?>
<!-- CSS style -->
<link rel='stylesheet' href='../css/bootstrap.css' />
<link rel="stylesheet" href="../css/jquery-ui.min.css" />
<link rel="stylesheet" href="../css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="../css/stylesheet.css" />

<script src='../scripts/bootstrap.js'></script>
<script src='../scripts/jquery.dataTables.min.js'></script>
<script src="../scripts/jquery.js"></script>

<?php
    //Display Thread Title
    if(isset($_GET['threadID'])){
      $thread_id = $_GET['threadID'];
    }

      $sqlGetThread = "SELECT threadName, threadDescription
      FROM discussion_thread WHERE threadID = ?";
      $stmtGetThread = mysqli_prepare($conn, $sqlGetThread) or die(mysqli_error($conn));
      mysqli_stmt_bind_param($stmtGetThread, "i", $thread_id);
      mysqli_stmt_execute($stmtGetThread);
      mysqli_stmt_bind_result($stmtGetThread, $threadName, $threadDesc);
      mysqli_stmt_fetch($stmtGetThread);
      mysqli_stmt_close($stmtGetThread);
      mysqli_close($conn);

      echo makeHeader($threadName);
      echo "<h5>Description: ".$threadDesc."</h5><br/>";
?>

<!--*******************************************************************************************************************************************************
      DISCUSSION BOARD: Display Message Content
*******************************************************************************************************************************************************-->
<?php
    $sqlGetMessage = "SELECT user.username, discussion_message.messageContent, discussion_message.messageDateTime
    FROM discussion_message
    INNER JOIN user
    ON discussion_message.userID=user.userID
    ORDER BY messageDateTime DESC";

    $stmtGetMessage = mysqli_prepare($conn, $sqlGetMessage) or die(mysqli_error($conn));
    mysqli_stmt_execute($stmtGetMessage);
    mysqli_stmt_bind_result($stmtGetMessage, $userName, $messageContent, $messageDateTime);

    while(mysqli_stmt_fetch($stmtGetMessage)){
        echo
        "<div class='content'>
            <div class='container'>
                <div class='message-group'>
                    <div>
                      <p>$messageContent</p>
                    </div>
                    <div>
                      <div>$userName</div>
                      <div>$messageDateTime</div>
                    </div>
                </div>
            </div>
        </div>";
    }
    mysqli_stmt_close($stmtGetMessage);
    mysqli_close($conn);
?>

<!--**********************************************************
 ***** Validation: only member can view this page ***********
***********************************************************-->
<!-- <?php
// if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
// (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) {

?> -->
<!--*******************************************************************************************************************************************************
      DISCUSSION BOARD: Post New Message
*******************************************************************************************************************************************************-->
    <!-- Validation - Only member can post message -->



<!--*******************************************************************************************************************************************************
      DISCUSSION BOARD: Reply Message
*******************************************************************************************************************************************************-->
    <!-- Validation - Only member can reply message -->

<!-- TODO: Change the form to be POP OUT form -->
<!--*******************************************************************************************************************************************************
      DISCUSSION BOARD: Report Inappropriate Message
*******************************************************************************************************************************************************-->
    <!-- Validation - Only member can report inappropriate message -->


<?php
//} //for ajax, close
//} //for validate member
echo makeFooter();
echo makePageEnd();
?>
