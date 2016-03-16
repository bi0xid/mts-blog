<?php $options = get_option('spike'); ?>
		</div>
	</div><!--#page-->
</div><!--.main-container-->
<footer>
	<div class="container">
		<div class="footer-widgets">
			<?php widgetized_footer(); ?>
		</div><!--.footer-widgets-->
	</div><!--.container-->
</footer><!--footer-->
<div class="copyrights">
	<?php mts_copyrights_credit(); ?>
</div> 
<?php mts_footer(); ?>
<?php wp_footer(); ?>

<script>
    (function(h, o, t, j, a, r) {
        h.hj = h.hj || function() {
            (h.hj.q = h.hj.q || []).push(arguments)
        };
        h._hjSettings = {
            hjid: 139211,
            hjsv: 5
        };
        a = o.getElementsByTagName('head')[0];
        r = o.createElement('script');
        r.async = 1;
        r.src = t + h._hjSettings.hjid + j + h._hjSettings.hjsv;
        a.appendChild(r);
    })(window, document, '//static.hotjar.com/c/hotjar-', '.js?sv=');
</script>

</body>
</html>