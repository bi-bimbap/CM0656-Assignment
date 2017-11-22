<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Discussion Index");
echo makeWrapper();
echo "<form method='post'>" . makeLoginLogoutBtn() . "</form>";
echo makeProfileButton();
echo makeNavMenu();
echo makeHeader("Discussion Index");
$environment = LOCAL;
?>

<!-- CSS style -->
<link rel='stylesheet' href='../css/bootstrap.css' />
<link rel="stylesheet" href="../css/jquery-ui.min.css" />
<link rel="stylesheet" href="../css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="../css/stylesheet.css" />

<!-- <script src='../scripts/bootstrap.js'></script> -->
<!-- <script src='../scripts/jquery.dataTables.min.js'></script> -->
<script src="../scripts/jquery.js"></script>

<!-- TODO: Verification - Only Admin Allowed to Login -->
<!--******************************************************************************************************************
    Validation - Only Only admin can view "Create New Thread" button
******************************************************************************************************************-->
<?php
  $_SESSION['userID'] = '3'; //TODO: Remove session
  $_SESSION['userType'] = 'admin'; //TODO: Remove
  $_SESSION['username'] = 'Seah Jia-min'; //TODO: Remove
  $_SESSION['logged-in'] = true; //TODO: Remove

  if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
  (isset($_SESSION['userType']) && ($_SESSION['userType'] == "admin" || $_SESSION['userType'] == "mainAdmin"))) {
    echo
    "<form method='post' action='Admin_createThread.php'>
      <input type='submit' value='Create New Thread' name='createThread_submit' />
    </form>";
  }
?>
<!--******************************************************************************************************************
    DISCUSSION BOARD : List Created Discussion Message and Information
*******************************************************************************************************************-->
<div class="displayDiscussionInfo">
<table id="tblThreadList" class="display" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>Thread Name</th>
      <th>Created By</th>
      <!-- <th>Total Message</th> -->
    </tr>
  </thead>

  <?php
        // SELECT discussion_thread.threadID, discussion_thread.threadName, user.username, count(discussion_thread.threadID) AS Total
        // FROM discussion_thread
        // INNER JOIN user
        // ON discussion_thread.userID=user.userID
        // GROUP BY discussion_thread.threadID

  // SELECT discussion_message.threadID, discussion_thread.threadName, user.username, count(discussion_message.messageID) AS TOTAL
  // FROM discussion_message
  // INNER JOIN discussion_thread
  // ON discussion_message.threadID=discussion_thread.threadID
  // INNER JOIN user
  // ON discussion_message.userID=user.userID
  // GROUP BY discussion_thread.threadID
      // $total_message
      // COUNT(discussion_thread.threadID) AS Total
      // GROUP BY discussion_message.threadID

      $sqlDiscussion = "SELECT discussion_thread.threadID, discussion_thread.threadName, user.username
      FROM discussion_thread
      INNER JOIN user
      ON discussion_thread.userID=user.userID
      ORDER BY discussion_thread.threadID";
      $stmtDiscussion = mysqli_prepare($conn, $sqlDiscussion) or die( mysqli_error($conn));
      mysqli_stmt_execute($stmtDiscussion);
      mysqli_stmt_bind_result($stmtDiscussion, $thread_id, $thread_name, $admin_username);
      while (mysqli_stmt_fetch($stmtDiscussion)) {
          echo
          "<tbody>
              <tr>
                <td><a href=\"Member_postMessage.php?threadID=$thread_id\">$thread_name</a></td>
                <td>$admin_username</td>
              </tr>
            </tbody>";
      }
  ?>
<!--***************************************************************************************************************
    Discussiom: Search Function
****************************************************************************************************************-->


<?php
    mysqli_stmt_close($stmtDiscussion);
    mysqli_close($conn);
//} //for ajax, close
echo makeFooter();
echo makePageEnd();
?>
