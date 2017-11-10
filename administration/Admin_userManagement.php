<!-- TODO: Focus on input in popup modal when open -->
<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("User Management");
echo makeProfileButton();
echo makeNavMenu();
echo makeHeader("User Management");
$environment = LOCAL;
?>

<link href="../css/jquery.dataTables.min.css" rel="stylesheet">
<link href="../css/bootstrap.css" rel="stylesheet">
<script src="../scripts/jquery.js"></script>
<script src="../scripts/bootstrap.min.js"></script>
<script src="../scripts/jquery.dataTables.min.js"></script>
<!-- <script src="../scripts/dataTables.editor.min.js"></script>
<script src="../scripts/dataTables.select.min.js"></script>
<script src="../scripts/dataTables.buttons.min.js"></script> -->

<?php //Only show content to admin/main admin
$_SESSION['userID'] = '3'; //TODO: Remove
$_SESSION['userType'] = 'mainAdmin'; //TODO: Remove
$_SESSION['logged-in'] = true; //TODO: Remove

if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
(isset($_SESSION['userType']) && ($_SESSION['userType'] == "admin" || $_SESSION['userType'] == "mainAdmin"))) {
  ?>

  <script>
  $(document).ready(function() {
    //Active member list
    var table = $('#tblMemberList').DataTable({ //Data table to display member list
      ajax: {
        url :"serverProcessing.php", //JSON datasource
        dataSrc: '', //Tell DataTables where the data array is in the JSON structure, left empty if it's an array
        data: { action : "loadAll" },
        type: "POST",
      },
      columns: [ //Tell DataTables where to get the data for each cell in that row
        { data: "username" },
        { data: "email" },
        { data: null, defaultContent: "<button>Ban</button>" }
      ]
    });

    $('#tblMemberList tbody').on('click', 'button', function () {
      var data = table.row($(this).parents('tr')).data(); //Get selected row from data table
      $("#modalReasonConfirmation").find('.modal-body #lblReason').text('Reason for banning ' + data["username"] + ":");
      $("#modalReasonConfirmation").find('.modal-body #lblActiveUsername').text(data["username"]); //Hidden label; For ajax use when btnBanMember onclick
      $("#modalReasonConfirmation").modal("show");
    });

    $('#btnBanMember').on('click', function(e) { //Confirm to ban a member
      var username = $("#modalConfirmation").find('.modal-body #lblUsername').text(); //Obtain username from hidden label
      var userID = <?php echo $_SESSION['userID'] ?>;
      var tab = $('.nav-tabs .active').text(); //Get currently selected tab

      $.ajax({
        url :"serverProcessing.php",
        type: "POST",
        data: "action=banMember&username=" + username + "&banBy=" + userID + "&tab=" + tab,
        success: function(data) {
          $("#modalConfirmation").modal("hide");
          alert(username + " has been banned!");
          tblBlacklistMembers.ajax.reload(); //Reload data table
        }
      });
    });
    //End active member list

    //Blacklisted member list
    var tblBlacklistMembers = $('#tblBlacklistMembers').DataTable({ //Data table to display blacklisted member list
      ajax: {
        url :"serverProcessing.php", //JSON datasource
        dataSrc: '', //Tell DataTables where the data array is in the JSON structure, left empty if it's an array
        data: { action : "loadBlacklistedMembers" },
        type: "POST",
      },
      columns: [ //Tell DataTables where to get the data for each cell in that row
        { data: "username" },
        { data: "email" },
        { data: "blacklistReason" },
        { data: null, defaultContent: "<button>Ban</button>" }
      ]
    });

    $('#tblBlacklistMembers tbody').on('click', 'button', function () {
      var data = tblBlacklistMembers.row($(this).parents('tr')).data(); //Get selected row from data table
      $("#modalConfirmation").find('.modal-body #lblConfirmation').text('Are you sure you want to ban ' + data["username"] + '?');
      $("#modalConfirmation").find('.modal-body #lblUsername').text(data["username"]); //Hidden label; For ajax use when btnBanMember onclick
      $("#modalConfirmation").modal("show");
    });

    $('#btnBanActiveMember').on('click', function(e) { //Confirm to ban a member
      var reason = $("#modalReasonConfirmation").find('.modal-body #txtReason').val();
      var username = $("#modalReasonConfirmation").find('.modal-body #lblActiveUsername').text(); //Obtain username from hidden label
      var userID = <?php echo $_SESSION['userID'] ?>;
      var tab = $('.nav-tabs .active').text(); //Get currently selected tab

      $.ajax({
        url :"serverProcessing.php",
        type: "POST",
        data: "action=banMember&username=" + username + "&banBy=" + userID + "&reason=" + reason + "&tab=" + tab,
        success: function(data) {
          $("#modalReasonConfirmation").modal("hide");
          alert(username + " has been banned!");
          table.ajax.reload(); //Reload data table
        }
      });
    });
    //End blacklisted member list

    //Banned member list
    var tblBannedMembers = $('#tblBannedMembers').DataTable({ //Data table to display member list
      ajax: {
        url :"serverProcessing.php", //JSON datasource
        dataSrc: '', //Tell DataTables where the data array is in the JSON structure, left empty if it's an array
        data: { action : "loadBannedMembers" },
        type: "POST",
      },
      columns: [ //Tell DataTables where to get the data for each cell in that row
        { data: "username" },
        { data: "email" },
        { data: "banReason" }
      ]
    });
    //End banned member list

    //Admin list
    var tblAdminList = $('#tblAdminList').DataTable({ //Data table to display member list
      ajax: {
        url :"serverProcessing.php", //JSON datasource
        dataSrc: '', //Tell DataTables where the data array is in the JSON structure, left empty if it's an array
        data: { action : "loadAdmin" },
        type: "POST",
      },
      columns: [ //Tell DataTables where to get the data for each cell in that row
        { data: "fullName" },
        { data: "email" },
        { data: "userStatus" },
        {
          mRender: function ( data, type, row ) {
            if (row.userStatus == "active") {
              return '<button id="btnEditAdmin">Edit</button>';
            }
            else {
              return '';
            }
          }
        },
        {
          mRender: function ( data, type, row ) {
            if (row.userStatus == "active") {
              return '<button id="btnDeleteAdmin">Delete</button>';
            }
            else {
              return '';
            }
          }
        }
      ]
    });

    $('#tblAdminList tbody').on('click', '#btnEditAdmin', function () {
      alert("test");
      //TODO
      //Check whether email in use, if yes -> don't allow<
      //If no, update member's email & expiry date + send email to new email address

      //Click link in email -> check if admin come from new email address
      //If yes & date havent pass -> ask admin complete registration
      //If yes & date expired -> resend email

      //If no -> redirect error page







      // var data = tblBlacklistMembers.row($(this).parents('tr')).data(); //Get selected row from data table
      // $("#modalConfirmation").find('.modal-body #lblConfirmation').text('Are you sure you want to ban ' + data["username"] + '?');
      // $("#modalConfirmation").find('.modal-body #lblUsername').text(data["username"]); //Hidden label; For ajax use when btnBanMember onclick
      // $("#modalConfirmation").modal("show");
    });
    //End admin list

    $('.modal').on('hidden.bs.modal', function(e) { //Reset field values when popup modal is closed
      $(".modal-body input").val("");
    });
  });
</script>

<div class="well">
  <!-- Tab options -->
  <ul class="nav nav-tabs" id="tabDetails">
    <li class="active"><a href="#tabMemberList" data-toggle="tab">Active Members</a></li>
    <li><a href="#tabBlacklistMembers" data-toggle="tab">Blacklisted Members</a></li>
    <li><a href="#tabBannedMembers" data-toggle="tab">Banned Members</a></li>
    <?php
    if ($_SESSION['userType'] == "mainAdmin") {
      echo '<li><a href="#tabAdminList" data-toggle="tab">Admin</a></li>';
    }
    ?>
  </ul>
  <!-- End tab options -->

  <div id="myTabContent" class="tab-content">
    <!-- Member list tab -->
    <div class="tab-pane active in" id="tabMemberList">
      <table id="tblMemberList" class="display" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Username</th>
            <th>Email Address</th>
            <th>Ban</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- End member list tab -->

    <!-- Blacklisted member list tab -->
    <div class="tab-pane" id="tabBlacklistMembers">
      <table id="tblBlacklistMembers" class="display" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Username</th>
            <th>Email Address</th>
            <th>Blacklist Reason</th>
            <th>Ban</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- End blacklisted member list tab -->

    <!-- Banned member list tab -->
    <div class="tab-pane" id="tabBannedMembers">
      <table id="tblBannedMembers" class="display" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Username</th>
            <th>Email Address</th>
            <th>Ban Reason</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- End blacklisted member list tab -->

    <!-- Admin list tab -->
    <div class="tab-pane fade" id="tabAdminList">
      <p>
        <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseTabAdminList" aria-expanded="false" aria-controls="collapseExample">
          + New Admin
        </button>
      </p>

      <div class="collapse" id="collapseTabAdminList">
        <div class="card card-body">
          <form id="tab2" data-parsley-validate method="post">
            <div class="form-group">
              <label for="txtFullName">Full Name *</label>
              <input type="text" class="form-control" id='txtFullName' name='txtFullName' value="<?php if (isset($_POST['txtFullName'])) echo $_POST['txtFullName']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>
            </div>

            <div class="form-group">
              <label for="txtEmail">Email Address *</label>
              <input type="text" class="form-control" id='txtEmail' name='txtEmail' placeholder="name@email.com" value="<?php if (isset($_POST['txtEmail'])) echo $_POST['txtEmail']; ?>" data-parsley-required="true" data-parsley-type="email" data-parsley-errors-messages-disabled/>
            </div>

            <div>
              <button class="btn" type="button" data-toggle="collapse" data-target="#collapseTabAdminList" aria-expanded="false" aria-controls="collapseExample">
                Cancel
              </button>

              <input type='submit' value='Add' class="btn btn-primary" id="btnAddAdmin" name='btnAddAdmin'/>
            </div>
          </form>
        </div>
      </div>

      <table id="tblAdminList" class="display" cellspacing="0" width="100%">
        <thead>
          <tr>
            <th>Full Name</th>
            <th>Email Address</th>
            <th>Status</th>
            <th>Edit</th>
            <th>Delete</th>
          </tr>
        </thead>
      </table>
    </div>
    <!-- <div class="form-group">
    <label for="txtFullName">Full Name *</label>
    <input type="text" class="form-control" id='txtFullName' name='txtFullName' value="<?php if (isset($_POST['txtFullName'])) echo $_POST['txtFullName']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>
  </div>

  <div class="form-group">
  <label for="txtEmail">Email Address *</label>
  <input type="text" class="form-control" id='txtEmail' name='txtEmail' placeholder="name@email.com" value="<?php if (isset($_POST['txtEmail'])) echo $_POST['txtEmail']; ?>" data-parsley-required="true" data-parsley-type="email" data-parsley-errors-messages-disabled/>
</div>

<div>
<input type='submit' value='Add' class="btn btn-primary" id="btnAddAdmin" name='btnAddAdmin'/>
</div> -->
<!-- End admin list tab -->
</div>
</div>

<!-- Popup modal to request confirmation -->
<div class="modal fade" id="modalConfirmation" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ban Member</h4>
      </div>

      <div class="modal-body">
        <!-- <div class="form-group"> -->
        <label id='lblConfirmation'></label>
        <label id='lblUsername' hidden></label>
        <!-- </div> -->
      </div>

      <div class="modal-footer">
        <input type="submit" class="btn" id="btnCancelBan" data-dismiss="modal" name="btnCancelBan" value="Cancel" />
        <input type="submit" class="btn btn-primary" id="btnBanMember" name="btnBanMember" value="Confirm" />
      </div>
    </div>
    <!-- End popup modal content -->
  </div>
</div>
<!-- End popup modal -->

<!-- Popup modal to request reason to ban a member -->
<div class="modal fade" id="modalReasonConfirmation" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ban Member</h4>
      </div>

      <div class="modal-body">
        <!-- <div class="form-group"> -->
        <label id='lblReason'></label>
        <!-- TODO: Add parsley js validation -->
        <input type="text" class="form-control" id='txtReason' name='txtReason' value="<?php if (isset($_POST['txtReason'])) echo $_POST['txtReason']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>
        <label id='lblActiveUsername' hidden></label>
        <!-- </div> -->
      </div>

      <div class="modal-footer">
        <input type="submit" class="btn" id="btnCancelBanActive" data-dismiss="modal" name="btnCancelBanActive" value="Cancel" />
        <input type="submit" class="btn btn-primary" id="btnBanActiveMember" name="btnBanActiveMember" value="Confirm" />
      </div>
    </div>
    <!-- End popup modal content -->
  </div>
</div>
<!-- End popup modal -->

<?php
}
else { //Redirect user to home page
  echo "<script>alert('You are not allowed here!')</script>";
  header("Refresh:1;url=index.php"); //TODO: change url
}
?>

<script src="../scripts/parsley.min.js"></script>
<link rel="stylesheet" href="../css/parsley.css" type="text/css" />

<?php
if (isset($_POST['btnAddAdmin'])) { //Clicked on add button
  //Obtain user input
  $fullName = filter_has_var(INPUT_POST, 'txtFullName') ? $_POST['txtFullName']: null;
  $email = filter_has_var(INPUT_POST, 'txtEmail') ? $_POST['txtEmail']: null;
  $userType = "admin";
  $userStatus = "pending";
  $memberConfirmationExpiryDate = time(); //Get current date
  $memberConfirmationExpiryDate = date('Y-m-d H:i:s', strtotime('+1 day', $memberConfirmationExpiryDate)); //Calculate url expiration date

  //Trim white space
  $fullName = trim($fullName);
  $email = trim($email);

  //Sanitize user input
  $fullName = filter_var($fullName, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
  $email = filter_var($email, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);

  try { //Check if there is an account associated with that email
    $emailSQL = "SELECT userID FROM user WHERE emailAddr = ?";
    $stmt = mysqli_prepare($conn, $emailSQL) or die( mysqli_error($conn));
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);
    $count = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);

    if ($count > 0) { //Email in use; Unable to add admin
      echo "<script>alert('An account has already been registered under this email address!')</script>";
    }
    else { //Email available to use; Add new addmin
      try {
        $signupSQL = "INSERT INTO user (fullName, emailAddr, userType, userStatus, memberConfirmationExpiryDate)
        VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $signupSQL) or die( mysqli_error($conn));
        mysqli_stmt_bind_param($stmt, "sssss", $fullName, $email, $userType, $userStatus, $memberConfirmationExpiryDate);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) { //Send email to new admin
          $emailEncoded = urlencode(base64_encode($email));
          $fullNameEncoded = urlencode(base64_encode($fullName));
          $memberConfirmationExpiryDateEncoded = urlencode(base64_encode($memberConfirmationExpiryDate));
          $url = $environment . "/CM0656-Assignment/administration/Member_signup.php?mail=" . $emailEncoded . "&name=" . $fullNameEncoded
          . "&exDate=" . $memberConfirmationExpiryDateEncoded;
          if (sendEmail($email, $fullName, 'Please Complete Your Registration', '../email/notifier_completeRegistration.html', $url)) { //Email sent
            echo "<script>alert('New admin added!')</script>";
          }
          else { //Email failed to send
            echo "<script>alert('Failed to send email!')</script>";
          }
        }
        else { //SQL statement failed; Failed to add admin
          echo "<script>alert('Failed to add admin!')</script>";
        }
      }
      catch (Exception $e) {
        echo "<script>alert('Registration failed!')</script>";
        //echo $e->getErrorsMessages();
      }
    }
  }
  catch (Exception $e) {
    echo "<script>alert('Unable to add new admin!')</script>";
    //echo $e->getErrorsMessages();
  }
  mysqli_stmt_close($stmt);
  mysqli_close($conn);
}
?>

<?php
echo makeFooter();
echo makePageEnd();
?>
