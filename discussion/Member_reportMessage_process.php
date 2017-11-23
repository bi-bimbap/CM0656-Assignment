<?php
  include '../db/database_conn.php';
  ini_set("session.save_path", "");
  session_start();
?>
  <!-- CSS style -->
  <link rel='stylesheet' href='../css/bootstrap.css' />
  <link rel="stylesheet" href="../css/jquery-ui.min.css" />
  <link rel="stylesheet" href="../css/parsley.css" />
  <link rel="stylesheet" href="../css/stylesheet.css" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora:400,400i,700">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i">
  <script src='../jquery-2.2.0.js'></script>
  <script src="../scripts/bootstrap.min.js"></script>
  <script src="../scripts/jquery.js"></script>
  <script src="../scripts/parsley.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

<!--*******************************************************************************************************************************************************
      DISCUSSION BOARD: Report Inappropriate Message Content
********************************************************************************************************************************************************-->
<?php
    $replyThread  = $_POST['reportSelection'];

    //report content type  is discussion
    $contentType = "discussion";

    $sqlReportMessage = "INSERT INTO report (contentID, userID, reportReason, reportFrom, contentType)	VALUES (?,?,?,?,?)";
    $stmtReportMessage = mysqli_prepare($conn, $sqlReportMessage) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmtReportMessage, 'si', $post_message, $_SESSION['userID'], $replyReason, $messageID);
    mysqli_stmt_execute($stmtReportMessage);

    if(mysqli_stmt_affected_rows($stmtReportMessage) > 0){
      echo "<script>alert('The message has been reported')</script>";
    }
    else {
      echo "<script>alert('Try again!')</script>";

    }
    //validation: Prevent Resubmit Users' Previous Input Data

    // $url="Member_postMessage.php?threadID=".$replyThread;
    // header('Location: '.$url);
?>

<!--*******************************************************************************************************************************************************
      DISCUSSION BOARD: Automatic Moderation inappropriate Word
*******************************************************************************************************************************************************-->
<?php
echo  $replyInput;
//check inappropriate language
  $array_message = explode(" ", $replyInput);
  print_r ($array_message);

	$sqlCheckInappropriate = "SELECT inappropriatePhrase FROM discussion_inappropriate";
	$stmtCheckInappropriate = mysqli_prepare($con, $sqlCheckInappropriate) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmtCheckInappropriate);
  mysqli_stmt_bind_result($stmtCheckInappropriate, $inappropriate_phrase);

  if(mysqli_stmt_affected_rows($stmtCheckInappropriate) > 0){

      while(mysqli_stmt_fetch($stmtCheckInappropriate)){

	    	for($i = 0; $i < count($array_message); $i++){
	    		if(strtolower($array_message[$i]) == $inappropriate_phrase){
	    			$array_message[$i] = '*';
	    		}
	    	}
    }
    echo "<script>alert('Found Inappropriate Phrase')</script>";
  }
  else
  {
		echo "<script>alert('No result')</script>";
	    //No Result
	}

clearstatcache();
mysqli_stmt_close($stmtReplyMessage);
mysqli_stmt_close($stmtCheckInappropriate);
  ?>
