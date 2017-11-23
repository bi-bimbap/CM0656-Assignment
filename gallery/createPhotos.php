<?php 
	include '../db/database_conn.php';
	ini_set("session.save_path", "../../../sessionData");
	session_start();
	$id = $_GET['albumID']
?>
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

		<form id="uploadPhoto" method="post" class="modal-body" enctype="multipart/form-data">
			<h2>Upload Photo</h2>
			<div>
				<p>Photo's Description</p>
				<input  placeholder ="Photo's Description" maxlength="256" style="background:#f3f3f3;border-color:#c2c2c2;width:400px;display:block;" name="title" type="text" name="title" value="" />
				<input type="hidden" value="<?php echo $id; ?>" name="albumID"/>
				
				<label for="files" class="filebtn">Select Image</label>
				<input id="files" type="file" style="visibility:hidden;position: absolute;" name="photo" onchange="previewFile()"/>
				<img id="preview" src="" height="200" alt="Image preview..."/>
			</div>
			<div style="position: absolute;text-align: center;display: block;width: 985.2px; bottom: 0;">
				<input type="submit"  id='button' name="btn-upload" onclick="close()" value="Create Album"/>
			</div>
		</form>
<?php
if(isset($_POST['btn-upload']))
{ 			
			$user = '1';
			$photoDescription	    = $_POST['title'];
			$photoDescription = filter_var($photoDescription, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
			$photoDescription = filter_var($photoDescription, FILTER_SANITIZE_SPECIAL_CHARS);


			$photoname = $_FILES['photo']['name'];
		    $photo_loc = $_FILES['photo']['tmp_name'];
			$photo_type = $_FILES['photo']['type'];
			$folder="../images/";
			
			$albumid = $_POST['albumID'];
			$abc = $_SESSION['userID'];
			
			echo $abc;
			
			$new_photo_name = strtolower($photoname);

			$final_photo=str_replace(' ','-',$new_photo_name);

			$status = 1;
			
			
			if(move_uploaded_file($photo_loc,$folder.$final_photo))
			{
				$sql =" INSERT INTO `album_photo`(`photoPath`, `photoStatus`, `photoDescription`, `albumID`, `userID`) 
						VALUES ( CONCAT('../images/',?), ?, ?, ?, ?)";
				$stmt = mysqli_prepare($conn, $sql); 
				mysqli_stmt_bind_param($stmt, 'sisii', $final_photo, $status, $photoDescription, $albumid, $user);
				mysqli_stmt_execute($stmt);
				?>

				<script>
				alert("Uploaded Successfully");
		        </script>
				<?php
			}
			else
			{
				?>
				<script>
				alert("Upload Failed");
		      //  window.location.href='upload_file.php?eventID=<?=$eventID?>&method=upload';
		        </script>
				<?php
			}
}

			/*if(!is_numeric($price)){
				echo "Please key in a proper number in price input<br>";
			}
			
			if(strlen($eventName)>256){
				echo "Please key in a shorter event title<br>";
			}
			if(strlen($desc)>256){
				echo "Please key in a shorter event description<br>";
			}
			if(empty($eventName)){
				echo "Please fill in the event name<br>";
			}
			if(empty($desc)){
				echo "Please fill in the event description<br>";
			}
			if($startDate > $endDate){
				echo "Start date must be hapenning before end date<br>";
			}
			if(empty($startDate)){
				echo "Start date cannot be empty<br>";
			}
			if(empty($endDate)){
				echo "End date cannot be empty<br>";
			}

			if(is_numeric($price) && strlen($eventName)<=256 && strlen($desc)<=256 && !empty($eventName) && !empty($desc) && $startDate <= $endDate && !empty($startDate) && !empty($startDate)){
				$sql = "UPDATE te_events SET eventTitle=?, eventDescription=?, venueID=?, catID=?, eventStartDate=?, eventEndDate=?, eventPrice=? WHERE eventID=?";
				
				$stmt = mysqli_prepare($conn, $sql); 
				mysqli_stmt_bind_param($stmt, 'ssssssdi', $eventName, $desc, $venue, $cat, $startDate, $endDate, $price, $eventid);
				mysqli_stmt_execute($stmt);	
				
				
				echo "Update successfully <br><br>";
				echo "Your page will be redirected within 3 seconds";
				header("Refresh:3;url=eventUpdate.php?eventID=$eventid");
				
				mysqli_stmt_close($stmt); 
			}
			else{
				echo "Your page will be redirected within 3 seconds";
				header("Refresh:3;url=eventUpdate.php?eventID=$eventid");
			}
			*/
		
		
	
?>
<script>
   function previewFile(){
	   var preview = document.querySelector('#preview'); 
	   var file    = document.querySelector('input[type=file]').files[0]; 	
	   var reader  = new FileReader();

	   reader.onloadend = function () {
		    preview.style.display='block';
		   preview.src = reader.result;
	   }

	   if (file) {
		   reader.readAsDataURL(file); 
	   } else {
		   preview.src = "";
	   }
  }

  previewFile();  //calls the function named previewFile()
</script>