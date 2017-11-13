<!-- TODO: Add autocomplete search box for auction & competition -->
<?php
ini_set("session.save_path", "");
session_start();
include '../db/database_conn.php';
include_once '../config.php';
require_once('../controls.php');
echo makePageStart("Statistical Reports");
echo makeProfileButton();
echo makeNavMenu();
echo makeHeader("Statistical Reports");
$environment = LOCAL;
?>

<link href="../css/bootstrap.css" rel="stylesheet">
<script src="../scripts/jquery.js"></script>
<script src="../scripts/Chart.min.js"></script>
<script src="../scripts/bootstrap.min.js"></script>

<!-- <div class="chart-container container-fluid" style="position: relative; height:40vh; width:40vw"> -->
<div class="chart-container container-fluid">
  <div class="row">
    <div class="col-lg-6">
      <canvas id="canvasAgeGroup"></canvas>
    </div>

    <div class="col-lg-6">
      <canvas id="canvasRegisteredUsers"></canvas>
    </div>
  </div>

  <div class="row">
    <div class="col-lg-6">
      <label for="ddlAuction">Auction: </label>

      <select id='ddlAuction' name='ddlAuction'>
        <?php
        $ddlOptionSQL = "SELECT auctionID, auctionTitle FROM auction WHERE CURDATE() > endDate ORDER BY endDate DESC";
        $stmt = mysqli_prepare($conn, $ddlOptionSQL) or die( mysqli_error($conn));
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $auctionID, $auctionTitle);
        while (mysqli_stmt_fetch($stmt)) {
          echo "<option value= '" . $auctionID . "'>" . $auctionTitle . "</option>";
        }
        mysqli_stmt_close($stmt);
        ?>
      </select>

      <canvas id="canvasAuction"></canvas>
    </div>

    <div class="col-lg-6">
      <label for="ddlCompetition">Competition: </label>

      <select id='ddlCompetition' name='ddlCompetition'>
        <?php
        $ddlCompetitionSQL = "SELECT testID, testName FROM competition_test WHERE
        CURDATE() > testEndDate ORDER BY testEndDate DESC";
        $stmt = mysqli_prepare($conn, $ddlCompetitionSQL) or die( mysqli_error($conn));
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $testID, $testName);
        while (mysqli_stmt_fetch($stmt)) {
          echo "<option value= '" . $testID . "'>" . $testName . "</option>";
        }
        mysqli_stmt_close($stmt);
        ?>
      </select>

      <canvas id="canvasCompetition"></canvas>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  $.ajaxSetup({
    url: "statisticalReports_serverProcessing.php",
    type: 'POST'
  });

  $.ajax({ //Display no. of users for each age group
    data: "action=ageGroup",
    success: function(data) {
      //Declare arrays to store age group & count returned
      var ageGroup = [];
      var count = [];

      for(var i in data) { //Loop through each row & push into array
        ageGroup.push(data[i].ageGroup);
        count.push(data[i].count);
      }

      var data = {
        labels: ageGroup,
        datasets : [{
          label: 'Age Group',
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          borderWidth: 1,
          hoverBackgroundColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          hoverBorderColor: [
            'rgba(255,99,132,1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
          ],
          data: count
        }]
      };

      var ctx = $("#canvasAgeGroup");

      var pieChart = new Chart(ctx, {
        type: 'doughnut',
        data: data,
        options: {
          title: {
            display: true,
            text: 'Age Group Breakdown of Users'
          }
        }
      });
    },
    error: function(data) {
      console.log(data);
    }
  });

  $.ajax({ //Display no. of registered users for the past 6 months
    data: "action=registeredUsers",
    success: function(data) {
      //Declare arrays to store month & count returned
      var month = [];
      var count = [];

      for(var i in data) { //Loop through each row & push into array
        month.push(data[i].month);
        count.push(data[i].count);
      }

      var data = {
        labels: month,
        datasets : [{
          label: 'User Count',
          backgroundColor: [
            'rgba(255, 99, 132, 0.2)'
          ],
          borderColor: [
            'rgba(255,99,132,1)'
          ],
          borderWidth: 1,
          pointHoverBackgroundColor: [
            'rgba(255,99,132,1)',
            'rgba(255,99,132,1)',
            'rgba(255,99,132,1)',
            'rgba(255,99,132,1)',
            'rgba(255,99,132,1)',
            'rgba(255,99,132,1)'
          ],
          pointHoverBorderColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 99, 132, 0.2)',
            'rgba(255, 99, 132, 0.2)'
          ],
          data: count
        }]
      };

      var ctx = $("#canvasRegisteredUsers");

      var lineChart = new Chart(ctx, {
        type: 'line',
        data: data,
        options: {
          title: {
            display: true,
            text: 'Registered Users for the Past 6 Months'
          },
          scales: {
            xAxes: [{
              display: true,
              scaleLabel: {
                display: true,
                labelString: 'Month'
              },
            }],
            yAxes: [{
              display: true,
              scaleLabel: {
                display: true,
                labelString: 'No. of users'
              },
              ticks: {
                beginAtZero: true,
                userCallback: function(label, index, labels) {
                  //If floored label value is the same as the value, we have a whole number
                  if (Math.floor(label) === label) {
                    return label;
                  }
                }
              }
            }]
          }
        }
      });
    },
    error: function(data) {
      console.log(data);
    }
  });

  $('#ddlAuction').on('change', function(e) { //Retrieve data for selected auction
    $.ajax({ //Display no. of members participated in an auction
      data: "action=auction&auctionID=" + $("#ddlAuction").val(),
      success: function(data) {
        //Declare arrays to store month & count returned
        var ageGroup = [];
        var participatedCount = [];
        var withdrawnCount = [];

        for(var i in data) { //Loop through each row & push into array
          ageGroup.push(data[i].ageGroup);
          participatedCount.push(data[i].participatedCount);
          withdrawnCount.push(data[i].withdrawnCount);
        }

        var data = {
          labels: ageGroup,
          datasets : [
            {
              label: 'Participated members',
              backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)'
              ],
              borderColor: [
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)'
              ],
              borderWidth: 1,
              hoverBackgroundColor: [
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)',
                'rgba(255,99,132,1)'
              ],
              hoverBorderColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 99, 132, 0.2)'
              ],
              data: participatedCount
            },
            {
              label: 'Withdrawn Members',
              backgroundColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)'
              ],
              borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)'
              ],
              borderWidth: 1,
              hoverBackgroundColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(54, 162, 235, 1)'
              ],
              hoverBorderColor: [
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(54, 162, 235, 0.2)'
              ],
              data: withdrawnCount
            }
          ]
        };

        var ctx = $("#canvasAuction");

        var barChart = new Chart(ctx, {
          type: 'bar',
          data: data,
          options: {
            title: {
              display: true,
              text: 'No. of Users Participated in ' + $("#ddlAuction :selected").text()
            },
            scales: {
              xAxes: [{
                display: true,
                scaleLabel: {
                  display: true,
                  labelString: 'Age Group'
                },
                stacked: true
              }],
              yAxes: [{
                display: true,
                scaleLabel: {
                  display: true,
                  labelString: 'No. of users'
                },
                ticks: {
                  beginAtZero: true,
                  userCallback: function(label, index, labels) {
                    //If floored label value is the same as the value, we have a whole number
                    if (Math.floor(label) === label) {
                      return label;
                    }
                  }
                }
              }]
            }
          }
        });
      },
      error: function(data) {
        console.log(data);
      }
    });
  }).change(); //Trigger dropdownlsit select on page load

  $('#ddlCompetition').on('change', function(e) { //Retrieve data for selected competition
    $.ajax({ //Display no. of members participated in a competition
      data: "action=competition&testID=" + $("#ddlCompetition").val(),
      success: function(data) {
        //Declare arrays to store month & count returned
        var ageGroup = [];
        var participatedCount = [];

        for(var i in data) { //Loop through each row & push into array
          ageGroup.push(data[i].ageGroup);
          participatedCount.push(data[i].participatedCount);
        }

        var data = {
          labels: ageGroup,
          datasets : [{
            label: 'Participated Members',
            backgroundColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)'
            ],
            borderColor: [
              'rgba(255,99,132,1)',
              'rgba(255,99,132,1)',
              'rgba(255,99,132,1)',
              'rgba(255,99,132,1)',
              'rgba(255,99,132,1)',
              'rgba(255,99,132,1)',
              'rgba(255,99,132,1)',
              'rgba(255,99,132,1)',
              'rgba(255,99,132,1)',
              'rgba(255,99,132,1)'
            ],
            borderWidth: 1,
            hoverBackgroundColor: [
              'rgba(255,99,132,1)',
              'rgba(255,99,132,1)',
              'rgba(255,99,132,1)',
              'rgba(255,99,132,1)',
              'rgba(255,99,132,1)',
              'rgba(255,99,132,1)'
            ],
            hoverBorderColor: [
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)',
              'rgba(255, 99, 132, 0.2)'
            ],
            data: participatedCount
          }] //End datasets
        }; //End data

        var ctx = $("#canvasCompetition");

        var competitionBarChart = new Chart(ctx, {
          type: 'bar',
          data: data,
          options: {
            title: {
              display: true,
              text: 'No. of Users Participated in ' + $("#ddlCompetition :selected").text()
            },
            scales: {
              xAxes: [{
                display: true,
                scaleLabel: {
                  display: true,
                  labelString: 'Age Group'
                },
                stacked: true
              }],
              yAxes: [{
                display: true,
                scaleLabel: {
                  display: true,
                  labelString: 'No. of users'
                },
                ticks: {
                  beginAtZero: true,
                  userCallback: function(label, index, labels) {
                    //If floored label value is the same as the value, we have a whole number
                    if (Math.floor(label) === label) {
                      return label;
                    }
                  }
                } //End ticks
              }] //End yAxes
            } //End scales
          } //End options
        }); //End competitionBarChart
      },
      error: function(data) {
        console.log(data);
      }
    }); //End ajax
  }).change(); //End ddlCompetition on change
}); //End document.ready
</script>

<?php
echo makeFooter();
echo makePageEnd();
?>
