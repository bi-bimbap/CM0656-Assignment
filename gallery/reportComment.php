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
	$comment = $_GET['commentID'];
	$baduser = $_GET['baduser'];
	
	$reporter = $_SESSION['userID'];
	$gallery = 'gallery-comment';
	
	$sql = "SELECT c.commentDescription, u.username from album_comment c INNER JOIN user u ON c.userID = u.userID WHERE commentID = ".$comment;
	$rs = mysqli_query($conn, $sql);
	while ($assoc = mysqli_fetch_assoc($rs)) {
		echo "<p id='reported'><span id='reportedUser'>{$assoc['username']} :</span>".$assoc['commentDescription']."</p>
		<form method='post' style='text-align:center'><input type='text' placeholder ='Description of the inappropriate content...' style='    display: block;
    margin: 50px auto 20px;' name='reason' id='reason'/>
		<input type='submit' id='button' name='report' value='REPORT'/></form>";
	}
	
	if(isset($_POST['report'])){
		$reason = $_POST['reason'];
		$sql =" INSERT INTO `report`(`contentID`, `contentType`, `userID`, `reportReason`, `reportFrom`) 
							VALUES (?, ?, ?, ?, ?)";
		$stmt = mysqli_prepare($conn, $sql); 
		mysqli_stmt_bind_param($stmt, 'isisi', $comment, $gallery, $baduser, $reason, $reporter);
		mysqli_stmt_execute($stmt);
		echo"<script>alert('Report submitted')</script>";
	}
	
	
	
	
?>