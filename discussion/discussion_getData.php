<?php
include '../db/database_conn.php';
require_once('../functions.php');
include_once '../config.php';
$environment = LOCAL;
header('content-type: application/json');

$row = $_POST['row'];
$viewmore = 2;

// selecting posts
$query = 'SELECT * FROM discussion_thread limit '.$row.','.$viewmore;
$result = mysql_query($query);


while ($row = mysqli_fetch_array($discussion)) {
    $thread_name         = $row['threadName'];
    $thread_desc         = $row['threadDescription'];

    echo
    "<div class="displayDiscussionInfo">
      <tr>
        <td>$thread_name</td>
        <td>$thread_desc</td>
      </tr>
    </div>";
}
?>
