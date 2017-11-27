<?php
// ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Discussion Index");
echo makeWrapper("../");
echo "<form method='post'>" . makeLoginLogoutBtn("../") . "</form>";
echo makeProfileButton("../");
echo makeNavMenu("../");
echo makeHeader("Discussion Index");
$environment = WEB;
?>
<!-- CSS style -->
<link rel='stylesheet' href='../css/bootstrap.css' />
<link rel="stylesheet" href="../css/jquery-ui.min.css" />
<link rel="stylesheet" href="../css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="../css/stylesheet.css" />
<!-- <script src='../scripts/bootstrap.js'></script> -->
<!-- <script src='../scripts/jquery.dataTables.min.js'></script> -->
<script src="../scripts/jquery.js"></script>
<div class='content'>
<div class='container'>
<?php
  //Validation - Only admin can view "Create New Thread " button
  if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
  (isset($_SESSION['userType']) && ($_SESSION['userType'] == "admin" || $_SESSION['userType'] == "mainAdmin"))) {

    echo
    "<form method='post' action='Admin_createThread.php'>
      <input type='submit' value='Create New Thread' name='createThread' />
    </form>";

    echo "<form method='post' action='Admin_manageInappropriate.php'>
      <input type='submit' value='Add Inappropriate Phrase' name='addInappropriate' />
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
                     discussion_thread.threadDateTime, user.fullName
                    FROM discussion_thread
                    INNER JOIN user ON discussion_thread.userID = user.userID
                    ORDER BY discussion_thread.threadDateTime DESC";

    $result = mysqli_query($conn, $sqlDiscussion);

    if (mysqli_num_rows($result) > 0){
					while($rows = mysqli_fetch_assoc($result))
						{ // Start looping table row
              $ThreadID = $rows['threadID'];
              $ThreadName = $rows['threadName'];
              $admin_usr = $rows['fullName'];
              $createdDateTime = $rows['threadDateTime'];

                //small process to calculate total message
                $showTotalMsg = "SELECT * FROM discussion_message WHERE threadID = $ThreadID";
                $MsgResult= mysqli_query($conn, $showTotalMsg);
                $SumOfMsg = 0;
                if (mysqli_num_rows($MsgResult) > 0) {
										while($row = mysqli_fetch_assoc($MsgResult)) {
										    $SumOfMsg = $SumOfMsg +1;
										}
								}// End calculate total message

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
    mysqli_close($conn);
?>
</table>
</div>
</div>
</div>

<?php
echo makeFooter("../");
echo makePageEnd();
?>
