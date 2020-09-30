<?php 
require '../../assets/functions/functions.php';
include '../../partials/header.php';
use magazine\fetch_functions;
if(isset($_SESSION['active_user_id'])){
	$user = fetch_functions\get_row('users','USER_ID',$_SESSION['active_user_id'])[0];
}
else{
	if(isset($_GET['subscriber'])){
		$_SESSION['subscriber_id'] = htmlspecialchars($_GET['subscriber']);
		$existing_subscriber = fetch_functions\get_row('subscribers','TABLE_ID',$_SESSION['subscriber_id'])[0];
		if($existing_subscriber){
			$stmt = $con->prepare("SELECT * FROM preference_center WHERE USER_ID = :USER_ID AND EDITABLE = :EDITABLE LIMIT 1");
			$stmt->execute(array('USER_ID' => $_SESSION['subscriber_id'], 'EDITABLE' => 0));
			$user = $stmt->fetch(\PDO::FETCH_OBJ);
			if($user){
				$message = "Please <a href='$base_url/registrations/?login'><u>login</u></a> or <a href='$base_url/subscribe'><u>subscribe</u></a> to continue";
				$_SESSION['subscriber_id'] = "";
			}
			else{
				if(isset($_SESSION['msg'])){
					$notice = $_SESSION['msg'];
				}
				else{	
					$notice = "<div class='message-for-subscribers'><p><strong>Please note that you can update your preference center only once and it can not be updated as a subscriber.</strong> To have access to a customizable preference center, please join zeybramag and update your preference center again and again</p><p><a href='http://www.zeybramag.com' target='_blank'>I WANNA JOIN</a></p></div>";	
				}
			}
		}
		else $message = "Please <a href='$base_url/registrations/?login'><u>login</u></a> or <a href='$base_url/subscribe'><u>subscribe</u></a> to continue";
	}	
	else $message = "Please <a href='$base_url/registrations/?login'><u>login</u></a> or <a href='$base_url/subscribe'><u>subscribe</u></a> to continue";
}
echo "<title>Preference Center | $site_name</title>";
?>




<?php if($message){ echo 
"<div id='preference-center' class='col-lg-12 col-md-12 col-sm-12 col-xs-12'>
	<h1>$message</h1>
</div>";

} else { ?>
<div id="preference-center" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<h1 class="page-title">PREFERENCE CENTER</h1>
	<h2>Feel free to enter your preferences, add to the list on the right side and press SAVE.</h2>
	<?php if($notice) { echo $notice; } ?>
	<section id="prefered-languages" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 preference-section no-padding">
		<div class="col-lg-7 col-md-7 col-sm-6 col-xs-12 no-padding pull-left">
			<select id="languages" class="preferred-items" data-country="">
				<option value="">Choose Country Language</option>
				<?php include '../../partials/countries.php';?>
			</select>
			<button>Add Language</button>
			<p>Type language you prefer to read in and press update to add to preference list.</p>
		</div>
		<div id="language-textarea" class="col-lg-4 col-md-4 col-sm-5 col-xs-12 pull-right preference-box"></div>
	</section>



	<section id="prefered-locations" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 preference-section no-padding">
		<div class="col-lg-7 col-md-7 col-sm-6 col-xs-12 no-padding pull-left">
			<input id="map-locations" class="preferred-items" placeholder="Search Location">
			<button>Add Location</button>
			<p>Type location you prefer to read about and press update to add to preference list.</p>
		</div>
		<div id="location-textarea" class="col-lg-4 col-md-4 col-sm-5 col-xs-12 pull-right preference-box"></div>
	</section>



	<section id="prefered-categories" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 preference-section no-padding">
		<div class="col-lg-7 col-md-7 col-sm-6 col-xs-12 no-padding pull-left">
			<select id="category" class="preferred-items">
				<option value="">Choose Category</option>
				<?php include '../../partials/categories.php';?>
			</select>
			<button>Add Category</button>
			<p>Select the tags you prefer to read about and press update to add to preference list.</p>
		</div>
		<div id="category-textarea" class="col-lg-4 col-md-4 col-sm-5 col-xs-12 pull-right preference-box"></div>
	</section>

	<button id="save-preference-center" class="save-buttons">Save</button>

</div> <!-- /preference-center -->
<?php } ?>




<?php include '../../partials/footer.php';?>