<?php
ini_set("session.save_path", "");
session_start(); //start session
include '../db/database_conn.php'; //include databas
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Create Discussion Thread");
echo makeProfileButton();
echo makeNavMenu();
echo makeHeader("Create Discussion Thread");
$environment = LOCAL;
?>

<link href="../css/bootstrap.css" rel="stylesheet">
<script src="../scripts/jquery.js"></script>
<script src="../scripts/bootstrap.min.js"></script>

<!-----------------------------------------------------------
    Verification - Only Admin Allowed to Login
------------------------------------------------------------>


  <!-----------------------------------------------------------
      DISCUSSION BOARD : Create New Thread
  ------------------------------------------------------------>
  <h2>Popup</h2>

  <div class="box-wrapper">
    <form method="post" action="create_new_thread.php">
          <div class="form-group">
            <label for="thread_name" >Thread Name</label>
              <input type="text" class="form-control" id="thread_name" name="thread_name" placeholder="Thread Name"</>
            </br>
            <label for="thread_desc" >Thread Description</label>
              <input type="text" class="form-control" id="thread_desc" name="thread_desc" placeholder="Description">
          </div>
        </div>
      </div>
      <div class="row">
        <div class="form-group">
          <div class="col-sm-3 col-md-offset-9">
            <button class ="btn btn-block btn-success btn-lg" type="submit" name="Submit" id="createThread_submit" onClick="createThreadForm()" VALUE="Submit">Create</button>
          </div>
        </div>
      </div>
<!-----------------------------------------------------------
   Script - Pop Our Form for Create New Thread
------------------------------------------------------------>
      <script>
      // When the user clicks on div, open the popup
      function createThreadForm() {
          var popup = document.getElementById("createThread_submit");
          popup.classList.toggle("show");
      }
      </script>
    </form>

<?php
//echo makeFooter();
echo makePageEnd();
?>
