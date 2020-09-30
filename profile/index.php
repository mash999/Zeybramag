<?php 
require '../assets/functions/functions.php';
include '../partials/header.php';
use magazine\fetch_functions;
echo "<title>$_SESSION[active_user_name] | $site_name</title>";

if(isset($_GET['user'])) $user_id = htmlspecialchars($_GET['user']);
else $user_id = $_SESSION['active_user_id'];
$user = fetch_functions\get_row('users','USER_ID',$user_id)[0];
if(!$user) {
	echo "<script>location.href = '$base_url/profile';</script>";
	die();
}
?>




<div id="user-profile" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">	
	<div id="user-intro" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		<div id="profile-name" class="col-lg-9 col-md-9 col-sm-9 col-xs-12 no-padding">
			<?php 
			if($user->USER_ACCESS_LEVEL == 2){
				echo "<h1 class='page-title'>EDITOR PROFILE <img src='$base_url/assets/images/mind-editorteam-icon.png' alt='zeybra-editor-icon'></h1>";
			}
			else{
				echo "<h1 class='page-title'>CONTRIBUTOR PROFILE <img src='$base_url/assets/images/soul-contributors-icon.png' alt='zeybra-contributors-icon'></h1>";
			}
			?>
			
			<p><?php if(!empty($user->USER_NICKNAME)) echo "@" . $user->USER_NICKNAME;?></p>

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

		<div id="profile-picture" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 no-padding">
			<?php 
			if(empty($user->USER_IMAGE)) echo "Upload <br>Photo";
			else echo "<img src='$base_url/assets/images/profile-pictures/$user->USER_IMAGE' alt='$_SESSION[active_user_name]'>";
			?>
		</div> <!-- /profile-picture -->
	</div> <!-- /user-intro -->


	<div id="ice-breaker" class="profile-sections col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		<h2>Ice-breaker</h2>
		<div class="profile-box">
			<?php echo htmlspecialchars_decode($user->ICE_BREAKER,ENT_NOQUOTES);?>
		</div> <!-- /profile-box -->
	</div> <!-- /ice-breaker -->


	<div id="passion-interest" class="profile-sections col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		<h2>Passion &amp; Interest</h2>
		<div class="profile-box">
			<?php echo htmlspecialchars_decode($user->INTERESTS,ENT_NOQUOTES);?>
		</div> <!-- /profile-box -->
	</div> <!-- /passion-interest -->


	<div id="loc-org-lang" class="profile-sections col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-left">
			<label for="current-location">Current Location</label>
			<p id="current-location"><?php echo $user->CURRENT_LOCATION;?></p>
		</div>


		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-right">
			<label for="home-location">Home or Origin</label>
			<p id="home-location"><?php echo $user->HOME_LOCATION;?></p>
		</div>


		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-left">
			<label for="native-language">Native Language</label>
			<p id="native-language"><?php echo $user->NATIVE_LANGUAGE;?></p>
		</div>


		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-right">
			<label for="alternative-language">Alternative Language</label>
			<p id="alternative-language"><?php echo $user->ALTERNATIVE_LANGUAGE;?></p>
		</div>
	</div> <!-- /loc-org-lang -->


	<div id="work-style" class="profile-sections col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		<h2>Work Style</h2>
		<div class="profile-box">
			<?php echo htmlspecialchars_decode($user->WORK_STYLE,ENT_NOQUOTES);?>
		</div> <!-- /profile-box -->
	</div> <!-- /work-interest -->


	<div id="collaboration" class="profile-sections col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		<h2>Collaboration</h2>
		<div class="profile-box">
			<?php echo htmlspecialchars_decode($user->COLLABORATION,ENT_NOQUOTES);?>
		</div> <!-- /profile-box -->
	</div> <!-- /collaboration -->


	<div id="most-least-fav" class="profile-sections col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-left">
			<h2>LOVE IT</h2>
			<div class="profile-box">
				<?php echo htmlspecialchars_decode($user->MOST_FAVORITE,ENT_NOQUOTES);?>
			</div> <!-- /profile-box -->
		</div>


		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-right">
			<h2>LEAST FAVORITE</h2>
			<div class="profile-box">
				<?php echo htmlspecialchars_decode($user->LEAST_FAVORITE,ENT_NOQUOTES);?>
			</div> <!-- /profile-box -->
		</div> <!-- /profile-box -->
	</div> <!-- /most-least-fav -->
</div> <!-- /user-profile -->




<?php include '../partials/footer.php';?>