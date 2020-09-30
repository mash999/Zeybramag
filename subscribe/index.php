<?php 
require '../assets/functions/functions.php';
include '../partials/header.php';
use magazine\fetch_functions;

echo "<title>Subscribe | $site_name</title>";
?>




<div id="spcd-login" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<h1 class="page-title">SUBSCRIBE</h1>

	
	<?php if (isset($_SESSION['msg']) && !empty($_SESSION['msg'])){
		echo $_SESSION['msg']; 
		$_SESSION['msg'] = "";
	}
	?>

	<h2>Pop in your e-mail address and hit the big button. Easy-peezy!</h2>
	<form action="<?php echo $base_url;?>/assets/functions/process-forms.php" method="post" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		<input type="email" name="subscriber-email" placeholder="Type your e-mail address here....." required>
		<button type="submit" name="save-subscriber">SUBSCRIBE</button>
		<button type="button" id="get-subscriber-by-mail" onclick="location.href='preference-center/';" class="link-button">PREFERENCE CENTER</button>
		<p class="little-info"><strong>Already subscribed?</strong> Enter your e-mail ID and click preference center.</p>
	</form>
</div> <!-- /spcd-login -->




<?php include '../partials/footer.php';?>