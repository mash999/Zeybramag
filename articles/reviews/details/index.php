<?php 
require '../../../assets/functions/functions.php';
include '../../../partials/header.php';
use magazine\fetch_functions;
if(!isset($_SESSION['active_user_access_level']) > 1){
	echo "<script>location.href = '$base_url/home.php';</script>";
}

if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])){
	echo "
	<div id='dialog-box' class='alert-dialog' style='display:block; z-index:99999;'>
		<div class='dialog-content lg-dialog-content'>
			<h4>$_SESSION[msg]</h4>
			<button class='btn btn-success btn-sm'>Ok, Thanks</button></div>
	</div>
	";
	$_SESSION['msg'] = "";
}

if(isset($_GET['article'])){
	$article_link = htmlspecialchars($_GET['article']);
	$stmt = $con->prepare("SELECT * FROM articles AS a JOIN article_translations AS at ON a.ARTICLE_ID = at.ARTICLE_ID WHERE a.ARTICLE_LINK = :ARTICLE_LINK");
	$stmt->execute(array('ARTICLE_LINK' => $article_link));
	$articles = $stmt->fetchAll(\PDO::FETCH_OBJ);
	$id = $articles[0]->ARTICLE_ID;
	$media = $articles[0]->ARTICLE_MEDIA;
	if(!$articles){
		echo "<script>location.href = '../';</script>";
	}
}
else{
	echo "<script>location.href = '../';</script>";
}

echo "<title>Update Article | $site_name</title>";
?>




<div class="article-forms col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<form id="article-review-form" action="<?php echo $base_url;?>/assets/functions/process-forms.php" method="post" enctype="multipart/form-data">
		<div class="form-buttons col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<h3>
				Article ID - <?php echo $articles[0]->ARTICLE_ID;?>
				<?php 
				if($articles[0]->ARTICLE_STATUS == 0) $status = "<span><i class='fa fa-spinner'></i> Pending</span>";
				if($articles[0]->ARTICLE_STATUS == 1) $status = "<span class='green'><i class='fa fa-check-circle green'></i> Approved</span>";
				if($articles[0]->ARTICLE_STATUS == -1) $status = "<span class='red'><i class='fa fa-times red'></i> Rejected</span>";
				echo $status;
				echo "<a href = '$base_url/articles/reviews/' class='pull-right'><i class='fa fa-arrow-left'></i>Back to reviews</a>";
				?>
			</h3>


			<label for="file-input" class="btn btn-default file-input img"><i class="fa fa-photo"></i><span>Add Photo</span></label>
			<label for="file-input" class="btn btn-default file-input vid"><i class="fa fa-video-camera"></i><span>Add Video</span></label>
			<input type="file" id="file-input" class="hidden" name="file">			
			<button type="button" id="show-link" class="btn btn-default"><i class="fa fa-chain"></i><span>Add Link</span></button>
			<button type="button" class="add-translation-box btn btn-default pull-right"><i class="fa fa-pencil-square-o"></i></button>


			<div class="all-flags">
				<?php 
				foreach ($articles as $a) {
					echo "<span class='flag flag-$a->ARTICLE_LANGUAGE'></span>";
				}
				?>
			</div> <!-- /all-flags -->

			
			<?php
			$type = ""; 
			$extension = pathinfo($articles[0]->ARTICLE_MEDIA, PATHINFO_EXTENSION);
			$img_extensions = array("jpg","jpeg","png","gif","tif","bmp","JPG","JPEG","PNG","GIF","TIF","BMP");
			$vid_extensions = array("mp4","webm","ogg","MP4","WEBM","OGG");
			$media = $articles[0]->ARTICLE_MEDIA;
			$multimedia = false;
			if(in_array($extension, $img_extensions)){
				$type = "img";
				$multimedia = true;
			}
			elseif(in_array($extension, $vid_extensions)){
				$type = "vid";
				$multimedia = true;
			}
			if(!$multimedia && !empty($media)){
				$type = "link";
			}
			?>


			<div class="small-inputs col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding">
				<?php 
				if($type == "link"){
				echo "
				<div id='link' style='display:block;'>
					<input type='text' id='link-input' name='link' class='form-control' placeholder='Provide A Link' value='$media'>;
				";
				}
				
				else{
				echo "
				<div id='link'>
					<input type='text' id='link-input' name='link' class='form-control' placeholder='Provide A Link'>
				";
				}
				?>
					<button type="button" id="hide-link" class="btn btn-default"><i class="fa fa-caret-up"></i></button>
				</div> <!-- /links -->


				<div id="preview-box" class="col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
					<?php 
					if($type == "img"){
						echo "<img src='../../../assets/images/$media' class='previews' id='preview-img' alt='preview img' style='display:block;'>";
					}
					else{
						echo "<img src='' class='previews' id='preview-img' alt='preview img'>";	
					}
					if($type == "vid"){
						echo "
						<video controls id='preview-video' class='previews' style='display:block;'>
							<source src='../../../assets/videos/$media'>
						</video>
						";
					}
					else{
						echo "<video controls id='preview-video' class='previews'><source src=''></video>";
					}
					if($type == "link"){
						$link_info = fetch_functions\get_link_info($articles[0]->ARTICLE_MEDIA);
						echo "<div id='link-preview' style='display:block;'>$link_info</div>";	
					}
					else{
						echo "<div id='link-preview'></div>";
					}
				?>
				</div> <!-- /preview-box -->
			</div> <!-- /small-inputs -->
		</div> <!-- /form-buttons -->



		<?php 
		$i = 1; 
		foreach($articles as $a){ 
			$file = file_get_contents('../../../partials/countries.php');
			$language_starting_from = explode("<option value=\"$a->ARTICLE_LANGUAGE\">", $file)[1];
			$language = explode("</option>", $language_starting_from)[0];
		?>

		<div class="form-inputs col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<label class="language-label">Country Language : <?php echo $language;?></label>
			<?php 
			if($i > 2){
				echo "<button class='btn btn-default remove-translated-article' type='button' onclick='deleteTranslationBox(this);'><i class='fa fa-trash'></i></button>";
			}
			?>
			<select class="languages" name="languages[]" onchange="languageChoice(this);" required>
				<option value="<?php echo $a->ARTICLE_LANGUAGE;?>"><?php echo $language;?></option>
				<?php include '../../../partials/countries.php';?>
			</select>
			<input type="text" name="titles[]" class="form-control article-title" placeholder="Article Title" value="<?php echo $a->ARTICLE_TITLE;?>" required minlength="10">
			<input type="text" name="hashtags[]" class="form-control article-hashtags" placeholder="Hastags (comma separated)" value="<?php echo $a->ARTICLE_HASHTAGS;?>" maxlength="500">

			<?php 
			$descriptions = str_replace("&lt;/p&gt;&lt;p&gt;", "", $a->ARTICLE_BODY);
			$descriptions = str_replace("\r\n", "\n", $descriptions);
			?>
			<textarea class="form-control article-body" name="descriptions[]" placeholder="Write down your article" minlength="10"><?php echo $descriptions;?></textarea>

		</div> <!-- /form-inputs -->
		<?php $i++; } ?>


		<div id="form-submit-info" class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="optional-inputs col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-left">
				<label for="location">Location &nbsp;<i class="fa fa-map-marker"></i></label>
				<input type="text" id="location" name="article-location" class="form-control" placeholder="Where this article belong to" value="<?php echo $articles[0]->ARTICLE_LOCATION;?>">
			</div>


			<div class="optional-inputs col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-right">
				<label for="tags">Tags &nbsp;<i class="fa fa-tags"></i></label>
				<input type="text" id="tags" name="article-tags" class="form-control" placeholder="Add tags (comma separated)" value="<?php echo $articles[0]->ARTICLE_TAGS;?>" maxlength="300">
			</div>


			<div class="tile-type">
				<h3>Tile Setup</h3>
				<select id="tile-type" name="tile-type" class="form-control" required>
					<option value="">Choose A Tile Type</option>
					<?php 
					if($articles[0]->TILE_TYPE == "article-type-1") echo "<option value='article-type-1' selected>Appear on Sidebar</option>";
					else echo "<option value='article-type-1'>Appear on Sidebar</option>";
					?>
					<optgroup label="Appear on Main Section">
						<?php 
						if($articles[0]->TILE_TYPE == "article-type-3") echo "<option value='article-type-3' selected>Video/Photo Only</option>";
						else echo "<option value='article-type-3'>Video/Photo Only</option>";

						if($articles[0]->TILE_TYPE == "article-type-4") echo "<option value='article-type-4' selected>Heading and Text Only</option>";
						else echo "<option value='article-type-4'>Heading and Text Only</option>";

						if($articles[0]->TILE_TYPE == "article-type-2") echo "<option value='article-type-2' selected>Video/Photo, Heading &amp; Little Text</option>";
						else echo "<option value='article-type-2'>Video/Photo, Heading &amp; Little Text</option>";
						?>
					</optgroup>
				</select>
			</div> <!-- /tile-type -->


			
			
			<div class="clearfix"></div>	
			<h3>
				<input type="hidden" name="current-media" value="<?php echo $media;?>">
				<input type="hidden" name="current-media-type" value="<?php echo $type;?>">
				<input type="hidden" id="type" name="media-type" value="<?php echo $type;?>">
				<input type="hidden" id="article-id" name="article-id" value="<?php echo $id;?>">
<!-- 				<button type="button" id="preview-article" class="btn btn-default">Preview</button> -->
				<button type="button" id="save-article" class="btn btn-success">Save</button>
				<?php if($articles[0]->ARTICLE_STATUS !=1) { ?>
				<button type="button" id="publish-article" class="btn btn-success">Publish</button>
				<?php } if($articles[0]->ARTICLE_STATUS != -1) { ?>
				<button type="submit" onclick="return confirm('Are you sure that you want to reject this article?');" class="btn btn-danger" name="reject-article">Reject</button>
				<?php } ?>
				<button type="submit" class="save-article submit-btn" name="save-article"></button>
				<button type="submit" class="publish-article submit-btn" name="publish-article"></button>
			</h3>
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

<?php include '../../../partials/footer.php';?>