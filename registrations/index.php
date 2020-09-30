<?php
require '../assets/functions/functions.php';
include '../partials/header.php';
use magazine\fetch_functions;
if(isset($_SESSION['active_user_id'])){
	echo "<script>location.href = '$base_url/home.php';</script>";
}

// LOG USER OUT WHEN THERE IS ?log_out_currently_active_contributor is on the url
if(isset($_GET['log_me_out'])){
	session_destroy();
	unset($_SESSION['active_user_id']);
	unsert($_SESSION['active_user_id']);
	unsert($_SESSION['active_user_email']);
	unsert($_SESSION['active_user_access_level']);
	unsert($_SESSION['active_user_name']);
	$_SESSION[] = array();
	echo "<script>location.href = '$base_url/home.php';</script>";
}

echo "<title>Authentication | $site_name</title>";
?>




<?php if(isset($_GET['register'])) { ?>
<div id="spcd-login" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<h1 class="page-title">Contribute</h1>
	<h2>Its your time to shine.</h2>
	<h3 class="register-msg-top">As a contributor you are the life and soul of the magazine.</h3>
	<h3>We are grateful for the incredible photos and heartening stories you bring from all over the world.</h3>
	<h3>Share your story, get noticed and meet likeminded people in our community.</h3>
	<h3 class="register-msg-bottom">We all have something to contribute to this world. Look around you.  </h3>

	
	<?php 
	if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
		echo $_SESSION['msg'];
		$_SESSION['msg'] = "";
	} 
	?>

	<form action="<?php echo $base_url;?>/assets/functions/process-forms.php" method="post" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 no-padding sections">
			<label for="name">FULL NAME</label>
			<input type="text" id="name" class="form-control" name="name" placeholder="Type Your Full Name...." value="<?php echo $_SESSION['name'];?>" required>
		</div>

		<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 no-padding sections">
			<label for="login-email">E-MAIL ID</label>
			<input type="email" id="login-email" name="email" placeholder="Type your e-mail addresss here...." value="<?php echo $_SESSION['email'];?>" required>
		</div>

		<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 no-padding sections">
			<label for="registration-password">PASSWORD</label>
			<input type="password" id="registration-password" class="form-control" name="password" placeholder="****" required minlength="4">
		</div>

		<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 no-padding sections">
			<label for="confirm-password">CONFIRM PASSWORD</label>
			<input type="password" id="confirm-password" class="form-control" name="confirm-password" placeholder="****" required minlength="4">
		</div>

		<div class="col-lg-5 col-md-5 col-sm-6 col-xs-12 no-padding">
			<br>
			<button type="submit"  name="register-user">Register</button>
		</div>
	</form>
</div> <!-- /register -->
<?php } else { ?>




<div id="spcd-login" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<h1 class="page-title">CONTRIBUTOR LOGIN <img src="<?php echo $base_url;?>/assets/images/soul-contributors-icon.png" alt="zeybra-contributors-icon"></h1>
	<h2>Finished your finger warm-up excercises? Go on then, light up that keyboard!</h2>
	

	<?php 
	if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
		echo $_SESSION['msg'];
		$_SESSION['msg'] = "";
	} 
	?>

	<form action="<?php echo $base_url;?>/assets/functions/process-forms.php" method="post" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		<section>
			<label for="login-email">E-MAIL ID</label>
			<input type="email" id="login-email" name="email" value="<?php echo $_SESSION['email'];?>" required>
		</section>

		<section>
			<label for="login-password">PASSWORD</label>
			<input type="password" id="login-password" name="password" required>
			<div class="clearfix"></div>
			<a href="#">Forgot Password?</a>
		</section>

		<section>
			<button type="submit" name="user-login">LOGIN</button>
		</section>
	</form>
	

	<h2>
		Hey there hawk-eye! Have you been contributing for a while? Why not try editing, we'd love to hear from you. <br>
		<strong class="clear">editor@zeybramag.com</strong>
	</h2>
</div> <!-- /spcd-login -->
<?php } ?>




<?php include '../partials/footer.php';?>