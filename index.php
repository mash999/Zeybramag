<?php 
session_start(); 
//error_reporting(0);
try{
	$con = new PDO('mysql:host=localhost;dbname=magazine','root','');
	$con->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e){
	echo "ERROR : " . $e->getMessage();
}


if(isset($_POST['save-guests'])){
	$name = htmlspecialchars($_POST['name']);
	$email = htmlspecialchars($_POST['email']);
	$city = htmlspecialchars($_POST['city']);
	$stmt = $con->prepare("INSERT INTO guests (GUEST_EMAIL, GUEST_NAME, GUEST_CITY) VALUES (:GUEST_EMAIL, :GUEST_NAME, :GUEST_CITY)");
	$executed = $stmt->execute(array('GUEST_EMAIL' => $email, 'GUEST_NAME' => $name, 'GUEST_CITY' => $city));
	if($executed){
		$_SESSION['msg'] = "<h2 class='success-msg'><i class='fa fa-check-circle fa-lg'></i> &nbsp;Youuuuuu've got mail! Check your e-mail for confirmation. Thanks!</h2>";
		$message = 
		"
		<div>
			<p>We hear ya! We've got your name on the list. Now keep your eyes open for the Zeybras near you. More details to follow soon.....</p>
			<img src='three-zeybra.jpg' style='width:200px; height: auto;'> 
		</div>	
		";
		$send_mail = send_email($email,"Welcome to Zeybramag",$message);
	}
	else{
		$_SESSION['msg'] = "<h2 class='error-msg'><i class='fa fa-times fa-lg'></i> &nbsp;This is embarrasing. Something went wrong. Please try again later.</h2>";
	}
}



function send_email($to,$subject,$message){
	$str = 
	"<br>$message<br><br>";
	$name = "Zeybra Magazine";
	$email = "noreply@zeybramagazine.com";
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: $name <$email>" . "\r\n";
	
	if(mail($to,$subject,$message,$headers)) return true;
	else return false;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Welcome to Zeybra Magazine</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalability=0">
	<link href="https://fonts.googleapis.com/css?family=Londrina+Solid" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	
	<style>
		#page-wrapper { width: 100%; max-width: 1366px; text-align: center; margin: auto; overflow-x: hidden; }
		h2.success-msg { font-size: 23px; color: #00b22d; }
		h2.error-msg { font-size: 23px; color: red; }
		#zeybra-logo { width: auto; max-width: 700px; }
		@media only screen and (max-width: 750px){
			#zeybra-logo { max-width: 100%; }
		}
		#join-button { width: 252px; height: 53px; background: #C4C4C4; border: 1px solid rgba(210, 8, 130, 0.2); box-sizing: border-box; font-family: Londrina Solid; font-size: 24px; color: #4F4F4F; }
		p { font-family: 'Roboto',sans-serif; line-height: 25px; font-size: 17px; text-align: center; color: #4F4F4F; }
		a#register-now { text-decoration: underline; color: #4F4F4F; }
		a#register-now:hover { color: #333; }
		#developers-entry { width: 150px; height: 40px; background: #F2F2F2; border: 1px solid #E5E5E5; color: #4F4F4F; font-family: Roboto; font-size: 15px; margin-top: 30px; }
	</style>
</head>
<body>
	<div id="page-wrapper">
		<?php 
		if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])){
			echo $_SESSION['msg'];
			$_SESSION = "";
		}
		?>
		<img id="zeybra-logo" src="assets/images/zeybra-logo.png" alt="zeybra-magazine"><br><br>
		<button id="join-button" data-toggle="modal" data-target="#login-modal">I WANNA JOIN</button>
		<br><br><br>

		<p>Imagine a place to freely express yourself.<br>She’s going to liberate your mind.</p><br>
	 	<p>
	 		<strong>20 VIP guests gain free access</strong> to the <strong>official launch party</strong>.<br>
	 		A magical location - join the journey.<br>
	 		<a id="register-now" href="#" data-toggle="modal" data-target="#login-modal"><strong>Register Now</strong></a>
	 	</p>

	 	<!-- <button id="developers-entry" data-toggle="modal" data-target="#login-modal">Developers Entry</button> -->
	</div> <!-- /page-wrapper -->	


	
	
	 <!-- Modal -->
    <div class="modal fade" id="login-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Please Provide the Following Information</h4>
                </div>
                
                <form action="" method="post" class="modal-body">
                    <div class="form-group">
                        <label>Your Name</label>
                        <input type="name" class="form-control" name="name" placeholder="Full Name">
                    </div>

                    <div class="form-group">
                        <label>E-mail ID</label>
                        <input type="text" class="form-control" name="email" placeholder="E-mail Address">
                    </div>
                    
                    <div class="form-group">
                        <label>Your City</label>
                        <input type="city" class="form-control" name="city" placeholder="City">
                    </div>
                    
                    <div class="form-group">
                        <button type="submit" name="save-guests" class="btn btn-default btn-sm">Submit</button>
                    </div>
                </form>
            </div> <!-- /modal-content -->
        </div> <!-- /modal-dialog -->
  	</div>  <!-- /modal -->




	<script>
		$(window).on('load',function(){ middleContent(); });
		$(window).resize(function(){ middleContent(); });
		function middleContent(){
			$('#page-wrapper').css('margin-top','0');
			var winheight = $(window).height(),
				contentHeight = $('#page-wrapper').height(),
				marginTop = Math.abs((winheight - contentHeight) / 2);
			console.log(winheight);
			console.log(contentHeight);
			$('#page-wrapper').css('margin-top',marginTop);
		}
	</script>
</body>
</html>