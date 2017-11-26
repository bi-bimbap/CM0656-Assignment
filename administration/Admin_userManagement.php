<?php
// ini_set("session.save_path", ""); //TODO: comment out
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("User Management");
echo makeWrapper("../");
echo "<form method='post'>" . makeLoginLogoutBtn("../") . "</form>";
echo makeProfileButton("../");
echo makeNavMenu("../");
echo makeHeader("User Management");
$environment = WEB; //TODO: change to server
?>

<link href="../css/jquery.dataTables.min.css" rel="stylesheet">
<link href="../css/bootstrap.css" rel="stylesheet">
<script src="../scripts/jquery.js"></script>
<script src="../scripts/bootstrap.min.js"></script>
<script src="../scripts/jquery.dataTables.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
<link rel="stylesheet" href="../css/stylesheet.css" type="text/css" />

<div class="content">
	<div class="container">
		<?php //Only show content to admin/main admin
		if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true) &&
		(isset($_SESSION['userType']) && ($_SESSION['userType'] == "admin" || $_SESSION['userType'] == "mainAdmin"))) {
			if (checkUserStatus($conn, $_SESSION['userID']) == "active") { //Only allow if user status is active
				?>

				<script>
				$(document).ready(function() {
					//Active member list
					var table = $('#tblMemberList').DataTable({ //Data table to display member list
						ajax: {
							url :"userManagement_serverProcessing.php", //JSON datasource
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

					$('#btnBanActiveMember').on('click', function(e) { //Confirm to ban a member
						$('#formReasonConfirmation').parsley().validate();

						if ($('#formReasonConfirmation').parsley().isValid()) {
							var reason = $("#modalReasonConfirmation").find('.modal-body #txtReason').val();
							var username = $("#modalReasonConfirmation").find('.modal-body #lblActiveUsername').text(); //Obtain username from hidden label
							var userID = <?php echo $_SESSION['userID'] ?>;
							var tab = $('.nav-tabs .active').text(); //Get currently selected tab

							$.ajax({
								url :"userManagement_serverProcessing.php",
								type: "POST",
								data: "action=banMember&username=" + username + "&banBy=" + userID + "&reason=" + reason + "&tab=" + tab,
								success: function(data) {
									$("#modalReasonConfirmation").modal("hide");
									alert(username + " has been banned!");
									table.ajax.reload(); //Reload data table
									tblBannedMembers.ajax.reload();
								}
							});
						}
					});
					//End active member list

					//Blacklisted member list
					var tblBlacklistMembers = $('#tblBlacklistMembers').DataTable({ //Data table to display blacklisted member list
						ajax: {
							url :"userManagement_serverProcessing.php", //JSON datasource
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

					$('#btnBanMember').on('click', function(e) { //Confirm to ban a member
						var username = $("#modalConfirmation").find('.modal-body #lblUsername').text(); //Obtain username from hidden label
						var userID = <?php echo $_SESSION['userID'] ?>;
						var tab = $('.nav-tabs .active').text(); //Get currently selected tab

						$.ajax({
							url :"userManagement_serverProcessing.php",
							type: "POST",
							data: "action=banMember&username=" + username + "&banBy=" + userID + "&tab=" + tab,
							success: function(data) {
								$("#modalConfirmation").modal("hide");
								alert(username + " has been banned!");
								tblBlacklistMembers.ajax.reload();
								tblBannedMembers.ajax.reload(); //Reload data table
							}
						});
					});
					//End blacklisted member list

					//Banned member list
					var tblBannedMembers = $('#tblBannedMembers').DataTable({ //Data table to display member list
						ajax: {
							url :"userManagement_serverProcessing.php", //JSON datasource
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
							url :"userManagement_serverProcessing.php", //JSON datasource
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
									if (row.userStatus == "pending") {
										return '<button id="btnEditAdmin">Edit</button>';
									}
									else {
										return '';
									}
								}
							},
							{
								mRender: function ( data, type, row ) {
									if (row.userStatus != "banned") {
										return '<button id="btnDeleteAdmin">Delete</button>';
									}
									else {
										return '';
									}
								}
							},
						],
						columnDefs: [
							{
								targets: [ 0 ],
								visible: true,
								searchable: false
							}
						]
					});

					$('#btnAddAdmin').on('click', function(e) { //Add new admin
						$("#tab2").parsley().validate(); //Trigger parsley js validation

						var fullName = $("#txtFullName").val(); //Obtain fullName
						var email = $("#txtEmailAddr").val(); //Obtain email

						$.ajax({
							url :"userManagement_serverProcessing.php",
							type: "POST",
							data: "action=addAdmin&fullName=" + fullName + "&email=" + email,
							success: function(data) {
								var dataString = data;
								var firstChar  = dataString.charAt(0);
								var message    = dataString.slice(1);

								if (firstChar == "1") { //Email in use; Unable to add admin
									alert(message);
								}
								else if (firstChar == "2") { //Admin successfully added
									alert(message);
									$('#collapseTabAdminList').collapse("hide");
								}
								else if (firstChar == "3") { //Failed to send email
									alert(message);
								}
								else if (firstChar == "4") { //Failed to add new admin
									alert(message);
								}
								else if (firstChar == "5") { //Unable to add new admin
									alert(message);
								}
								tblAdminList.ajax.reload(); //Reload data table
							}
						});
					});

					$('#tblAdminList tbody').on('click', '#btnEditAdmin', function () { //Change email for admin with status = pending
						var data = tblAdminList.row($(this).parents('tr')).data(); //Get selected row from data table
						$("#modalRequestEmail").find('.modal-body #lblEmail').text('Enter new email for ' + data["fullName"] + ':');
						$("#modalRequestEmail").find('.modal-body #lblUserID').text(data["userID"]); //Hidden label; For ajax use when btnUpdateEmail onclick
						$("#modalRequestEmail").find('.modal-body #lblFullName').text(data["fullName"]); //Hidden label; For ajax use when btnUpdateEmail onclick
						$("#modalRequestEmail").modal("show");
					});

					$('#btnUpdateEmail').on('click', function(e) { //Update email for admin
						if ($('#formRequestEmail').parsley().isValid()) {

							var email = $("#modalRequestEmail").find('.modal-body #txtEmail').val();
							var userID = $("#modalRequestEmail").find('.modal-body #lblUserID').text(); //Obtain userID from hidden label
							var fullName = $("#modalRequestEmail").find('.modal-body #lblFullName').text(); //Obtain fullName from hidden label

							$.ajax({
								url :"userManagement_serverProcessing.php",
								type: "POST",
								data: "action=updateAdminEmail&userID=" + userID + "&email=" + email + "&fullName=" + fullName,
								success: function(data) {
									var dataString = data;
									var firstChar  = dataString.charAt(0);
									var message    = dataString.slice(1);

									if (firstChar == "1") { //Successfully updated email & send email
										$("#modalRequestEmail").modal("hide");
										alert(message);
										tblAdminList.ajax.reload(); //Reload data table
									}
									else if (firstChar == "2") { //Email failed to send
										alert(message);
									}
									else if (firstChar == "3") { //Failed to update email address
										alert(message);
									}
									else if (firstChar == "4") { //Email in use
										alert(message);
									}
								}
							});
						}
					});

					$('#tblAdminList tbody').on('click', '#btnDeleteAdmin', function () { //Delete admin
						var data = tblAdminList.row($(this).parents('tr')).data(); //Get selected row from data table
						$("#modalDeleteAdmin").find('.modal-body #lblContent').text('Revoke administrative permission for ' + data["fullName"] + '?');
						$("#modalDeleteAdmin").find('.modal-body #lblAdminUserID').text(data["userID"]); //Hidden label; For ajax use when btnUpdateEmail onclick
						$("#modalDeleteAdmin").modal("show");
					});

					$('#btnConfirmDeleteAdmin').on('click', function(e) { //Delete admin
						var userID = $("#modalDeleteAdmin").find('.modal-body #lblAdminUserID').text(); //Obtain userID from hidden label

						$.ajax({
							url :"userManagement_serverProcessing.php",
							type: "POST",
							data: "action=deleteAdmin&userID=" + userID,
							success: function(data) {
								var dataString = data;
								var firstChar  = dataString.charAt(0);
								var message    = dataString.slice(1);

								if (firstChar == "1") { //Successfully removed admin
									alert(message);
									tblAdminList.ajax.reload(); //Reload data table
								}
								else if (firstChar == "2") { //Failed to remove admin
									alert(message);
								}
								$("#modalDeleteAdmin").modal("hide");
							}
						});
					});
					//End admin list

					$('.modal').on('hidden.bs.modal', function(e) { //Reset field values when popup modal is closed
						$(".modal-body input").val("");
					});

					$('#collapseTabAdminList').on('hidden.bs.collapse', function () { //Reset field values when collapsed
						$("#txtFullName").val("");
						$("#txtEmail").val("");
					});

					//Report Contents
					var tblReportedContents = $('#tblReportedContents').DataTable({ //Data table to display member list
						ajax: {
							url :"userManagement_serverProcessing.php", //JSON datasource
							dataSrc: '', //Tell DataTables where the data array is in the JSON structure, left empty if it's an array
							data: { action : "loadReportedContents" },
							type: "POST",
						},
						columns: [ //Tell DataTables where to get the data for each cell in that row
							{ data: "ReportID" },
							{ data: "ContentType" },
							{ data: "ReportedUser" },
							{ data: "ReportedBy" }
						]
					});
					//End Report Contents
				});
				</script>

				<div class="well">
					<!-- Tab options -->
					<ul class="nav nav-tabs" id="tabDetails">
						<li class="active"><a href="#tabMemberList" data-toggle="tab">Active Members</a></li>
						<li><a href="#tabBlacklistMembers" data-toggle="tab">Blacklisted Members</a></li>
						<li><a href="#tabBannedMembers" data-toggle="tab">Banned Members</a></li>
						<li><a href="#tabReportedContents" data-toggle="tab">Reported Content</a></li>
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

						<div class="tab-pane" id="tabReportedContents">
							<table id="tblReportedContents" class="display" cellspacing="0" width="100%">
								<thead>
									<tr>
										<th>Report ID</th>
										<th>Content Type</th>
										<th>Reported User</th>
										<th>Reported By</th>
									</tr>
								</thead>
							</table>
						</div>

						<!-- Admin list tab -->
						<div class="tab-pane fade" id="tabAdminList">
							<p>
								<button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseTabAdminList" aria-expanded="false" aria-controls="collapseExample">
									+ New Admin
								</button>
							</p>

							<div class="collapse" id="collapseTabAdminList">
								<div class="card card-body">
									<form id="tab2" data-parsley-validate>
										<div class="form-group">
											<label for="txtFullName">Full Name *</label>
											<input type="text" class="form-control" id='txtFullName' name='txtFullName' value="<?php if (isset($_POST['txtFullName'])) echo $_POST['txtFullName']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>
										</div>

										<div class="form-group">
											<label for="txtEmailAddr">Email Address *</label>
											<input type="text" class="form-control" id='txtEmailAddr' name='txtEmailAddr' placeholder="name@email.com" value="<?php if (isset($_POST['txtEmailAddr'])) echo $_POST['txtEmailAddr']; ?>" data-parsley-required="true" data-parsley-type="email" data-parsley-errors-messages-disabled/>
										</div>

										<div>
											<button class="btn" type="button" data-toggle="collapse" data-target="#collapseTabAdminList" aria-expanded="false" aria-controls="collapseExample">
												Cancel
											</button>

											<button class="btn btn-primary" type="button" id="btnAddAdmin" name='btnAddAdmin' aria-expanded="false" aria-controls="collapseExample">
												Add
											</button>
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
					<form id="formReasonConfirmation" data-parsley-validate>
						<div class="modal-dialog">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">Ban Member</h4>
								</div>

								<div class="modal-body">
									<label id='lblReason'></label>
									<input type="text" class="form-control" id='txtReason' name='txtReason' value="<?php if (isset($_POST['txtReason'])) echo $_POST['txtReason']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled autofocus/>
									<label id='lblActiveUsername' hidden></label>
								</div>

								<div class="modal-footer">
									<input type="button" class="btn" id="btnCancelBanActive" data-dismiss="modal" name="btnCancelBanActive" value="Cancel" />
									<input type="button" class="btn btn-primary" id="btnBanActiveMember" name="btnBanActiveMember" value="Confirm" />
								</div>
							</div>
							<!-- End popup modal content -->
						</div>
					</form>
				</div>
				<!-- End popup modal -->

				<!-- Popup modal to request new email for admin -->
				<div class="modal fade" id="modalRequestEmail" role="dialog">
					<form id="formRequestEmail" data-parsley-validate>
						<div class="modal-dialog">
							<!-- Modal content-->
							<div class="modal-content">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal">&times;</button>
									<h4 class="modal-title">New Email</h4>
								</div>

								<div class="modal-body">
									<label id='lblEmail'></label>
									<label id='lblUserID' hidden></label>
									<label id='lblFullName' hidden></label>
									<input type="text" class="form-control" id='txtEmail' name='txtEmail' value="<?php if (isset($_POST['txtEmail'])) echo $_POST['txtEmail']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled autofocus/>
								</div>

								<div class="modal-footer">
									<input type="button" class="btn" id="btnCancelEmail" data-dismiss="modal" name="btnCancelEmail" value="Cancel" />
									<input type="button" class="btn btn-primary" id="btnUpdateEmail" name="btnUpdateEmail" value="Confirm" />
								</div>
							</div>
							<!-- End popup modal content -->
						</div>
					</form>
				</div>
				<!-- End popup modal -->

				<!-- Popup modal to delete admin -->
				<div class="modal fade" id="modalDeleteAdmin" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title">Remove Admin</h4>
							</div>

							<div class="modal-body">
								<label id='lblContent'></label>
								<label id='lblAdminUserID' hidden></label>
							</div>

							<div class="modal-footer">
								<input type="submit" class="btn" id="btnCancelDelete" data-dismiss="modal" name="btnCancelDelete" value="Cancel" />
								<input type="submit" class="btn btn-primary" id="btnConfirmDeleteAdmin" name="btnConfirmDeleteAdmin" value="Confirm" />
							</div>
						</div>
						<!-- End popup modal content -->
					</div>
				</div>
				<!-- End popup modal -->

				<?php
			}
			else { //User has been banned; Redirect to home page
				setCookie(session_name(), "", time() - 1000, "/");
				$_SESSION = array();
				session_destroy();
				echo "<script>alert('You are not allowed here!')</script>";
				header("Refresh:0;url=../index.php");
			}
		}
		else { //Redirect user to home page
			echo "<script>alert('You are not allowed here!')</script>";
			header("Refresh:0;url=../index.php");
		}
		?>
	</div>
</div>
<script src="../scripts/parsley.min.js"></script>
<link rel="stylesheet" href="../css/parsley.css" type="text/css" />

<?php
echo makeFooter("../");
echo makePageEnd();
?>
