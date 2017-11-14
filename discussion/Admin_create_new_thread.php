<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Create Discussion Thread");
echo makeNavMenu();
echo makeHeader("Create Discussion Thread");
$environment = LOCAL; //TODO: Change to server
?>

<!-- CSS style -->
<link rel='stylesheet' href='../css/bootstrap.css' />
<link rel="stylesheet" href="../css/jquery-ui.min.css" />
<link rel="stylesheet" href="../css/parsley.css" />
<link rel="stylesheet" href="../css/stylesheet.css" />

<script src="../scripts/jquery.js"></script>
<script src="../scripts/parsley.min.js"></script>

<!-- TODO: Change the form to be POP OUT form -->
<!--------------------------------------------------------------------------------------------------------------------------
   Script - Pop Our Form for Create New Thread
--------------------------------------------------------------------------------------------------------------------------->

<!------------------------------------------------------------------------------------------------------------------------
      DISCUSSION BOARD : Create New Thread Form
------------------------------------------------------------------------------------------------------------------------->
    <form id="createThreadForm" data-parsley-validate method="post">
          <p>Thread Name: <input type="text" id="txtThreadName" name="txtThreadName" data-parsley-required="true" placeholder="Thread Name" /></p>
          <p>Thread Description: <input type="text" id="txtThreadDesc" name="txtThreadDesc" data-parsley-required="true" placeholder="Description" /></p>
          <!-- <input type="submit" name="createThread_submit" id="createThread_submit" value="Create" /> -->
          <button type="submit" name="createThread_submit" id="createThread_submit">Create</button>
      </br>
      </br>
      </br>
    </form>

<!--------------------------------------------------------------------------------------------------------------------------
      DISCUSSION BOARD: "Create" Submit Button Function
--------------------------------------------------------------------------------------------------------------------------->
<?php
      if(isset($_POST['createThread_submit']) && !empty($_POST['txtThreadName'] && !empty($_POST['txtThreadDesc'])) ){
        //obtain user

        $thread_name = filter_has_var(INPUT_POST,'txtThreadName') ? $_POST['txtThreadName']: null;
        $thread_desc = filter_has_var(INPUT_POST,'txtThreadDesc') ? $_POST['txtThreadDesc']: null;

        //Trim white space
        $thread_name = trim($thread_name);
        $thread_desc = trim($thread_desc);

        //Sanitize user input
        $thread_name = filter_var($thread_name, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
        $thread_desc = filter_var($thread_desc, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

        //Insert user's input into database
          $sqlNewThread = "INSERT INTO discussion_thread (threadName, threadDescription)	VALUES (?,?)";
          $stmtNewThread = mysqli_prepare($conn, $sqlNewThread) or die( mysqli_error($conn));
          mysqli_stmt_bind_param($stmtNewThread, 'ss', $thread_name, $thread_desc);
          mysqli_stmt_execute($stmtNewThread);

        	if (mysqli_stmt_affected_rows($stmtNewThread) > 0) {
        		echo "<script>alert('New Thread has been created successfully!')</script>";
        	}
          else {
        		echo "<script>alert('Failed to create! Try Again!')</script>";
        	}

          mysqli_stmt_close($stmtNewThread);
          mysqli_close($conn);

          clearstatcache();
}
?>

<?php
echo makeFooter();
echo makePageEnd();
?>
