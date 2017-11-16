<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Create Discussion Thread");
echo makeNavMenu();

$environment = LOCAL; //TODO: Change to server
?>
<!-- CSS style -->
<link rel='stylesheet' href='../css/bootstrap.css' />
<link rel="stylesheet" href="../css/jquery-ui.min.css" />
<link rel="stylesheet" href="../css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="../css/stylesheet.css" />

<script src='../scripts/bootstrap.js'></script>
<script src='../scripts/jquery.dataTables.min.js'></script>
<script src="../scripts/jquery.js"></script>

<?php

    if(isset($_GET['threadID'])){
      $thread_id = $_GET['threadID'];
    }
      $sqlNewMessage = "SELECT discussion_message.threadID, discussion_thread.threadName
      FROM discussion_message INNER JOIN discussion_thread ON discussion_message.threadID=discussion_thread.threadID WHERE discussion_message.threadID=$thread_id";

      $stmtNewMessage = mysqli_prepare($conn, $sqlNewMessage) or die( mysqli_error($conn));
      $NewMessage= mysqli_query($conn,$sqlNewMessage);

      while ($row = mysqli_fetch_array($NewMessage)) {
          $thread_id           = $row['threadID'];
          $thread_name         = $row['threadName'];

          echo "<div class='paragraph'>
        					<h2><b>TITLE : 			</b></h2>
        					<p>". $row['threadName'] . "</p>
        				</div>";
      }

        //mysqli_stmt_close($stmtDiscussion);
        mysqli_free_result($NewMessage);
        mysqli_close($conn);
?>


<?php
//} //for ajax, close
//Selected thread as header
// echo makeMessageHeader();
echo makeHeader($thread_name);
echo makeFooter();
echo makePageEnd();
?>
