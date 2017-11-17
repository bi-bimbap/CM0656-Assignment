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
    if(isset($_GET['messageID'])){
      $messageID = $_GET['messageID'];
    }

    $sqlGetMessage = "SELECT userID, messageContent, messageDateTime
    FROM discussion_message ORDER BY messageDateTime DESC";

    $stmtGetMessage = mysqli_prepare($conn, $sqlGetMessage) or die(mysqli_error($conn));
    mysqli_stmt_execute($stmtGetMessage);
    mysqli_stmt_bind_result($stmtGetMessage, $userID, $messageContent, $messageDateTime);
    mysqli_stmt_fetch($stmtGetMessage);

        echo
        "<div class='content'>
            <div class='container'>
                <div class='message-group'>
                    <div>
                      <p>$messageContent</p>
                    </div>
                    <div>
                      <div>$userID</div>
                      <div>$messageDateTime</div>
                    </div>
                </div>
            </div>
        </div>";
    mysqli_stmt_close($stmtGetMessage);
    mysqli_close($conn);

?>

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
echo makeFooter();
echo makePageEnd();
?>
