<script type='text/javascript' src='../assests/jquery-2.2.0.js'></script>
<script type="text/javascript" src="../assests/jquery-ui.js"></script>
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





	
	<!-- FOR FANCY BOS  -->
	<link rel="stylesheet" href="../assests/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="../assests/font-awesome/css/font-awesome.min.css">
	<script src="../assests/jquery/jquery.min.js"></script>
	<link rel="stylesheet" href="../assests/jquery-ui/jquery-ui.min.css">
	<script src="../assests/jquery-ui/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="../assests/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />    
    <script type="text/javascript" src="../assests/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
	
	
	
	
<?php
	include '../db/database_conn.php';
	$photoid = $_GET['photoID'];
	date_default_timezone_set('Asia/Kuala_Lumpur');

	
	$sqlDetail = "SELECT * from album_photo WHERE photoID = ".$photoid;
			$rsDetail = mysqli_query($conn, $sqlDetail);
			while ($Detail = mysqli_fetch_assoc($rsDetail)) {
				
				
				echo "<div style='vertical-align:top'><div class='left'>";
				
				
							$filename = $Detail['photoPath'];

							if (file_exists($filename)) {
								echo "<img src='{$Detail['photoPath']}' width='100%' height='270px'/>";
							} else {
								echo "<img src='../images/notfound.png' width='100%' height='270px'/>";
							}			
						
				
				
			
				echo "
					</div>
					<div class='right'>";
					
				$user = "SELECT username from user WHERE userID = ".$Detail['userID'];
				$rsUser = mysqli_query($conn, $user);
				while ($ususer = mysqli_fetch_assoc($rsUser)) {
					echo  "<p id='postedby'>{$ususer['username']}<span>";
				};
				
				
				
				$time = strtotime($Detail['uploadDate']);


				
				
				echo      humanTiming($time)." ago</span></p>
							<p id='description'>{$Detail['photoDescription']}</p><div id='commentBox'>";
							
							
				$comment = "SELECT * from album_comment WHERE commentStatus = '1' AND photoID = ".$photoid;
				$rsComment = mysqli_query($conn, $comment);
				while ($CoComment = mysqli_fetch_assoc($rsComment)) {
								
								$commentTime = strtotime($CoComment['uploadDate']);
								
								$user1 = "SELECT username from user WHERE userID = ".$CoComment['userID'];
								$rsUser1 = mysqli_query($conn, $user1);
								while ($ususer1 = mysqli_fetch_assoc($rsUser1)) {
									echo  "<div><span id='commentUser'>{$ususer1['username']} :</span>
									<span id='comment'>{$CoComment['commentDescription']}</span>
									
									<a class='various' data-fancybox-type='iframe' href='reportComment.php?commentID={$CoComment['commentID']}&baduser={$CoComment['userID']}' id='report'><i class='fa fa-exclamation-circle'></i>Report</a>
									<span id='time'>".humanTiming($commentTime)." ago</span></div>";
								};
								
								
								
					
					
				};
				echo "<form action='makeComment.php' method='post'>
						<input type='text' placeholder='Enter a comment....' name='comment'/>
						<input type='hidden' name='photoid' value='$photoid'/>
					<form></div></div></div>";		
				
			}
			
	function humanTiming($time)
	{

		$time =  time() -$time; // to get the time since that moment
		$time = ($time<1)? 1 : $time;
		$tokens = array (
			31536000 => 'year',
			2592000 => 'month',
			604800 => 'week',
			86400 => 'day',
			3600 => 'hour',
			60 => 'minute',
			1 => 'second'
		);

		foreach ($tokens as $unit => $text) {
			if ($time < $unit) continue;
			$numberOfUnits = floor($time / $unit);
			return $numberOfUnits.' '.$text.(($numberOfUnits>1)?'s':'');
		}

	}

?>
<script>
	$(".various").fancybox({
		maxWidth	: 800,
		maxHeight	: 300,
		fitToView	: false,
		width		: '70%',
		height		: '70%',
		autoSize	: false,
		closeClick	: false,
		openEffect	: 'none',
		closeEffect	: 'none',
		afterClose: function () { // USE THIS IT IS YOUR ANSWER THE KEY WORD IS "afterClose"
			parent.location.reload(true);
		}
	});
</script>