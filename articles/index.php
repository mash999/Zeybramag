<?php 
require '../assets/functions/functions.php';
include '../partials/header.php';
use magazine\fetch_functions;
if(!isset($_GET['article'])){
	echo "<script> location.href = '$base_url/home.php'; </script>";
}
else{
	$article_link = htmlspecialchars($_GET['article']);
	$stmt = $con->prepare("SELECT * FROM articles AS a JOIN article_translations AS at ON a.ARTICLE_ID = at.ARTICLE_ID WHERE a.ARTICLE_LINK = :ARTICLE_LINK AND ARTICLE_STATUS = :ARTICLE_STATUS");
	$executed = $stmt->execute(array('ARTICLE_LINK' => $article_link, 'ARTICLE_STATUS' => 1));
	$articles = $stmt->fetchAll(\PDO::FETCH_OBJ);
	if(!$articles){
		echo "<script>location.href='$base_url';</script>";
	}
	$id = $articles[0]->ARTICLE_ID;
}

$img_exts = array("jpg","jpeg","png","gif","tif","bmp","JPG","JPEG","PNG","GIF","TIF","BMP");
$vid_exts = array("mp4","webm","ogg","MP4","WEBM","OGG");

$media = $articles[0]->ARTICLE_MEDIA;
if(empty($media)) { $media = ""; }
else{
	$ext = pathinfo($media)['extension'];
	if(in_array(strtolower($ext), $img_exts)){
		$media = "<img src='$base_url/assets/images/$media' alt='" . $articles[0]->ARTICLE_TITLE . "'>";
	}
	else if(in_array(strtolower($ext), $vid_exts)){
		$media = "<video controls src = '$base_url/assets/videos/$media'></video>";
	}
	else{
	    $tmp_media = $media;
		$media = fetch_functions\get_link_info($media);
		$media = "<a class='media-link-lg' href='$tmp_media' target='_blank'>$media</a>";
	}
}

$title = $articles[0]->ARTICLE_TITLE;
echo "<title>$title | $site_name</title>";
?>




<div class="full-article col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<h1 class="main-title"><?php echo $articles[0]->ARTICLE_TITLE;?></h1>
	<div class="article-detail col-lg-9 col-md-9 col-sm-9 col-xs-12 no-padding" data-article="<?php echo $id;?>">
		<div class="article-banner col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
			<?php 
			echo $media;
			$hashtags = $articles[0]->ARTICLE_HASHTAGS;
			if(!empty($hashtags)){
    			$hashtags = explode(",", $articles[0]->ARTICLE_HASHTAGS);
				$tmp = "";
				foreach ($hashtags as $h) {
					$tmp .= "<em>#" . trim($h) . "</em>";
				}
				$hashtags = $tmp;	
			}
			?>
			<div class="little-info col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
				<?php 
				if(!empty($hashtags)){
					echo "<p class='article-hashtags pull-left col-lg-7 col-md-7 col-sm-6 col-xs-12 no-padding'>$hashtags</p>";
				}
				if(!empty($articles[0]->ARTICLE_LOCATION)){
					echo "<p class='article-location col-lg-4 col-md-4 col-sm-5 col-xs-12 no-padding'><i class='fa fa-map-marker'></i> &nbsp;" . $articles[0]->ARTICLE_LOCATION . "</p>";
				}
				?>
			</div>
		</div> <!-- /article-banner -->



		<div class="article-content col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
			<div class="sharing col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-left">
				<?php $name = fetch_functions\get_row('users','USER_ID',$articles[0]->POSTED_BY)[0]->USER_NAME; ?>
				<p>
					By <strong><?php echo $name;?></strong> 
					<span>(<?php echo fetch_functions\post_time($articles[0]->PUBLISH_TIME);?> ago)</span>
				</p>
				
				<?php 
				$twitter_url = "https://twitter.com/intent/tweet?text=" . $articles[0]->ARTICLE_TITLE . "&hashtags=" . $articles[0]->ARTICLE_HASHTAGS . "&url=" . $base_url . $_SERVER['REQUEST_URI'];
				$fb_url = "https://www.facebook.com/sharer/sharer.php?u=" . $base_url . $_SERVER['REQUEST_URI'];
				$google_url = "https://plus.google.com/share?url=" . $base_url . $_SERVER['REQUEST_URI'];
				?>
				<a href="<?php echo $fb_url;?>" class="fb-icon" rel="nofollow" target="_blank"><i class="fa fa-facebook fa-lg"></i></a>
				<a href="<?php echo $twitter_url;?>" class="tt-icon" target="_blank"><i class="fa fa-twitter fa-lg"></i></a>
				<a href="<?php echo $google_url;?>" class="gp-icon" target="_blank"><i class="fa fa-google-plus fa-lg"></i></a>
				<a href="https://www.gmail.com/" class="email-icon"><i class="fa fa-envelope fa-lg"></i></a>
			</div> <!-- /sharing -->


			<div class="flags col-lg-6 col-md-6 col-sm-6 col-xs-12 no-padding-right">
				<p>
					<?php 
					foreach ($articles as $a) {
						$country_name = fetch_functions\get_row('countries','COUNTRY_CODE',$a->ARTICLE_LANGUAGE)[0]->COUNTRY_NAME;
						echo "<span data-toggle='tooltip' data-placement='top' title='" . $country_name . "' class='flag flag-" . $a->ARTICLE_LANGUAGE . "' data-language='" . $a->ARTICLE_LANGUAGE . "'></span>";
					}
					?>
				</p>
			</div> <!-- /flags -->
			

			<div class="clearfix"></div>
			
			<br>
			<div class="article-text"><?php echo "<p>" . htmlspecialchars_decode($articles[0]->ARTICLE_BODY);?></div>
		</div> <!-- /article-content -->
	</div> <!-- /article-detail -->




	<div class="more-articles">
		<?php 
		$stmt = $con->prepare("SELECT ARTICLE_ID,ARTICLE_LINK FROM articles WHERE ARTICLE_LINK != :ARTICLE_LINK ORDER BY PUBLISH_TIME DESC LIMIT 10");
		$executed = $stmt->execute(array('ARTICLE_LINK' => $article_link));
		if($executed){
			$recent_ids = $stmt->fetchAll(\PDO::FETCH_OBJ);
			foreach ($recent_ids as $rids) {
				$recent_articles = fetch_functions\get_row('article_translations','ARTICLE_ID',$rids->ARTICLE_ID);
				$id = $recent_articles[0]->ARTICLE_ID;
				$article_link = $rids->ARTICLE_LINK;
				$title = $recent_articles[0]->ARTICLE_TITLE;
				echo "
				<div class='this-article' data-article = '$id'>
					<h1>
						<a target='_blank' href='$base_url/articles/?article=$article_link'>$title</a>
					</h1>
					<div class='clearfix'></div>
					<div class='border-bottom language-availability'>";
					foreach ($recent_articles as $ra) {
						$country_name = fetch_functions\get_row('countries','COUNTRY_CODE',$ra->ARTICLE_LANGUAGE)[0]->COUNTRY_NAME;
						echo "<span data-toggle='tooltip' data-placement='top' title='" . $country_name . "' class='flag flag-" . $ra->ARTICLE_LANGUAGE . "' data-language='" . $ra->ARTICLE_LANGUAGE . "'></span>";
					}
					echo "
					</div>
				</div>
				";
			}
		}
		?>
	</div> <!-- /more-articles -->
</div> <!-- /full-article -->




<?php include '../partials/footer.php';?>