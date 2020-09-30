<?php namespace magazine\process_forms;
require_once 'functions.php';
require 'phpmailer/vendor/autoload.php';
use magazine\fetch_functions;
use magazine\process_forms;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;




// TRIGGERS

if(isset($_POST['save-guests']))
	save_guests();

if(isset($_POST['save-subscriber']))
	save_subscriber();

if(isset($_POST['saveSubscriberEmail']))
	save_subscriber_from_footer();

if(isset($_POST['register-user']))
	register_user();

if(isset($_POST['user-login']))
	user_login();

if(isset($_POST['preferenceCenter']))
	save_preference_center();

if(isset($_POST['save-profile']))
	save_profile();

if(isset($_POST['crawl']))
	get_link_data();

if(isset($_POST['submit-new-article']))
	submit_new_article();

if(isset($_POST['save-article']))
	save_article();

if(isset($_POST['publish-article']))
	publish_article();

if(isset($_POST['reject-article']))
	reject_article();

if(isset($_POST['retriveEmail']))
	retrieve_email();

if(isset($_POST['send-email']))
	send_email();

if(isset($_POST['change-password']))
	change_password();

if(isset($_GET['articleId']) && isset($_GET['language']))
	change_article_language();









function save_guests(){
	global $con;
	global $base_url;
	$name = htmlspecialchars($_POST['name']);
	$email = htmlspecialchars($_POST['email']);
	$city = htmlspecialchars($_POST['city']);
	$stmt = $con->prepare("INSERT INTO guests (GUEST_EMAIL, GUEST_NAME, GUEST_CITY) VALUES (:GUEST_EMAIL, :GUEST_NAME, :GUEST_CITY)");
	$executed = $stmt->execute(array('GUEST_EMAIL' => $email, 'GUEST_NAME' => $name, 'GUEST_CITY' => $city));
	if($executed){
		$subject = "Greetings From Zeybramag";
		$message = "<div><p>We hear ya! We've got your name on the list. Now keep your eyes open for the Zeybras near you. More details to follow soon.....</p><img src='../images/three-zeybra.jpg' style='width:200px; height: auto;'></div>";
		$alt_body = "We hear ya! We've got your name on the list. Now keep your eyes open for the Zeybras near you. More details to follow soon.....";
		$set_from = "noreply@zeybramag.com";
		$emailer_name = "Zeybramag";
		$send_mail = send_email($email,$subject,$message,$alt_body,$set_from,$emailer_name,'noreply@zeybramag.com','noreply_zeybramag123');
		if($send_mail){
			$_SESSION['msg'] = "<h2 class='success-msg'><i class='fa fa-check-circle fa-lg'></i> &nbsp;Youuuuuu've got mail! Check your e-mail for confirmation. Thanks!</h2>";
		}
		else{
			$stmt = $con->prepare("DELETE FROM guests WHERE TABLE_ID = :TABLE_ID");
			$deleted = $stmt->execute(array('TABLE_ID' => $con->lastInsertId()));
			if($deleted){
				$_SESSION['msg'] = "<h2 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;We couldn't reach you to the e-mail you provided. Please try again or try a different e-mail address</h2>";
			}
		}
	}
	else{
		$_SESSION['msg'] = "<h2 class='error-msg'><i class='fa fa-times fa-lg'></i> &nbsp;This is embarrasing. Something went wrong. Please try again later.</h2>";
	}
	echo "<script>location.href = '$base_url';</script>";
	die();
}









function save_subscriber(){
	global $con;
	global $base_url;
	$email = htmlspecialchars($_POST['subscriber-email']);
	$email_message = false;
	$subscriber = fetch_functions\get_row('subscribers','SUBSCRIBER_EMAIL',$email)[0];
	if(sizeof($subscriber) > 0){
		if($subscriber->SUBSCRIBER_STATUS == 1){
			$_SESSION['msg'] = "<h4 class='success-msg'><i class='fa fa-check-circle fa-lg'></i> &nbsp;Looks like you already have subscribed before. No worries, we have you listed as a subscriber. Cheers.</h4>";
		}
		else{
			$_SESSION['msg'] = "<h4 class='success-msg'><i class='fa fa-check-circle fa-lg'></i> &nbsp;You have already subscribed once but did not verify you account. No matter, we have sent you the verification link again.</h4>";
			$email_message = true;
		}
	}
	else{
		$stmt = $con->prepare("INSERT INTO subscribers (SUBSCRIBER_EMAIL) VALUES (:SUBSCRIBER_EMAIL)");
		$executed = $stmt->execute(array('SUBSCRIBER_EMAIL' => $email));
		if($executed){
			$_SESSION['msg'] = "<h4 class='success-msg'><i class='fa fa-check-circle fa-lg'></i> &nbsp;Youuuuuu've got mail! Check your e-mail for confirmation. Thanks! (This could take up to 30minutes)</h4>";
			$email_message = true;
			$subscriber_id = $con->lastInsertId();
		}
		else{
			$_SESSION['msg'] = "<h4 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Whoops !! Something went wrong. Please try again later</h4>";
		}
	}
	if($email_message){
		$_SESSION['zeybramag_subscription_email'] = $email;
		$subject = "Zeybramag Subscription";
		$message = "<h3>Hi there</h3><p>Thank you for subscribing to our magazine. You are just 1 step away. Please click on the following link to verify your account. </p><p><a href='$base_url/assets/functions/verify.php?subscription=true&subscriber=$subscriber_id'>Verify my account</a></p>";

		$alt_body = "Hi there, thank you for subscribing to our magazine. You are just 1 step away. Please follow the following link to verify your account : $base_url/assets/functions/verify.php?subscription=true&subscriber=$subscriber_id.";
		$set_from = "subscribe@zeybramag.com";
		$email_message = "Zeybramag";
		$send_mail = send_email($email,$subject,$message,$alt_body,$set_from,$emailer_name,'subscribe@zeybramag.com','subscriber_zeybramag123');
	}
	echo "<script>location.href = '$base_url/subscribe';</script>";
	die();	
}









function save_subscriber_from_footer(){
	global $con;
	global $base_url;
	$email = htmlspecialchars($_POST['subscriber_email']);
	$email_message = false;
	$subscriber = fetch_functions\get_row('subscribers','SUBSCRIBER_EMAIL',$email)[0];
	if(sizeof($subscriber) > 0){
		if($subscriber->SUBSCRIBER_STATUS == 1){
			$msg = "<i class='fa fa-check-circle fa-lg'></i> &nbsp;Looks like you already have subscribed before. No worries, we have you listed as a subscriber. Cheers.";
		}
		else{
			$msg = "<i class='fa fa-check-circle fa-lg'></i> &nbsp;You have already subscribed once but did not verify you account. No matter, we have sent you the verification link again.";
			$email_message = true;
		}
	}
	else{
		$stmt = $con->prepare("INSERT INTO subscribers (SUBSCRIBER_EMAIL) VALUES (:SUBSCRIBER_EMAIL)");
		$executed = $stmt->execute(array('SUBSCRIBER_EMAIL' => $email));
		if($executed){
			$msg = "<i class='fa fa-check-circle fa-lg'></i> &nbsp;Youuuuuu've got mail! Check your e-mail for confirmation. Thanks! (This could take up to 30minutes)";
			$email_message = true;
		}
		else{
			$msg = "<i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Whoops !! Something went wrong. Please try again later";
		}
	}
	if($email_message){
		$_SESSION['zeybramag_subscription_email'] = $email;
		$subject = "Zeybramag Subscription";
		$message = "<h3>Hi there</h3><p>Thank you for subscribing to our magazine. You are just 1 step away. Please click on the following link to verify your account. </p><p>Cheers.</p> <p> <a href='$base_url/assets/functions/verify.php?subscription=true'>Verify my account</a></p>";
		$alt_body = "Hi there, thank you for subscribing to our magazine. You are just 1 step away. Please check out the following link to verify your account : $base_url/assets/functions/verify.php?subscription=true";
		$set_from = "subscribe@zeybramag.com";
		$email_message = "Zeybramag";
		$send_mail = send_email($email,$subject,$message,$alt_body,$set_from,$emailer_name,'subscribe@zeybramag.com','subscriber_zeybramag123');
	}
	echo $msg;
	die();	
}









function register_user(){
	global $con;
	global $base_url;
	$name = htmlspecialchars($_POST['name']);
	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);
	$confirm_password = htmlspecialchars($_POST['confirm-password']);
	$token = "zeybramag-" . uniqid() . uniqid();
	$user = fetch_functions\get_row('users','USER_EMAIL',$email)[0];
	if(sizeof($user) > 0){
		$_SESSION['msg'] = "<h4 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Wait a minute. This user already exists. If you forgot the password, please try retrieving the password using <a href='#'>Forget Password</a></h4>";
		echo "<script>location.href = '$base_url/registrations/?register';</script>";
		die();
	}
	else{
		if($password != $confirm_password){
			$_SESSION['msg'] = "<h4 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Sorry, but it seems like the password and the confirmed password did not matched. Please try again.</h4>";
			echo "<script>location.href='$base_url/registrations/?register';</script>";
			die();
		}
		else{
			$stmt = $con->prepare("INSERT INTO users (USER_ACCOUNT_STATUS, USER_ACCESS_LEVEL, USER_EMAIL, USER_NAME) VALUES (:USER_ACCOUNT_STATUS, :USER_ACCESS_LEVEL, :USER_EMAIL, :USER_NAME)");
			$executed = $stmt->execute(array('USER_ACCOUNT_STATUS' => $token, 'USER_ACCESS_LEVEL' => 1, 'USER_EMAIL' => $email, 'USER_NAME' => $name));
			if($executed){
				$last_inserted_id = $con->lastInsertId();
				$stmt = $con->prepare("INSERT INTO contributors (USER_ID) VALUES (:USER_ID)");
				$executed = $stmt->execute(array('USER_ID' => $last_inserted_id));
				if($executed){
					$subject = "Registration Validation";
					$message = "<p>Thank you for registering to our magazine. You are just 1 step away. Please click on the following link to verify your account and get started. </p><p>Cheers.</p> <p> <a href='$base_url/assets/functions/verify.php?account=$email&token=$token'>$base_url/assets/functions/verify.php?account=$email&token=$token</a></p>";
					$alt_body = "Thank you for registering to our magazine. You are just 1 step away. Please copy and paste following link to verify your account and get started : $base_url/assets/functions/verify.php?account=$email&token=$token";
					$set_from = "noreply@zeybramag.com";
					$emailer_name = "Zeybramag";
					$send_mail = send_email($email,$subject,$message,$alt_body,$set_from,$emailer_name,'noreply@zeybramag.com','noreply_zeybramag123');
					if($send_mail){
						$_SESSION['msg'] = "<h4 class='success-msg'><i class='fa fa-check-circle fa-lg'></i> &nbsp;A link is sent to <strong><em>$email</em></strong>. Please verify your account to get started. <br> <span>It may take time to get the e-mail. If you don't find the e-mail from us in your inbox, please check the spam folder. If you don't receive an e-mail within 24 hours, then <a href='#'>contact us</a> or try again.</span></h4>";
	
						echo "<script>location.href = '$base_url/registrations/?register';</script>";	
					}
					else{
						$stmt = $con->prepare("DELETE FROM users WHERE TABLE_ID = :TABLE_ID");
						$stmt->execute(array('TABLE_ID' => $last_inserted_id));
						$stmt = $con->prepare("DELETE FROM contributors WHERE USER_ID = :USER_ID");
						$stmt->execute(array('USER_ID' => $last_inserted_id));
						$_SESSION['msg'] = "<h4 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Whoops !! Something went wrong. Please try again later</h4>";
					}
					die();
				}
				else{
					$stmt = $con->prepare("DELETE FROM users WHERE USER_ID = :USER_ID");
					$executed = $stmt->execute(array('USER_ID' => $con->lastInsertId()));
					$_SESSION['msg'] = "<h4 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Whoops !! Something went wrong. Please try again later</h4>";
					echo "<script>location.href='$base_url/registrations/?register';</script>";
					die();
				}
			}
			else{
				$_SESSION['msg'] = "<h4 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Whoops !! Something went wrong. Please try again later</h4>";
				echo "<script>location.href='$base_url/registrations/?register';</script>";
				die();
			}
		}
	}
}









function user_login(){
	global $con;
	global $base_url;
	$email = htmlspecialchars($_POST['email']);
	$password = htmlspecialchars($_POST['password']);
	$user = fetch_functions\get_row('users','USER_EMAIL',$email)[0];
	$_SESSION['email'] = $email;
	if($user){
		$stmt = $con->prepare("SELECT * FROM users WHERE USER_EMAIL = :USER_EMAIL");
		$stmt->execute(array('USER_EMAIL' => $user->USER_EMAIL));
		$authenticated = $stmt->fetch(\PDO::FETCH_OBJ);
		if($authenticated->USER_PASSWORD == hash('sha512', $password)){
			$_SESSION['active_user_id'] = $authenticated->USER_ID;
			$_SESSION['active_user_email'] = $authenticated->USER_EMAIL;
			$_SESSION['active_user_access_level'] = $authenticated->USER_ACCESS_LEVEL;
			$_SESSION['active_user_name'] = $authenticated->USER_NAME;
			echo "<script>location.href='$base_url/home.php';</script>";
			die();
		}
		else{
			$_SESSION['msg'] = "<h4 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;The e-mail and password do not match !!</h4>";
			echo "<script>location.href='$base_url/registrations/?login';</script>";
			die();
		}
		
	}
	else{
		$_SESSION['msg'] = "<h4 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Oops, Looks like you provided a wrong e-mail address. This user <strong><em>$email</em></strong> does not exist in database.</h4>";
		echo "<script>location.href='$base_url/registrations/?login';</script>";
		die();
	}
}









function save_preference_center(){
	global $con;
	global $base_url;
	$country_language =  htmlspecialchars($_POST['countryLanguages']);
	$language = htmlspecialchars($_POST['languages']);
	$category = htmlspecialchars($_POST['categories']);
	$location = htmlspecialchars($_POST['locations']);
	$user_id = htmlspecialchars($_SESSION['active_user_id']);
	if(isset($_SESSION['subscriber_id']) && !empty($_SESSION['subscriber_id'])){
		$subscriber_id = $_SESSION['subscriber_id'];
		$_SESSION['subscriber_id'] = "";
	}
	if($user_id || $subscriber_id){
		if($user_id){
			$selected_id = $user_id;
			$editable = 1;
			$user = fetch_functions\get_row('preference_center','USER_ID',$user_id)[0];
			if($user){
				$stmt = $con->prepare("UPDATE preference_center SET EDITABLE = :EDITABLE, COUNTRY_LANGUAGE = :COUNTRY_LANGUAGE, LANGUAGE = :LANGUAGE, LOCATION = :LOCATION, CATEGORY = :CATEGORY WHERE USER_ID = :USER_ID");
			}
			else{
				$stmt = $con->prepare("INSERT INTO preference_center (USER_ID, EDITABLE, COUNTRY_LANGUAGE, LANGUAGE, LOCATION, CATEGORY) VALUES (:USER_ID, :EDITABLE, :COUNTRY_LANGUAGE, :LANGUAGE, :LOCATION, :CATEGORY)");
			}	
		}
		else{
			$selected_id = $subscriber_id;
			$editable = 0;
			$stmt = $con->prepare("INSERT INTO preference_center (USER_ID, EDITABLE, COUNTRY_LANGUAGE, LANGUAGE, LOCATION, CATEGORY) VALUES (:USER_ID, :EDITABLE, :COUNTRY_LANGUAGE, :LANGUAGE, :LOCATION, :CATEGORY)");
		}
		$executed = $stmt->execute(array('USER_ID' => $selected_id, 'EDITABLE' => $editable, 'COUNTRY_LANGUAGE' => $country_language, 'LANGUAGE' => $language, 'LOCATION' => $location, 'CATEGORY' => $category));
		if($executed) echo "true";
		else echo "false";
	}
	die();
}









function save_profile(){
	global $con;
	global $base_url;
	$name = htmlspecialchars($_POST['user-name']);
	$nickname = htmlspecialchars($_POST['nickname']);
	$ice_breaker = htmlspecialchars($_POST['ice-breaker']);
	$passion_interest = htmlspecialchars($_POST['passion-interest']);
	$current_location = htmlspecialchars($_POST['current-location']);
	$home_location = htmlspecialchars($_POST['home-location']);
	$native_language = htmlspecialchars($_POST['native-language']);
	$alternative_language = htmlspecialchars($_POST['alternative-language']);
	$work_style = htmlspecialchars($_POST['work-style']);
	$collaboration = htmlspecialchars($_POST['collaboration']);
	$most_fav = htmlspecialchars($_POST['most-fav']);
	$least_fav = htmlspecialchars($_POST['least-fav']);

	$row = fetch_functions\get_row('users','USER_ID',$_SESSION['active_user_id'])[0];
	if(!empty(basename($_FILES['profile-picture']['name']))){
		$image = move_file('profile-picture','../images/profile-pictures/');
		if(!$image) $image = $row->USER_IMAGE;
		else unlink("../images/profile-pictures/$row->USER_IMAGE");
	}
	else{
		$image = $row->USER_IMAGE;
	}

	$stmt = $con->prepare("UPDATE users SET USER_NAME = :USER_NAME, USER_NICKNAME = :USER_NICKNAME, USER_IMAGE = :USER_IMAGE, ICE_BREAKER = :ICE_BREAKER, INTERESTS = :INTERESTS, CURRENT_LOCATION = :CURRENT_LOCATION, HOME_LOCATION = :HOME_LOCATION, NATIVE_LANGUAGE = :NATIVE_LANGUAGE, ALTERNATIVE_LANGUAGE = :ALTERNATIVE_LANGUAGE, WORK_STYLE = :WORK_STYLE, COLLABORATION = :COLLABORATION, MOST_FAVORITE = :MOST_FAVORITE, LEAST_FAVORITE = :LEAST_FAVORITE WHERE USER_ID = :USER_ID");
	$executed = $stmt->execute(array('USER_NAME' => $name, 'USER_NICKNAME' => $nickname, 'USER_IMAGE' => $image, 'ICE_BREAKER' => $ice_breaker, 'INTERESTS' => $passion_interest, 'CURRENT_LOCATION' => $current_location, 'HOME_LOCATION' => $home_location, 'NATIVE_LANGUAGE' => $native_language, 'ALTERNATIVE_LANGUAGE' => $alternative_language, 'WORK_STYLE' => $work_style, 'COLLABORATION' => $collaboration, 'MOST_FAVORITE' => $most_fav, 'LEAST_FAVORITE' => $least_fav, 'USER_ID' => $_SESSION['active_user_id']));

	if($executed){
		$_SESSION['user_name'] = $name;
	}
	echo "<script>location.href='$base_url/profile/';</script>";
	die();
}









function get_link_data(){
	$url = $_POST['url'];
	if($page = file_get_contents($url)){
		$title_end = explode("</title>", $page)[0];
		$title = explode("<title>", $title_end)[1];
		echo "<h4>$title</h4><p><a href='$url'>$url</a></p>";	
	}
	else{
		echo "<h4>Invalid URL. No such link found</h4>";
	}
}









function submit_new_article(){
	global $con;
	global $base_url;
	$article_id = date("dmY",time()) . time() . $_SESSION['active_user_id'];
	$article_link = trim(htmlspecialchars($_POST['titles'][0]));
	$allowed_chars = array("a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z","1","2","3","4","5","6","7","8","9"," ");
	$strlen = strlen($article_link);
	$tmp_str = "";
	for($i = 0; $i < $strlen; $i++){
		if(in_array(strtolower($article_link[$i]), $allowed_chars)){
			$tmp_str .= $article_link[$i];
		}
	}
	$article_link = strtolower($tmp_str);
	$article_link = preg_replace('/\s{2,}/'," ",$article_link); 
	$article_link = str_replace(" ", "-", $article_link);
	$article_mod_title = $article_link;
	$same_title_article = fetch_functions\get_row('articles','ARTICLE_MOD_TITLE',$article_mod_title);
	$same_title_article_number = sizeof($same_title_article);
	if($same_title_article_number > 0){
		$article_link .= '-' . $same_title_article_number + 1;
	}

	if($_SESSION['active_user_access_level'] == 2){
		$status = htmlspecialchars($_POST['status']);
		if($status != 0 && $status != 1){ 
			$status = 0; 
		}
		$approved_by = $_SESSION['active_user_id'];
		$tile_type = htmlspecialchars($_POST['tile-type']);
	}
	else{ 
		$status = 0; 
		$approved_by = 0;  
		$tile_type = ""; 
	}

	if($_SESSION['active_user_access_level'] == 1){
		$user = fetch_functions\get_rows('users','USER_ID',$_SESSION['active_user_id'])[0];
		if(strtolower(trim($user->USER_ACCOUNT_STATUS)) != "verified"){
			$_SESSION['msg'] = "<i class='fa fa-times-circle fa-lg'></i> &nbsp;Your account is not verified. Please verify your account by clicking on the link we sent you in your email address when you registered";
			echo "<script>location.href='$base_url/home.php';</script>";
			die();
		}
	}

	$tags = htmlspecialchars($_POST['article-tags']);
	$location = htmlspecialchars($_POST['article-location']);
	// SET LINK INPUT = MEDIA INITIALLY
	$media = trim(htmlspecialchars($_POST['link']));
	if(empty($media)){
		// LINK INPUT IS EMPTY. SO THE USER PROVIDED IMAGE/VIDEO OR NO MEDIA AT ALL
		if(basename($_FILES['file']['name']) == ""){
			// FILENAME IS EMPTY, SO THE USER HAS NOT PROVIDED ANY MEDIA AT ALL
			// SET MEDIA = NULL
			$media = "";
		}
		else{
			// USER PROVIDED IMAGE/VIDEO
			$type = trim(htmlspecialchars($_POST['media-type'])); 
			if($type == "img")  $folder = '../images/';
			elseif($type == "vid") $folder = '../videos/'; 
			$media = process_forms\move_file('file', $folder, $type);
			if(!$media){
				// SOMETHING WENT WRONG, FILE COULD NOT BE MOVED TO THE SERVER
				$_SESSION['msg'] = "<h4 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Oh snap, Something went wrong. File could not be uploaded. Please try again later.</h4>";
			}
		}
	}
	// INSERT THE ARTICLE IN THE DATABASE
	$stmt = $con->prepare("INSERT INTO articles (ARTICLE_ID, ARTICLE_MOD_TITLE, ARTICLE_LINK, ARTICLE_LOCATION, ARTICLE_TAGS, ARTICLE_MEDIA, POSTED_BY, ARTICLE_STATUS, APPROVED_BY, PUBLISHER_TYPE, TILE_TYPE) VALUES (:ARTICLE_ID, :ARTICLE_MOD_TITLE, :ARTICLE_LINK, :ARTICLE_LOCATION, :ARTICLE_TAGS, :ARTICLE_MEDIA, :POSTED_BY, :ARTICLE_STATUS, :APPROVED_BY, :PUBLISHER_TYPE, :TILE_TYPE)");
	$executed = $stmt->execute(array('ARTICLE_ID' => $article_id, 'ARTICLE_MOD_TITLE' => $article_mod_title, 'ARTICLE_LINK' => $article_link, 'ARTICLE_LOCATION' => $location, 'ARTICLE_TAGS' => $tags, 'ARTICLE_MEDIA' => $media, 'POSTED_BY' => $_SESSION['active_user_id'], 'ARTICLE_STATUS' => $status, 'APPROVED_BY' => $approved_by, 'PUBLISHER_TYPE' => $_SESSION['active_user_access_level'], 'TILE_TYPE' => $tile_type));

	if($executed){
		for ($i = 0; $i < sizeof($_POST['titles']); $i++) {
			$stmt = $con->prepare("INSERT INTO article_translations (ARTICLE_ID, ARTICLE_LANGUAGE, ARTICLE_TITLE, ARTICLE_HASHTAGS, ARTICLE_BODY) VALUES (:ARTICLE_ID, :ARTICLE_LANGUAGE, :ARTICLE_TITLE, :ARTICLE_HASHTAGS, :ARTICLE_BODY)");
			$executed = $stmt->execute(array('ARTICLE_ID' => $article_id, 'ARTICLE_LANGUAGE' => htmlspecialchars($_POST['languages'][$i]), 'ARTICLE_TITLE' =>  htmlspecialchars($_POST['titles'][$i]), 'ARTICLE_HASHTAGS' => htmlspecialchars($_POST['hashtags'][$i]), 'ARTICLE_BODY' => htmlspecialchars($_POST['descriptions'][$i])));
		}
		if($executed){
			if($_SESSION['active_user_access_level'] == 1){
				$_SESSION['msg'] = "<i class='fa fa-check-circle fa-lg'></i> &nbsp;Thank you for your post. We will publish it as soon as we review it. You will be notified through e-mail about the status of your article";		
			}
			else{
				if($status == 1){
					$_SESSION['msg'] = "<i class='fa fa-check-circle fa-lg'></i> &nbsp;Thank you for your post. Your post has been successfully published.";			
				}
				else{
					$_SESSION['msg'] = "<i class='fa fa-check-circle fa-lg'></i> &nbsp;Your post has been saved. You can publish it anytime from the review section.";			
				}
			}
		}
		else{
			$_SESSION['msg'] = "<h4 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Whoops!!, Something went wrong. Please try again later.</h4>";
		}
	}
	echo "<script>location.href='$base_url/home.php';</script>";
	die();
}









function save_article(){
	global $con;
	global $base_url;
	$article_id = htmlspecialchars($_POST['article-id']);
	$tags = htmlspecialchars($_POST['article-tags']);
	$location = htmlspecialchars($_POST['article-location']);
	$tile_type = htmlspecialchars($_POST['tile-type']);
	$ids = array();
	$fetch_ids = fetch_functions\get_row('article_translations','ARTICLE_ID',$article_id);
	foreach ($fetch_ids as $id) {
		array_push($ids, $id->TABLE_ID);
	}

	$prev_media = htmlspecialchars($_POST['current-media']);
	$media_type = htmlspecialchars($_POST['current-media-type']);
	$new_media_type = htmlspecialchars($_POST['media-type']);
	$media = "";
	if(!empty($media_type)){
		$tmp_media = $prev_media;
		if($media_type == "img") $prev_media = "../images/" . $prev_media;
		if($media_type == "vid") $prev_media = "../videos/" . $prev_media;
		if(basename($_FILES['file']['name']) == ""){
			if($new_media_type != "img" && $new_media_type != "vid")  $media = htmlspecialchars($_POST['link']);
			else $media = $tmp_media;
		}
		else{
			if($new_media_type == "img")  $folder = '../images/';
			elseif($new_media_type == "vid") $folder = '../videos/'; 
			$media = process_forms\move_file('file', $folder);
			if(!$media){
				$_SESSION['msg'] = "<h4 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Oh snap, Something went wrong. File could not be uploaded. Please try again later.</h4>";
			}
			else{
				unlink($prev_media);
			}
		}
	}
	
	// UPDATE THE ARTICLE IN THE DATABASE
	$stmt = $con->prepare("UPDATE articles SET ARTICLE_LOCATION = :ARTICLE_LOCATION, ARTICLE_TAGS = :ARTICLE_TAGS, ARTICLE_MEDIA = :ARTICLE_MEDIA, TILE_TYPE = :TILE_TYPE WHERE ARTICLE_ID = :ARTICLE_ID");
	$executed = $stmt->execute(array('ARTICLE_LOCATION' => $location, 'ARTICLE_TAGS' => $tags, 'ARTICLE_MEDIA' => $media, 'TILE_TYPE' => $tile_type, 'ARTICLE_ID' => $article_id));
	if($executed){
		$total_translations = sizeof($ids);
		$translations_posted = sizeof($_POST['titles']);
		$loop_count = min($total_translations,$translations_posted);
		for ($i = 0; $i < $loop_count; $i++) {
			$descriptions = nl2br($_POST['descriptions'][$i], false);
			$descriptions = str_replace("<br>", "</p><p>", $descriptions);
			$stmt = $con->prepare("UPDATE article_translations SET ARTICLE_LANGUAGE = :ARTICLE_LANGUAGE, ARTICLE_TITLE = :ARTICLE_TITLE, ARTICLE_HASHTAGS = :ARTICLE_HASHTAGS, ARTICLE_BODY = :ARTICLE_BODY WHERE TABLE_ID = :TABLE_ID");
			$executed = $stmt->execute(array('ARTICLE_LANGUAGE' => htmlspecialchars($_POST['languages'][$i]), 'ARTICLE_TITLE' =>  htmlspecialchars($_POST['titles'][$i]), 'ARTICLE_HASHTAGS' => htmlspecialchars($_POST['hashtags'][$i]), 'ARTICLE_BODY' => htmlspecialchars($descriptions), 'TABLE_ID' => $ids[$i]));
		}
		if($translations_posted != $total_translations){
			// SOME OF THE TRANSLATED COPIES HAS BEEN REMOVED OR ADDED
			if($total_translations > $translations_posted){
				// SOME OF THE TRANSLATED COPIES HAS BEEN REMOVED BY THE EDITOR 
				for($j = $i; $j < $total_translations; $j++){
					$stmt = $con->prepare("DELETE FROM article_translations WHERE TABLE_ID = :TABLE_ID");
					$stmt->execute(array('TABLE_ID' => $ids[$j]));
				}
			}
			else{
				// SOME OF THE TRANSLATED COPIES HAS BEEN ADDED BY THE EDITOR 
				for($j = $i; $j < $translations_posted; $j++){
					$stmt = $con->prepare("INSERT INTO article_translations (ARTICLE_ID, ARTICLE_LANGUAGE, ARTICLE_TITLE, ARTICLE_HASHTAGS, ARTICLE_BODY) VALUES (:ARTICLE_ID, :ARTICLE_LANGUAGE, :ARTICLE_TITLE, :ARTICLE_HASHTAGS, :ARTICLE_BODY)");
					$executed = $stmt->execute(array('ARTICLE_ID' => $article_id, 'ARTICLE_LANGUAGE' => htmlspecialchars($_POST['languages'][$j]), 'ARTICLE_TITLE' =>  htmlspecialchars($_POST['titles'][$j]), 'ARTICLE_HASHTAGS' => htmlspecialchars($_POST['hashtags'][$j]), 'ARTICLE_BODY' => htmlspecialchars($_POST['descriptions'][$j])));
				}
			}
		}	
	}
	if($executed){
		$_SESSION['msg'] = "<i class='fa fa-check-circle fa-lg'></i> &nbsp;You have successfully saved the article";
	}
	else{
		$_SESSION['msg'] = "<h4 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Whoops!!, Something went wrong. Please try again later.</h4>";
	}
	echo "<script>location.href = '$base_url/articles/reviews/details/?article=$article_id'</script>";
	die();
}









function publish_article(){
	global $con;
	global $base_url;
	$article_id = htmlspecialchars($_POST['article-id']);
	$editor_id = fetch_functions\get_row('users','USER_ID', $_SESSION['active_user_id'])[0]->EDITOR_ID;
	$stmt = $con->prepare("UPDATE articles SET ARTICLE_STATUS = :ARTICLE_STATUS, APPROVED_BY = :APPROVED_BY, PUBLISH_TIME = :PUBLISH_TIME WHERE ARTICLE_ID = :ARTICLE_ID");
	$executed = $stmt->execute(array('ARTICLE_STATUS' => 1, 'APPROVED_BY' => $editor_id, 'PUBLISH_TIME' => time(), 'ARTICLE_ID' => $article_id));
	if($executed){
		$_SESSION['msg'] = "<i class='fa fa-check-circle fa-lg'></i> &nbsp;The article has been posted on the landing page";
		$subject = "Your article got posted !!!";
		$message = "<p>Your article titled \"" . $_POST[titles][0] . "\" just got posted on the magazine.</p><p> Click on the following link to view the article</p><p><a href='$base_url/articles/?article=$article_id'>$base_url/articles/?article=$article_id</a></p><br><br>Thank you for your contribution<br>Team Zeybra Magazine.";
		$alt_body = "Your article titled \"" . $_POST[titles][0] . "\" just got posted on the magazine.Check out the following link to view the article : $base_url/articles/?article=$article_id. \nThank you from team Zeybra Magazine for your contribution.";
		$set_from = "noreply@zeybramag.com";
		$emailer_name = "Zeybramag";
		$send_mail = send_email($email,$subject,$message,$alt_body,$set_from,$emailer_name,'noreply@zeybramag.com','noreply_zeybramag123');
	}
	else{
		$_SESSION['msg'] = "<h4 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Whoops!!, Something went wrong. Please try again later.</h4>";
	}
	echo "<script>location.href='$base_url/articles/reviews/details/?article=$article_id';</script>";
	die();
}









function reject_article(){
	global $con;
	global $base_url;
	$article_id = htmlspecialchars($_POST['article-id']);

	// UPDATE THE ARTICLE IN THE DATABASE
	$editor_id = fetch_functions\get_row('users','USER_ID', $_SESSION['active_user_id'])[0]->EDITOR_ID;
	$stmt = $con->prepare("UPDATE articles SET ARTICLE_STATUS = :ARTICLE_STATUS, APPROVED_BY = :APPROVED_BY WHERE ARTICLE_ID = :ARTICLE_ID");
	$executed = $stmt->execute(array('ARTICLE_STATUS' => -1, 'APPROVED_BY' => $editor_id, 'ARTICLE_ID' => $article_id));
	if($executed){
		$_SESSION['msg'] = "<i class='fa fa-check-circle fa-lg'></i> &nbsp;You have rejected the article.";
	}
	else{
		$_SESSION['msg'] = "<h4 class='error-msg'><i class='fa fa-exclamation-triangle fa-lg'></i> &nbsp;Whoops!!, Something went wrong. Please try again later.</h4>";
	}
	echo "<script>location.href='$base_url/articles/reviews/details/?article=$article_id';</script>";
	die();
}









function retrieve_email(){
	global $con;
	global $base_url;
	$account_info = fetch_functions\get_row('users','USER_EMAIL', $_SESSION['active_user_email'])[0];
	$email = $account_info->USER_EMAIL;
	$token = $account_info->USER_ACCOUNT_STATUS;
	if($token != "verified"){
		$subject = "Registration Validation";
		$message = "<p>Thank you for registering to our magazine. You are just 1 step away. Please click on the following link to verify your account and get started. </p><p> <a href='$base_url/assets/functions/verify.php?account=$email&token=$token'>$base_url/assets/functions/verify.php?account=$email&token=$token</a></p><p>Cheers.</p>";
		$alt_body = "Thank you for registering to our magazine. You are just 1 step away. Please copy and paste following link to verify your account and get started : $base_url/assets/functions/verify.php?account=$email&token=$token";
		$set_from = "noreply@zeybramag.com";
		$emailer_name = "Zeybramag";
	}
	$send_mail = send_email($email,$subject,$message,$alt_body,$set_from,'noreply@zeybramag.com','noreply_zeybramag123');
	echo "true";
}









function send_email($to,$subject,$message,$alt_body,$set_from,$emailer_name,$user_email,$passcode){
	// $str = 
	// "<br>$message<br><br>";
	// $name = "Zeybra Magazine";
	// $email = "noreply@zeybramagazine.com";
 //    $headers = "MIME-Version: 1.0" . "\r\n";
 //    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
 //    $headers .= "From: $name <$email>" . "\r\n";
	
	// if(mail($to,$subject,$message,$headers)) return true;
	// else return false;
	$mail = new PHPMailer(true);                             
	try {
	    $mail->isSMTP();
	    $mail->Host = 'smtp.gmail.com'; 
	    $mail->SMTPAuth = true;                              
	    $mail->Username = "mashbu111@gmail.com";                
	    $mail->Password = "FormosaQQTea";                          
	    $mail->SMTPSecure = 'tsl';                           
	    $mail->Port = 587;                                   
	    $mail->setFrom("mashbu111@gmail.com", $emailer_name);
	    $mail->addAddress($to);    
	    $mail->isHTML(true);                                 
	    $mail->Subject = $subject;
	    $mail->Body    = $message;
	    $mail->AltBody = $alt_body;
	    $mail->send();
	    return true;
	} catch (Exception $e) {
		return false;
	}
}









function change_password(){
	global $con;
	$curr_pass = htmlspecialchars($_POST['curr-pass']);
	$new_pass = htmlspecialchars($_POST['new-pass']);
	$confirm_pass = htmlspecialchars($_POST['confirm-pass']);
	$password = $con->query("SELECT password FROM admin WHERE id = 1");
	$fetch = $password->fetch(\PDO::FETCH_OBJ);
	$password = $fetch->password;
	$str = hash('sha256', $curr_pass);
	if($str == $password){
		if($new_pass == $confirm_pass){
			$str = hash('sha256', $new_pass);
			$query = $con->query("UPDATE admin SET password = '$str' WHERE id = 1");
			if($query){
				header("Location:../admin/views/settings.php?mode=passwordchanged");
				die();
			}
			else{
				header("Location:../admin/views/settings.php?error_mode=unknownerror");
				die();
			}
		}
		else{
			header("Location:../admin/views/settings.php?error_mode=passwordmismatch");
			die();
		}
	}
	else{
		header("Location:../admin/views/settings.php?error_mode=wrongpassword");
		die();
	}
}









function change_article_language(){
	global $con;
	$article_id = htmlspecialchars($_GET['articleId']);	
	$language = htmlspecialchars($_GET['language']);
	$stmt = $con->prepare("SELECT * FROM article_translations WHERE ARTICLE_ID = :ARTICLE_ID AND ARTICLE_LANGUAGE = :ARTICLE_LANGUAGE LIMIT 1");
	$executed = $stmt->execute(array('ARTICLE_ID' => $article_id, 'ARTICLE_LANGUAGE' => $language));
	if($executed){
		$content = $stmt->fetch(\PDO::FETCH_OBJ);
		echo json_encode($content);
	}
}









function move_file($name,$temp_dir){
	$file_name = uniqid() . basename($_FILES[$name]['name']);
	$target_file = $temp_dir . $file_name;
    if (move_uploaded_file($_FILES[$name]["tmp_name"], $target_file))  return $file_name;    	
	else return false;
}