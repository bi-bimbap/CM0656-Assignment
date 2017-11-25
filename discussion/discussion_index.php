<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
require_once('../config.php');
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
  // $_SESSION['userID'] = '3'; //TODO: Remove session
  // $_SESSION['userType'] = 'admin'; //TODO: Remove
  // $_SESSION['username'] = 'Seah Jia-min'; //TODO: Remove
  // $_SESSION['logged-in'] = true; //TODO: Remove

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
      <th>Topic ID</th>
      <th>Thread Name</th>
      <th>Created By</th>
      <th>Created DateTime</th>
      <th>Total Message</th>
    </tr>
  </thead>

  <?php
    $sqlDiscussion = "SELECT discussion_thread.threadID, discussion_thread.threadName,
                     discussion_thread.threadDateTime, user.username
              FROM discussion_thread
              INNER JOIN user ON discussion_thread.userID = user.userID
              ORDER BY discussion_thread.threadDateTime DESC";

    $result = mysqli_query($conn, $sqlDiscussion);

    if (mysqli_num_rows($result) > 0){
					while($rows = mysqli_fetch_assoc($result))
						{ // Start looping table row
              $ThreadID = $rows['threadID'];
              $ThreadName = $rows['threadName'];
              $admin_usr = $rows['username'];
              $createdDateTime = $rows['threadDateTime'];

                //small process to calculate total message
                $showTotalMsg = "SELECT * FROM discussion_message WHERE threadID = $ThreadID";
                $MsgResult= mysqli_query($conn, $showTotalMsg);
                $SumOfMsg = 0;
                if (mysqli_num_rows($MsgResult) > 0) {
										while($row = mysqli_fetch_assoc($MsgResult)) {
										    $SumOfMsg = $SumOfMsg +1;
										}
								}
                // End calculate total msg

              echo
                  "<tbody>
                      <tr>
                        <td><a href=\"Member_postMessage.php?threadID=$ThreadID\">$ThreadID</a></td>
                        <td><a href=\"Member_postMessage.php?threadID=$ThreadID\">$ThreadName</a></td>
                        <td>$admin_usr</td>
                        <td>$createdDateTime</td>
                        <td>$SumOfMsg</td>
                      </tr>
                    </tbody>";

              }

    }
  ?>
<!--***************************************************************************************************************
    Discussiom: Search Function
****************************************************************************************************************-->

<!--***************************************************************************************************************
    Discussiom: Update Function
****************************************************************************************************************-->
<!--***************************************************************************************************************
    Discussiom: Delete Function
****************************************************************************************************************-->
</table>
</div>
<?php
    // mysqli_stmt_close($stmtDiscussion);
    mysqli_close($conn);
//} //for ajax, close
echo makeFooter();
echo makePageEnd();
?>
=======
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
<link rel="stylesheet" href="../css/parsley.css" />
<link rel="stylesheet" href="../css/stylesheet.css" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,400i,700">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i">
<script src='../jquery-2.2.0.js'></script>
<script src="../jquery-ui.js"></script>
<script src="../scripts/bootstrap.min.js"></script>
<script src="../scripts/parsley.min.js"></script>
<script src="../scripts/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!--******************************************************************************************************************
    Validation - Only Only admin can view "Create New Thread" button
******************************************************************************************************************-->
<?php

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
      $sqlDiscussion = "SELECT discussion_thread.threadID, discussion_thread.threadName, user.username
      FROM discussion_thread
      INNER JOIN discussion_message
      ON discussion_thread.threadID=discussion_message.threadID
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
            //total message
      }
  ?>



<!--***************************************************************************************************************
    Discussiom: Search Function
****************************************************************************************************************-->

<!--***************************************************************************************************************
    Discussiom: Update Function
****************************************************************************************************************-->
<!--***************************************************************************************************************
    Discussiom: Delete Function
****************************************************************************************************************-->
</table>
</div>
<?php
    mysqli_stmt_close($stmtDiscussion);
    mysqli_close($conn);
//} //for ajax, close
echo makeFooter();
echo makePageEnd();
?>
