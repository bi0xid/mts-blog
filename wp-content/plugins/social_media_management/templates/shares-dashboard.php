<?php

/**
 * Admin Area where we can update all Posts Stats (Share/Likes)
 * @author Alejandro Orta (alejandro@mytinysecrets.com)
 */

$ajax_nonce = wp_create_nonce( 'seguridad' );

?>

<section id="facebook_posts_stats_update">
	<h1>Posts Shares and Likes.</h1>

	<input type="hidden" id="nonce" value="<?php echo $ajax_nonce; ?>">

	<em>The last update was <strong id="update_date"><?php echo get_option( 'facebook_posts_stats_lats_update' ); ?></strong></em>
	<button id="update_all">Update</button>

	<hr>
	<p><strong>Please</strong>, reload the page after Update to see the latest data.</p>
	<p>If the field Shares/Like appears as empty that means there is no data inside post_meta.</p>

	<table id="table">
		<thead>
			<tr>
				<th>Post ID</th>
				<th>Post Name</th>
				<th>Create Date</th>
				<th>Shares</th>
				<th>Likes</th>
			</tr>
		</thead>
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
						echo '<td>'.get_the_date( false, $post->ID ).'</td>';
						echo '<td>'.get_post_meta( $post->ID, 'facebook_shares', true ).'</td>';
						echo '<td>'.get_post_meta( $post->ID, 'facebook_likes', true ).'</td>';
					echo '</tr>';
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<th>Post ID</th>
				<th>Post Name</th>
				<th>Create Date</th>
				<th>Shares</th>
				<th>Likes</th>
			</tr>
		</tfoot>
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
