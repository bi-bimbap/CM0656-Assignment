<?php
//
// if (date('Y-m-d H:i:s') > date('Y-m-d H:i:s', strtotime('2017-11-02 10:20:41'))) {
//   echo "Expired";
// }
// else {
//   echo "Valid";
// }

// include_once 'config.php';
// $environment = LOCAL;
// $url = $environment . "CM0656-Assignment/administration/Member_confirmMembership.php?mail=" . "sjm@gmail.com" . "&exDate=" . "2017-11-01";
// echo $url;

// if (password_verify('test123', '$2y$10$2f0XokfiGo5zVs1KzG9CM.0UDRiTc7X5yqvpPnZ1bW40eGCcJLWUC')) {
//   echo "yes";
// }
// else {
//   echo "no";
//}

// $password = password_hash('test123', PASSWORD_DEFAULT);
// echo $password;
?>

<?php
if (password_verify("test123", '$2y$10$284.T.6VrSY.PoP392RMuOjT5q4G.LPWjKoO10gfY1Sx2apipX/Ze')) { //Check if password matches email
echo "yes";
}
else {
  echo "no";
}
?>

<?php
// http://localhost/CM0656-Assignment/administration/Member_signup.php?mail=c2VhaGptOTZAaG90bWFpbC5jb20%3D&name=Q2hlb25nIFlpIFFp&exDate=2017-11-12+08%3A22%3A50
// $email = urldecode(base64_decode('c2VhaGptOTZAaG90bWFpbC5jb20%3D'));
// $fullName = urldecode(base64_decode('Q2hlb25nIFlpIFFp'));
// $expiryDate = urldecode('2017-11-12+08%3A22%3A50');
// $expiryDate = trim($expiryDate);
// $expiryDate = filter_var($expiryDate, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
// $expiryDate = date('Y-m-d H:i:s', strtotime("$expiryDate")); //Convert string to date time
// echo $email . " " . $fullName . " " . $expiryDate;
//
// if (date('Y-m-d H:i:s') > $expiryDate) { //Link expired; Resend email to new admin
//   echo "YES";
// }
// else {
//   echo "no";
// }
// // $test = urlencode(base64_encode("seeee@gmail.com"));
// // echo $test;
// $test = urlencode("2017-11-10 00:00:00");
// echo $test;
// //2017-11-10+00%3A00%3A00
//
// $currMonthValue = date('m', strtotime(date('Y-m-d H:i:s'))) - 1;
// $months = array(1 => "Jan", 2 => "Feb", 3 => "Mar", 4 => "Apr", 5 => "May", 6 => "Jun", 7 => "Jul",
// 8 => "Aug", 9 => "Sep", 10 => "Oct", 11 => "Nov", 12 => "Dec");
// $currMonthName = $months[$currMonthValue];
// echo $currMonthValue . " " . $currMonthName;

// $memberConfirmationExpiryDate = time(); //Get current date
// $memberConfirmationExpiryDate = date('Y-m-d H:i:s', strtotime('+1 day', $memberConfirmationExpiryDate)); //Calculate url expiration date
// $memberConfirmationExpiryDateEncoded = urlencode($memberConfirmationExpiryDate);
// echo $memberConfirmationExpiryDate;
// echo "<br />";
//
// $expiryDate = urldecode($memberConfirmationExpiryDateEncoded);
// // $expiryDate = trim($expiryDate);
// // $expiryDate = filter_var($expiryDate, FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
// echo $expiryDate;
?>

<html>
<head>
  <script src="scripts/jquery.js"></script>

<script>
$(document).ready(function() {
  $('#test').on('click', function(e) { //Confirm to ban a member
    $("#txtReason").focus();
  });
});
</script>
</head>

<body>
<form method='post'>
<input type='submit' value='test' name='test' id='test'/>

<!-- Popup modal to request reason to ban a member -->
<div class="modal fade" id="modalReasonConfirmation" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Ban Member</h4>
      </div>

      <div class="modal-body">
        <!-- <div class="form-group"> -->
        <label id='lblReason'></label>
        <!-- TODO: Add parsley js validation -->
        <input type="text" class="form-control" id='txtReason' name='txtReason' value="<?php if (isset($_POST['txtReason'])) echo $_POST['txtReason']; ?>" data-parsley-required="true" data-parsley-errors-messages-disabled/>
        <label id='lblActiveUsername' hidden></label>
        <!-- </div> -->
      </div>

      <div class="modal-footer">
        <input type="submit" class="btn" id="btnCancelBanActive" data-dismiss="modal" name="btnCancelBanActive" value="Cancel" />
        <input type="submit" class="btn btn-primary" id="btnBanActiveMember" name="btnBanActiveMember" value="Confirm" />
      </div>
    </div>
    <!-- End popup modal content -->
  </div>
</div>
<!-- End popup modal -->
</form>
</body>
