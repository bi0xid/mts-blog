	<?php $options = get_option('spike'); ?>
			</div>
		</div>
	</div>
	<footer>
		<div class="container">
			<div class="footer-widgets">
				<?php widgetized_footer(); ?>
			</div>
		</div>

		<!-- Facebook JavaScript SDK -->
		<script>
			(function(d, s, id){
				var js, fjs = d.getElementsByTagName(s)[0];
				if (d.getElementById(id)) {return;}
				js = d.createElement(s); js.id = id;
				js.src = "//connect.facebook.net/en_US/sdk.js";
				fjs.parentNode.insertBefore(js, fjs);
			}(document, 'script', 'facebook-jssdk'));
		</script>
	</footer>

	<div class="copyrights">
		<?php mts_copyrights_credit(); ?>
	</div> 

	<?php
		mts_footer();
		wp_footer();
	?>

	</body>
</html>
