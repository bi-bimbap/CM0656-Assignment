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

//Validation - Only Only member can view "Reply" button
//Only show content if user is logged in
$_SESSION['userID'] = '1'; //TODO: Remove session
$_SESSION['userType'] = 'senior'; //TODO: Remove
$_SESSION['username'] = 'seahjm'; //TODO: Remove
$_SESSION['logged-in'] = true; //TODO: Remove
// $_SESSION['userID'] = '3'; //TODO: Remove session
// $_SESSION['userType'] = 'admin'; //TODO: Remove
// $_SESSION['username'] = 'Seah Jia-min'; //TODO: Remove
// $_SESSION['logged-in'] = true; //TODO: Remove
?>
<!-- CSS style -->
<link rel='stylesheet' href='../css/bootstrap.css' />
<link rel="stylesheet" href="../css/jquery-ui.min.css" />
<link rel="stylesheet" href="../css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="../css/stylesheet.css" />
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!-- <i class='material-icons'>reply</i></input> -->
<script src='../scripts/bootstrap.js'></script>
<script src='../scripts/jquery.dataTables.min.js'></script>
<script src="../scripts/jquery.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>

<!-- Report Inappropriate -->
<style>
                /**{margin: 0;padding:0px}*/

                .showLeft{
                    border:1px solid #BEC4C7 !important;
                    text-shadow: none !important;
                    color:#fff !important;
                    padding:10px;
                }

                .icons li {
                    background: none repeat scroll 0 0 #fff;
                    height: 7px;
                    width: 7px;
                    line-height: 0;
                    list-style: none outside none;
                    margin-right: 15px;
                    margin-top: 3px;
                    vertical-align: top;
                    border-radius:50%;
                    pointer-events: none;
                }

                .button-left {
                    left: 0.4em;
                }

                .button-right {
                    right: 0.4em;
                }

                .button-left, .button-right {
                    top: 0.24em;
                }

                .dropbtn {
                    background-color: #BEC4C7;
                    /*position: fixed;*/
                    color: white;
                    font-size: 16px;
                    border: none;
                    cursor: pointer;
                }

                /*.dropbtn:hover, .dropbtn:focus {
                    background-color: #3e8e41;
                }*/

                .dropdown {
                    position: absolute;
                    display: inline-block;
                    right: 0.4em;
                }

                .report-content {
                    display: none;
                    /*position: relative;*/
                    margin-top: 60px;
                    background-color: #f9f9f9;
                    min-width: 160px;
                    overflow: auto;
                    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
                    z-index: 1;
                }

                .report-content a {
                    color: black;
                    padding: 12px 16px;
                    text-decoration: none;
                    display: block;
                }

                /*.dropdown a:hover {background-color: #f1f1f1}*/

                .show {display:block;}

            </style>
            <script>
                function changeLanguage(language) {
                    var element = document.getElementById("url");
                    element.value = language;
                    element.innerHTML = language;
                }

                function showDropdown() {
                    document.getElementById("reportContent").classList.toggle("show");
                }

                // Close the dropdown if the user clicks outside of it
                window.onclick = function(event) {
                    if (!event.target.matches('.dropbtn')) {
                        var dropdowns = document.getElementsByClassName("dropdown-content");
                        var i;
                        for (i = 0; i < dropdowns.length; i++) {
                            var openDropdown = dropdowns[i];
                            if (openDropdown.classList.contains('show')) {
                                openDropdown.classList.remove('show');
                            }
                        }
                    }
                }
            </script>
<!-- reply Message  -->
<script>
    function reply_show(){
    document.getElementsById("txtReplyMessage").style.visibility = 'visible';
    }
    //Function to Hide Popup
    function reply_hide(){
    document.getElementsById("txtReplyMessage").style.visibility= 'hidden';
    }
</script>

<style>

</style>

<?php
    //Display Thread Title
    if(isset($_GET['threadID'])){
      $threadID = $_GET['threadID'];
    }

      $sqlGetThread = "SELECT threadName, threadDescription
      FROM discussion_thread WHERE threadID = ?";
      $stmtGetThread = mysqli_prepare($conn, $sqlGetThread) or die(mysqli_error($conn));
      mysqli_stmt_bind_param($stmtGetThread, "i", $threadID);
      mysqli_stmt_execute($stmtGetThread);
      mysqli_stmt_bind_result($stmtGetThread, $threadName, $threadDesc);
      mysqli_stmt_fetch($stmtGetThread);

      echo makeHeader($threadName);
      echo "<h5>Description: ".$threadDesc."</h5><br/>";
      mysqli_stmt_close($stmtGetThread);
?>

<!--*******************************************************************************************************************************************************
      DISCUSSION BOARD: Messages
*******************************************************************************************************************************************************-->
<div class='content'>
<div class='container'>
<div class='message-group'>
<!--*******************************************************************************************************************************************************
      DISCUSSION BOARD: (1.1) Display Posted Message Content
*******************************************************************************************************************************************************-->
        <?php
            $sqlGetMessage = "SELECT user.username, discussion_message.messageContent, discussion_message.messageID, discussion_message.messageDateTime
            FROM discussion_message
            INNER JOIN discussion_thread
            ON discussion_message.threadID=discussion_thread.threadID
            INNER JOIN user
            ON discussion_message.userID=user.userID
            WHERE discussion_thread.threadID = ?
            ORDER BY discussion_message.messageID DESC";

            $stmtGetMessage = mysqli_prepare($conn, $sqlGetMessage) or die(mysqli_error($conn));
            mysqli_stmt_bind_param($stmtGetMessage, "i", $threadID);
            mysqli_stmt_execute($stmtGetMessage);
            mysqli_stmt_bind_result($stmtGetMessage, $userName, $messageContent, $messageID, $messageDateTime);

              //if(mysqli_stmt_num_rows($stmtGetMessage) == 0){

              if(mysqli_stmt_affected_rows($stmtGetMessage) < 0 ){

                //calculate total messages in a thread
                $messageNum = 0;
                while(mysqli_stmt_fetch($stmtGetMessage)){


echo"
    <div class='message-post'>
    <div><h6><b>$userName said: </b></h6></div>
    <div><h6><i>$messageDateTime</i></h6></div>
    <div><h4>$messageContent</h4></div>";

                    /*************************************************************************************************************************************************
                          DISCUSSION BOARD: (2.1) Show Reply Message Textbox (Member)
                    *************************************************************************************************************************************************/
                    //Validation - Only Only member can view "Reply" button
                    if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) && (isset($_SESSION['userID'])) &&
                    (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) {

                      if(isset($_POST['replyMessage_submit'])) {

                      }

echo "<div><button type='submit' id='replyMessage_submit' name='replyMessage_submit'>Reply</button></div>";


echo "<form method='post' action='Member_postMessage_process.php'>
        <input type='hidden' name='replyTo_threadID' value='$threadID'/>
        <input type='hidden' name='replyTo_messageID' value='$messageID'/>
        <input type='text' id='txtReplyMessage' name='txtReplyMessage' placeholder='Write a comment..'/>
      </form>";
echo "</div></br>";
                    }
                    else
                    {
echo "";
echo "";
echo "</div></br>";
                    }
//.................................................................................................................
$sqlGetReply = "SELECT discussion_message.messageID, user.username, discussion_message.messageContent, discussion_message.messageDateTime, discussion_message.replyTo
FROM discussion_message
INNER JOIN discussion_thread
ON discussion_message.threadID=discussion_thread.threadID
INNER JOIN user
ON discussion_message.userID=user.userID
WHERE discussion_thread.threadID = ? AND discussion_message.replyTo=discussion_message.messageID
ORDER BY discussion_message.messageID DESC";

$stmtGetReply = mysqli_prepare($conn, $sqlGetReply) or die(mysqli_error($conn));
mysqli_stmt_bind_param($stmtGetReply, "i", $threadID);
mysqli_stmt_execute($stmtGetReply);
mysqli_stmt_bind_result($stmtGetReply, $messageID, $userName, $messageContent, $messageDateTime, $replyTo);

  if(mysqli_stmt_affected_rows($stmtGetReply) < 0 ){

    //calculate total replies in a message
    $replyNum = 0;
    while(mysqli_stmt_fetch($stmtGetReply)){

echo"
<div class='message-reply'>
<input type='hidden' name='replyTo_display' value='$replyTo'/>
<div><h6><b>$userName said: </b></h6></div>
<div><h6><i>$messageDateTime</i></h6></div>
<div><h4>$messageContent</h4></div>
</div>";
    $replyNum++;
  } //End: calculate total messages
}
//.................................................................................................................
                $messageNum++;
              } //End: calculate total messages

                  if($messageNum == 0){
echo"
<div class='message-post'>
<div><h4>No Message Content</h4></div>
</div>
</br>";
                  }
              } //END: (1) Post Message
            //}
            mysqli_stmt_close($stmtGetMessage);
        ?>

<!--*******************************************************************************************************************************************************
              DISCUSSION BOARD: (1.2) Display Replied Message Content
*******************************************************************************************************************************************************-->
        <?php
//             $sqlGetReply = "SELECT discussion_message.messageID, user.username, discussion_message.messageContent, discussion_message.messageDateTime, discussion_message.replyTo
//             FROM discussion_message
//             INNER JOIN discussion_thread
//             ON discussion_message.threadID=discussion_thread.threadID
//             INNER JOIN user
//             ON discussion_message.userID=user.userID
//             WHERE discussion_thread.threadID = ? AND discussion_message.replyTo=discussion_message.messageID
//             ORDER BY discussion_message.messageID DESC";
//
//             $stmtGetReply = mysqli_prepare($conn, $sqlGetReply) or die(mysqli_error($conn));
//             mysqli_stmt_bind_param($stmtGetReply, "i", $threadID);
//             mysqli_stmt_execute($stmtGetReply);
//             mysqli_stmt_bind_result($stmtGetReply, $messageID, $userName, $messageContent, $messageDateTime, $replyTo);
//
//               if(mysqli_stmt_affected_rows($stmtGetReply) < 0 ){
//
//                 //calculate total replies in a message
//                 $replyNum = 0;
//                 while(mysqli_stmt_fetch($stmtGetReply)){
//
// echo"
// <div class='message-reply'>
// <input type='hidden' name='replyTo_display' value='$replyTo'/>
// <div><h6><b>$userName said: </b></h6></div>
// <div><h6><i>$messageDateTime</i></h6></div>
// <div><h4>$messageContent</h4></div>
// </div>";
//                 $replyNum++;
//               } //End: calculate total messages
//             }
                //calculate total messages in a thread
                // $messageNum = 0;
                // while(mysqli_stmt_fetch($stmtGetMessage)){
        ?>

        <?php
            //Validation - Only member can view "Post" textfield
            if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) && (isset($_SESSION['userID'])) &&
            (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) {

              /*******************************************************************************************************************************************************
                    DISCUSSION BOARD: (2.2) Post New Message (Member)
              *******************************************************************************************************************************************************/
              if(isset($_POST['postMessage_submit']) && !empty($_POST['txtPostMessage'])){
                //obtain user input
                $post_message = filter_has_var(INPUT_POST,'txtPostMessage') ? $_POST['txtPostMessage']: null;

                //Trim white space
                $post_message = trim($post_message);

                //Sanitize user input
                $post_message = filter_var($post_message, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

                //new posted message status is active
                $messageStatus = "active";

                //Insert user's input into database
                $sqlPostMessage = "INSERT INTO discussion_message (userID, threadID, messageContent, messageStatus)	VALUES (?,?,?,?)";
                $stmtPostMessage = mysqli_prepare($conn, $sqlPostMessage) or die( mysqli_error($conn));
                mysqli_stmt_bind_param($stmtPostMessage, 'ssss', $_SESSION['userID'], $threadID, $post_message, $messageStatus);
                mysqli_stmt_execute($stmtPostMessage);
                //mysqli_stmt_bind_result($stmtPostMessage, $_SESSION['userID'], $post_message);

                if(mysqli_stmt_affected_rows($stmtPostMessage) > 0){
                  echo "<script>alert('The message has been posted')</script>";
                }
                else {
                  echo "<script>alert('Try again!')</script>";
                }
                //validation: Prevent Resubmit Users' Previous Input Data
                clearstatcache();
                mysqli_stmt_close($stmtPostMessage);
              } //END: (3) Post New Message

echo "
<div class='message-new'>
<form id='postMessage_field' method='post'>
<input type='text' id='txtPostMessage' name='txtPostMessage' placeholder='Post a message..' />
<input type='submit' id='postMessage_submit' name='postMessage_submit' value='Post'/>
</form>
</div>";
            }
            else {
echo "
<div class='message-new'>
<form id='postMessage_field' method='post'>
</form>
</div>";
            }
        ?>
</div>
</div>
</div>

<!-- TODO: Change the form to be POP OUT form -->
<?php
                  // echo"
                  //     <div class='message-new'>
                  //       <form id='postMessage_field' method='post'>
                  //       </form>
                  //     </div>";

                  //(2) Reply Message
//THREE DOTS MENU: reportInappropriate = dropdown
//THREE DOTS:      = dropbtn icons btn-right showLeft
//MENU (5):        = -d'myDropdown' class'dropdown-content'

?>

<?php
            mysqli_close($conn);
//} //for ajax, close
echo makeFooter();
echo makePageEnd();
?>
