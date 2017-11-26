<script type='text/javascript' src='../jquery-2.2.0.js'></script>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<script type="text/javascript" src="../jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<meta charset="UTF-8" />
<script src="../scripts/jquery.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
<script src="../scripts/parsley.min.js"></script>
<link rel="stylesheet" href="../css/parsley.css" type="text/css" />
<link rel="stylesheet" href="../css/stylesheet.css" type="text/css" />
<link href="../css/bootstrap.css" rel="stylesheet">
<script src="../scripts/bootstrap.min.js"></script>

<?php	
	include '../db/database_conn.php'; 
	session_start();
	$report = $_GET['reportid'];
	
	$reports = "SELECT * from report WHERE reportID = $report AND reportStatus = 0";
	$rsReport = mysqli_query($conn, $reports);
	while ($reportDetail = mysqli_fetch_assoc($rsReport)) {
		
		
		if($reportDetail['contentType'] == "gallery-comment"){
			
			$content = "SELECT * from album_comment WHERE commentID = {$reportDetail['contentID']}";
			$rscontent = mysqli_query($conn, $content);
			while ($contentDetail = mysqli_fetch_assoc($rscontent)) {
				
				$user = "SELECT * from user WHERE userID = {$reportDetail['userID']}";
				$rsuser = mysqli_query($conn, $user);
				while ($userDetail = mysqli_fetch_assoc($rsuser)) {
				
					$from = "SELECT * from user WHERE userID = {$reportDetail['reportFrom']}";
					$rsfrom = mysqli_query($conn, $from);
					while ($userFrom = mysqli_fetch_assoc($rsfrom)) {
				
							echo "<div id='reportSource'>
									{$contentDetail['commentDescription']}
									<span>Posted by {$userDetail['username']}</span>
							</div>
							<div>
								<span id='judgeReason'>Reason :</span>{$reportDetail['reportReason']}
							</div>
							<div>
								<span>Reported From :</span>{$userFrom['username']}
							</div>
							<form method='post'>
								<input type='hidden' name='reportID' value='{$userDetail['userID']}'/>
								<input type='submit' name='punish' value='Add Penalty'/>
							</form>";
					}
				
				}
				
			}
			
			
		}
		else if($reportDetail['contentType'] == "gallery-photo"){
			$content = "SELECT * from album_photo WHERE photoID = {$reportDetail['contentID']}";
			$rscontent = mysqli_query($conn, $content);
			while ($contentDetail = mysqli_fetch_assoc($rscontent)) {
				
				$user = "SELECT * from user WHERE userID = {$reportDetail['userID']}";
				$rsuser = mysqli_query($conn, $user);
				while ($userDetail = mysqli_fetch_assoc($rsuser)) {
				
					$from = "SELECT * from user WHERE userID = {$reportDetail['reportFrom']}";
					$rsfrom = mysqli_query($conn, $from);
					while ($userFrom = mysqli_fetch_assoc($rsfrom)) {
				
							echo "<div id='reportSource'>
									<img src='{$contentDetail['photoPath']}'width='400px' height='auto'/>
									<span>Posted by {$userDetail['username']}</span>
							</div>
							<div>
								<span id='judgeReason'>Reason :</span>{$reportDetail['reportReason']}
							</div>
							<div>
								<span>Reported From :</span>{$userFrom['username']}
							</div>
							<form method='post'>
								<input type='hidden' name='reportID' value='{$userDetail['userID']}'/>
								<input type='submit' name='punish' value='Add Penalty'/>
							</form>";
					}
				
				}
				
			}
		}
		else{
			$msg = "SELECT * from discussion_message WHERE messageID = {$reportDetail['contentID']}";
			$rsmsg = mysqli_query($conn, $msg);
			while ($msgDetail = mysqli_fetch_assoc($rsmsg)) {
				
				$user = "SELECT * from user WHERE userID = {$msgDetail['userID']}";
				$rsuser = mysqli_query($conn, $user);
				while ($userDetail = mysqli_fetch_assoc($rsuser)) {
				
					$from = "SELECT * from user WHERE userID = {$reportDetail['reportFrom']}";
					$rsfrom = mysqli_query($conn, $from);
					while ($userFrom = mysqli_fetch_assoc($rsfrom)) {
				
							echo "<div id='reportSource'>
									{$msgDetail['messageContent']}
									<span>Posted by {$userDetail['username']}</span>
							</div>
							<div>
								<span id='judgeReason'>Reason :</span>{$reportDetail['reportReason']}
							</div>
							<div>
								<span>Reported From :</span>{$userFrom['username']}
							</div>
							<form method='post'>
								<input type='hidden' name='reportID' value='{$userDetail['userID']}'/>
								<input type='submit' name='punish' value='Add Penalty'/>
							</form>";
					}
				
				}
				
			}
		}
	}
	
	
	if(isset($_POST['punish'])){
		$punish = $_POST['reportID'];
		$SELECTid = "SELECT * from user WHERE userID = $punish";
		$SELECT = mysqli_query($conn, $SELECTid);
		while ($userSelect = mysqli_fetch_assoc($SELECT)) {
			$count = $userSelect['penaltyCount']+1;
			if($count > 2){
				$sql = "UPDATE user SET penaltyCount = $count, userStatus = 'banned' WHERE userID = $punish";
				$conn->query($sql);
			}
			else{
				$sql = "UPDATE user SET penaltyCount = $count WHERE userID = $punish";
				$conn->query($sql);
			}
			
		}
	}
	
	
	
	
	
?>