<?php
include '../db/database_conn.php';
require_once('../functions.php');
include_once '../config.php';
$environment = LOCAL;
header('content-type: application/json');

$function = filter_has_var(INPUT_POST, 'action') ? $_POST['action']: null;
$function = trim($function);
$function = filter_var($function, FILTER_SANITIZE_STRING);

$a_json = array();
$a_json_row = array();

if($function == "loadEverything"){
  $sqlDiscussion = "SELECT threadName, threadDescription FROM discussion_thread ORDER BY threadName DESC";
  $stmtDiscussion = mysqli_prepare($conn, $sqlDiscussion) or die( mysqli_error($conn));
  mysqli_stmt_execute($stmtDiscussion);
  mysqli_stmt_bind_result($stmtDiscussion, $thread_name, $thread_name);
  //$discussion= mysqli_query($conn,$sqlDiscussion) or die(mysqli_error());

  while(mysqli_stmt_fetch($stmtDiscussion)) {
    $a_json_row = array("threadName" => $thread_name, "threadDescription" => $thread_name);
    array_push($a_json, $a_json_row);
  }
  echo json_encode($a_json, JSON_PRETTY_PRINT);

  mysqli_stmt_close($stmtDiscussion);
  mysqli_close($conn);
}
?>
