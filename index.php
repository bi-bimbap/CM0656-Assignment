<?php
// ini_set("session.save_path", ""); //TODO: Comment out
session_start();
include 'db/database_conn.php';
require_once('controls.php');
echo makePageStart("Home Page");
echo makeWrapper("");
echo "<form method='post'>" . makeLoginLogoutBtn("") . "</form>";
echo makeProfileButton("");
echo makeNavMenu("");
echo makeHeader("Home Page");
?>

<script src="scripts/jquery.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Lora:400,400i,700" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i,700,700i" rel="stylesheet">
<link rel="stylesheet" href="css/stylesheet.css" type="text/css" />
<link href="css/bootstrap.css" rel="stylesheet">
<script src="scripts/bootstrap.min.js"></script>
<div class='content index'>
	<div class='container'>
		<div>
			<div class='left'>
				<img src='images/auction.jpg' width='468px' height ='auto'/>
				<div class="block"></div>
			</div>
			<div class='right'>
				<h4>Win your dream prize</h4>
				<h6>The auction of Ima's products</h6>
				<p>Win a prize through bidding for the item you want the most.Win a prize through bidding for the item you want the most.Win a prize through bidding for the item you want the most.</p>
				<a href='auction/auctionList.php' id="button">Goto Auction</a>
			</div>
		</div>
		<div>
			<div class='left'>
			<h4>Getting free prizes</h4>
				<h6>Competitions for the capable ones</h6>
				<p>Win a prize through getting the highest score in a competition.Win a prize through getting the highest score in a competition.Win a prize through getting the highest score in a competition.</p>
				<a href='competition/Member_joinCompetition.php' id="button">Goto Competition</a>

			</div>
			<div class='right'>
				<img src='images/comp.jpg'width='468px' height ='auto' />
				<div class="block"></div>
			</div>
		</div>
	</div>

		<div id='concert'>
			<div class='container'>
				<h4>JOIN US</h4>
				<h5>In the journey of following Ima</h5>
			</div>
		</div>
		<div class='container' style='text-align:Center;margin-bottom:180px'>
			<h3>A fan of Ima?</h4>
			<p>Sign up for the latest news regarding Ima and the latest news ongoing within the website. Sign up for the latest news regarding Ima and the latest news ongoing within the website.</p>
			<a href='loginForm.php' id='button' style=''>MORE</a>
		</div>
</div>
<?php
echo makeFooter("");
echo makePageEnd();
?>
