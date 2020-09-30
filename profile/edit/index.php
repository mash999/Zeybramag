<?php 
require '../../assets/functions/functions.php';
include '../../partials/header.php';
use magazine\fetch_functions;

if(!isset($_SESSION['active_user_id'])){
	echo "<script>location.href='$base_url/profile/';</script>";
	die();
}

echo "<title>$_SESSION[active_user_name] | $site_name</title>";	
$user = fetch_functions\get_row('users','USER_ID',$_SESSION['active_user_id'])[0];
?>




<div id="user-profile" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<h1 class="page-title">YOUR PROFILE</h1>
	<h2 class="page-edit">About time you came to visit again. :) <br>Simply fill in the fields and press SAVE to update your profile.<br>Don’t forget your photo :)</h2>

	
	<form action="<?php echo $base_url;?>/assets/functions/process-forms.php" method="post" enctype="multipart/form-data" id="user-profile-form" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		<div id="user-intro" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
			<div id="profile-name" class="col-lg-9 col-md-9 col-sm-9 col-xs-12 no-padding">

				<h1 class="page-title"><input type="text" name="user-name" placeholder="FULL NAME" value="<?php echo $_SESSION['active_user_name'];?>"></h1>
				<p><input type="text" name="nickname" placeholder="ASSIGN A COOL NICKNAME" value="<?php echo $user->USER_NICKNAME;?>"></p>

				<div id="profile-totempole" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
					<img src="<?php echo $base_url;?>/assets/images/totem-incentive-forarticles.png" alt="zeybra-totem-pole">
					<div class="article-number">
						<?php 
							$stmt = $con->prepare("SELECT COUNT(TABLE_ID) AS ARTICLE_NUMBER FROM articles WHERE POSTED_BY = :POSTED_BY AND ARTICLE_STATUS = :ARTICLE_STATUS AND PUBLISHER_TYPE = :PUBLISHER_TYPE");
							$execute = $stmt->execute(array('POSTED_BY' => $_SESSION['active_user_id'], 'ARTICLE_STATUS' => 1, 'PUBLISHER_TYPE' => $_SESSION['active_user_access_level']));
							$article_number = $stmt->fetch(\PDO::FETCH_OBJ)->ARTICLE_NUMBER;
							$article_number = sprintf('%06d',$article_number);
							$join_date = fetch_functions\get_row('users','USER_ID',$_SESSION['active_user_id'])[0]->ENTERED_AT;
							$join_date = date("F Y", strtotime($join_date));
							echo "<p>$article_number Article uploaded since $join_date</p>";
							
							if($user->USER_ACCESS_LEVEL == 2){
								echo $_SESSION['active_user_id'];die();
								$approved_by = fetch_functions\get_row('users','USER_ID',$_SESSION['active_user_id'])[0]->USER_ID;
								$stmt = $con->prepare("SELECT COUNT(TABLE_ID) AS REVIEW_NUMBER FROM articles WHERE APPROVED_BY = :APPROVED_BY");
								$execute = $stmt->execute(array('APPROVED_BY' => $approved_by));
								$review_number = $stmt->fetch(\PDO::FETCH_OBJ)->REVIEW_NUMBER;
								$review_number = sprintf('%06d',$review_number);
								$editor_join_date = fetch_functions\get_row('users','KEY_ID',$_SESSION['active_user_id'])[0]->ENTERED_AT;
								$editor_join_date = date("F Y", strtotime($editor_join_date));
								echo "<p>$review_number Article reviewed since $editor_join_date</p>";
							}
						?>
					</div> <!-- /article-number -->
				</div> <!-- /profile-totempole -->
			</div> <!-- /profile-name -->

			<label for="choose-profile-picture" id="profile-picture" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-padding">
				<?php 
				if(empty($user->USER_IMAGE)) echo "Upload <br>Photo";
				else echo "<img src='$base_url/assets/images/profile-pictures/$user->USER_IMAGE' alt='$_SESSION[user_name]'>";
				?>
			</label> <!-- /profile-picture -->
			<input type="file" id="choose-profile-picture" name="profile-picture" class="hidden">
		</div> <!-- /user-intro -->


		<div id="ice-breaker" class="profile-sections col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
			<h2>Ice-breaker</h2>
			<h3>Type in a statement or question that will help people break the ice and get to know you.</h3>
			<textarea name="ice-breaker" class="profile-box" placeholder="I once had a pet dog called Tuppence. Tuppence was a term used for the old coins before the Euro."><?php echo $user->ICE_BREAKER;?></textarea>
		</div> <!-- /ice-breaker -->


		<div id="passion-interest" class="profile-sections col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
			<h2>Passion &amp; Interest</h2>
			<h3>Passion or Interests? Share something you love to do or take great pride in.</h3>
			<textarea name="passion-interest" class="profile-box" placeholder="I love to write about cars and travel, especially the electric motors and future of transport"><?php echo $user->INTERESTS;?></textarea>
		</div> <!-- /passion-interest -->


		<div id="loc-org-lang" class="profile-sections col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-left">
				<label for="current-location">Current Location</label>
				<input type="text" id="current-location" name="current-location" value="<?php echo $user->CURRENT_LOCATION;?>">
			</div>


			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-right">
				<label for="home-location">Home or Origin</label>
				<input type="text" id="home-location" name="home-location" value="<?php echo $user->HOME_LOCATION;?>">
			</div>


			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-left">
				<label for="native-language">Native Language</label>
				<input type="text" id="native-language" name="native-language" value="<?php echo $user->NATIVE_LANGUAGE;?>">
			</div>


			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-right">
				<label for="alternative-language">Alternative Language</label>
				<input type="text" id="alternative-language" name="alternative-language" value="<?php echo $user->ALTERNATIVE_LANGUAGE;?>">
			</div>
		</div> <!-- /loc-org-lang -->


		<div id="work-style" class="profile-sections col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
			<h2>Work Style</h2>
			<h3>Give people a heads up on how you operate, which communication style works best and which days or times you are not available.</h3>
			<textarea name="work-style" class="profile-box" placeholder="E-mail is best, might take a day or two to reply. I value my pleasure time so I will not answer whatsapp immediately. I am productive Monday&Tuesday and the rest of the week, no contact. thanks :)"><?php echo $user->WORK_STYLE;?></textarea>
		</div> <!-- /passion-interest -->


		<div id="collaboration" class="profile-sections col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
			<h2>Collaboration</h2>
			<h3>Collaborating with someone? Let them know your A-game skills and experience you have, plus mention your least favourite thing to do. Maybe they love it!</h3>
			<textarea name="collaboration" class="profile-box" placeholder="Absolutely love making colourfil ppt, but hate with a capital H working in excel...ugh...help."><?php echo $user->COLLABORATION;?></textarea>
		</div> <!-- /collaboration -->


		<div id="most-least-fav" class="profile-sections col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-left">
				<h2>LOVE IT</h2>
				<h3>Type your A-game skills</h3>
				<textarea name="most-fav" class="profile-small-box"><?php echo $user->MOST_FAVORITE;?></textarea>
			</div>


			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-right">
				<h2>LEAST FAVORITE</h2>
				<h3>Add things you need help with</h3>
				<textarea name="least-fav" class="profile-small-box"><?php echo $user->LEAST_FAVORITE;?></textarea>
			</div>
		</div> <!-- /most-least-fav -->


		<button type="submit" class="save-buttons" name="save-profile">SAVE</button>
	</form> 

</div> <!-- /user-profile -->




<?php include '../../partials/footer.php';?>