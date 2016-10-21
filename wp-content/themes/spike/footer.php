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
