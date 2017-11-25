<?php
  include '../db/database_conn.php';
  ini_set("session.save_path", "");
  session_start();
?>

<?php

if(isset($_POST['msgID'])  && isset($_POST['threadID']) && isset($_POST['myReply']) ){
  $msgID = $_POST['msgID'];
  $threadID = $_POST['threadID'];
  $myReply = $_POST['myReply'];
  $userID = $_POST['userID'];
  // echo $msgID . " - " . $threadID. " - " . $myReply;
  // echo $userID;

  $sqlInsertReply = "INSERT INTO discussion_message (userID, threadID, messageContent, messageStatus,replyTo)
                      VALUES ('$userID', '$threadID','$myReply','active','$msgID')";

  if ($conn->query($sqlInsertReply) === TRUE) {
    echo "Your reply has been posted!!!!";
  }
  $conn->close();
}

?>
