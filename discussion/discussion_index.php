<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
require_once('../functions.php');
echo makePageStart("Discussion Board");
echo makeNavMenu();
echo makeHeader("Discussion Board");
$environment = LOCAL;
?>

<!-- CSS style -->
<link rel='stylesheet' href='../css/bootstrap.css' />
<link rel="stylesheet" href="../css/jquery-ui.min.css" />
<link rel="stylesheet" href="../css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="../css/stylesheet.css" />

<script src='../scripts/bootstrap.js'></script>
<script src='../scripts/jquery.dataTables.min.js'></script>
<script src="../scripts/jquery.js"></script>

<!-- TODO: Verification - Only Admin Allowed to Login -->
<!--------------------------------------------------------------------------------------------------------------------------
    Verification - Only Admin Can View "Create New Thread" button
--------------------------------------------------------------------------------------------------------------------------->


<!-----------------------------------------------------------------------------
    DISCUSSION BOARD : List Created Discussion Message and Information
------------------------------------------------------------------------------>
<div class="displayDiscussionInfo">
<table id="tblThreadList" class="display" cellspacing="0" width="100%">
  <thead>
    <tr>
      <th>Thread Name</th>
      <th>Thread Description</th>
    </tr>
  </thead>
    <?php
        //display 3 rows when "VIEW MORE" button is clicked
        $row = $_POST['row'];
        $viewmore = 2;

        //total number of posts
        $allcount_query = "SELECT count(*) AS allcount FROM discussion_thread";
        $allcount_result = mysqli_query($conn,$allcount_query);
        $allcount_fetch = mysqli_fetch_array($allcount_result);
        $allcount = $allcount_fetch['allcount'];

        //TODO Change "threadDescription" to "userID"
        // select first 5 posts
        $sqlDiscussion = "SELECT threadName, threadDescription FROM discussion_thread ORDER BY threadName DESC limit 0,$viewmore";

        $stmtDiscussion = mysqli_prepare($conn, $sqlDiscussion) or die( mysqli_error($conn));
        $discussion= mysqli_query($conn,$sqlDiscussion);

        while ($row = mysqli_fetch_array($discussion)) {
            $thread_name         = $row['threadName'];
            $thread_desc         = $row['threadDescription'];

            echo
            "<div class='displayDiscussionInfo'
              <tbody>
                <tr>
                  <td>$thread_name</td>
                  <td>$thread_desc</td>
                </tr>
              </tbody>
            </div>";
        }

          //mysqli_stmt_close($stmtDiscussion);
          mysqli_free_result($discussion);
          mysqli_close($conn);
    ?>

<h3 class="view-more">View More</h3>
    <input type="show" id="row" value="0" />
    <input type="show" id="all" value="<?php echo $allcount; ?>" />
</div>

<script>
$(document).ready(function(){
  $('.view-more').click(function(){
    var row = Number($('#row').val());
    var allcount = Number($('#all').val());
    var viewmore = 2;
    row = row + viewmore;

    if(row <= allcount){
      ("#row").val(row);

      $.ajax({
          url: 'discussion_getData.php',
          data: {row:row},
          type: "POST",

          success:function(response){
console.log("testing");
                // Setting little delay while displaying more discussion threads
                setTimeout(function() {
                    // appending posts after last post with class="post"
                    $(".displayDiscussionInfo:last").after(response).show().fadeIn("slow");

                    var rownum = row + viewmore;

                    // checking row value is greater than allcount or not
                    if(rownum > allcount){

                        // Change the text and background
                        $('.view-more').text("Hide");
                    }else{
                        $(".view-more").text("View More");
                    }
                }, 2000);

          }
      })
    }
    else
    {
        $('.view-more').text("Loading...");

        // Setting little delay while removing contents
        setTimeout(function() {

            // When row is greater than allcount then remove all class='post' element after 3 element
            $('.displayDiscussionInfo:nth-child(2)').nextAll('.displayDiscussionInfo').remove().fadeIn("slow");

            // Reset the value of row
            $("#row").val(0);

            // Change the text and background
            $('.view-more').text("View More");
            $('.view-more').css("background","#15a9ce");

        }, 2000);


    }
  });
});
</script>
</table>

<!-- //TODO: Change to Ajax
//TODO : what should i change this line to??????????
//if((isset($_SESSION['logged-in']) && $_SESSION['logged-in'] == true)) {
?> -->

<!-- <script>
//   $(document).ready(function() {
//     //Created Thread List
//     var table = $('#tblThreadList').DataTable({
//       ajax: {
//         url:"discussion_index_serverProcessing.php",
//         dataSrc: '',
//         data: { action : "loadEverything"},
//         type: "POST",
//       },
//       columns:[
//         { data: "threadName" },
//         { data: "threadDescription" },
//       ]
//     });
//   });
// </script> -->

<?php
//} //for ajax, close
echo makeFooter();
echo makePageEnd();
?>
