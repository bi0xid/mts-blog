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
	<button id="update_all">Update all Social Media at one</button>

	<ul class="individual_updated">
		<li class="facebook_shares">
			<a href="#" data-ajax="update_facebook_shares">Update Facebook Shares and Likes</a>
		</li>
		<li class="google">
			<a href="#" data-ajax="update_google_plus">Update Google+</a>
		</li>
		<li class="pinterest">
			<a href="#" data-ajax="update_pinterest_pins">Update Pinterest Pins</a>
		</li>
		<li class="stumbleupon">
			<a href="#" data-ajax="update_stumble_upon">Update StumbleUpon</a>
		</li>
	</ul>

	<hr>
	<p><strong>Please</strong>, reload the page after Update to see the latest data.</p>

	<table id="table">
		<thead>
			<tr>
				<th>Post ID</th>
				<th>Post Name</th>
				<th>Facebook Shares</th>
				<th>Facebook Likes</th>
				<th>Google+</th>
				<th>Pinterest</th>
				<th>StumbleUpon</th>
				<th>Digg</th>
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
						echo '<td>'.get_post_meta( $post->ID, 'facebook_shares', true ).'</td>';
						echo '<td>'.get_post_meta( $post->ID, 'facebook_likes', true ).'</td>';
						echo '<td>'.get_post_meta( $post->ID, 'google_shares', true ).'</td>';
						echo '<td>'.get_post_meta( $post->ID, 'pinterest_shares', true ).'</td>';
						echo '<td>'.get_post_meta( $post->ID, 'stumble_shares', true ).'</td>';
						echo '<td>'.get_post_meta( $post->ID, 'digg_post_type', true ).'</td>';
					echo '</tr>';
				}
			?>
		</tbody>
		<tfoot>
			<tr>
				<th>Post ID</th>
				<th>Post Name</th>
				<th>Facebook Shares</th>
				<th>Facebook Likes</th>
				<th>Google+</th>
				<th>Pinterest</th>
				<th>StumbleUpon</th>
				<th>Digg</th>
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
