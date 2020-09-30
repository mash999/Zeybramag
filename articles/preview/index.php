<?php 
require '../../partials/header.php';
require '../../assets/functions/functions.php';
use magazine\fetch_functions;
if(!isset($_SESSION['currently_active_editor'])){
	echo "<script>location.href = '$base_url';</script>";
}

$img_exts = array("jpg","jpeg","png","gif","tif","bmp");
$vid_exts = array("mp4","webm","ogg");

if(isset($_GET['article']) && isset($_GET['type'])){
	$id = htmlspecialchars($_GET['article']);
	$type = htmlspecialchars($_GET['type']);
	$stmt = $con->prepare("SELECT * FROM articles AS a JOIN article_translations at ON a.ARTICLE_ID = at.ARTICLE_ID WHERE a.ARTICLE_ID = :ARTICLE_ID LIMIT 1");
	$executed = $stmt->execute(array('ARTICLE_ID' => $id));
	$preview_article = $stmt->fetchAll(\PDO::FETCH_OBJ);
	$preview_article[0]->TILE_TYPE = $type;
}
else{
	header("Location:$base_url");
}

echo "<title>Preview Article | $site_name</title>";
?>

<div class="sidebar">
	<?php 
	$stmt = $con->prepare("SELECT * FROM articles WHERE ARTICLE_STATUS = :ARTICLE_STATUS AND TILE_TYPE = :TILE_TYPE");
	$executed = $stmt->execute(array('ARTICLE_STATUS' => 1, 'TILE_TYPE' => 'article-type-1'));
	$articles = $stmt->fetchAll(\PDO::FETCH_OBJ);
	if($type == "article-type-1"){
		array_unshift($articles, $preview_article[0]);
	}
	foreach ($articles as $a) {
		$stmt = $con->prepare("SELECT * FROM article_translations WHERE ARTICLE_ID = :ARTICLE_ID");
		$executed = $stmt->execute(array('ARTICLE_ID' => $a->ARTICLE_ID));	
		$id = $a->ARTICLE_ID;
		$translations = $stmt->fetchAll(\PDO::FETCH_OBJ);
		$title = $translations[0]->ARTICLE_TITLE;
		$body = htmlspecialchars_decode($translations[0]->ARTICLE_BODY);
		$body = substr($body, 0, 142);
		$hashtags = explode(",", $translations[0]->ARTICLE_HASHTAGS);
		$tmp = "";
		foreach ($hashtags as $h) {
			$tmp .= "<em>#" . $h . "</em>";
		}
		$hashtags = $tmp;
		$location = $a->ARTICLE_LOCATION;
		$time = $a->PUBLISH_TIME;
		$media = $a->ARTICLE_MEDIA;
	
		if(empty($media)) { $media = ""; }
		else{
			$ext = pathinfo($media)['extension'];
			if(in_array(strtolower($ext), $img_exts)){
				$media = "<img src='$base_url/assets/images/$media' alt='Article Thumbnail'>";
			}
			else if(in_array(strtolower($ext), $vid_exts)){
				$media = "<video src = '$base_url/assets/videos/$media'></video>";
			}
			else{
				$media = "<a class='media-link' href='$media' target='_blank'>$media</a>";
			}
		}
	
		echo "	
		<div class='article this-article article-type-1' data-article='$id'>
			<h1><a href='$base_url/articles/?article=$id' target='_blank'>$title</a></h1>
			<div class='this-article-text'><p>$body</p></div>
			$media
			<div class='spans'>
				<span class='hashtags'>$hashtags</span>
				<span class='locations'><i class='fa fa-map-marker fa-lg'></i> &nbsp; $location</span>
				<span class='post-time'>$time ago</span>
			</div> <!-- /spans -->
			<div class='language-availability'>";
			foreach ($translations as $t) {
				echo "<span class='flag flag-" . $t->ARTICLE_LANGUAGE . "' data-language='" . $t->ARTICLE_LANGUAGE . "'></span>";
			}
			echo "
			</div> <!-- /language-availability -->
		</div> <!-- /article -->
		";
	}
	?>
</div> <!-- /sidebar -->









<div class="article-thumbnails">	
	<?php 
	$stmt = $con->prepare("SELECT * FROM articles WHERE ARTICLE_STATUS = :ARTICLE_STATUS AND TILE_TYPE IS NOT NULL AND TILE_TYPE != :TILE_TYPE");
	$executed = $stmt->execute(array('ARTICLE_STATUS' => 1, 'TILE_TYPE' => 'article-type-1'));
	$articles = $stmt->fetchAll(\PDO::FETCH_OBJ);
	if($type != "article-type-1"){
		array_unshift($articles, $preview_article[0]);
	}
	foreach ($articles as $a) {
		$stmt = $con->prepare("SELECT * FROM article_translations WHERE ARTICLE_ID = :ARTICLE_ID");
		$executed = $stmt->execute(array('ARTICLE_ID' => $a->ARTICLE_ID));	
		$id = $a->ARTICLE_ID;
		$translations = $stmt->fetchAll(\PDO::FETCH_OBJ);
		$title = $translations[0]->ARTICLE_TITLE;
		$body = htmlspecialchars_decode($translations[0]->ARTICLE_BODY);
		$body = substr($body, 0, 142);
		$hashtags = explode(",", $translations[0]->ARTICLE_HASHTAGS);
		$tmp = "";
		foreach ($hashtags as $h) {
			$tmp .= "<em>#" . $h . "</em>";
		}
		$hashtags = $tmp;
		$location = $a->ARTICLE_LOCATION;
		$time = $a->PUBLISH_TIME;
		$media = $a->ARTICLE_MEDIA;
		if(empty($media)) { $media = ""; }
		else{
			$ext = pathinfo($media)['extension'];
			if(in_array(strtolower($ext), $img_exts)){
				$media = "<img src='$base_url/assets/images/$media' alt='Article Thumbnail'>";
			}
			else if(in_array(strtolower($ext), $vid_exts)){
				$media = "<video src = '$base_url/assets/videos/$media'></video>";
			}
			else{
				$media = "<a class='media-link' href='$media' target='_blank'>$media</a>";
			}
		}




		if($a->TILE_TYPE == "article-type-2"){
			echo "
			<div class='article this-article article-type-2' data-article='$id'>
				<div class='article-type-2-image'>
					$media
				</div> <!-- /article-image -->
				
				<h1><a href='$base_url/articles/?article=$id' target='_blank'>$title</a></h1>
				<div class='this-article-text'><p>$body</p></div>
				<div class='spans'>
					<span class='hashtags'>$hashtags</span>
					<span class='locations'><i class='fa fa-map-marker fa-lg'></i> &nbsp; $location</span>
					<span class='post-time'>$time ago</span>
				</div> <!-- /spans -->
				<div class='language-availability'>";
				foreach ($translations as $t) {
					echo "<span class='flag flag-" . $t->ARTICLE_LANGUAGE . "' data-language='" . $t->ARTICLE_LANGUAGE . "'></span>";
				}
				echo "
				</div> <!-- /language-availability -->
			</div> <!-- /article -->
			";
		}




		if($a->TILE_TYPE == "article-type-3"){
			echo "			
			<div class='article double-article'>
				<div class='article-type-3'>
					$media
					<div class='spans'>
						<span class='hashtags'>$hashtags</span>
						<span class='locations'><i class='fa fa-map-marker fa-lg'></i> &nbsp; $location</span>
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
					<h1>$title</h1>
					<div class='this-article-text'><p>$body</p></div>
					<div class='spans'>
						<span class='hashtags'>$hashtags</span>
						<span class='locations'><i class='fa fa-map-marker fa-lg'></i> &nbsp; $location</span>
						<span class='post-time'>$time ago</span>
					</div> <!-- /spans -->
					<div class='language-availability'>";
					foreach ($translations as $t) {
						echo "<span class='flag flag-" . $t->ARTICLE_LANGUAGE . "' data-language='" . $t->ARTICLE_LANGUAGE . "'></span>";
					}
					echo "
					</div> <!-- /language-availability -->
				</div> <!-- /article-type-4 -->
			</div> <!-- double-article -->
			";
		}

	} // end foreach
	?>

</div> <!-- /article-thumbnails -->



<?php include '../../partials/footer.php';?>