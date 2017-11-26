<?php
  include '../db/database_conn.php';
  ini_set("session.save_path", "");
  session_start();
?>

<?php
/****************************************************************************************************************
      DISCUSSION BOARD: (REPLY MESSAGE) Reply New Message Function
*****************************************************************************************************************/
//Validation - Only member can reply message
if(isset($_POST['msgID'])  && isset($_POST['threadID']) && isset($_POST['replyMsg']) ){
  $msgID = $_POST['msgID'];
  $threadID = $_POST['threadID'];
  $reply_message = $_POST['replyMsg'];
  $userID = $_POST['userID'];

  /*******************************************************************************************************************************************************
        DISCUSSION BOARD: (REPLY MESSAGE - INAPPROPRIATE) Automatic Moderate Inappropriate Phrase
  *******************************************************************************************************************************************************/
  //check inappropriate Phrase
  $str_message = $reply_message;
  $array_message = explode(" ", $str_message);
  $check_replyInappropriateSQL = "SELECT * FROM discussion_inappropriate";

  $check_replyInappropriateResult = mysqli_query($conn, $check_replyInappropriateSQL);

  if (mysqli_num_rows($check_replyInappropriateResult) > 0) {
      // output data of each row
      while($row = mysqli_fetch_assoc($check_replyInappropriateResult)) {
        for($i = 0; $i < count($array_message); $i++){
          if(strtolower($array_message[$i]) == $row['inappropriatePhrase']){
            $array_message[$i] = $row['replacementWord'];
          }
        }
      }
  }
  $reply_message = implode(" ", $array_message);

  //insert reply message content
  $sqlInsertReply = "INSERT INTO discussion_message (userID, threadID, messageContent, messageStatus,replyTo)
                      VALUES ('$userID', '$threadID','$reply_message','active','$msgID')"; //new posted reply status is active

  if ($conn->query($sqlInsertReply) === TRUE) {
    echo "Your reply has been posted!!!!";
  }
  $conn->close();
}

?>
