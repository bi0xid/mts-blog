<?php

/**
 * Admin Area where we can update all Posts Stats (Share/Likes)
 * @author Alejandro Orta (alejandro@mytinysecrets.com)
 */

$ajax_nonce = wp_create_nonce( 'seguridad' );

?>

<section id="facebook_posts_stats_update">
	<h1>Posts Shares and Likes in FaceBook</h1>

	<p>Update all Posts Shares/Likes from Facebook.</p>

	<input type="hidden" id="nonce" value="<?php echo $ajax_nonce; ?>">

	<em>The last update was <span></span></em>
	<button id="update_all">Update</button>

	<hr>

	<p>All the data below are from the post_meta (<strong>_msp_total_shares</strong> and <strong>_msp_fb_likes</strong>).</p>
	<p><strong>Please</strong>, reload the page after Update to see the latest data.</p>

	<table id="table">
		<thead>
			<tr>
				<th>Post ID</th>
				<th>Post Name</th>
				<th>Shares</th>
				<th>Likes</th>
			</tr>
		</thead>
		<tfoot>
			<tr>
				<th>Post ID</th>
				<th>Post Name</th>
				<th>Shares</th>
				<th>Likes</th>
			</tr>
		</tfoot>
		<tbody>
			<?php
				$posts = get_posts( array(
					'numberposts' => 2000,
					'orderby'     => 'post_date',
					'order'       => 'DESC',
					'post_status' => 'publish'
				) );

				foreach ( $posts as $post ) {
					echo '<tr>';
						echo '<td>'.$post->ID.'</td>';
						echo '<td>'.get_the_title( $post->ID ).'</td>';
						echo '<td>'.get_post_meta( $post->ID, '_msp_total_shares', true ).'</td>';
						echo '<td>'.get_post_meta( $post->ID, '_msp_fb_likes', true ).'</td>';
					echo '</tr>';
				}
			?>
		</tbody>
	</table>

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
