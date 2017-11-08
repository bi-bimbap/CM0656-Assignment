<?php
  // Set up connection to database
  define ('SERVER', 'localhost');
  define ('USER', 'root');
  define ('PASSWORD','');
  define ('DATABASE', 'ima_megastar');

  $conn = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
  if (mysqli_connect_errno()) {
  	echo "<p>Connection failed:".mysqli_connect_error()."</p>\n";
  }
?>

<?php
// 	//Set up connection to database
//   define ('SERVER', 'localhost');
//   define ('USER', 'ima-fanbase');
//   define ('PASSWORD','imafanbase123');
//   define ('DATABASE', 'ima-fanbase');
//
//   $conn = mysqli_connect(SERVER, USER, PASSWORD, DATABASE);
//   if (mysqli_connect_errno()) {
//   echo "<p>Connection failed:".mysqli_connect_error()."</p>\n";
// }
?>
