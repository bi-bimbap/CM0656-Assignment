<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Report Message");
echo makeWrapper("");
echo "<form method='post'>" . makeLoginLogoutBtn("") . "</form>";
echo makeProfileButton("");
echo makeNavMenu("");
echo makeHeader("Report Message");
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
  $_SESSION['userID'] = 3; //TODO: Remove session
  $_SESSION['userType'] = 'admin'; //TODO: Remove
  $_SESSION['username'] = 'Seah Jia-min'; //TODO: Remove
  $_SESSION['logged-in'] = true; //TODO: Remove

  $userID = $_SESSION['userID'];
    if(isset($_POST['msgID'])){
      $msgID = $_POST['msgID'];
      $_SESSION['msgID'] = $msgID;

      $threadID = $_POST['threadID'];
      $_SESSION['threadID'] = $threadID;

      $postedUserID = $_POST['PostedUserID'];
      $_SESSION['PostedUserID'] = $postedUserID;
    }else{
      $threadID = $_SESSION['threadID'];
      $msgID = $_SESSION['msgID'];
      $postedUserID = $_SESSION['PostedUserID'];
    }

    $sqlGetReport = "SELECT user.username, discussion_message.messageContent,
                              discussion_message.messageID,
                              discussion_message.messageDateTime
                        FROM discussion_message
                        INNER JOIN user
                        ON discussion_message.userID=user.userID
                        WHERE discussion_message.messageID = $msgID";
    $MsgReport = mysqli_query($conn, $sqlGetReport) or die(mysqli_error($conn));

    if (mysqli_num_rows($MsgReport) > 0){
        while($rows = mysqli_fetch_assoc($MsgReport)){
          $messageID = $rows['messageID'];
          $username = $rows['username'];
          $MsgDateTime= $rows['messageDateTime'];
          $MsgContent= $rows['messageContent'];
          echo "</br>
                <b>Reply Msg : $MsgContent </b> by $username - $MsgDateTime";

      }
    }

    ?>

    <br/><br/><br/>
    <div class='message-report'>
      <form method='post' action='Member_reportMessage_process.php'>
      Report:
      <select name='reportSelection'>
        <option value='sexual'>Sexual content</option>
        <option value='spam'>Spam</option>
        <option value='offensive'>Offensive</option>
        <option value='scam'>Scam or misleading</option>
        <option value='falsenews'>False news story</option>
        <option value='violent'>Violent or repulsive content</option>
        <option value='others'>Others</option>
      </select>
      <input type='submit' id='reportSelection_submit' name='reportSelection_submit' value='Post'/>
      </form>
    </div>
    <br/><br/><br/>
    <!--**********************************************************
     ***** Validation: only admin can access this page **********
    ***********************************************************-->
    <?php
    $dropdown = "sexual";
    if(isset($_POST['reportSelection'])) {
      $dropdown = $_POST['reportSelection'];
    }

    // echo "msgID :" . $msgID;
    // echo "<br/> postedUserID :" . $postedUserID;
    // echo "<br/> dropdown :" . $dropdown;
    // echo "<br/> userID :" . $_SESSION['userID'];

    if(isset($_POST['reportSelection']) )   {

      if ($conn->connect_error) {
         die("Connection failed: " . $conn->connect_error);
      }

      $sqlReport = "INSERT INTO report (contentID, userID, reportReason, reportFrom,contentType)
                    VALUES ('$msgID','$postedUserID','$dropdown','$userID','discussion message')";

      if (mysqli_query($conn, $sqlReport)) {
          echo "<script>alert('Your report has been posted!!!!')</script>";
          echo "<script>
                        top.window.location='../discussion/Member_postMessage.php?threadID=$threadID';
               </script>";
      } else {
          echo "<script>alert('Error')</script>";
      }

      mysqli_close($conn);
    }
    ?>

    <!--*******************************************************************************************************************************************************
          DISCUSSION BOARD : Create New Thread Form
    *******************************************************************************************************************************************************-->


    <?php
    echo makeFooter("");
    echo makePageEnd("");
    ?>
