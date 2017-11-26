<!-- Reference: https://stackoverflow.com/questions/2704314/multiple-file-upload-in-php
                https://stackoverflow.com/questions/1175347/how-can-i-select-and-upload-multiple-files-with-html-and-php-using-http-post
 -->

 <?php
 include '../db/database_conn.php';
 ?>

<form method="post" enctype="multipart/form-data">
  <input type="file" name="files[]" multiple> <!-- NOTE: Input name must be defined as an ARRAY -->
  <input type="submit" value="Upload" name='btnUpload'>
</form>

<?php
if (isset($_POST['btnUpload'])) { //Upload button is clicked
  $fileCount = count($_FILES['files']['name']);
  $coverPhotoName = $_FILES['coverPhoto']['name'];
  $coverPhotoLoc = $_FILES['coverPhoto']['tmp_name'];

  //NOTE: Optional validation (Refer staff_addEvent.php [TyneEvents Assignment])
  // //Set allowed file extensions
  // $allowedExtension = array('jpg', 'jpeg', 'png','txt', 'doc', 'docx', 'pdf', 'ppt', 'pptx', 'xls', 'xlsx');
  //
  // //Set allowed MIME type
  // $allowedMime = array('image/jpg', 'image/jpeg', 'image/pjeg', 'image/png', 'image/x-png', 'text/plain',
  // 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
  // 'application/pdf', 'application/vnd.ms-powerpoint',
  // 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/vnd.ms-excel',
  // 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

  if ($fileCount > 0) { //Check if files are selected
    for($i = 0; $i < $fileCount; $i++) {
      $target_file = "../uploads/" . basename($_FILES["files"]["name"][$i]); //Location where files will be uploaded to

      if (move_uploaded_file($_FILES["files"]["tmp_name"][$i], $target_file)) {
        $auctionID = '1'; //TODO: Change
        $fileName = basename($_FILES["files"]["name"][$i]);
        $filePath = "CM0656-Assignment/uploads/" . basename($_FILES["files"]["name"][$i]);
        $fileType = '1'; //TODO: Change

        $uploadSQL = "INSERT INTO file (auctionID, fileName, filePath, fileType) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_prepare($conn, $uploadSQL) or die( mysqli_error($conn));
        mysqli_stmt_bind_param($stmt, "ssss", $auctionID, $fileName, $filePath, $fileType);
        mysqli_stmt_execute($stmt);

        if (mysqli_stmt_affected_rows($stmt) > 0) {
          mysqli_stmt_close($stmt);
          echo "Files successfully uploaded";
        }
        else {
          echo "Failed to execute SQL.";
        }
      }
      else {
        echo "Sorry, there was an error uploading your file.";
      }
    }
  }
  else {
    echo "Please select a file.";
  }
}
?>
