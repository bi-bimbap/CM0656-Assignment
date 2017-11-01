<?php
require_once('controls.php');
//echo password_hash("testingpassword", PASSWORD_DEFAULT);
echo makePageStart("Page Title");
echo makeHeader("Page Header");
echo makeLoginLogoutBtn();
echo makeFooter();
echo makePageEnd();
?>

<script language="JavaScript" type="text/javascript">
$(document).ready(function() {
  $("#txtDOB").datepicker({
    dateFormat: 'dd M yy', //'dd-M-y' = 01-Sep-17, 'dd M yy' = 12 Sep 2017
    showWeek: true,
    //minDate: '-1d'/'1m'/'1y'
    minDate: '-95y', //Constrain minimum date to today onwards
    maxDate: '-10y', //Constrain maximum date to one month ahead
    showButtonPanel: true, //Shows button to jump back to current date
    showAnim: 'show' //'shake', 'show', 'explode'
  });
});
</script>

<script src="scripts/jquery.js"></script>
<script src='scripts/jquery-ui.min.js'></script>



<p>Date of Birth: <input id='txtDOB' size='8' maxlength="11"/></p>
<!-- <script src='ui.js'></script> -->
