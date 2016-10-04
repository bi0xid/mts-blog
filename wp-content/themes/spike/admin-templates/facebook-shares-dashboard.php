<?php

/**
 * Admin Area where we can update all Posts Stats (Share/Likes)
 * @author Alejandro Orta (alejandro@mytinysecrets.com)
 */

$ajax_nonce = wp_create_nonce( 'seguridad' );

?>

<section id="facebook_posts_stats_update">
	<h1>Posts Shares and Likes in FaceBook</h1>

	<p>Update all Posts Shares/Likes from Facebook</p>

	<input type="hidden" id="nonce" value="<?php echo $ajax_nonce; ?>">

	<em>The last update was <span></span></em>
	<button id="update_all">Update</button>

	<div class="loading-background">
		<div class="spinner-css">
			<div class="rect1"></div>
			<div class="rect2"></div>
			<div class="rect3"></div>
			<div class="rect4"></div>
			<div class="rect5"></div>
		</div>
	</div>
</section>
