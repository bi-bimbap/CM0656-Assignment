<?php
  // Set up connection to database
  define ('SERVER', 'localhost');
  define ('USER', 'root');
  define ('PASSWORD','');
  define ('DATABASE', 'ima_megastar');

  $conn = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
<<<<<<< HEAD
  	echo "<p>Connection failed:".mysqli_connect_error()."</p>\n"; //Test
=======
  	echo "<p>Connection failed:".mysqli_connect_error()."</p>\n";
>>>>>>> 4d9cace372f0eb8df47d74d43b8b0b33ed1ba5d2
  }
?>

<?php
	//Set up connection to database
//   define ('SERVER', 'localhost');
//   define ('USER', 'SE209');
//   define ('PASSWORD','902ES');
//   define ('DATABASE', 'SE209');
//
//   $conn = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
//   if (mysqli_connect_errno()) {
//   echo "<p>Connection failed:".mysqli_connect_error()."</p>\n";
// }
?>
