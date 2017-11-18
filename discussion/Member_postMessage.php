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
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<!-- <i class='material-icons'>reply</i></input> -->
<script src='../scripts/bootstrap.js'></script>
<script src='../scripts/jquery.dataTables.min.js'></script>
<script src="../scripts/jquery.js"></script>

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
      DISCUSSION BOARD: Display Message Content
*******************************************************************************************************************************************************-->
        <?php
            $sqlGetMessage = "SELECT user.username, discussion_message.messageContent, discussion_message.messageDateTime
            FROM discussion_message
            INNER JOIN discussion_thread
            ON discussion_message.threadID=discussion_thread.threadID
            INNER JOIN user
            ON discussion_message.userID=user.userID
            WHERE discussion_thread.threadID = ?
            ORDER BY discussion_message.messageDateTime DESC";

            $stmtGetMessage = mysqli_prepare($conn, $sqlGetMessage) or die(mysqli_error($conn));
            mysqli_stmt_bind_param($stmtGetMessage, "i", $threadID);
            mysqli_stmt_execute($stmtGetMessage);
            mysqli_stmt_bind_result($stmtGetMessage, $userName, $messageContent, $messageDateTime);

            while(mysqli_stmt_fetch($stmtGetMessage)){
                echo"
                  <div class='message-created'>
                      <p><h6>$userName</h6></p>
                      <p><h6>$messageDateTime</h6></p>
                      <p><h4>$messageContent</h4></p>
                      <p>
                        <a>Reply</a>
                      </p>
                    </div>
                    </br>";

            }
            mysqli_stmt_close($stmtGetMessage);
        ?>

        <?php
        /*******************************************************************************************************************************************************
              DISCUSSION BOARD: Reply Message (Member)
        *******************************************************************************************************************************************************/
            //TODO Validation: Only Member can see This
            //Validation - Only member can reply message
              // echo"
              //         <p>
              //           <a>Reply</a>
              //         </p>
              //       </div>
              //       </br>";
        ?>

        <?php
            if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
            (isset($_SESSION['userType']) && ($_SESSION['userType'] == "junior" || $_SESSION['userType'] == "senior"))) {

              /*******************************************************************************************************************************************************
                    DISCUSSION BOARD: Post New Message (Member)
              *******************************************************************************************************************************************************/
              //TODO Validation: Only Member can see This
              //Validation - Only member can post message

              if(isset($_POST['postMessage_submit']) && !empty($_POST['txtPostMessage'])){
                //obtain user input
                $post_message = filter_has_var(INPUT_POST,'txtPostMessage') ? $_POST['txtPostMessage']: null;

                //Trim white space
                $post_message = trim($post_message);

                //Sanitize user input
                $post_message = filter_var($post_message, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

                //TODO get userID
                //TODO get messageStatus
                // if(isset($_GET['userID'])){
                //   $threadID = $_GET['userID'];
                // }

                //Insert user's input into database
                $sqlPostMessage = "INSERT INTO discussion_message (messageContent)	VALUES (?)";
                $stmtPostMessage = mysqli_prepare($conn, $sqlPostMessage) or die( mysqli_error($conn));
                mysqli_stmt_bind_param($stmtPostMessage, 's', $messageContent);
                mysqli_stmt_execute($stmtPostMessage);
                mysqli_stmt_bind_result($stmtPostMessage, $messageContent);

                if(mysqli_stmt_affected_rows($stmtPostMessage) > 0){
                  echo "<script>alert('The message has been posted')</script>";
                }
                else {
                  echo "<script>alert('Try again!')</script>";
                }
                mysqli_stmt_close($stmtPostMessage);
              }

          }
          else {
            $url = "../loginForm.php";
            echo "<script type='text/javascript'>";
            echo "alert('You are not member, please log in as member to post message!');";
            echo 'window.location.href="'.$url.'";';
            echo "</script>";
          }
        ?>
        <!-- onKeyPress='postMessage(event)' -->
            <div class='message-new'>
              <form id='postMessage_field' method='post'>
                <input type='text' id='txtPostMessage' name='txtPostMessage' data-parsley-required='true' placeholder='Post a message..' />
                <input type='submit' id='postMessage_submit' name='postMessage_submit' value='Post'/>
              </form>
            </div>
      </div>
  </div>
</div>

<!-- TODO: Change the form to be POP OUT form -->
<!--*******************************************************************************************************************************************************
      DISCUSSION BOARD: Report Inappropriate Message (Member)
*******************************************************************************************************************************************************-->
    <!-- Validation - Only member can report inappropriate message -->


<?php
            mysqli_close($conn);
//} //for ajax, close
echo makeFooter();
echo makePageEnd();
?>
