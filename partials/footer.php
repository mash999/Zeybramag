
	</div> <!-- /content-wrapper -->

	<footer class="page-footer">
		<div>
			<h3>Zeybra Magazine</h3>
			<p>A social animal.<br>Not Black, nor white and each one is unique.</p>
			<ul class="social-media">
				<li><a href=""><i class="fa fa-facebook"></i></a></li>
				<li><a href=""><i class="fa fa-instagram"></i></a></li>
				<li><a href=""><i class="fa fa-twitter"></i></a></li>
			</ul>	
		</div>


		<div>
			<h3>You may like</h3>
			<?php 
			$stmt = $con->query("SELECT at.ARTICLE_ID, at.ARTICLE_TITLE FROM articles AS a JOIN article_translations AS at ON a.ARTICLE_ID = at.ARTICLE_ID WHERE a.ARTICLE_STATUS = 1 GROUP BY at.ARTICLE_ID ORDER BY a.ENTERED_AT DESC LIMIT 5");
			$last_five_articles = $stmt->fetchAll(\PDO::FETCH_OBJ);
			foreach ($last_five_articles as $lfa) {
				echo "<a target='_blank' href='$base_url/articles/?article=$lfa->ARTICLE_ID'>$lfa->ARTICLE_TITLE</a>";
			}
			?>
		</div>


		<div>
			<h2>Subscribe to Zeybra</h2>
			<form id="subscribe-user" action="<?php echo $base_url;?>/assets/functions/process-forms.php" method="post">
				<input type="email" id="subscriber-email" name="subscriber-email" placeholder="Type Your E-mail Here ... ">
				<input type="submit" id="save-subscriber" name="save-subscriber" value="SUBSCRIBE">
			</form>
			<h4 id="status-msg"></h4>
		</div>
		

		<div class="copyright">
			<p class="pull-left">
				&copy; Zeybramag 2018. All rights reserved. 
				<span class="pull-right">Developed with love by <a target="blank" href="">Ruhul Mashbu</a></span>
			</p>
		</div> <!-- /copyright -->
	</footer>
</div> <!-- /page-wrapper -->




<!-- JQUERY, BOOTSTRAP, CUSTOM SCRIPT-->
<script src="<?php echo $base_url;?>/assets/js/jquery.min.js"></script>
<script src="<?php echo $base_url;?>/assets/js/bootstrap.min.js"></script>
<script src="<?php echo $base_url;?>/assets/js/script.js"></script>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyA8utqsxiyLZHa9tIqIqFZGd0_LDKiEaBo&libraries=places&callback=activatePlacesSearch"></script>


</body>
</html>