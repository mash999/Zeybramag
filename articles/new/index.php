<?php 
require '../../assets/functions/functions.php';
include '../../partials/header.php';
use magazine\fetch_functions;
if(!isset($_SESSION['active_user_id'])){
	echo "<script>location.href = '$base_url/registrations/?login';</script>";
}
echo "<title>New Article | $site_name</title>";
?>

<div class="article-forms col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<?php 
	$account_status = "";
	if($_SESSION['active_user_access_level'] < 2 ){
		$user = fetch_functions\get_row('users', 'USER_ID', $_SESSION['active_user_id'])[0];
		$account_status = trim($user->USER_ACCOUNT_STATUS);
		if(strtolower($account_status) != "verified"){
			echo "
			<h2 id='non-verified-account'>
				** It seems that your account hasn't been verified yet. Please check your email for verification link. You will be able to
				post articles once you verify your account. If you didn't get the e-mail or lost it, click the button to retrieve 
				<br><br>
				<button id='retrieve-email' class='btn btn-primary btn-sm'>Resend verification link</button>
				<i class='fa fa-spinner fa-spin hidden'></i>
				<br><br>
			</h2>
			";	
		}
	}
	?>




	<form action="<?php echo $base_url;?>/assets/functions/process-forms.php" method="post" enctype="multipart/form-data">
		<div class="form-buttons col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>
				<?php $posted_article = fetch_functions\get_rows('articles','POSTED_BY',$_SESSION['active_user_id']);?>
				Your contribution is what makes zeybramag great.
				<a href="#" class="pull-right">You have posted <?php echo sizeof($posted_article);?> articles till now</a>
			</h3>

			<label for="file-input" class="btn btn-default file-input img"><i class="fa fa-photo"></i><span>Add Photo</span></label>
			<label for="file-input" class="btn btn-default file-input vid"><i class="fa fa-video-camera"></i><span>Add Video</span></label>
			<input type="hidden" id="type" name="media-type" value="">
			<input type="file" id="file-input" class="hidden" name="file">			
			<button type="button" id="show-link" class="btn btn-default"><i class="fa fa-chain"></i><span>Add Link</span></button>
<!-- 			<button type="button" id="show-tags" class="btn btn-default"><i class="fa fa-tags"></i> &nbsp; Add Tags</button> -->
			<button type="button" class="add-translation-box btn btn-default pull-right"><i class="fa fa-pencil-square-o"></i></button>
		
			<div class="all-flags"><span class="flag flag-us"></span></div>


			<div class="small-inputs col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding">
				<div id="link">
					<input type="text" id="link-input" name="link" class="form-control" placeholder="Provide A Link">
					<button type="button" id="hide-link" class="btn btn-default"><i class="fa fa-caret-up"></i></button>
				</div> <!-- /links -->


				<!-- <div id="tags">
					<input type="text" id="tags-input" name="tags" class="form-control" placeholder="Add tags (comma separated)">
					<button type="button" id="hide-tags" class="btn btn-default"><i class="fa fa-caret-up"></i></button>
				</div> --> <!-- /tags -->


				<div id="preview-box" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
					<img src="" class="previews" id="preview-img" alt="preview img">
					<video controls id="preview-video" class="previews"><source src=""></video>
					<div id="link-preview"></div>
				</div> <!-- /preview-box -->


			</div> <!-- /small-inputs -->
		</div> <!-- /form-buttons -->




		<div class="form-inputs col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label class="language-label">Country Language : English</label>
			<select class="languages" name="languages[]" onchange="languageChoice(this);" required>
				<option value="us">United States</option>
				<?php include '../../partials/countries.php';?>
			</select>
			<input type="text" name="titles[]" class="form-control article-title" placeholder="Article Title" required minlength="10">
			<input type="text" name="hashtags[]" class="form-control article-hashtags" placeholder="Hastags (comma separated)" maxlength="500">
			<textarea class="form-control article-body" name="descriptions[]" placeholder="Write down your article" minlength="10"></textarea>
		</div> <!-- /form-inputs -->


	

		<div class="form-inputs col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label>Choose Language</label>
			<select class="languages" name="languages[]" onchange="languageChoice(this);" required>
				<option value="">Choose Language</option>
				<?php include '../../partials/countries.php';?>
			</select>
			<input type="text" name="titles[]" class="form-control article-title" placeholder="Article Title" required minlength="10">
			<input type="text" name="hashtags[]" class="form-control article-hashtags" placeholder="Hastags (comma separated)" maxlength="500">
			<textarea class="form-control article-body" name="descriptions[]" placeholder="Write down your article" minlength="10"></textarea>
		</div> <!-- /form-inputs -->


		<div id="form-submit-info" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="optional-inputs col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-left">
				<label for="location">Location &nbsp;<i class="fa fa-map-marker"></i></label>
				<input type="text" id="map-locations" name="article-location" class="form-control" placeholder="Where this article belong to">
			</div>


			<div class="optional-inputs col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-right">
				<label for="tags">Tags &nbsp;<i class="fa fa-tags"></i></label>
				<input type="text" id="tags" name="article-tags" class="form-control" placeholder="Add tags (comma separated)" maxlength="300">
			</div>

			<?php if($_SESSION['active_user_access_level'] == 2) { ?>
			<div class="tile-type">
				<h3>Tile Setup</h3>
				<select id="tile-type" name="tile-type" class="form-control" required>
					<option value="">Choose A Tile Type</option>
					<option value="article-type-1">Appear on Sidebar</option>
					<optgroup label="Appear on Main Section">
						<option value="article-type-3">Video/Photo Only</option>
						<option value="article-type-4">Heading and Text Only</option>
						<option value="article-type-2">Video/Photo, Heading &amp; Little Text</option>
					</optgroup>
				</select>
			</div> <!-- /tile-type -->
			<?php } ?>
			
			<div class="clearfix"></div>	
			<?php if(strtolower($account_status) == "verified"){ ?>
			<h3>
				All Done? Submit the article for reviewing&nbsp;&nbsp;
				<button type="submit" id="submit-article-btn" class="btn btn-success" name="submit-new-article">Submit</button>
			</h3>
			<?php } else if($_SESSION['active_user_access_level'] == 2) {?>
			<h3>
				<input type="hidden" id="status-val" name="status" value="1">
				<button type="button" id="save-article" class="btn btn-success">Save</button>
				<button type="button" id="publish-article" class="btn btn-success">Save &amp; Publish</button>
				<button type="submit" class="save-article submit-btn" name="submit-new-article"></button>
				<button type="submit" class="publish-article submit-btn" name="submit-new-article"></button>
			</h3>
			<?php } ?>

		</div>
	</form>
</div> <!-- /article-forms -->









<div id="dialog-box" class="alert-dialog">
	<div class="dialog-content sm-dialog-content">
		<h4></h4>
		<p></p>
		<button class="btn btn-primary btn-sm">Ok, Gotcha !!</button>
	</div> <!-- /dialog-content -->
</div> <!-- /dialog-box -->

<?php include '../../partials/footer.php';?>