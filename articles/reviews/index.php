<?php 
require '../../assets/functions/functions.php';
include '../../partials/header.php';
use magazine\fetch_functions;
if(!isset($_SESSION['active_user_id'])){
	echo "<script>location.href = '$base_url/home.php';</script>";
}

if(isset($_GET['approved'])) $status = 1;
elseif(isset($_GET['rejected'])) $status = -1;
else $status = 0;
$editor_id = fetch_functions\get_row('users','USER_ID',$_SESSION['active_user_id'])[0]->USER_ID;
$stmt = $con->prepare("SELECT DISTINCT ARTICLE_ID FROM articles WHERE ARTICLE_STATUS = :ARTICLE_STATUS ORDER BY TABLE_ID DESC");
$executed = $stmt->execute(array('ARTICLE_STATUS' => $status));
$article_ids = $stmt->fetchAll(\PDO::FETCH_OBJ);
if($executed){
	$articles = array();
	foreach ($article_ids as $a) {
		$stmt = $con->prepare("SELECT m.ARTICLE_ID, t.ARTICLE_TITLE, m.ENTERED_AT FROM articles AS m JOIN article_translations AS t ON m.ARTICLE_ID = t.ARTICLE_ID WHERE m.ARTICLE_ID = :ARTICLE_ID LIMIT 1");
		$executed = $stmt->execute(array('ARTICLE_ID' => $a->ARTICLE_ID));
		if($executed){
			$article = $stmt->fetch(\PDO::FETCH_OBJ);
			array_push($articles, $article);
		}
		else{
			echo "Something went wrong. Please try again later.";
			die();
		}
	}
}

else{
	echo "Something went wrong. Please try again later.";
	die();
}

echo "<title>Review Articles | $site_name</title>";
?>




<div class="review-articles col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<h1>Review Articles</h1>


	<div class="status-links">
		<?php 
		if ($status == 0) echo "<a href='?pending' class='active btn btn-default'>Pending</a>";
		else echo "<a href='?pending' class='btn btn-default'>Pending</a>";
		if ($status == 1) echo "<a href='?approved' class='active btn btn-default'>Approved</a>";
		else echo "<a href='?approved' class='btn btn-default'>Approved</a>";
		if ($status == -1) echo "<a href='?rejected' class='active btn btn-default'>Rejected</a>";
		else echo "<a href='?rejected' class='btn btn-default'>Rejected</a>";
		?>
	</div> <!-- /status-links -->




	<div class="searchable-table col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		 <div class="input-group col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
		 	<h4 class="approval-status col-lg-6 col-md-6 col-sm-4 col-xs-12 no-padding-left">
				<?php 
				if($status == 1) echo "Approved Posts &nbsp; <i class='fa fa-check-circle green'></i>";
				else if($status == -1) echo "Rejected Posts &nbsp; <i class='fa fa-times red'></i>";
				else echo "Pending Posts &nbsp; <i class='fa fa-spinner blue'></i>";
		 		?>
		 	</h4>
		 	<div class="approval-status col-lg-6 col-md-6 col-sm-8 col-xs-12 no-padding-right">
            	<input class="form-control" id="system-search" name="q" placeholder="Search by ID, Title, Date" required>
            </div> <!-- /approval-status -->
        </div> <!-- /input-group -->



		<div class="table-responsive col-lg-12 col-md-12 col-sm-12 col-xs-12 no-padding">
			<table class="table table-bordered table-striped table-list-search">
				<thead>
					<tr>
						<th>Article ID</th>
						<th>Title</th>
						<th>Language</th>
						<th>Date of Post</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					foreach ($articles as $a) {
						$date = date("d M, Y", strtotime($a->ENTERED_AT)) . " at " .  date("h:s A", strtotime($a->ENTERED_AT));
						$flags = fetch_functions\get_row('article_translations','ARTICLE_ID',$a->ARTICLE_ID);
						$flag = "";
						foreach ($flags as $lang) {
							$country_name = fetch_functions\get_row('countries','COUNTRY_CODE',$lang->ARTICLE_LANGUAGE)[0]->COUNTRY_NAME;
							$flag .= "<span data-toggle='tooltip' data-placement='top' title='" . $country_name . "' class='flag flag-" . $lang->ARTICLE_LANGUAGE . "' data-language='" . $lang->ARTICLE_LANGUAGE . "'></span>";
						}
						echo "
						<tr class='this-article' data-article='$a->ARTICLE_ID'>
		                    <td>$a->ARTICLE_ID</td>
		                    <td class='this-title'>$a->ARTICLE_TITLE</td>
		                    <td class='language-availability'>$flag</td>
		                    <td>$date</td>
		                    <td>
		                    	<a target='_blank' href='details/?article=$a->ARTICLE_LINK' class='btn btn-primary btn-sm'>Details</a>
		                    	<a target='_blank' href='../?article=$a->ARTICLE_LINK' class='btn btn-primary btn-sm'>View</a>
		                    </td>
		                </tr>
		                ";
		            }
		            ?>
				</tbody>
			</table>
		</div> <!-- /table-responsive -->
	</div> <!-- /searchable-table -->
</div> <!-- /review-articles -->




<?php include '../../partials/footer.php';?>