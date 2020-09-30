<?php
require_once 'functions.php';
use magazine\fetch_functions;
if(isset($_GET['token']) && isset($_GET['account'])){
	global $con;
	$email = htmlspecialchars($_GET['account']);
	$token = htmlspecialchars($_GET['token']);
	$account_info = fetch_functions\get_row('users','USER_EMAIL',$email)[0];
	if($account_info->USER_ACCOUNT_STATUS == $token){
		$stmt = $con->prepare("UPDATE users SET USER_ACCOUNT_STATUS = :ACCOUNT_STATUS WHERE USER_EMAIL = :USER_EMAIL AND USER_ACCOUNT_STATUS = :USER_ACCOUNT_STATUS");
		$executed = $stmt->execute(array('ACCOUNT_STATUS' => 'verified', 'USER_EMAIL' => $email, 'USER_ACCOUNT_STATUS' => $token));
		if($executed){
			$_SESSION['msg'] = "Great!!! Your account is now verified. Let's get started";
			$_SESSION['active_user_id'] = $account_info->USER_ID;
			$_SESSION['active_user_email'] = $account_info->USER_EMAIL;
			$_SESSION['active_user_access_level'] = $account_info->USER_ACCESS_LEVEL;
			$_SESSION['active_user_name'] = $account_info->USER_NAME;
			echo "<script>location.href = '$base_url/home.php'; </script>";
		}
	}
}





if(isset($_GET['subscription'])){
	global $con;
	$subscriber_id = htmlspecialchars($_GET['subscriber']);
	if(!empty($_SESSION['zeybramag_subscription_email'])){
		$email = $_SESSION['zeybramag_subscription_email'];
		$_SESSION['zeybramag_subscription_email'] = "";
		$stmt = $con->prepare("UPDATE subscribers SET SUBSCRIBER_STATUS = :SUBSCRIBER_STATUS WHERE SUBSCRIBER_EMAIL = :SUBSCRIBER_EMAIL");
		$executed = $stmt->execute(array('SUBSCRIBER_STATUS' => 1, 'SUBSCRIBER_EMAIL' => $email));
		if($executed){
			$_SESSION['msg'] = "<div class='message-for-subscribers'><p>Great!!! Your account is verified. Let's get started.</p><p><strong>Please note that you can update your preference center only once and it can not be updated as a subscriber.</strong> To have access to a customizable preference center, please join zeybramag and update your preference center again and again</p><p><a href='http://www.zeybramag.com' target='_blank'>I WANNA JOIN</a></p></div>";	
			
			echo "<script>location.href = '$base_url/subscribe/preference-center/?subscriber=$subscriber_id'; </script>";
		}
	}
}
?>