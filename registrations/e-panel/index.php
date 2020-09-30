<?php 
require '../../assets/functions/functions.php';
include '../../partials/header.php';
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

echo "<title>Editor Panel Login | $site_name</title>";
?>




<div id="spcd-login" class="col-lg-12 col-md-12 col-sm-12 col-xs-12"">
	<h1 class="page-title">EDITOR LOGIN <img src="<?php echo $base_url;?>/assets/images/mind-editorteam-icon.png" alt="zeybra-editors-icon"></h1>
	<h2>Are you ready to edit the sh*t out of stuff today or what?  Get in there tiger!</h2>


	<?php 
	if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])) {
		echo $_SESSION['msg'];
		$_SESSION['msg'] = "";
	} 
	?>
	

	<form action="<?php echo $base_url;?>/assets/functions/process-forms.php" method="post" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		<section>
			<label for="email">E-MAIL ID</label>
			<input type="email" id="email" name="email" value="<?php echo $_SESSION['email'];?>" required>
		</section>

		<section>
			<label for="password">PASSWORD</label>
			<input type="password" id="password" name="password" required>
			<div class="clearfix"></div>
			<a href="#">Forgot Password?</a>
		</section>

		<section>
			<button type="submit" name="user-login">LOGIN</button>
		</section>
	</form>
	

	<h2>
		Hey there hawk-eye! Fancy joining the editors team? E-mail us and we'll show you the ropes. <br>
		<strong class="clear">editor@zeybramag.com</strong>
	</h2>
</div> <!-- /spcd-login -->




<?php include '../../partials/footer.php';?>