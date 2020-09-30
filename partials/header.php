<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalability=0">
	<!-- GOOGLE FONTS AND FONT AWESOME -->
	<link href="https://fonts.googleapis.com/css?family=Indie+Flower" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Lobster" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Patua+One" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Londrina+Solid" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<!-- BOOTSTRAP -->
	<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>/assets/css/bootstrap.min.css">

	<!-- CUSTOM CONNECTIONS -->
	<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>/assets/css/style.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>/assets/css/responsive.css">
	<link rel="stylesheet" type="text/css" href="<?php echo $base_url;?>/assets/css/flags.min.css">

</head>
<body>


<div id="page-wrapper">
	
	<div class="topbar">
		<div class="topbar-container">
			<h1 class="pull-left">Welcome to Zeybra Magazine</h1>
			<i class="fa fa-bars fa-lg menu-bars"></i>
			<?php 
			if(!isset($_SESSION['active_user_id'])){
				echo "
				<div class='login-menu pull-right'>
					<a href='$base_url/subscribe'>Subscribe</a>
					<a href='$base_url/registrations?register'>Register</a>
					<a href='$base_url/registrations/?login'>Login</a>
				</div> <!-- /login-menu -->
				";
			}
			else{
				$f_name = explode(" ", $_SESSION['active_user_name'])[0];
				echo "
				<div class='already-logged-in'>
					<p class='pull-right'>Hey, $f_name <i id='accounts-menu-trigger' class='fa fa-caret-down' aria-hidden='true'></i></p>
					<div class='accounts-drop-down'>
						<i class='fa fa-caret-up' aria-hidden='true'></i>
						<a href='$base_url/profile/'>Profile</a>
						<a href=''>Preference Center</a>
						<a href='$base_url/registrations?log_me_out'>Logout</a>
					</div>
				</div> <!-- /already-logged-in --> 
				";
			}
			?>
		</div> <!-- /topbar-container -->
	</div> <!-- /topbar -->




	<div id="nav-border"></div>
	<div id="body-overlay"></div>
	<div class="navigation-menu">
		<div class="social-links">
			<p>Follow</p>
			<a href="#"><i class="fa fa-twitter" aria-hidden="true"></i></a>
			<a href="#"><i class="fa fa-instagram" aria-hidden="true"></i></a>
			<a href="#"><i class="fa fa-facebook" aria-hidden="true"></i></a>
		</div> <!-- /social-links -->


		<!-- <h1 class="logo">Zeybra Magazine</h1> -->
		<img class="logo" src="<?php echo $base_url;?>/assets/images/zeybra-magazine.jpg" alt="Zeybra-Magazine">
		<img class="logo-text" src="<?php echo $base_url;?>/assets/images/zeybra-magazine-text.jpg" alt="Zeybra-Magazine">


		<nav>
			<a href="<?php echo $base_url . '/home.php';?>">Home</a>
			<a href="<?php echo $base_url . '/articles/new';?>">New Article</a>
			<?php 
			if(isset($_SESSION['active_user_access_level']) &&  $_SESSION['active_user_access_level'] == 2){
				echo "<a href='$base_url/articles/reviews/'>Review</a>";
			}
			?>
		</nav>
	</div> <!-- /navigation-menu -->




	<div class="content-wrapper">
		
	