<?php 
	include '../db/database_conn.php';
	ini_set("session.save_path", "");
	session_start();
	

?>
<!doctype html>
<html>
<head>
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
<!-- fancyBox -->
<link rel="stylesheet" href="css/jquery.fancybox.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery.fancybox.pack.js?v=2.0.5"></script>

<!-- fancyBox button helpers -->
<link rel="stylesheet" href="css/jquery.fancybox-buttons.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery.fancybox-buttons.js?v=2.0.5"></script>

<!-- fancyBox thumbnail helpers -->
<link rel="stylesheet" href="css/jquery.fancybox-thumbs.css?v=2.0.5" type="text/css" media="screen" />
<script type="text/javascript" src="js/jquery.fancybox-thumbs.js?v=2.0.5"></script>

<script type='text/javascript' src='../jquery-2.2.0.js'></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<script type="text/javascript" src="../jquery-ui.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<meta charset="UTF-8" />

	<!-- FOR FANCY BOS  -->
	<link rel="stylesheet" href="../assests/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="../assests/font-awesome/css/font-awesome.min.css">
	<script src="../assests/jquery/jquery.min.js"></script>
	<link rel="stylesheet" href="../assests/jquery-ui/jquery-ui.min.css">
	<script src="../assests/jquery-ui/jquery-ui.min.js"></script>
	<link rel="stylesheet" href="../assests/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen" />    
    <script type="text/javascript" src="../assests/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>
	
</head>
<body>
<?php 
	$id = $_GET['albumID'];
	$albumtitle = $_GET['albumtitle'];
	$photo = "SELECT * FROM album_photo WHERE albumID=".$id." AND photoStatus = '1' ORDER BY uploadDate";
	
	$rs = mysqli_query($conn,$photo) or die (mysqli_error($conn));
	
	require_once('../controls.php');
	echo makePageStart($albumtitle);
	echo makeWrapper();
	echo makeLoginLogoutBtn();
	echo makeProfileButton();
	echo makeNavMenu();
	echo makeHeader($albumtitle);
?>
<title><?php echo $albumtitle; ?></title>
<div class="content">
	<div class="container">
<?php	
	while ($photos = mysqli_fetch_assoc($rs))
	{
			
				
				echo "\t<div class='photo'>
							<a class ='various fancybox' data-fancybox-type='iframe' href='photoDetails.php?photoID={$photos['photoID']}'>";
							
					$filename = $photos['photoPath'];

					if (file_exists($filename)) {
						echo "<img src='{$photos['photoPath']}' width='100%' height='270px'/>";
					} else {
						echo "<img src='../images/notfound.png' width='100%' height='270px'/>";
					}			
								
								
								
				echo "		</a>
							<div><a class ='various fancybox' href='photoDetails.php?photoID={$photos['photoID']}'>{$photos['photoDescription']}</a>";
							
							
							
							$sqlphoto = "SELECT commentID
									 FROM album_comment WHERE commentStatus = '1' AND photoID = '".$photos['photoID']."'";
							$photors = mysqli_query($conn, $sqlphoto);
							$count = 0;
							while($rowphoto = mysqli_fetch_row($photors)){
								$count += 1;
							};
				echo "\t<span class='photoCount'>$count comments</span>
						</div></div>";
	}
?>



	
		<a class='various outer' data-fancybox-type='iframe' href='createPhotos.php?albumID=<?php echo $id;?>'>Upload Photos</a>
		
		
		
		
		
		
		
		
		
		
		

		  
		  
		  
		  
		  
		  
	</div>
</div>
<?php
	echo makeFooter();
	echo makePageEnd();
?>
</body>
<script>

  
	$(document).ready(function() {
		
    $(".various").fancybox({
            maxWidth    : 1170,
            maxHeight   : 700,
            fitToView   : false,
            width       : '70%',
            height      : '70%',
            autoSize    : false,
            closeClick  : false,
            openEffect  : 'none',
            closeEffect : 'none'
        });
})

</script>
</html>