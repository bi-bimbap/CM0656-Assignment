<?php
	include '../db/database_conn.php';
		session_start();
	$photoid = $_POST['photoid'];
	$comment = $_POST['comment'];
	$comment = filter_var($comment, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
	$comment = filter_var($comment, FILTER_SANITIZE_SPECIAL_CHARS);
	
	$status = 1;
	$user = $_SESSION['userID'];
	
	$sql =" INSERT INTO `album_comment`(`photoID`, `commentStatus`, `commentDescription`, `userID`) 
						VALUES (  ?, ?, ?, ?)";
	$stmt = mysqli_prepare($conn, $sql); 
	mysqli_stmt_bind_param($stmt, 'iisi', $photoid, $status, $comment, $user);
	mysqli_stmt_execute($stmt);
	
	
?>
<script>
	
	window.location.href='photoDetails.php?photoID=<?=$photoid?>';
</script>