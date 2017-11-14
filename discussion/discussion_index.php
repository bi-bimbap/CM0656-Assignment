<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Discussion Board");
echo makeNavMenu();
echo makeHeader("Discussion Board");
$environment = LOCAL;
?>

<!-- CSS style -->
<link rel='stylesheet' href='../css/bootstrap.css' />
<link rel="stylesheet" href="../css/jquery-ui.min.css" />
<!-- <link rel="stylesheet" href="../css/jquery-ui.dataTables.min.css" /> -->
<link rel="stylesheet" href="../css/parsley.css" />
<link rel="stylesheet" href="../css/stylesheet.css" />

<!-- <script src='../scripts/bootstrap.js'></script> -->
<!-- <script src='../scripts/jquery-ui.dataTables.min.js'></script> -->
<script src="../scripts/jquery.js"></script>
<script src="../scripts/parsley.min.js"></script>

<!-- TODO: Verification - Only Admin Allowed to Login -->
<!--------------------------------------------------------------------------------------------------------------------------
    Verification - Only Admin Can View "Create New Thread" button
--------------------------------------------------------------------------------------------------------------------------->


<!-----------------------------------------------------------------------------
    DISCUSSION BOARD : List Created Message and Information
------------------------------------------------------------------------------>
<!-- Thread List -->
<table id="tblThreadList" class="display" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>Thread Name</th>
      <th>Thread Description</th>
    </tr>
  </thead>
 <?php
    $sqlDiscussion = "SELECT threadName, threadDescription FROM discussion_thread ORDER BY threadName DESC";
    //$stmtDiscussion = mysqli_prepare($conn, $sqlDiscussion) or die( mysqli_error($conn));

    $discussion= mysqli_query($conn,$sqlDiscussion) or die(mysqli_error());

    while ($row = mysqli_fetch_array($discussion)) {
        $thread_name         = $row['threadName'];
        $thread_desc         = $row['threadDescription'];

        echo
        "<tr>
            <td>$thread_name</td>
            <td>$thread_desc</td>
        </tr>";
    }

      //mysqli_stmt_close($stmtDiscussion);
      mysqli_free_result($discussion);
      mysqli_close($conn);
?>

<!-- <script>
  $(document).ready(function(){
    //Created Thread List
    var tblThreadList = $('#tblThreadList').DataTable({
      ajax:{
        url:"discussion_index_serverProcessing.php",
        dataSrc: '',
        data: { action : "loadEverything"},
        type: "POST",
      },
      column:[
        { data: "threadName" ,}
        { data: "threadDescription" ,}
      ]
    });
  });
</script> -->


</table>

<?php
echo makeFooter();
echo makePageEnd();
?>
