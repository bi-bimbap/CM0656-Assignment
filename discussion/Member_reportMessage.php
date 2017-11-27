<?php
// ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Report Message");
echo makeWrapper("../");
echo "<form method='post'>" . makeLoginLogoutBtn("../") . "</form>";
echo makeProfileButton("../");
echo makeNavMenu("../");
echo makeHeader("Report Message");
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
  //retrieve selected messageID
  $userID = $_SESSION['userID'];
    if(isset($_POST['msgID'])){
      //retrieve selected messageID
      $msgID = $_POST['msgID'];
      $_SESSION['msgID'] = $msgID;
      //retrieve selected threadID
      $threadID = $_POST['threadID'];
      $_SESSION['threadID'] = $threadID;
      //retrieve userID of posted message
      $postedUserID = $_POST['PostedUserID'];
      $_SESSION['PostedUserID'] = $postedUserID;
    }else{
      $threadID = $_SESSION['threadID'];
      $msgID = $_SESSION['msgID'];
      $postedUserID = $_SESSION['PostedUserID'];
    }

    /*******************************************************************************************************************************************************
          DISCUSSION BOARD: Display Message Content Before Report
    *******************************************************************************************************************************************************/
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

    <!--*******************************************************************************************************************************************************
          DISCUSSION BOARD : Report Message/Reply Form
    *******************************************************************************************************************************************************-->
    <br/><br/><br/>
    <div class='message-report'>
        <form method='post' style='text-align:center'>
          <input type='text' placeholder ='Description of the inappropriate content...' style='    display: block;
          margin: 50px auto 20px;' name='report_reason' id='reason'/>
    		  <input type='submit' id='report_submit' name='report_submit' value='REPORT'/>
        </form>
    </div>
    <br/><br/><br/>

<?php
/*******************************************************************************************************************************************************
      DISCUSSION BOARD: Report Message Function
*******************************************************************************************************************************************************/
    //Validation - Only member can view "Report" button
    if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) && (isset($_SESSION['userID'])) &&
    (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) {

      if(isset($_POST['report_submit']) )   {
        $reason = $_POST['report_reason'];

        $sqlReport = "INSERT INTO report (contentID, userID, reportReason, reportFrom,contentType)
                      VALUES ('$msgID','$postedUserID','$reason','$userID','discussion-message')";

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
    }
?>
</div>
</div>
<?php
echo makeFooter("../");
echo makePageEnd();
?>
