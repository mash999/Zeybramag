<?php 
require 'assets/functions/functions.php';
require 'partials/header.php';
use magazine\fetch_functions;

if(isset($_SESSION['msg']) && !empty($_SESSION['msg'])){
	echo "
	<div id='dialog-box' class='alert-dialog' style='display:block;'>
		<div class='dialog-content lg-dialog-content'>
			<h4>$_SESSION[msg]</h4>
			<button class='btn btn-success btn-sm'>Ok, Thanks</button></div>
	</div>
	";
	$_SESSION['msg'] = "";
}
$img_exts = array("jpg","jpeg","png","gif","tif","bmp","JPG","JPEG","PNG","GIF","TIF","BMP");
$vid_exts = array("mp4","webm","ogg","MP4","WEBM","OGG");

echo "<title>$site_name</title>";
?>


<div class="sidebar">
	<?php 
	$stmt = $con->prepare("SELECT * FROM articles WHERE ARTICLE_STATUS = :ARTICLE_STATUS AND TILE_TYPE = :TILE_TYPE ORDER BY PUBLISH_TIME DESC");
	$executed = $stmt->execute(array('ARTICLE_STATUS' => 1, 'TILE_TYPE' => 'article-type-1'));
	$articles = $stmt->fetchAll(\PDO::FETCH_OBJ);

	foreach ($articles as $a) {
		$stmt = $con->prepare("SELECT * FROM article_translations WHERE ARTICLE_ID = :ARTICLE_ID");
		$executed = $stmt->execute(array('ARTICLE_ID' => $a->ARTICLE_ID));	
		$id = $a->ARTICLE_ID;
		$article_link = $a->ARTICLE_LINK;
		$translations = $stmt->fetchAll(\PDO::FETCH_OBJ);
		$title = $translations[0]->ARTICLE_TITLE;
		$body = $translations[0]->ARTICLE_BODY;
		$body = substr($body, 0, 142);
		$hashtags = trim($translations[0]->ARTICLE_HASHTAGS);
		if(!empty($hashtags)){
			$hashtags = explode(",", $hashtags);
			$tmp = "";
			foreach ($hashtags as $h) {
				$tmp .= "<em>#" . $h . "</em>";
			}
			$hashtags = $tmp;	
		}
		$location = $a->ARTICLE_LOCATION;
		if(!empty($location)){
			$location = "<i class='fa fa-map-marker fa-lg'></i> &nbsp; $location";
		}
		$time = fetch_functions\post_time($a->PUBLISH_TIME);
		$media = $a->ARTICLE_MEDIA;
	
		if(empty($media)) { $media = ""; }
		else{
			$ext = pathinfo($media)['extension'];
			if(in_array($ext, $img_exts)){
				$media = "<img src='$base_url/assets/images/$media' alt='Article Thumbnail'>";
			}
			else if(in_array($ext, $vid_exts)){
				$media = "<video controls src = '$base_url/assets/videos/$media'></video>";
			}
			else{
				$link = $a->ARTICLE_MEDIA;
				$media = fetch_functions\get_link_info($link);
				$media = "<a class='media-link' href='$link' target='_blank'>$media</a>";
			}
		}
	
		echo "	
		<div class='article this-article article-type-1' data-article='$id'>
			<a href='$base_url/articles/?article=$article_link' target='_blank'><h1>$title</h1></a>
			<div class='this-article-text'><p>$body</p></div>
			$media
			<div class='spans'>
				<span class='hashtags'>$hashtags</span>
				<span class='locations'>$location</span>
				<span class='post-time'>$time ago</span>
			</div> <!-- /spans -->
			<div class='language-availability'>";
			foreach ($translations as $t) {
				$country_name = fetch_functions\get_row('countries','COUNTRY_CODE',$t->ARTICLE_LANGUAGE)[0]->COUNTRY_NAME;
				echo "<span data-toggle='tooltip' data-placement='top' title='" . $country_name . "' class='flag flag-" . $t->ARTICLE_LANGUAGE . "' data-language='" . $t->ARTICLE_LANGUAGE . "'></span>";
			}
			echo "
				<div class='different-language-translation'>Translating ... <i class='fa fa-spinner fa-spin'></i></div>
			</div> <!-- /language-availability -->
		</div> <!-- /article -->
		";
	}
	?>
</div> <!-- /sidebar -->









<div class="article-thumbnails">	
	<?php 
	$stmt = $con->prepare("SELECT * FROM articles WHERE ARTICLE_STATUS = :ARTICLE_STATUS AND TILE_TYPE IS NOT NULL AND TILE_TYPE != :TILE_TYPE ORDER BY PUBLISH_TIME DESC");
	$executed = $stmt->execute(array('ARTICLE_STATUS' => 1, 'TILE_TYPE' => 'article-type-1'));
	$articles = $stmt->fetchAll(\PDO::FETCH_OBJ);
	foreach ($articles as $a) {
		$stmt = $con->prepare("SELECT * FROM article_translations WHERE ARTICLE_ID = :ARTICLE_ID");
		$executed = $stmt->execute(array('ARTICLE_ID' => $a->ARTICLE_ID));	
		$id = $a->ARTICLE_ID;
		$article_link = $a->ARTICLE_LINK;
		$translations = $stmt->fetchAll(\PDO::FETCH_OBJ);
		$title = $translations[0]->ARTICLE_TITLE;
		$body = $translations[0]->ARTICLE_BODY;
		$body = substr($body, 0, 142);
		$hashtags = trim($translations[0]->ARTICLE_HASHTAGS);
		if(!empty($hashtags)){
			$hashtags = explode(",", $hashtags);
			$tmp = "";
			foreach ($hashtags as $h) {
				$tmp .= "<em>#" . $h . "</em>";
			}
			$hashtags = $tmp;	
		}
		$location = $a->ARTICLE_LOCATION;
		if(!empty($location)){
			$location = "<i class='fa fa-map-marker fa-lg'></i> &nbsp; $location";
		}
		$time = fetch_functions\post_time($a->PUBLISH_TIME);
		$media = $a->ARTICLE_MEDIA;
		if(empty($media)) { $media = ""; }
		else{
			$ext = pathinfo($media)['extension'];
			if(in_array($ext, $img_exts)){
				$media = "<img src='$base_url/assets/images/$media' alt='Article Thumbnail'>";
			}
			else if(in_array($ext, $vid_exts)){
				$media = "<video controls src = '$base_url/assets/videos/$media'></video>";
			}
			else{
				$link = $a->ARTICLE_MEDIA;
				$media = fetch_functions\get_link_info($link);
				$media = "<a class='media-link' href='$link' target='_blank'>$media</a>";
			}
		}




		if($a->TILE_TYPE == "article-type-2"){
			echo "
			<div class='article this-article article-type-2' data-article='$id'>
				<div class='article-type-2-image'>
					<a href='$base_url/articles/?article=$article_link' target='_blank'>$media</a>
				</div> <!-- /article-image -->
				
				<h1>$title</h1>
				<div class='this-article-text'><p>$body</p></div>
				<div class='spans'>
					<span class='hashtags'>$hashtags</span>
					<span class='locations'>$location</span>
					<span class='post-time'>$time ago</span>
				</div> <!-- /spans -->
				<div class='language-availability'>";
				foreach ($translations as $t) {
					$country_name = fetch_functions\get_row('countries','COUNTRY_CODE',$t->ARTICLE_LANGUAGE)[0]->COUNTRY_NAME;
					echo "<span data-toggle='tooltip' data-placement='top' title='" . $country_name . "' class='flag flag-" . $t->ARTICLE_LANGUAGE . "' data-language='" . $t->ARTICLE_LANGUAGE . "'></span>";
				}
				echo "
					<div class='different-language-translation'>Translating ... <i class='fa fa-spinner fa-spin'></i></div>
				</div> <!-- /language-availability -->
			</div> <!-- /article -->
			";
		}




		if($a->TILE_TYPE == "article-type-3"){
			echo "		
			<div class='article double-article'>
				<div class='article-type-3'>
					<a href='$base_url/articles/?article=$article_link' target='_blank'>$media</a>
					<div class='spans'>
						<span class='hashtags'>$hashtags</span>
						<span class='locations'>$location</span>
						<span class='post-time'>$time ago</span>
					</div> <!-- /spans --> 
				</div> <!-- /article-type-3 -->
			</div> <!-- double-article -->
			";
		}




		if($a->TILE_TYPE == "article-type-4"){
			echo "
			<div class='article double-article'>
				<div class='article-type-4 this-article' data-article='$id'>
					<a href='$base_url/articles/?article=$article_link' target='_blank'><h1>$title</h1></a>
					<div class='this-article-text'><p>$body</p></div>
					<div class='spans'>
						<span class='hashtags'>$hashtags</span>
						<span class='locations'>$location</span>
						<span class='post-time'>$time ago</span>
					</div> <!-- /spans -->
					<div class='language-availability'>";
					foreach ($translations as $t) {
						$country_name = fetch_functions\get_row('countries','COUNTRY_CODE',$t->ARTICLE_LANGUAGE)[0]->COUNTRY_NAME;
						echo "<span data-toggle='tooltip' data-placement='top' title='" . $country_name . "' class='flag flag-" . $t->ARTICLE_LANGUAGE . "' data-language='" . $t->ARTICLE_LANGUAGE . "'></span>";
					}
					echo "
						<div class='different-language-translation'>Translating ... <i class='fa fa-spinner fa-spin'></i></div>
					</div> <!-- /language-availability -->
				</div> <!-- /article-type-4 -->
			</div> <!-- double-article -->
			";
		}

	} // end foreach
	?>

</div> <!-- /article-thumbnails -->



<?php include 'partials/footer.php';?>