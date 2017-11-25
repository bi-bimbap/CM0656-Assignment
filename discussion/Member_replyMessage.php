<?php
  include '../db/database_conn.php';
  ini_set("session.save_path", "");
  session_start();
?>

<!--**********************************************************************************************************
      DISCUSSION BOARD: (2.1) Reply New Message (Member)
**************************************************************************************************************
<?php
//Validation - Only member can reply message
if(isset($_POST['msgID'])  && isset($_POST['threadID']) && isset($_POST['myReply']) ){
  $msgID = $_POST['msgID'];
  $threadID = $_POST['threadID'];
  $myReply = $_POST['myReply'];
  $userID = $_POST['userID'];

  $sqlInsertReply = "INSERT INTO discussion_message (userID, threadID, messageContent, messageStatus,replyTo)
                      VALUES ('$userID', '$threadID','$myReply','active','$msgID')";

  if ($conn->query($sqlInsertReply) === TRUE) {
    echo "Your reply has been posted!!!!";
  }
  $conn->close();
}

?>
